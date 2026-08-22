<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OgImageController;
use App\Http\Controllers\ProofController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TranslateController;
use App\Http\Controllers\VideoStoryController;
use App\Http\Controllers\WhatsappChatController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Middleware\CheckAdminToken;
use Illuminate\Support\Facades\Route;

// Dynamic OG image — stats text reflects live course count from DB
Route::get('/og-image', [OgImageController::class, 'show']);

// Admin authentication — session-token flow used by the React admin panel
Route::middleware('throttle:admin-auth')->post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);
Route::middleware('throttle:admin-auth')->post('/admin/change-password', [AdminAuthController::class, 'changePassword']);
Route::middleware('throttle:admin-forgot')->post('/admin/forgot-password', [AdminAuthController::class, 'forgotPassword']);
Route::middleware('throttle:admin-auth')->post('/admin/reset-password', [AdminAuthController::class, 'resetPassword']);

// Dynamic course sitemap — referenced by robots.txt and llms.txt
Route::get('/sitemap.xml', [SitemapController::class, 'courses']);

// Health check
Route::get('/healthz', [HealthController::class, 'index']);
Route::middleware(CheckAdminToken::class)->post('/healthz/email-probe', [LeadController::class, 'emailProbe']);

// Status page — HTML and JSON (no auth, no rate-limit: it's public and cheap)
Route::get('/status',      [StatusController::class, 'html']);
Route::get('/status.json', [StatusController::class, 'json']);

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// Courses — public
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{slug}', [CourseController::class, 'show']);

// Courses — admin (must be defined before {slug} wildcard)
Route::middleware(CheckAdminToken::class)->group(function () {
    Route::post('/courses/admin', [CourseController::class, 'store']);
    Route::put('/courses/admin/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/admin/{id}', [CourseController::class, 'destroy']);
});

// Stats
Route::get('/stats', [StatsController::class, 'index']);

// Testimonials — public
Route::middleware('throttle:60,1')->get('/testimonials', [TestimonialController::class, 'index']);

// Testimonials — admin
Route::middleware(CheckAdminToken::class)->group(function () {
    Route::get('/testimonials/admin', [TestimonialController::class, 'adminIndex']);
    Route::post('/testimonials/admin', [TestimonialController::class, 'store']);
    Route::patch('/testimonials/admin/{id}/visibility', [TestimonialController::class, 'updateVisibility']);
    Route::delete('/testimonials/admin/{id}', [TestimonialController::class, 'destroy']);
});

// Leads
Route::middleware('throttle:leads')->post('/leads', [LeadController::class, 'store']);

// Chat
Route::middleware('throttle:chat')->post('/chat', [ChatController::class, 'send']);

// Translate
Route::middleware('throttle:translate')->post('/translate', [TranslateController::class, 'translate']);
Route::middleware('throttle:translate-batch')->post('/translate/batch', [TranslateController::class, 'translateBatch']);

// Proofs — public
Route::middleware('throttle:proofs')->get('/proofs', [ProofController::class, 'index']);

// Proofs — admin
Route::middleware(CheckAdminToken::class)->group(function () {
    Route::post('/proofs', [ProofController::class, 'store']);
    Route::delete('/proofs/{id}', [ProofController::class, 'destroy']);
});

// WhatsApp chats — public
Route::middleware('throttle:whatsapp')->get('/whatsapp-chats', [WhatsappChatController::class, 'index']);

// WhatsApp chats — admin
Route::middleware(CheckAdminToken::class)->group(function () {
    Route::post('/whatsapp-chats', [WhatsappChatController::class, 'store']);
    Route::put('/whatsapp-chats/{id}', [WhatsappChatController::class, 'update']);
    Route::delete('/whatsapp-chats/{id}', [WhatsappChatController::class, 'destroy']);
});

// Video stories
Route::get('/video-stories', [VideoStoryController::class, 'index']);

Route::middleware(CheckAdminToken::class)->group(function () {
    Route::post('/video-stories', [VideoStoryController::class, 'store']);
    Route::put('/video-stories/{id}', [VideoStoryController::class, 'update']);
    Route::delete('/video-stories/{id}', [VideoStoryController::class, 'destroy']);
});
