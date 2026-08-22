<?php

namespace Tests\Feature\Web;

use App\Models\WhatsappChat;
use App\Services\AdminAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Server-rendered admin panel (/admin). Auth uses the AdminAuth service via
 * the Laravel session; middleware AdminWebAuth redirects unauthenticated
 * requests to the login form. CRUD forms reuse the same model/validation logic
 * as the API controllers. The /api/admin/* endpoints are covered separately by
 * AdminAuthTest and remain untouched.
 */
class AdminWebTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'test-secret-password';

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.admin.password' => self::PASSWORD]);
    }

    /** Log in through the web form and keep the session cookie. */
    private function webLogin(): self
    {
        $this->post('/admin/login', ['password' => self::PASSWORD])
            ->assertRedirect(route('admin.dashboard'));

        return $this;
    }

    public function test_login_page_returns_200(): void
    {
        $this->get('/admin/login')
            ->assertStatus(200)
            ->assertSee('Admin Panel', false);
    }

    public function test_wrong_password_is_rejected(): void
    {
        $this->post('/admin/login', ['password' => 'nope'])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHas('error', 'Incorrect password');

        // Still no session token issued.
        $this->assertNull(session('admin_token'));
    }

    public function test_login_leads_to_dashboard(): void
    {
        $this->post('/admin/login', ['password' => self::PASSWORD])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertNotNull(session('admin_token'));
        $this->assertTrue(AdminAuth::verifyToken(session('admin_token')));

        $this->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('WhatsApp Chats', false);
    }

    public function test_dashboard_requires_auth_and_redirects(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'))
            ->assertSessionHas('error');
    }

    public function test_expired_session_redirects_with_flash(): void
    {
        $this->webLogin();
        // Expire every session server-side.
        DB::table('admin_sessions')->update(['expires_at' => now()->subMinute()]);

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'))
            ->assertSessionHas('error');
    }

    public function test_create_and_delete_whatsapp_chat_via_web_forms(): void
    {
        $this->webLogin();

        $dataUrl = 'data:image/png;base64,'.base64_encode('fake-image-bytes');

        $this->post(route('admin.whatsapp.store'), [
            'imageData' => $dataUrl,
            'caption' => 'Great feedback',
        ])->assertRedirect(route('admin.dashboard', ['tab' => 'whatsapp']))
            ->assertSessionHas('success');

        $this->assertSame(1, WhatsappChat::count());
        $chat = WhatsappChat::first();
        $this->assertSame('Great feedback', $chat->caption);

        $this->delete(route('admin.whatsapp.destroy', $chat->id))
            ->assertRedirect(route('admin.dashboard', ['tab' => 'whatsapp']))
            ->assertSessionHas('success');

        $this->assertSame(0, WhatsappChat::count());
    }

    public function test_whatsapp_store_rejects_non_data_url(): void
    {
        $this->webLogin();

        $this->post(route('admin.whatsapp.store'), [
            'imageData' => 'https://example.com/not-a-data-url.png',
        ])->assertRedirect(route('admin.dashboard', ['tab' => 'whatsapp']))
            ->assertSessionHas('error');

        $this->assertSame(0, WhatsappChat::count());
    }

    public function test_change_password_revokes_sessions_and_reprompts(): void
    {
        $this->webLogin();
        $oldToken = session('admin_token');
        $this->assertNotNull($oldToken);

        $this->post(route('admin.change-password'), [
            'currentPassword' => self::PASSWORD,
            'newPassword' => 'brand-new-password-9',
            'confirmPassword' => 'brand-new-password-9',
        ])->assertRedirect(route('admin.login'))
            ->assertSessionHas('success');

        // All sessions revoked and the browser session token cleared.
        $this->assertSame(0, DB::table('admin_sessions')->count());
        $this->assertNull(session('admin_token'));
        $this->assertFalse(AdminAuth::verifyToken($oldToken));

        // The new password is now authoritative.
        $this->assertTrue(AdminAuth::verifyPassword('brand-new-password-9'));
        $this->assertFalse(AdminAuth::verifyPassword(self::PASSWORD));

        // Protected pages now redirect to login again.
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_change_password_enforces_min_length(): void
    {
        $this->webLogin();

        $this->post(route('admin.change-password'), [
            'currentPassword' => self::PASSWORD,
            'newPassword' => 'short',
            'confirmPassword' => 'short',
        ])->assertRedirect(route('admin.dashboard', ['tab' => 'security']))
            ->assertSessionHas('error');

        // Session still valid — password unchanged.
        $this->assertTrue(AdminAuth::verifyPassword(self::PASSWORD));
    }

    public function test_logout_revokes_token_and_redirects(): void
    {
        $this->webLogin();
        $token = session('admin_token');

        $this->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'))
            ->assertSessionHas('success');

        $this->assertNull(session('admin_token'));
        $this->assertFalse(AdminAuth::verifyToken($token));

        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }
}
