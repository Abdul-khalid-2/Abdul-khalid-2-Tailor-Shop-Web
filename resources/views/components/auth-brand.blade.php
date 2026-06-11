@props([
    'title' => 'Welcome',
    'subtitle' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ $brandName ?? config('app.name', 'Tailor Shop') }}</title>
    <link rel="shortcut icon" href="{{ $brandFavicon ?? asset('/backend/assets/images/favicon.ico') }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-black: #121212;
            --secondary-black: #1e1e1e;
            --primary-gold: radial-gradient(circle at 30% 30%, #f7e486 0%, #e9d275 18%, #E6C35C 35%, #D4AF37 55%, #e7b836 72%, #daac2d 88%, #a58019 100%);
            --primary-gold-solid: #D4AF37;
            --light-gray: #E5E5E5;
            --text-gray: #888888;
        }

        body { font-family: 'Inter', sans-serif; color: var(--primary-black); background-color: #f4f4f4; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; font-weight: 600; }

        .auth-wrapper { min-height: 100vh; }

        /* ── Brand panel ── */
        .auth-brand-panel {
            background: linear-gradient(rgba(18,18,18,.82), rgba(18,18,18,.92)),
                url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1400&q=80');
            background-size: cover; background-position: center;
            color: #fff; padding: 3rem; position: relative;
        }
        .auth-logo { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #fff; text-decoration: none; }
        .auth-logo span { background: var(--primary-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .auth-brand-tagline { font-size: 2.2rem; line-height: 1.3; margin: 1.5rem 0; }
        .auth-brand-tagline span { background: var(--primary-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .auth-feature { display: flex; align-items: center; margin-bottom: 1rem; color: var(--light-gray); }
        .auth-feature i { color: var(--primary-gold-solid); width: 28px; font-size: 1.1rem; }

        /* ── Form panel ── */
        .auth-form-panel { padding: 3rem 2.5rem; display: flex; flex-direction: column; justify-content: center; background: #fff; }
        .auth-form-inner { width: 100%; max-width: 420px; margin: 0 auto; }
        .auth-title { font-size: 2rem; margin-bottom: .25rem; }
        .auth-subtitle { color: var(--text-gray); margin-bottom: 2rem; }

        .form-label { font-weight: 500; font-size: .9rem; }
        .form-control { padding: .7rem 1rem; border: 1px solid var(--light-gray); }
        .form-control:focus { border-color: var(--primary-gold-solid); box-shadow: 0 0 0 .2rem rgba(212,175,55,.15); }
        .form-check-input:checked { background-color: var(--primary-gold-solid); border-color: var(--primary-gold-solid); }
        .form-check-input:focus { box-shadow: 0 0 0 .2rem rgba(212,175,55,.2); }

        .btn-gold { background: var(--primary-gold); color: var(--primary-black); font-weight: 600; border: none; padding: .75rem 2rem; border-radius: 4px; transition: all .3s ease; }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(140,111,28,.3); color: var(--primary-black); }

        .auth-link { color: var(--primary-gold-solid); text-decoration: none; font-weight: 500; }
        .auth-link:hover { text-decoration: underline; }

        @media (max-width: 991px) { .auth-form-panel { padding: 2.5rem 1.5rem; } }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row auth-wrapper">
            <!-- Brand side -->
            <div class="col-lg-6 auth-brand-panel d-none d-lg-flex flex-column">
                <a href="{{ url('/') }}" class="auth-logo">
                    @if(!empty($brandLogo))
                        <img src="{{ $brandLogo }}" alt="{{ $brandName }}" style="max-height:44px;">
                    @else
                        <span>{{ $brandName ?? 'Tailor Shop' }}</span>
                    @endif
                </a>
                <div class="mt-auto">
                    <h2 class="auth-brand-tagline">Premium Tailoring &amp; <span>Bespoke Suits</span></h2>
                    <div class="auth-feature"><i class="fas fa-cut"></i> Expert craftsmanship since 2010</div>
                    <div class="auth-feature"><i class="fas fa-ruler-combined"></i> Precise measurements, perfect fit</div>
                    <div class="auth-feature"><i class="fas fa-store"></i> Trusted across multiple branches</div>
                </div>
                <p class="mt-auto mb-0 text-muted small">&copy; {{ date('Y') }} {{ $brandName ?? 'Tailor Shop' }}. All rights reserved.</p>
            </div>

            <!-- Form side -->
            <div class="col-lg-6 auth-form-panel">
                <div class="auth-form-inner">
                    <a href="{{ url('/') }}" class="auth-logo text-dark d-lg-none mb-4 d-inline-block">
                        @if(!empty($brandLogo))
                            <img src="{{ $brandLogo }}" alt="{{ $brandName }}" style="max-height:40px;">
                        @else
                            <span>{{ $brandName ?? 'Tailor Shop' }}</span>
                        @endif
                    </a>
                    <h1 class="auth-title">{{ $title }}</h1>
                    @if($subtitle)
                        <p class="auth-subtitle">{{ $subtitle }}</p>
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
