<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Proof;
use App\Models\Testimonial;
use App\Models\VideoStory;
use App\Models\WhatsappChat;
use App\Services\AdminAuth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Server-rendered admin panel controller. Mirrors the flows in the React
 * Admin.tsx page, reusing the App\Services\AdminAuth service directly (not over
 * HTTP) and the existing Eloquent models with the SAME validation rules as the
 * API controllers. Feedback is delivered via session flash.
 */
class AdminController extends Controller
{
    // ── Auth: login form ──────────────────────────────────────────────────

    public function loginForm(Request $request): View|RedirectResponse
    {
        // Already authenticated → straight to the dashboard.
        $token = $request->session()->get('admin_token');
        if ($token && AdminAuth::verifyToken($token)) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $password = $request->input('password');
        if (!is_string($password) || !AdminAuth::verifyPassword($password)) {
            return redirect()->route('admin.login')->with('error', 'Incorrect password');
        }

        // Prevent session fixation: issue a fresh session ID on login.
        $request->session()->regenerate();

        $session = AdminAuth::createSession();
        $request->session()->put('admin_token', $session['token']);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $token = $request->session()->get('admin_token');
        if ($token) {
            AdminAuth::revokeSession($token);
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Signed out.');
    }

    // ── Auth: forgot / reset password (OTP) ────────────────────────────────

    public function forgotPassword(Request $request): RedirectResponse
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
                return redirect()->route('admin.login')->with('error',
                    'Admin password is not configured on this server. Set ADMIN_PASSWORD before using password reset.');
            }
            $bootstrapHash = AdminAuth::hashSecret($fallback);
        }

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

            return redirect()->route('admin.login', ['reset' => 1])
                ->with('error', "Too many requests. You can request another code in {$retryAfter}s.");
        }

        if (!$this->sendOtpEmail($otp)) {
            DB::table('admin_settings')
                ->where('id', 1)
                ->where('last_otp_sent_at', $claimedAt)
                ->update(['last_otp_sent_at' => null]);

            return redirect()->route('admin.login')->with('error', 'Failed to send OTP email. Please try again.');
        }

        return redirect()->route('admin.login', ['reset' => 1])
            ->with('success', 'OTP sent. Check the registered admin email for a 6-digit code (valid 10 minutes).');
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $otp = $request->input('otp');
        $new = $request->input('newPassword');
        $back = redirect()->route('admin.login', ['reset' => 1]);

        if (!is_string($otp) || !is_string($new)) {
            return $back->with('error', 'otp and newPassword are required');
        }
        if (strlen($new) < AdminAuth::MIN_PASSWORD_LENGTH) {
            return $back->with('error', 'New password must be at least '.AdminAuth::MIN_PASSWORD_LENGTH.' characters');
        }
        $settings = AdminAuth::settings();
        if (!$settings || !$settings->otp_hash || !$settings->otp_expires_at) {
            return $back->with('error', 'No OTP requested. Use forgot password first.');
        }
        if (strtotime($settings->otp_expires_at) < time()) {
            return $back->with('error', 'OTP has expired. Request a new one.');
        }

        $consumed = DB::table('admin_settings')
            ->where('id', $settings->id)
            ->where('otp_hash', $settings->otp_hash)
            ->where('otp_attempts', '<', AdminAuth::MAX_OTP_ATTEMPTS)
            ->increment('otp_attempts');
        if ($consumed === 0) {
            return $back->with('error', 'Too many incorrect attempts. Request a new OTP.');
        }

        if (!AdminAuth::verifySecret($otp, $settings->otp_hash)) {
            return $back->with('error', 'Incorrect OTP');
        }

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
            return $back->with('error', 'OTP already used. Request a new one.');
        }

        AdminAuth::revokeAllSessions();

        return redirect()->route('admin.login')->with('success', 'Password reset. Sign in with your new password.');
    }

    public function changePassword(Request $request): RedirectResponse
    {
        $current = $request->input('currentPassword');
        $new = $request->input('newPassword');
        $confirm = $request->input('confirmPassword');
        $back = redirect()->route('admin.dashboard', ['tab' => 'security']);

        if (!is_string($current) || !is_string($new)) {
            return $back->with('error', 'currentPassword and newPassword are required');
        }
        if (strlen($new) < AdminAuth::MIN_PASSWORD_LENGTH) {
            return $back->with('error', 'New password must be at least '.AdminAuth::MIN_PASSWORD_LENGTH.' characters');
        }
        if ($confirm !== null && $new !== $confirm) {
            return $back->with('error', "New passwords don't match");
        }
        if (!AdminAuth::verifyPassword($current)) {
            return $back->with('error', 'Current password is incorrect');
        }

        $this->upsertSettings([
            'password_hash' => AdminAuth::hashSecret($new),
            'otp_hash' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
        ]);

        // Old sessions may belong to whoever knew the old password — revoke
        // everything and re-prompt (the current browser session is cleared too).
        AdminAuth::revokeAllSessions();
        $request->session()->forget('admin_token');

        return redirect()->route('admin.login')
            ->with('success', 'Password updated successfully. Please sign in again.');
    }

    // ── Dashboard ──────────────────────────────────────────────────────────

    public function dashboard(Request $request): View
    {
        $tab = $request->query('tab', 'whatsapp');

        return view('admin.dashboard', [
            'tab' => $tab,
            'chats' => WhatsappChat::orderBy('created_at', 'desc')->get(),
            'proofs' => Proof::orderBy('created_at', 'desc')->get(),
            'stories' => VideoStory::orderBy('sort_order')->orderBy('created_at')->get(),
            'courses' => Course::orderBy('id')->get(),
            'reviews' => Testimonial::orderBy('id')->get(),
        ]);
    }

    // ── WhatsApp chats CRUD ─────────────────────────────────────────────────

    public function storeWhatsapp(Request $request): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'whatsapp']);
        $imageData = $request->input('imageData') ?? $request->input('image_data');
        $caption = $request->input('caption', '');

        if (!is_string($imageData) || !str_starts_with($imageData, 'data:image/')) {
            return $back->with('error', 'imageData must be a base64 data URL.');
        }
        if (strlen($imageData) > 5_000_000) {
            return $back->with('error', 'Image too large (max ~3.5 MB).');
        }

        WhatsappChat::create([
            'image_data' => $imageData,
            'caption' => is_string($caption) ? $caption : '',
        ]);

        return $back->with('success', 'Chat screenshot uploaded.');
    }

    public function updateWhatsapp(Request $request, int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'whatsapp']);
        $chat = WhatsappChat::find($id);
        if (!$chat) {
            return $back->with('error', 'Not found.');
        }
        $caption = $request->input('caption');
        $chat->caption = is_string($caption) ? $caption : '';
        $chat->save();

        return $back->with('success', 'Caption updated.');
    }

    public function destroyWhatsapp(int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'whatsapp']);
        $chat = WhatsappChat::find($id);
        if (!$chat) {
            return $back->with('error', 'Not found.');
        }
        $chat->delete();

        return $back->with('success', 'Deleted.');
    }

    // ── Placement proofs CRUD ────────────────────────────────────────────────

    public function storeProof(Request $request): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'proofs']);
        $imageData = $request->input('imageData') ?? $request->input('image_data');
        $caption = $request->input('caption', '');
        $proofDate = $request->input('proofDate') ?? $request->input('proof_date');

        if (!is_string($imageData) || !str_starts_with($imageData, 'data:image/')) {
            return $back->with('error', 'imageData must be a base64 data URL.');
        }
        if (!is_string($proofDate) || !trim($proofDate)) {
            return $back->with('error', 'proofDate is required.');
        }
        if (strlen($imageData) > 5_000_000) {
            return $back->with('error', 'Image too large (max ~3.5 MB).');
        }

        Proof::create([
            'image_data' => $imageData,
            'caption' => is_string($caption) ? $caption : '',
            'proof_date' => trim($proofDate),
        ]);

        return $back->with('success', 'Screenshot uploaded.');
    }

    public function destroyProof(int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'proofs']);
        $proof = Proof::find($id);
        if (!$proof) {
            return $back->with('error', 'Not found.');
        }
        $proof->delete();

        return $back->with('success', 'Deleted.');
    }

    // ── Video stories CRUD ───────────────────────────────────────────────────

    public function storeVideo(Request $request): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'videos']);
        $videoData = $request->input('videoData') ?? $request->input('video_data');
        $label = $request->input('label');
        $sortOrder = $request->input('sortOrder') ?? $request->input('sort_order', 0);

        if (!is_string($videoData) || !$videoData) {
            return $back->with('error', 'Invalid input');
        }
        if (!is_string($label) || !$label) {
            return $back->with('error', 'Invalid input');
        }

        VideoStory::create([
            'video_data' => $videoData,
            'label' => $label,
            'sort_order' => is_numeric($sortOrder) ? (int) $sortOrder : 0,
        ]);

        return $back->with('success', 'Video story uploaded.');
    }

    public function updateVideo(Request $request, int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'videos']);
        $story = VideoStory::find($id);
        if (!$story) {
            return $back->with('error', 'Not found');
        }

        $updates = [];
        $label = $request->input('label');
        if (is_string($label) && $label) {
            $updates['label'] = $label;
        }
        $sortOrder = $request->input('sortOrder') ?? $request->input('sort_order');
        if (is_numeric($sortOrder)) {
            $updates['sort_order'] = (int) $sortOrder;
        }
        if (empty($updates)) {
            return $back->with('error', 'Nothing to update');
        }

        $story->update($updates);

        return $back->with('success', 'Label updated.');
    }

    public function destroyVideo(int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'videos']);
        $story = VideoStory::find($id);
        if (!$story) {
            return $back->with('error', 'Not found');
        }
        $story->delete();

        return $back->with('success', 'Deleted.');
    }

    // ── Courses CRUD ─────────────────────────────────────────────────────────

    public function storeCourse(Request $request): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'courses']);
        try {
            $validated = $this->validateCourse($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $back->withErrors($e->errors())->withInput()
                ->with('error', $e->validator->errors()->first());
        }

        Course::create($validated);

        return $back->with('success', 'Course created.');
    }

    public function updateCourse(Request $request, int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'courses']);
        $course = Course::find($id);
        if (!$course) {
            return $back->with('error', 'Course not found.');
        }
        try {
            $validated = $this->validateCourse($request, $id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $back->withErrors($e->errors())->withInput()
                ->with('error', $e->validator->errors()->first());
        }

        $course->update($validated);

        return $back->with('success', 'Course updated.');
    }

    public function destroyCourse(int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'courses']);
        $course = Course::find($id);
        if (!$course) {
            return $back->with('error', 'Course not found.');
        }
        $course->delete();

        return $back->with('success', 'Course deleted.');
    }

    /**
     * Normalise the HTML form (camelCase + comma-separated skills) into the
     * snake_case payload the API validation/model expect, then validate with
     * the SAME rules as CourseController.
     *
     * @return array<string, mixed>
     */
    private function validateCourse(Request $request, ?int $id = null): array
    {
        $skills = $request->input('skills');
        if (is_string($skills)) {
            $skills = array_values(array_filter(array_map('trim', explode(',', $skills))));
        }

        $payload = array_filter([
            'slug' => $this->trimOrNull($request->input('slug')),
            'title' => $this->trimOrNull($request->input('title')),
            'category_slug' => $this->trimOrNull($request->input('categorySlug')),
            'category_name' => $this->trimOrNull($request->input('categoryName')),
            'level' => $this->trimOrNull($request->input('level')),
            'summary' => $this->trimOrNull($request->input('summary')),
            'description' => $this->trimOrNull($request->input('description')),
            'duration_hours' => $this->intOrNull($request->input('durationHours')),
            'mode' => $this->trimOrNull($request->input('mode')),
            'price' => $this->intOrNull($request->input('price')),
            'rating' => $this->numOrNull($request->input('rating')),
            'total_rating' => $this->intOrNull($request->input('reviewCount')),
            'enrolled' => $this->intOrNull($request->input('enrolled')),
            'image_url' => $this->trimOrNull($request->input('imageUrl')),
        ], fn ($v) => $v !== null);

        $payload['featured'] = $request->boolean('featured');
        $payload['skills'] = is_array($skills) ? $skills : [];

        $uniqueRule = $id === null
            ? 'unique:courses,slug'
            : 'unique:courses,slug,'.$id;

        $rules = [
            'slug' => 'required|string|'.$uniqueRule,
            'title' => 'required|string',
            'category_slug' => 'required|string',
            'category_name' => 'required|string',
            'level' => 'required|string',
            'summary' => 'required|string',
            'description' => 'required|string',
            'duration_hours' => 'required|integer|min:1',
            'mode' => 'required|string',
            'price' => 'required|integer|min:0',
            'rating' => 'sometimes|numeric|min:0|max:5',
            'total_rating' => 'sometimes|integer|min:0',
            'enrolled' => 'sometimes|integer|min:0',
            'featured' => 'sometimes|boolean',
            'skills' => 'sometimes|array',
            'image_url' => 'sometimes|string',
        ];

        return validator($payload, $rules)->validate();
    }

    private function trimOrNull($v): ?string
    {
        if (!is_string($v)) {
            return null;
        }
        $v = trim($v);

        return $v === '' ? null : $v;
    }

    private function intOrNull($v): ?int
    {
        if ($v === null || $v === '' || !is_numeric($v)) {
            return null;
        }

        return (int) $v;
    }

    private function numOrNull($v): ?float
    {
        if ($v === null || $v === '' || !is_numeric($v)) {
            return null;
        }

        return (float) $v;
    }

    // ── Testimonials / reviews ───────────────────────────────────────────────

    public function storeReview(Request $request): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'reviews']);
        try {
            $validated = validator($request->all(), [
                'name' => 'required|string',
                'role' => 'required|string',
                'company' => 'required|string',
                'quote' => 'required|string',
                'rating' => 'sometimes|numeric|min:0|max:5',
                'avatar_url' => 'sometimes|string',
                'source' => 'sometimes|string',
                'visible' => 'sometimes|boolean',
            ])->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $back->withInput()->with('error', $e->validator->errors()->first());
        }

        Testimonial::create($validated);

        return $back->with('success', 'Review added.');
    }

    public function toggleReview(Request $request, int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'reviews']);
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return $back->with('error', 'Not found.');
        }
        $testimonial->visible = $request->boolean('visible');
        $testimonial->save();

        return $back->with('success', $testimonial->visible ? 'Review shown' : 'Review hidden');
    }

    public function destroyReview(int $id): RedirectResponse
    {
        $back = redirect()->route('admin.dashboard', ['tab' => 'reviews']);
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return $back->with('error', 'Not found.');
        }
        $testimonial->delete();

        return $back->with('success', 'Review deleted');
    }

    // ── Helpers copied from AdminAuthController (identical behaviour) ─────────

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
