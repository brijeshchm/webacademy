@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $reset = request()->query('reset');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Panel | Corporate Academy</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body>
<div class="min-h-screen bg-gradient-to-br from-foreground to-foreground/90 flex items-center justify-center p-4 text-foreground">
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-10 w-full max-w-sm shadow-2xl">
        <div class="flex justify-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-primary/20 flex items-center justify-center">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-xl bg-green-500/20 border border-green-400/40 text-green-100 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-xl bg-red-500/20 border border-red-400/40 text-red-100 text-sm px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        @if ($reset)
            {{-- ── Reset password (OTP) ── --}}
            <h1 class="text-2xl font-bold text-white text-center mb-2">Reset Password</h1>
            <p class="text-white/50 text-sm text-center mb-8">Enter the 6-digit code sent to the admin email</p>

            <form method="POST" action="{{ route('admin.reset') }}">
                @csrf
                <input
                    type="text"
                    name="otp"
                    inputmode="numeric"
                    maxlength="6"
                    placeholder="6-digit OTP"
                    class="w-full rounded-md bg-white/10 border border-white/20 text-white placeholder:text-white/40 mb-4 text-center tracking-[0.5em] font-bold px-3 py-2"
                    required
                >
                <input
                    type="password"
                    name="newPassword"
                    placeholder="New password (min 8 characters)"
                    minlength="8"
                    class="w-full rounded-md bg-white/10 border border-white/20 text-white placeholder:text-white/40 mb-4 px-3 py-2"
                    required
                >
                <button type="submit" class="w-full rounded-md bg-primary hover:bg-primary/90 text-white font-semibold py-2 mb-3 transition-colors">
                    Reset Password
                </button>
            </form>
            <div class="flex justify-between text-sm">
                <a href="{{ route('admin.login') }}" class="text-white/50 hover:text-white transition-colors">Back to sign in</a>
                <form method="POST" action="{{ route('admin.forgot') }}">
                    @csrf
                    <button type="submit" class="text-primary/80 hover:text-primary transition-colors">Resend OTP</button>
                </form>
            </div>
        @else
            {{-- ── Sign in ── --}}
            <h1 class="text-2xl font-bold text-white text-center mb-2">Admin Panel</h1>
            <p class="text-white/50 text-sm text-center mb-8">Corporate Academy</p>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="relative mb-4">
                    <input
                        type="password"
                        name="password"
                        placeholder="Admin password"
                        class="w-full rounded-md bg-white/10 border border-white/20 text-white placeholder:text-white/40 px-3 py-2"
                        required
                        autofocus
                    >
                </div>
                <button type="submit" class="w-full rounded-md bg-primary hover:bg-primary/90 text-white font-semibold py-2 mb-3 transition-colors">
                    Sign In
                </button>
            </form>

            <form method="POST" action="{{ route('admin.forgot') }}">
                @csrf
                <button type="submit" class="w-full text-center text-sm text-white/50 hover:text-white transition-colors">
                    Forgot password?
                </button>
            </form>
        @endif
    </div>
</div>
</body>
</html>
