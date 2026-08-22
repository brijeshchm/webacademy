<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //$this->configureRateLimiters();
    }

    private function configureRateLimiters(): void
    {
        // POST /api/leads — 5 per minute per IP
        RateLimiter::for('leads', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // POST /api/chat — 20 per minute per IP
        RateLimiter::for('chat', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip());
        });

        // POST /api/translate — 30 per minute per IP
        RateLimiter::for('translate', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });

        // POST /api/translate/batch — 60 per minute per IP (matches the Node API;
        // batches are mostly served from the translations cache without LLM calls)
        RateLimiter::for('translate-batch', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        // GET /api/proofs — 60 per minute per IP
        RateLimiter::for('proofs', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        // GET /api/whatsapp-chats — 60 per minute per IP
        RateLimiter::for('whatsapp', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        // POST /api/admin/login, change-password, reset-password — 10/min per IP
        RateLimiter::for('admin-auth', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        // POST /api/admin/forgot-password — 1/min AND 5/15min per IP
        // (the persistent DB send-slot in the controller adds a global cap)
        RateLimiter::for('admin-forgot', function (Request $request) {
            return [
                Limit::perMinute(1)->by($request->ip()),
                Limit::perMinutes(15, 5)->by($request->ip()),
            ];
        });
    }
}
