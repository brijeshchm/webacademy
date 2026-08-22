<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Session-token admin authentication, matching the behaviour of the original
 * Node API exactly:
 *  - passwords & OTPs stored as one-way hashes (bcrypt here)
 *  - session tokens are 64-hex random values; only their SHA-256 is stored
 *  - sessions expire after 12 hours
 *  - if no DB-managed password exists, ADMIN_PASSWORD (.env) is the fallback;
 *    in production with no ADMIN_PASSWORD admin access fails closed
 *    (development keeps the convenient "admin123" default).
 */
class AdminAuth
{
    public const SESSION_TTL_SECONDS = 12 * 60 * 60; // 12 hours
    public const OTP_TTL_SECONDS = 10 * 60;          // 10 minutes
    public const OTP_SEND_INTERVAL_SECONDS = 60;     // 1 OTP email per minute
    public const MAX_OTP_ATTEMPTS = 5;
    public const MIN_PASSWORD_LENGTH = 8;

    public static function fallbackPassword(): ?string
    {
        $env = config('services.admin.password');
        if (!empty($env)) {
            return $env;
        }

        return app()->environment('production') ? null : 'admin123';
    }

    public static function hashSecret(string $secret): string
    {
        return password_hash($secret, PASSWORD_BCRYPT);
    }

    public static function verifySecret(string $secret, string $stored): bool
    {
        return password_verify($secret, $stored);
    }

    public static function settings(): ?object
    {
        return DB::table('admin_settings')->first();
    }

    public static function verifyPassword(string $password): bool
    {
        if ($password === '') {
            return false;
        }
        $settings = self::settings();
        if ($settings) {
            return self::verifySecret($password, $settings->password_hash);
        }
        $fallback = self::fallbackPassword();
        if ($fallback === null) {
            return false; // fail closed in production
        }

        return hash_equals($fallback, $password);
    }

    /** Tokens are high-entropy random values, so an unsalted SHA-256 is safe. */
    public static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    /** Create a session and return the raw token (never stored in plaintext). */
    public static function createSession(): array
    {
        $token = bin2hex(random_bytes(32));
        $expiresAt = now()->addSeconds(self::SESSION_TTL_SECONDS);

        // Opportunistically purge expired sessions.
        DB::table('admin_sessions')->where('expires_at', '<', now())->delete();

        DB::table('admin_sessions')->insert([
            'token_hash' => self::hashToken($token),
            'expires_at' => $expiresAt,
            'created_at' => now(),
        ]);

        return ['token' => $token, 'expiresAt' => $expiresAt->toISOString()];
    }

    public static function verifyToken(?string $token): bool
    {
        if (empty($token)) {
            return false;
        }
        $session = DB::table('admin_sessions')
            ->where('token_hash', self::hashToken($token))
            ->first();
        if (!$session) {
            return false;
        }
        if (strtotime($session->expires_at) < time()) {
            DB::table('admin_sessions')->where('id', $session->id)->delete();

            return false;
        }

        return true;
    }

    public static function revokeSession(string $token): void
    {
        DB::table('admin_sessions')->where('token_hash', self::hashToken($token))->delete();
    }

    public static function revokeAllSessions(): void
    {
        DB::table('admin_sessions')->delete();
    }

    /** Accepts `Authorization: Bearer <token>` or `x-admin-token: <token>`. */
    public static function extractToken(\Illuminate\Http\Request $request): ?string
    {
        $auth = (string) $request->header('Authorization', '');
        if (str_starts_with($auth, 'Bearer ')) {
            $token = trim(substr($auth, 7));
            if ($token !== '') {
                return $token;
            }
        }
        $header = (string) $request->header('x-admin-token', '');

        return $header !== '' ? $header : null;
    }
}
