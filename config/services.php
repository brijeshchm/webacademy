<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    // Read via config() (not env()) so values survive `php artisan config:cache`.
    'notify' => [
        'email' => env('NOTIFY_EMAIL', 'connectabhihr29@gmail.com'),
        'from' => env('NOTIFY_FROM', 'Corporate Academy <onboarding@resend.dev>'),
        'reply_to' => env('SMTP_USER', 'corporatesacademy2@gmail.com'),
    ],

    'admin' => [
        'password' => env('ADMIN_PASSWORD'),
    ],

    // Public site origin used in sitemap <loc> URLs (no trailing slash needed).
    'site' => [
        'origin' => env('SITE_ORIGIN', 'https://corporateacademy.com'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
