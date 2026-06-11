<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $brandName ?? 'Tailor Shop' }} | Premium Tailoring & Bespoke Suits</title>
    <link rel="shortcut icon" href="{{ $brandFavicon ?? asset('/backend/assets/images/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-black: #121212;
            --secondary-black: #1e1e1e;
            --primary-gold: radial-gradient(circle at 30% 30%, #f7e486 0%, #e9d275 18%, #E6C35C 35%, #D4AF37 55%, #e7b836 72%, #daac2d 88%, #a58019 100%);
            --primary-gold-solid: #D4AF37;
            --light-gold: #F4E4A6;
            --dark-gold: #8C6F1C;
            --primary-white: #FFFFFF;
            --off-white: #F8F8F8;
            --light-gray: #E5E5E5;
            --text-gray: #888888;
        }

        body { font-family: 'Inter', sans-serif; color: var(--primary-black); background-color: var(--primary-white); overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; font-weight: 600; }

        /* ── Navbar ── */
        .navbar { background-color: var(--primary-white); box-shadow: 0 4px 12px rgba(0,0,0,.05); padding: 1rem 0; transition: all .3s ease; }
        .navbar-brand { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: var(--primary-black) !important; }
        .navbar-brand span { background: var(--primary-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .nav-link { color: var(--primary-black) !important; font-weight: 500; margin: 0 .5rem; transition: color .3s; position: relative; }
        .nav-link::after { content: ''; position: absolute; width: 0; height: 2px; bottom: 0; left: 0; background: var(--primary-gold); transition: width .3s ease; }
        .nav-link:hover::after { width: 100%; }
        .navbar-toggler { border: none; } .navbar-toggler:focus { box-shadow: none; }

        /* ── Hero ── */
        .hero-section {
            background: linear-gradient(rgba(18,18,18,.88), rgba(18,18,18,.92)),
                url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1950&q=80');
            background-size: cover; background-position: center;
            color: var(--primary-white); padding: 9rem 0 7rem; position: relative;
        }
        .hero-title { font-size: 3.6rem; font-weight: 700; margin-bottom: 1.5rem; line-height: 1.2; }
        .hero-subtitle { font-size: 1.2rem; margin-bottom: 2rem; max-width: 600px; color: var(--light-gray); }
        .hero-highlight { background: var(--primary-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* ── Buttons ── */
        .btn-gold { background: var(--primary-gold); color: var(--primary-black); font-weight: 600; border: none; padding: .8rem 2rem; border-radius: 4px; transition: all .3s ease; }
        .btn-gold:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(140,111,28,.3); color: var(--primary-black); }

        /* ── Section titles ── */
        .section-title { font-size: 2.5rem; margin-bottom: 3rem; position: relative; display: inline-block; }
        .section-title::after { content: ''; position: absolute; width: 60%; height: 4px; background: var(--primary-gold); bottom: -10px; left: 0; border-radius: 2px; }
        .section-pad { padding: 4rem 0; }
        .bg-soft { background-color: var(--off-white); }

        /* ── Service Cards ── */
        .service-card {
            border-radius: 10px; overflow: hidden; margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,.06); transition: all .3s ease;
            background-color: var(--primary-white); border: 1px solid var(--light-gray);
            position: relative; padding: 2rem 1.5rem; text-align: center;
        }
        .service-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--primary-gold); opacity: 0; transition: opacity .3s; }
        .service-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,.1); border-color: transparent; }
        .service-card:hover::before { opacity: 1; }
        .service-icon { font-size: 2.5rem; margin-bottom: 1rem; background: var(--primary-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .service-title { font-size: 1.3rem; font-weight: 600; margin-bottom: .75rem; }
        .service-desc { color: #666; font-size: .95rem; line-height: 1.7; }

        /* ── Process Steps ── */
        .process-step { text-align: center; padding: 1.5rem 1rem; }
        .step-number { width: 60px; height: 60px; border-radius: 50%; background: var(--primary-gold); color: var(--primary-black); font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem; box-shadow: 0 5px 15px rgba(140,111,28,.3); }
        .step-title { font-size: 1.1rem; font-weight: 600; margin-bottom: .5rem; }
        .step-desc { color: #666; font-size: .9rem; }
        .process-connector { position: relative; }
        .process-connector::after { content: '→'; position: absolute; top: 30px; right: -15px; color: var(--primary-gold-solid); font-size: 1.5rem; }

        /* ── Measurement Image ── */
        .measurement-visual { border-radius: 10px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,.15); }
        .measurement-list { list-style: none; padding: 0; }
        .measurement-list li { padding: .6rem 0; border-bottom: 1px solid var(--light-gray); display: flex; align-items: center; color: #555; }
        .measurement-list li i { color: var(--primary-gold-solid); width: 24px; margin-right: .5rem; }

        /* ── Suit Showcase ── */
        .suit-card { border-radius: 10px; overflow: hidden; margin-bottom: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,.07); transition: all .3s ease; background-color: var(--primary-white); border: 1px solid var(--light-gray); position: relative; }
        .suit-card:hover { box-shadow: 0 12px 28px rgba(0,0,0,.12); transform: translateY(-6px); border-color: transparent; }
        .suit-card:hover::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--primary-gold); z-index: 2; }
        .suit-img-wrap { height: 300px; overflow: hidden; position: relative; }
        .suit-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
        .suit-card:hover .suit-img-wrap img { transform: scale(1.06); }
        .suit-badge { position: absolute; top: 12px; left: 12px; background: var(--primary-gold); color: var(--primary-black); padding: 4px 14px; border-radius: 20px; font-size: .78rem; font-weight: 700; z-index: 2; box-shadow: 0 4px 10px rgba(140,111,28,.3); }
        .suit-info { padding: 1.4rem; }
        .suit-name { font-size: 1.1rem; font-weight: 600; margin-bottom: .4rem; }
        .suit-price { font-size: 1.2rem; font-weight: 700; background: linear-gradient(to right, #BF953F, #B38728, #FBF5B7, #AA771C); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .suit-colors { display: flex; margin-top: .5rem; }
        .color-dot { width: 18px; height: 18px; border-radius: 50%; margin-right: 7px; border: 2px solid var(--light-gray); transition: transform .2s, border-color .2s; cursor: pointer; }
        .color-dot:hover { transform: scale(1.2); border-color: var(--primary-gold-solid); }

        /* ── Slider ── */
        .image-slider { margin: 4rem 0; }
        .slider-item { border-radius: 10px; overflow: hidden; height: 420px; position: relative; }
        .slider-img { width: 100%; height: 100%; object-fit: cover; }
        .carousel-control-prev, .carousel-control-next { width: 50px; height: 50px; background: var(--primary-gold); border-radius: 50%; top: 50%; transform: translateY(-50%); opacity: .85; transition: all .3s; }
        .carousel-control-prev { left: 20px; } .carousel-control-next { right: 20px; }
        .carousel-control-prev:hover, .carousel-control-next:hover { opacity: 1; transform: translateY(-50%) scale(1.1); }
        .slider-dots { display: flex; justify-content: center; margin-top: 1.5rem; }
        .slider-dot { width: 12px; height: 12px; border-radius: 50%; background-color: var(--light-gray); margin: 0 8px; cursor: pointer; transition: all .3s; }
        .slider-dot.active { background: var(--primary-gold-solid); transform: scale(1.2); }

        /* ── Stats ── */
        .stats-section {
            background: linear-gradient(rgba(18,18,18,.92), rgba(18,18,18,.92)),
                url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1950&q=80');
            background-size: cover; background-position: center; background-attachment: fixed;
            color: var(--primary-white); padding: 4rem 0;
        }
        .stat-item { text-align: center; padding: 1rem; }
        .stat-number { font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; background: var(--primary-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1; }
        .stat-label { text-transform: uppercase; letter-spacing: 1px; font-size: .9rem; color: var(--light-gray); margin-top: .75rem; }

        /* ── Testimonials ── */
        .testimonial-card { background: var(--primary-white); border: 1px solid var(--light-gray); border-radius: 10px; padding: 2rem; height: 100%; box-shadow: 0 5px 15px rgba(0,0,0,.05); transition: all .3s; position: relative; }
        .testimonial-card:hover { transform: translateY(-6px); box-shadow: 0 15px 30px rgba(0,0,0,.1); border-color: transparent; }
        .testimonial-quote { font-size: 2.5rem; color: var(--primary-gold-solid); line-height: 1; margin-bottom: .5rem; opacity: .5; }
        .testimonial-stars { color: var(--primary-gold-solid); margin-bottom: 1rem; }
        .testimonial-text { color: #555; font-style: italic; margin-bottom: 1.5rem; line-height: 1.7; }
        .testimonial-author { display: flex; align-items: center; }
        .testimonial-avatar { width: 55px; height: 55px; border-radius: 50%; object-fit: cover; margin-right: 1rem; border: 2px solid var(--primary-gold-solid); }
        .testimonial-name { font-weight: 600; margin: 0; }
        .testimonial-role { color: var(--text-gray); font-size: .85rem; }

        /* ── Branch ── */
        .branch-card { border-radius: 10px; overflow: hidden; background: var(--primary-white); border: 1px solid var(--light-gray); box-shadow: 0 5px 15px rgba(0,0,0,.05); transition: all .3s; height: 100%; }
        .branch-card:hover { transform: translateY(-6px); box-shadow: 0 15px 30px rgba(0,0,0,.1); border-color: transparent; }
        .branch-img { height: 200px; width: 100%; object-fit: cover; }
        .branch-body { padding: 1.5rem; }
        .branch-name { font-size: 1.3rem; margin-bottom: 1rem; }
        .branch-meta { list-style: none; padding: 0; margin: 0; }
        .branch-meta li { color: #555; margin-bottom: .6rem; display: flex; align-items: flex-start; }
        .branch-meta li i { color: var(--primary-gold-solid); width: 22px; margin-top: 4px; }

        /* ── Contact ── */
        .contact-section { background-color: var(--secondary-black); color: var(--primary-white); }
        .contact-info-item { display: flex; align-items: center; margin-bottom: 1.5rem; }
        .contact-icon { width: 50px; height: 50px; min-width: 50px; border-radius: 50%; background: var(--primary-gold); color: var(--primary-black); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-right: 1rem; }
        .contact-form .form-control { background-color: var(--primary-black); border: 1px solid #333; color: var(--primary-white); padding: .8rem 1rem; margin-bottom: 1rem; }
        .contact-form .form-control:focus { border-color: var(--primary-gold-solid); box-shadow: 0 0 0 .2rem rgba(212,175,55,.15); background-color: var(--primary-black); color: var(--primary-white); }
        .contact-form .form-control::placeholder { color: #888; }

        /* ── WhatsApp Float ── */
        .whatsapp-float { position: fixed; bottom: 30px; right: 30px; z-index: 999; }
        .whatsapp-btn { width: 60px; height: 60px; border-radius: 50%; background: #25D366; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.7rem; box-shadow: 0 5px 20px rgba(37,211,102,.45); text-decoration: none; transition: all .3s; }
        .whatsapp-btn:hover { transform: scale(1.12); color: #fff; box-shadow: 0 8px 25px rgba(37,211,102,.55); }

        /* ── Footer ── */
        .footer { background-color: var(--primary-black); color: var(--primary-white); padding: 4rem 0 2rem; margin-top: 4rem; position: relative; }
        .footer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--primary-gold); }
        .footer-title { font-size: 1.5rem; margin-bottom: 1.5rem; color: var(--primary-white); }
        .footer-title span { background: var(--primary-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .footer-links { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: .8rem; position: relative; padding-left: 0; transition: padding-left .3s; }
        .footer-links li:hover { padding-left: 10px; }
        .footer-links a { color: var(--text-gray); text-decoration: none; transition: color .3s; }
        .footer-links a:hover { color: var(--light-gold); }
        .social-icons { display: flex; margin-top: 1.5rem; }
        .social-icon { width: 40px; height: 40px; border-radius: 50%; background-color: var(--secondary-black); display: flex; align-items: center; justify-content: center; margin-right: 10px; color: var(--primary-white); text-decoration: none; transition: all .3s; position: relative; overflow: hidden; }
        .social-icon::before { content: ''; position: absolute; inset: 0; background: var(--primary-gold); opacity: 0; transition: opacity .3s; }
        .social-icon:hover { transform: translateY(-5px); color: var(--primary-black); }
        .social-icon:hover::before { opacity: 1; }
        .social-icon i { position: relative; z-index: 1; }
        .copyright { border-top: 1px solid var(--secondary-black); padding-top: 2rem; margin-top: 3rem; text-align: center; color: var(--text-gray); }

        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--off-white); }
        ::-webkit-scrollbar-thumb { background: var(--primary-gold-solid); border-radius: 4px; }

        @media (max-width: 768px) {
            .hero-title { font-size: 2.4rem; }
            .section-title { font-size: 2rem; }
            .process-connector::after { display: none; }
        }
    </style>
</head>

<body>

<!-- ══ NAVBAR ══════════════════════════════════════════════════════ -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            @if(!empty($brandLogo))
                <img src="{{ $brandLogo }}" alt="{{ $brandName }}" style="max-height:42px;" class="mr-2">
            @endif
            {{ $brandName ?? 'Tailor Shop' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#suits">Suits</a></li>
                <li class="nav-item"><a class="nav-link" href="#process">How It Works</a></li>
                <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
                <li class="nav-item"><a class="nav-link" href="#branches">Branches</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        @hasanyrole('superadmin|admin')
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @endhasanyrole
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@if(session('success') || session('status'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') ?? session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container mt-4">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

<main>

<!-- ══ HERO ════════════════════════════════════════════════════════ -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="hero-title">
                    Perfectly Stitched,<br>
                    <span class="hero-highlight">Perfectly Yours</span>
                </h1>
                <p class="hero-subtitle">
                    Bespoke suits, shalwar kameez, and sherwanis — tailored to your exact measurements
                    by master craftsmen with decades of experience.
                </p>
                <a href="#suits" class="btn btn-gold me-2">View Our Work</a>
                <a href="#contact" class="btn btn-outline-light px-4 py-2">Book Appointment</a>
            </div>
        </div>
    </div>
</section>

<!-- ══ SERVICES ═════════════════════════════════════════════════════ -->
<section class="section-pad" id="services">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Services</h2>
        </div>
        <div class="row">
            @php
            $services = [
                ['icon' => 'fas fa-tshirt',          'title' => 'Shalwar Kameez',    'desc' => 'Custom stitched shalwar kameez in any style — from everyday casual to formal wedding wear, with precise measurements.'],
                ['icon' => 'fas fa-crown',            'title' => 'Sherwani & Achkan', 'desc' => 'Elegant sherwanis for weddings and special occasions. Traditional craftsmanship with modern finishing.'],
                ['icon' => 'fas fa-briefcase',        'title' => 'Formal Suits',      'desc' => 'Two-piece and three-piece suits tailored for business and formal events. Perfect fit guaranteed.'],
                ['icon' => 'fas fa-scissors',         'title' => 'Alterations',       'desc' => 'Expert alterations and repairs on any garment. Resizing, shortening, and modifications done with care.'],
                ['icon' => 'fas fa-ruler-combined',   'title' => 'Custom Measurements','desc' => 'We record and save your measurements so every future order is ready without starting from scratch.'],
                ['icon' => 'fas fa-truck',            'title' => 'Home Delivery',     'desc' => 'Get your finished suits delivered to your doorstep on time, with proper packaging.'],
            ];
            @endphp
            @foreach($services as $service)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <div class="service-icon"><i class="{{ $service['icon'] }}"></i></div>
                    <h4 class="service-title">{{ $service['title'] }}</h4>
                    <p class="service-desc">{{ $service['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══ SUIT SHOWCASE ════════════════════════════════════════════════ -->
<section class="bg-soft section-pad" id="suits">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Featured Suits &amp; Pricing</h2>
        </div>
        <div class="row" id="suitGrid">
            @php
            $suits = [
                [
                    'name'    => 'Classic Shalwar Kameez',
                    'price'   => 'From Rs 2,500',
                    'badge'   => 'BEST SELLER',
                    'img'     => 'assets/landing-page-images/Classic-shalwar-kameez.jpg',
                    'colors'  => ['#2C3E50','#5D6D7E','#1ABC9C','#E74C3C'],
                    'desc'    => 'Cotton / Lawn / Khaddar',
                ],
                [
                    'name'    => 'Premium Sherwani',
                    'price'   => 'From Rs 8,000',
                    'badge'   => 'WEDDING',
                    'img'     => 'assets/landing-page-images/premium-sherwani.jpg',
                    'colors'  => ['#D4AF37','#121212','#7D3C98','#C0392B'],
                    'desc'    => 'Silk / Velvet / Brocade',
                ],
                [
                    'name'    => 'Business Formal Suit',
                    'price'   => 'From Rs 5,000',
                    'badge'   => 'NEW',
                    'img'     => 'assets/landing-page-images/Business-formal-suit.jpg',
                    'colors'  => ['#1C2833','#5D6D7E','#117A65','#784212'],
                    'desc'    => 'Wool / Polyester Blend',
                ],
                [
                    'name'    => 'Kurta Pajama',
                    'price'   => 'From Rs 1,800',
                    'badge'   => null,
                    'img'     => 'assets/landing-page-images/Kurta-pajama.jpg',
                    'colors'  => ['#ECF0F1','#F9E79F','#D2B4DE','#AED6F1'],
                    'desc'    => 'Cotton / Silk / Chiffon',
                ],
                [
                    'name'    => 'Party Wear Suit',
                    'price'   => 'From Rs 4,500',
                    'badge'   => 'POPULAR',
                    'img'     => 'assets/landing-page-images/Party-wear-suit.jpg',
                    'colors'  => ['#D4AC0D','#2E4057','#C0392B','#117A65'],
                    'desc'    => 'Jamawar / Brocade / Silk',
                ],
                [
                    'name'    => 'Kids Shalwar Kameez',
                    'price'   => 'From Rs 1,200',
                    'badge'   => null,
                    'img'     => 'assets/landing-page-images/Kids-shalwar-kameez.jpg',
                    'colors'  => ['#3498DB','#E74C3C','#2ECC71','#F39C12'],
                    'desc'    => 'All fabrics available',
                ],
            ];
            @endphp
            @foreach($suits as $suit)
            <div class="col-md-6 col-lg-4">
                <div class="suit-card">
                    @if($suit['badge'])
                    <div class="suit-badge">{{ $suit['badge'] }}</div>
                    @endif
                    <div class="suit-img-wrap">
                        <img src="{{ asset($suit['img']) }}" alt="{{ $suit['name'] }}">
                    </div>
                    <div class="suit-info">
                        <h5 class="suit-name">{{ $suit['name'] }}</h5>
                        <div class="text-muted mb-1" style="font-size:.9rem;">{{ $suit['desc'] }}</div>
                        <div class="suit-price">{{ $suit['price'] }}</div>
                        <div class="suit-colors mt-2">
                            @foreach($suit['colors'] as $color)
                            <div class="color-dot" style="background-color:{{ $color }};"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══ SLIDER ═══════════════════════════════════════════════════════ -->
<section class="">
    <div class="container image-slider">
        <div id="tailorSlider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded">
                <div class="carousel-item active">
                    <div class="slider-item">
                        <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1950&q=80" class="slider-img" alt="Tailoring craftsmanship">
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="slider-item">
                        <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1950&q=80" class="slider-img" alt="Formal suits">
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="slider-item">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=1950&q=80" class="slider-img" alt="Bespoke tailoring">
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#tailorSlider" data-bs-slide="prev">
                <i class="fas fa-chevron-left text-dark"></i><span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#tailorSlider" data-bs-slide="next">
                <i class="fas fa-chevron-right text-dark"></i><span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="slider-dots">
            <span class="slider-dot active"></span>
            <span class="slider-dot"></span>
            <span class="slider-dot"></span>
        </div>
    </div>
</section>

<!-- ══ HOW IT WORKS ═════════════════════════════════════════════════ -->
<section class="section-pad" id="process">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">How It Works</h2>
        </div>
        <div class="row justify-content-center">
            @php
            $steps = [
                ['num'=>'1','title'=>'Visit or Call Us',    'desc'=>'Come to any branch or call us to book your appointment at a convenient time.'],
                ['num'=>'2','title'=>'Take Measurements',   'desc'=>'Our expert tailor records all your body measurements carefully and saves them for future orders.'],
                ['num'=>'3','title'=>'Choose Your Style',   'desc'=>'Select suit type, fabric, color and any special finishing you want.'],
                ['num'=>'4','title'=>'We Stitch Your Suit', 'desc'=>'Your suit is assigned to a skilled tailor and stitched with precision by the delivery date.'],
                ['num'=>'5','title'=>'Collect or Delivery', 'desc'=>'Pick it up from the branch or get it delivered to your home — perfectly packed.'],
            ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="col-6 col-md-4 col-lg-2 {{ $i < count($steps)-1 ? 'process-connector' : '' }}">
                <div class="process-step">
                    <div class="step-number">{{ $step['num'] }}</div>
                    <h6 class="step-title">{{ $step['title'] }}</h6>
                    <p class="step-desc">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══ MEASUREMENTS SECTION ════════════════════════════════════════ -->
<section class="bg-soft section-pad">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="section-title">Precise Measurements<br>Every Time</h2>
                <p class="text-muted mb-4">
                    We record and store your complete measurements so every order —
                    whether it's your first suit or your tenth — fits you perfectly without
                    needing to come in for a fitting again.
                </p>
                <ul class="measurement-list">
                    @php
                    $measures = ['Length','Shoulder','Chest','Waist','Hip','Sleeve','Collar','Trouser Length','Trouser Waist','Thigh'];
                    @endphp
                    @foreach($measures as $m)
                    <li><i class="fas fa-check-circle"></i> {{ $m }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="measurement-visual">
                    <img src="{{ asset('assets/landing-page-images/Precise-measurements.jpg') }}"
                         alt="Measurement process" class="img-fluid"
                         style="border-radius:10px; width:100%; height:450px; object-fit:cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ STATS ════════════════════════════════════════════════════════ -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-number">15+</div><div class="stat-label">Years in Business</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-number">8,000+</div><div class="stat-label">Suits Stitched</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-number">3,500+</div><div class="stat-label">Happy Customers</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-number">4.9★</div><div class="stat-label">Average Rating</div></div></div>
        </div>
    </div>
</section>

<!-- ══ REVIEWS ══════════════════════════════════════════════════════ -->
<section class="section-pad" id="reviews">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">What Our Customers Say</h2>
        </div>
        <div class="row">
            @php
            $reviews = [
                ['name'=>'Ahmed Raza',    'city'=>'Lahore',    'stars'=>5, 'avatar'=>'https://randomuser.me/api/portraits/men/32.jpg',
                 'text'=>'My sherwani was stitched perfectly for my wedding. The tailor understood exactly what I wanted. Delivered 2 days early. Highly recommended!'],
                ['name'=>'Usman Tariq',   'city'=>'Karachi',   'stars'=>5, 'avatar'=>'https://randomuser.me/api/portraits/men/44.jpg',
                 'text'=>'I have been getting my suits stitched here for 5 years. The quality and fitting is always spot-on. No one else compares.'],
                ['name'=>'Hamza Sheikh',  'city'=>'Islamabad', 'stars'=>4, 'avatar'=>'https://randomuser.me/api/portraits/men/68.jpg',
                 'text'=>'Great experience. They saved my measurements so when I ordered again it was very fast. The shalwar kameez fits perfectly.'],
            ];
            @endphp
            @foreach($reviews as $review)
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-quote"><i class="fas fa-quote-left"></i></div>
                    <div class="testimonial-stars">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fa{{ $i < $review['stars'] ? 's' : 'r' }} fa-star"></i>
                        @endfor
                    </div>
                    <p class="testimonial-text">{{ $review['text'] }}</p>
                    <div class="testimonial-author">
                        <img src="{{ $review['avatar'] }}" class="testimonial-avatar" alt="{{ $review['name'] }}">
                        <div>
                            <p class="testimonial-name">{{ $review['name'] }}</p>
                            <span class="testimonial-role">{{ $review['city'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══ BRANCHES ════════════════════════════════════════════════════ -->
<section class="bg-soft section-pad" id="branches">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Branches</h2>
        </div>
        <div class="row">
            @php
            $branches = [
                ['name'=>'Karachi — Main Branch',  'img'=>'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&q=80', 'address'=>'Tariq Road, PECHS Block 2, Karachi', 'phone'=>'+92 300 1234567', 'hours'=>'Mon – Sat: 10:00 AM – 9:00 PM'],
                ['name'=>'Lahore — Gulberg',        'img'=>'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&w=800&q=80', 'address'=>'Liberty Market, Gulberg III, Lahore',  'phone'=>'+92 321 7654321', 'hours'=>'Mon – Sun: 11:00 AM – 9:00 PM'],
                ['name'=>'Islamabad — F-10',        'img'=>'https://images.unsplash.com/photo-1604335399105-a0c585fd81a1?auto=format&fit=crop&w=800&q=80', 'address'=>'Jinnah Super, F-10 Markaz, Islamabad',  'phone'=>'+92 333 9876543', 'hours'=>'Mon – Sat: 10:00 AM – 8:30 PM'],
            ];
            @endphp
            @foreach($branches as $branch)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="branch-card">
                    <img src="{{ $branch['img'] }}" class="branch-img" alt="{{ $branch['name'] }}">
                    <div class="branch-body">
                        <h3 class="branch-name">{{ $branch['name'] }}</h3>
                        <ul class="branch-meta">
                            <li><i class="fas fa-map-marker-alt"></i><span>{{ $branch['address'] }}</span></li>
                            <li><i class="fas fa-phone"></i><span>{{ $branch['phone'] }}</span></li>
                            <li><i class="fas fa-clock"></i><span>{{ $branch['hours'] }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══ CONTACT ══════════════════════════════════════════════════════ -->
<section class="contact-section section-pad" id="contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h2 class="footer-title">Get in <span>Touch</span></h2>
                <p class="text-muted mb-4">Want to place an order, ask about pricing, or book an appointment? We are happy to help.</p>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div><strong>Head Office</strong><br><span class="text-muted">Tariq Road, PECHS Block 2, Karachi</span></div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
                    <div><strong>WhatsApp</strong><br><span class="text-muted">+92 300 1234567</span></div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div><strong>Email</strong><br><span class="text-muted">info@royalstitch.pk</span></div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <div><strong>Working Hours</strong><br><span class="text-muted">Mon – Sat: 10:00 AM – 9:00 PM</span></div>
                </div>
            </div>
            <div class="col-lg-7">
                <form class="contact-form" onsubmit="event.preventDefault(); this.reset(); alert('Thank you! We will contact you shortly.');">
                    <div class="row">
                        <div class="col-md-6"><input type="text" class="form-control" placeholder="Your Name" required></div>
                        <div class="col-md-6"><input type="tel" class="form-control" placeholder="Phone Number" required></div>
                    </div>
                    <input type="text" class="form-control" placeholder="Suit Type (e.g. Shalwar Kameez, Sherwani)">
                    <textarea class="form-control" rows="5" placeholder="Tell us about your requirement..." required></textarea>
                    <button type="submit" class="btn btn-gold">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

</main>

<!-- ══ FOOTER ═══════════════════════════════════════════════════════ -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h4 class="footer-title">{{ $brandName ?? 'Tailor Shop' }}</h4>
                <p class="text-muted">Master tailors delivering bespoke suits since 2008. Your measurements, your style, your perfect fit.</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#suits">Suits & Pricing</a></li>
                    <li><a href="#branches">Branches</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title">Services</h5>
                <ul class="footer-links">
                    <li><a href="#">Shalwar Kameez</a></li>
                    <li><a href="#">Sherwani & Achkan</a></li>
                    <li><a href="#">Formal Suits</a></li>
                    <li><a href="#">Kids Wear</a></li>
                    <li><a href="#">Alterations</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h5 class="footer-title">Contact Info</h5>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt me-2"></i>Tariq Road, Karachi</li>
                    <li><i class="fas fa-phone me-2"></i>+92 300 1234567</li>
                    <li><i class="fab fa-whatsapp me-2"></i>+92 300 1234567</li>
                    <li><i class="fas fa-envelope me-2"></i>info@royalstitch.pk</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; {{ date('Y') }} Royal Stitch. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- WhatsApp Float Button -->
<a href="https://wa.me/923001234567" target="_blank" class="whatsapp-float">
    <div class="whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
    </div>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Slider dots sync
    const slider = document.getElementById('tailorSlider');
    const dots   = document.querySelectorAll('.slider-dot');

    slider.addEventListener('slid.bs.carousel', function () {
        const active = Array.from(slider.querySelectorAll('.carousel-item'))
                            .findIndex(el => el.classList.contains('active'));
        dots.forEach((d, i) => d.classList.toggle('active', i === active));
    });

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            bootstrap.Carousel.getInstance(slider)?.to(i);
        });
    });

    // Smooth scroll for nav links
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

});
</script>

</body>
</html>