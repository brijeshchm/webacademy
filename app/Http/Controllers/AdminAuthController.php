<?php

namespace App\Http\Controllers;

use App\Services\AdminAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Session-token admin authentication endpoints, matching the original Node
 * API's request/response contract exactly so the compiled React admin panel
 * works without modification.
 */
class AdminAuthController extends Controller
{
    /** Exchange the admin password for a short-lived session token. */
    public function login(Request $request): JsonResponse
    {
        $password = $request->input('password');
        if (!is_string($password) || !AdminAuth::verifyPassword($password)) {
            return response()->json(['error' => 'Incorrect password'], 401);
        }
        $session = AdminAuth::createSession();

        return response()->json($session);
    }

    /** Revoke the current session token. */
    public function logout(Request $request): JsonResponse
    {
        $token = AdminAuth::extractToken($request);
        if ($token) {
            AdminAuth::revokeSession($token);
        }

        return response()->json(['success' => true]);
    }

    /** Change password (requires knowing the current password). */
    public function changePassword(Request $request): JsonResponse
    {
        $current = $request->input('currentPassword');
        $new = $request->input('newPassword');
        if (!is_string($current) || !is_string($new)) {
            return response()->json(['error' => 'currentPassword and newPassword are required'], 400);
        }
        if (strlen($new) < AdminAuth::MIN_PASSWORD_LENGTH) {
            return response()->json(['error' => 'New password must be at least '.AdminAuth::MIN_PASSWORD_LENGTH.' characters'], 400);
        }
        if (!AdminAuth::verifyPassword($current)) {
            return response()->json(['error' => 'Current password is incorrect'], 401);
        }

        $this->upsertSettings([
            'password_hash' => AdminAuth::hashSecret($new),
            'otp_hash' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
        ]);

        // Old sessions may belong to whoever knew the old password — revoke
        // them and hand the caller a fresh token so their tab keeps working.
        AdminAuth::revokeAllSessions();
        $session = AdminAuth::createSession();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ] + $session);
    }

    /** Request a password-reset OTP (emailed to the configured admin address). */
    public function forgotPassword(): JsonResponse
    {
        $otp = (string) random_int(100000, 999999);
        $otpHash = AdminAuth::hashSecret($otp);
        $otpExpiresAt = now()->addSeconds(AdminAuth::OTP_TTL_SECONDS);

        $existing = AdminAuth::settings();
        if ($existing) {
            $bootstrapHash = $existing->password_hash;
        } else {
            $fallback = AdminAuth::fallbackPassword();
            if ($fallback === null) {
                return response()->json([
                    'error' => 'Admin password is not configured on this server. Set ADMIN_PASSWORD before using password reset.',
                ], 503);
            }
            $bootstrapHash = AdminAuth::hashSecret($fallback);
        }

        // Persistent 1-per-minute cap: atomically claim the send slot so the
        // limit survives restarts. claimedAt uniquely identifies this claim.
        $claimedAt = now();
        $cutoff = $claimedAt->copy()->subSeconds(AdminAuth::OTP_SEND_INTERVAL_SECONDS);

        $claimed = false;
        if (!$existing) {
            try {
                DB::table('admin_settings')->insert([
                    'id' => 1,
                    'password_hash' => $bootstrapHash,
                    'otp_hash' => $otpHash,
                    'otp_expires_at' => $otpExpiresAt,
                    'otp_attempts' => 0,
                    'last_otp_sent_at' => $claimedAt,
                    'created_at' => $claimedAt,
                    'updated_at' => $claimedAt,
                ]);
                $claimed = true;
            } catch (\Illuminate\Database\QueryException $e) {
                // Row created concurrently — fall through to conditional update.
            }
        }
        if (!$claimed) {
            $claimed = DB::table('admin_settings')
                ->where('id', 1)
                ->where(function ($q) use ($cutoff) {
                    $q->whereNull('last_otp_sent_at')->orWhere('last_otp_sent_at', '<', $cutoff);
                })
                ->update([
                    'otp_hash' => $otpHash,
                    'otp_expires_at' => $otpExpiresAt,
                    'otp_attempts' => 0,
                    'last_otp_sent_at' => $claimedAt,
                    'updated_at' => $claimedAt,
                ]) > 0;
        }

        if (!$claimed) {
            $current = AdminAuth::settings();
            $lastSent = $current && $current->last_otp_sent_at ? strtotime($current->last_otp_sent_at) : time();
            $retryAfter = max(1, (int) ceil($lastSent + AdminAuth::OTP_SEND_INTERVAL_SECONDS - time()));

            return response()->json([
                'error' => 'Too many requests. Please try again shortly.',
                'retryAfterSeconds' => $retryAfter,
            ], 429)->header('Retry-After', (string) $retryAfter);
        }

        if (!$this->sendOtpEmail($otp)) {
            // The email never went out — release the send slot for an
            // immediate retry, but only if it still holds THIS claim.
            DB::table('admin_settings')
                ->where('id', 1)
                ->where('last_otp_sent_at', $claimedAt)
                ->update(['last_otp_sent_at' => null]);

            return response()->json(['error' => 'Failed to send OTP email. Please try again.'], 502);
        }

        return response()->json(['success' => true, 'message' => 'OTP sent to the registered admin email']);
    }

    /** Reset the password using the emailed OTP. */
    public function resetPassword(Request $request): JsonResponse
    {
        $otp = $request->input('otp');
        $new = $request->input('newPassword');
        if (!is_string($otp) || !is_string($new)) {
            return response()->json(['error' => 'otp and newPassword are required'], 400);
        }
        if (strlen($new) < AdminAuth::MIN_PASSWORD_LENGTH) {
            return response()->json(['error' => 'New password must be at least '.AdminAuth::MIN_PASSWORD_LENGTH.' characters'], 400);
        }
        $settings = AdminAuth::settings();
        if (!$settings || !$settings->otp_hash || !$settings->otp_expires_at) {
            return response()->json(['error' => 'No OTP requested. Use forgot password first.'], 400);
        }
        if (strtotime($settings->otp_expires_at) < time()) {
            return response()->json(['error' => 'OTP has expired. Request a new one.'], 400);
        }

        // Atomically consume an attempt BEFORE checking the OTP so concurrent
        // guesses cannot race past the limit.
        $consumed = DB::table('admin_settings')
            ->where('id', $settings->id)
            // Bind the exact OTP hash so a concurrently issued new OTP can
            // never have its attempt counter consumed by a stale request.
            ->where('otp_hash', $settings->otp_hash)
            ->where('otp_attempts', '<', AdminAuth::MAX_OTP_ATTEMPTS)
            ->increment('otp_attempts');
        if ($consumed === 0) {
            return response()->json(['error' => 'Too many incorrect attempts. Request a new OTP.'], 429);
        }

        if (!AdminAuth::verifySecret($otp, $settings->otp_hash)) {
            return response()->json(['error' => 'Incorrect OTP'], 401);
        }

        // Atomically consume the OTP: only the first valid reset clears it.
        $reset = DB::table('admin_settings')
            ->where('id', $settings->id)
            ->where('otp_hash', $settings->otp_hash)
            ->update([
                'password_hash' => AdminAuth::hashSecret($new),
                'otp_hash' => null,
                'otp_expires_at' => null,
                'otp_attempts' => 0,
                'updated_at' => now(),
            ]);
        if ($reset === 0) {
            return response()->json(['error' => 'OTP already used. Request a new one.'], 409);
        }

        AdminAuth::revokeAllSessions();

        return response()->json(['success' => true, 'message' => 'Password reset successfully']);
    }

    /** Send the OTP to the configured admin inbox via the Resend HTTP API. */
    private function sendOtpEmail(string $otp): bool
    {
        $apiKey = (string) config('services.resend.key', '');
        $to = (string) config('services.notify.email', '');
        if (!$apiKey || !$to) {
            Log::error('OTP email not sent: RESEND_API_KEY or NOTIFY_EMAIL missing');

            return false;
        }
        $from = (string) config('services.notify.from');

        try {
            $response = Http::withToken($apiKey)
                ->timeout(15)
                ->post('https://api.resend.com/emails', [
                    'from' => $from,
                    'to' => [$to],
                    'subject' => 'Your admin password reset code',
                    'html' => '<p>Your Corporate Academy admin password reset code is:</p>'
                        .'<p style="font-size:28px;font-weight:bold;letter-spacing:4px;">'.$otp.'</p>'
                        .'<p>This code expires in 10 minutes. If you did not request it, you can ignore this email.</p>',
                    'text' => "Your Corporate Academy admin password reset code is: {$otp}\nThis code expires in 10 minutes.",
                ]);

            if (!$response->successful()) {
                Log::error('OTP email failed: '.$response->status().' '.$response->body());

                return false;
            }

            return true;
        } catch (\Illuminate\Http\Client\ConnectionException|\Throwable $e) {
            Log::error('OTP email failed: '.$e->getMessage());

            return false;
        }
    }

    /** Singleton upsert on the fixed id=1 admin_settings row. */
    private function upsertSettings(array $values): void
    {
        $existing = AdminAuth::settings();
        if ($existing) {
            DB::table('admin_settings')->where('id', 1)->update($values + ['updated_at' => now()]);

            return;
        }
        if (empty($values['password_hash'])) {
            throw new \RuntimeException('password_hash required for initial insert');
        }
        DB::table('admin_settings')->insert($values + [
            'id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
