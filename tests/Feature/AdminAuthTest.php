<?php

namespace Tests\Feature;

use App\Services\AdminAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Covers the session-token admin auth flow used by the React admin panel:
 * login -> x-admin-token on admin CRUD -> logout / change-password / OTP reset.
 */
class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    private function login(string $password = 'test-secret-password'): string
    {
        config(['services.admin.password' => 'test-secret-password']);
        $res = $this->postJson('/api/admin/login', ['password' => $password]);
        $res->assertStatus(200)->assertJsonStructure(['token', 'expiresAt']);

        return $res->json('token');
    }

    // ── Login ────────────────────────────────────────────────────────────────

    public function test_login_rejects_wrong_password(): void
    {
        config(['services.admin.password' => 'test-secret-password']);
        $this->postJson('/api/admin/login', ['password' => 'wrong'])
            ->assertStatus(401)
            ->assertJsonFragment(['error' => 'Incorrect password']);
    }

    public function test_login_fails_closed_in_production_without_password(): void
    {
        config(['services.admin.password' => null]);
        $this->app['env'] = 'production';

        $this->postJson('/api/admin/login', ['password' => 'admin123'])
            ->assertStatus(401);
    }

    public function test_login_returns_64_char_token(): void
    {
        $token = $this->login();
        $this->assertSame(64, strlen($token));
        $this->assertSame(1, DB::table('admin_sessions')->count());
        // Only the SHA-256 hash is stored, never the raw token.
        $this->assertSame(
            AdminAuth::hashToken($token),
            DB::table('admin_sessions')->value('token_hash')
        );
    }

    // ── Token-protected admin routes ─────────────────────────────────────────

    public function test_admin_endpoint_denied_without_token(): void
    {
        $this->getJson('/api/testimonials/admin')
            ->assertStatus(401)
            ->assertJsonFragment(['error' => 'Unauthorized']);
    }

    public function test_admin_endpoint_denied_with_invalid_token(): void
    {
        $this->withHeaders(['x-admin-token' => str_repeat('a', 64)])
            ->getJson('/api/testimonials/admin')
            ->assertStatus(401);
    }

    public function test_admin_endpoint_accepted_with_valid_token(): void
    {
        $token = $this->login();
        $this->withHeaders(['x-admin-token' => $token])
            ->getJson('/api/testimonials/admin')
            ->assertStatus(200)
            ->assertJsonIsArray();
    }

    public function test_admin_endpoint_accepts_bearer_header(): void
    {
        $token = $this->login();
        $this->withHeaders(['Authorization' => "Bearer {$token}"])
            ->getJson('/api/testimonials/admin')
            ->assertStatus(200);
    }

    public function test_expired_session_is_rejected_and_deleted(): void
    {
        $token = $this->login();
        DB::table('admin_sessions')->update(['expires_at' => now()->subMinute()]);

        $this->withHeaders(['x-admin-token' => $token])
            ->getJson('/api/testimonials/admin')
            ->assertStatus(401);
        $this->assertSame(0, DB::table('admin_sessions')->count());
    }

    // ── Logout ───────────────────────────────────────────────────────────────

    public function test_logout_revokes_token(): void
    {
        $token = $this->login();
        $this->withHeaders(['x-admin-token' => $token])
            ->postJson('/api/admin/logout')
            ->assertStatus(200)
            ->assertJsonFragment(['success' => true]);

        $this->withHeaders(['x-admin-token' => $token])
            ->getJson('/api/testimonials/admin')
            ->assertStatus(401);
    }

    // ── Change password ──────────────────────────────────────────────────────

    public function test_change_password_requires_current_password(): void
    {
        config(['services.admin.password' => 'test-secret-password']);
        $this->postJson('/api/admin/change-password', [
            'currentPassword' => 'wrong',
            'newPassword' => 'new-password-123',
        ])->assertStatus(401)
            ->assertJsonFragment(['error' => 'Current password is incorrect']);
    }

    public function test_change_password_enforces_min_length(): void
    {
        config(['services.admin.password' => 'test-secret-password']);
        $this->postJson('/api/admin/change-password', [
            'currentPassword' => 'test-secret-password',
            'newPassword' => 'short',
        ])->assertStatus(400);
    }

    public function test_change_password_revokes_old_sessions_and_returns_fresh_token(): void
    {
        $oldToken = $this->login();

        $res = $this->postJson('/api/admin/change-password', [
            'currentPassword' => 'test-secret-password',
            'newPassword' => 'brand-new-password-9',
        ]);
        $res->assertStatus(200)->assertJsonStructure(['success', 'message', 'token', 'expiresAt']);
        $newToken = $res->json('token');

        // Old token revoked, new token works.
        $this->withHeaders(['x-admin-token' => $oldToken])
            ->getJson('/api/testimonials/admin')->assertStatus(401);
        $this->withHeaders(['x-admin-token' => $newToken])
            ->getJson('/api/testimonials/admin')->assertStatus(200);

        // DB-managed password is now authoritative (bcrypt hash stored).
        $this->postJson('/api/admin/login', ['password' => 'test-secret-password'])
            ->assertStatus(401);
        $this->postJson('/api/admin/login', ['password' => 'brand-new-password-9'])
            ->assertStatus(200);
    }

    // ── OTP reset ────────────────────────────────────────────────────────────

    private function seedOtp(string $otp = '123456', int $attempts = 0): void
    {
        DB::table('admin_settings')->insert([
            'id' => 1,
            'password_hash' => AdminAuth::hashSecret('test-secret-password'),
            'otp_hash' => AdminAuth::hashSecret($otp),
            'otp_expires_at' => now()->addMinutes(10),
            'otp_attempts' => $attempts,
            'last_otp_sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_reset_password_requires_prior_otp(): void
    {
        $this->postJson('/api/admin/reset-password', [
            'otp' => '123456', 'newPassword' => 'new-password-123',
        ])->assertStatus(400)
            ->assertJsonFragment(['error' => 'No OTP requested. Use forgot password first.']);
    }

    public function test_reset_password_rejects_wrong_otp_and_counts_attempt(): void
    {
        $this->seedOtp('123456');
        $this->postJson('/api/admin/reset-password', [
            'otp' => '999999', 'newPassword' => 'new-password-123',
        ])->assertStatus(401)
            ->assertJsonFragment(['error' => 'Incorrect OTP']);
        $this->assertSame(1, (int) DB::table('admin_settings')->value('otp_attempts'));
    }

    public function test_reset_password_locks_after_max_attempts(): void
    {
        $this->seedOtp('123456', AdminAuth::MAX_OTP_ATTEMPTS);
        $this->postJson('/api/admin/reset-password', [
            'otp' => '123456', 'newPassword' => 'new-password-123',
        ])->assertStatus(429)
            ->assertJsonFragment(['error' => 'Too many incorrect attempts. Request a new OTP.']);
    }

    public function test_reset_password_rejects_expired_otp(): void
    {
        $this->seedOtp('123456');
        DB::table('admin_settings')->update(['otp_expires_at' => now()->subMinute()]);
        $this->postJson('/api/admin/reset-password', [
            'otp' => '123456', 'newPassword' => 'new-password-123',
        ])->assertStatus(400)
            ->assertJsonFragment(['error' => 'OTP has expired. Request a new one.']);
    }

    public function test_reset_password_succeeds_with_correct_otp(): void
    {
        $token = $this->login();
        $this->seedOtp('123456');

        $this->postJson('/api/admin/reset-password', [
            'otp' => '123456', 'newPassword' => 'after-reset-pass-1',
        ])->assertStatus(200)
            ->assertJsonFragment(['success' => true]);

        // OTP consumed, all sessions revoked, new password active.
        $settings = DB::table('admin_settings')->first();
        $this->assertNull($settings->otp_hash);
        $this->assertSame(0, DB::table('admin_sessions')->count());
        $this->withHeaders(['x-admin-token' => $token])
            ->getJson('/api/testimonials/admin')->assertStatus(401);
        $this->postJson('/api/admin/login', ['password' => 'after-reset-pass-1'])
            ->assertStatus(200);
    }
}
