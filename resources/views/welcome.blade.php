<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JaansFabrics.com | Luxury Fabrics Collection</title>
    <!-- CSRF Token for Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
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

        body {
            font-family: 'Inter', sans-serif;
            color: var(--primary-black);
            background-color: var(--primary-white);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        /* Header Styles */
        .navbar {
            background-color: var(--primary-white);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-black) !important;
        }

        .navbar-brand span {
            background: var(--primary-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: var(--primary-black) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-black) !important;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: var(--primary-gold);
            transition: width 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        /* Product Card */
        .product-card {
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            background-color: var(--primary-white);
            position: relative;
            border: 1px solid var(--light-gray);
        }

        .product-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
            border-color: transparent;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary-gold);
            color: var(--primary-black);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(140, 111, 28, 0.3);
        }

        /* Footer */
        .footer {
            background-color: var(--primary-black);
            color: var(--primary-white);
            padding: 4rem 0 2rem;
            margin-top: 4rem;
            position: relative;
        }

        .footer:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gold);
        }

        .footer-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary-white);
        }

        .footer-title span {
            background: var(--primary-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
            position: relative;
            padding-left: 0;
            transition: padding-left 0.3s ease;
        }

        .footer-links li:hover {
            padding-left: 10px;
        }

        .footer-links li:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-gold);
            transition: width 0.3s ease;
        }

        .footer-links li:hover:before {
            width: 6px;
        }

        .footer-links a {
            color: var(--text-gray);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--light-gold);
        }

        .social-icons {
            display: flex;
            margin-top: 1.5rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-black);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: var(--primary-white);
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .social-icon:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gold);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-5px);
        }

        .social-icon:hover:before {
            opacity: 1;
        }

        .social-icon i {
            position: relative;
            z-index: 1;
        }

        .copyright {
            border-top: 1px solid var(--secondary-black);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: var(--text-gray);
        }

        /* Buttons with Gold Gradient */
        .btn-gold {
            background: var(--primary-gold);
            color: var(--primary-black);
            font-weight: 600;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(140, 111, 28, 0.3);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--off-white);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gold);
            border-radius: 4px;
        }

        /* Add more styles as needed from your template */
    </style>

    <style>
        .navbar-toggler {
            border: none;
            color: var(--primary-black);
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(18, 18, 18, 0.85), rgba(18, 18, 18, 0.9)), url('https://images.unsplash.com/photo-1523380744952-b7e00e6e2ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            color: var(--primary-white);
            padding: 8rem 0 6rem;
            position: relative;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
            color: var(--light-gray);
        }

        .hero-highlight {
            background: var(--primary-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Category Section */
        .section-title {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 60%;
            height: 4px;
            background: var(--primary-gold);
            bottom: -10px;
            left: 0;
            border-radius: 2px;
        }

        /* Products Header */
        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .filter-toggle-btn {
            background: var(--primary-gold);
            color: var(--primary-black);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .filter-toggle-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(140, 111, 28, 0.3);
        }

        .sort-dropdown .btn {
            background-color: var(--primary-white);
            border: 1px solid var(--light-gray);
            color: var(--primary-black);
            padding: 0.6rem 1.2rem;
            min-width: 180px;
            text-align: left;
            position: relative;
            transition: all 0.3s ease;
        }

        .sort-dropdown .btn:hover,
        .sort-dropdown .btn:focus {
            border-color: var(--primary-gold-solid);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.1);
        }

        .sort-dropdown .btn:after {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Offcanvas Styles */
        .offcanvas-filter {
            background-color: var(--off-white);
        }

        .offcanvas-filter .offcanvas-header {
            background: var(--primary-gold);
            color: var(--primary-black);
            border-bottom: 1px solid var(--light-gray);
        }

        .offcanvas-filter .offcanvas-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .offcanvas-filter .btn-close {
            background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23121212'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
            opacity: 1;
        }

        .filter-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .filter-title:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: var(--primary-gold);
            bottom: 0;
            left: 0;
            border-radius: 2px;
        }

        .form-check-input:checked {
            background-color: var(--primary-gold-solid);
            border-color: var(--primary-gold-solid);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }

        .btn-apply-filters {
            background: var(--primary-gold);
            color: var(--primary-black);
            font-weight: 600;
            border: none;
            padding: 0.75rem;
            border-radius: 4px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-apply-filters:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(140, 111, 28, 0.3);
        }

        /* Category Card */
        .category-card {
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: var(--primary-white);
            border: 1px solid var(--light-gray);
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: transparent;
        }

        .category-card:hover:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gold);
            z-index: 2;
        }

        .category-img {
            height: 250px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-card:hover .category-img {
            transform: scale(1.05);
        }

        .category-name {
            font-size: 1.4rem;
            font-weight: 600;
            padding: 1.5rem 1rem 0.5rem;
            margin: 0;
        }

        .category-count {
            color: var(--text-gray);
            padding: 0 1rem 1.5rem;
            font-size: 0.9rem;
        }

        /* Product Card */
        .product-card {
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            background-color: var(--primary-white);
            position: relative;
            border: 1px solid var(--light-gray);
        }

        .product-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
            border-color: transparent;
        }

        .product-card:hover:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gold);
            z-index: 2;
        }

        .product-image-container {
            position: relative;
            overflow: hidden;
            height: 280px;
        }

        .product-front-img,
        .product-back-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .product-back-img {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transform: scale(1.1);
        }

        .product-image-container:hover .product-front-img {
            opacity: 0;
            transform: scale(1.1);
        }

        .product-image-container:hover .product-back-img {
            opacity: 1;
            transform: scale(1);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary-gold);
            color: var(--primary-black);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(140, 111, 28, 0.3);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-black);
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            background: linear-gradient(to right, #BF953F, #be9343, #B38728, #FBF5B7, #AA771C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .product-colors {
            display: flex;
            margin-bottom: 0.5rem;
        }

        .color-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 8px;
            border: 2px solid var(--light-gray);
            transition: transform 0.3s ease, border-color 0.3s ease;
            cursor: pointer;
        }

        .color-dot:hover {
            transform: scale(1.2);
            border-color: var(--primary-gold-solid);
        }

        /* Filters */
        .filter-sidebar {
            background-color: var(--off-white);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--light-gray);
            position: relative;
        }

        .filter-sidebar:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gold);
            border-radius: 8px 8px 0 0;
        }

        .filter-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .filter-title:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: var(--primary-gold);
            bottom: 0;
            left: 0;
            border-radius: 2px;
        }

        .form-check-input:checked {
            background-color: var(--primary-gold-solid);
            border-color: var(--primary-gold-solid);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }

        .dropdown-filter {
            margin-bottom: 2rem;
        }

        .dropdown-filter .btn {
            background-color: var(--primary-white);
            border: 1px solid var(--light-gray);
            color: var(--primary-black);
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .dropdown-filter .btn:hover,
        .dropdown-filter .btn:focus {
            border-color: var(--primary-gold-solid);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.1);
        }

        .dropdown-filter .btn:after {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .dropdown-item.active,
        .dropdown-item:active {
            background: var(--primary-gold);
            color: var(--primary-black);
            font-weight: 600;
        }

        /* Chat Widget */
        .chat-widget {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .chat-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gold);
            color: var(--primary-black);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(140, 111, 28, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .chat-button:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(244, 228, 166, 0.8) 0%, rgba(212, 175, 55, 0.8) 50%, rgba(140, 111, 28, 0.8) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .chat-button:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(140, 111, 28, 0.5);
        }

        .chat-button:hover:before {
            opacity: 1;
        }

        .chat-button i {
            position: relative;
            z-index: 1;
        }

        .chat-options {
            position: absolute;
            bottom: 70px;
            right: 0;
            background-color: var(--primary-white);
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
            padding: 1rem;
            width: 200px;
            display: none;
            border: 1px solid var(--light-gray);
        }

        .chat-options.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .chat-option {
            display: flex;
            align-items: center;
            padding: 0.8rem;
            border-radius: 5px;
            margin-bottom: 0.5rem;
            transition: background-color 0.2s, transform 0.2s;
            color: var(--primary-black);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .chat-option:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary-gold);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .chat-option:hover {
            background-color: var(--off-white);
            color: var(--primary-black);
            transform: translateX(5px);
        }

        .chat-option:hover:before {
            opacity: 1;
        }

        .chat-option i {
            margin-right: 10px;
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }

        /* Image Slider */
        .image-slider {
            margin: 4rem 0;
        }

        .slider-item {
            border-radius: 10px;
            overflow: hidden;
            height: 400px;
            position: relative;
        }

        .slider-item:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(244, 228, 166, 0.1) 0%, rgba(212, 175, 55, 0.1) 50%, rgba(140, 111, 28, 0.1) 100%);
            z-index: 1;
        }

        .slider-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            background: var(--primary-gold);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: 20px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
            transform: translateY(-50%) scale(1.1);
        }

        .slider-dots {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--light-gray);
            margin: 0 8px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .slider-dot.active {
            background: var(--primary-gold);
            transform: scale(1.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .products-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .sort-dropdown {
                width: 100%;
            }

            .sort-dropdown .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/Jaans_Fabrics_Logo_Print_Ready_page-0002.jpg') }}" alt="Jaans Fabrics Logo" height="50">
                <span>Fabrics</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Collections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Masterpieces</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Luxury Fabrics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Embroideries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Fancy Collection</a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h4 class="footer-title">Jaans<span>Fabrics</span></h4>
                    <p>Providing premium quality fabrics and embroideries since 2010.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Collections</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title">Categories</h5>
                    <ul class="footer-links">
                        <li><a href="#">Masterpieces</a></li>
                        <li><a href="#">Luxury Fabrics</a></li>
                        <li><a href="#">Embroideries</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="footer-title">Contact Info</h5>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> Main Street, Lahore, Pakistan</li>
                        <li><i class="fas fa-phone me-2"></i> +92 300 1234567</li>
                        <li><i class="fas fa-envelope me-2"></i> info@jaansfabrics.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} JaansFabrics.com. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const productGrid = document.getElementById('productGrid');
            const resetBtn = document.getElementById('resetFilters');

            // All products data
            const allProducts = [{
                    id: 1,
                    name: 'Premium Silk Embroidered',
                    price: 8500,
                    front_image: 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    back_image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    category: 'Embroidered Silk',
                    collection: 'Winter Collection',
                    is_bestseller: true,
                    is_new: false,
                    colors: ['#D4AF37', '#2C3E50', '#7D3C98', '#C0392B'],
                    tags: ['men', 'winter', 'luxury']
                },
                {
                    id: 2,
                    name: 'Cotton Linen Blend',
                    price: 5200,
                    front_image: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    back_image: 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    category: 'Premium Cotton',
                    collection: 'Summer Collection',
                    is_bestseller: false,
                    is_new: false,
                    colors: ['#ECF0F1', '#34495E', '#1ABC9C'],
                    tags: ['men', 'summer', 'luxury']
                },
                {
                    id: 3,
                    name: 'Royal Velvet Collection',
                    price: 12000,
                    front_image: 'https://images.unsplash.com/photo-1562157873-818bc0726f68?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    back_image: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    category: 'Luxury Velvet',
                    collection: 'Winter Collection',
                    is_bestseller: false,
                    is_new: true,
                    colors: ['#2C3E50', '#7D3C98', '#C0392B'],
                    tags: ['women', 'winter', 'luxury']
                },
                {
                    id: 4,
                    name: 'Sheer Chiffon Embroidered',
                    price: 6800,
                    front_image: 'https://images.unsplash.com/photo-1520004434532-668416a08753?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    back_image: 'https://images.unsplash.com/photo-1544441893-675973e31985?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    category: 'Embroidered Chiffon',
                    collection: 'All Seasons',
                    is_bestseller: false,
                    is_new: false,
                    colors: ['#FADBD8', '#D4EFDF', '#D6EAF8', '#FCF3CF'],
                    tags: ['women', 'summer', 'embroidery']
                },
                {
                    id: 5,
                    name: 'Pure Wool Premium',
                    price: 9500,
                    front_image: 'https://tailorbros.com/wp-content/uploads/2023/10/cotton-fabric-unveiled-best-cotton-types-for-mens-suits-3407-2.jpg',
                    back_image: 'https://images.unsplash.com/photo-1519457431-44ccd64a579b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    category: '100% Wool',
                    collection: 'Winter Collection',
                    is_bestseller: false,
                    is_new: false,
                    colors: ['#5D6D7E', '#1C2833', '#641E16'],
                    tags: ['men', 'winter', 'masterpieces']
                },
                {
                    id: 6,
                    name: 'Sparkle Organza Collection',
                    price: 7200,
                    front_image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZQOTC-NUcdS64ezfaqkPTxI8dbonIIsCV6Q&s',
                    back_image: 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80',
                    category: 'Embellished Organza',
                    collection: 'Party Wear',
                    is_bestseller: false,
                    is_new: false,
                    colors: ['#F7DC6F', '#F0B27A', '#D7BDE2'],
                    tags: ['women', 'fancy']
                }
            ];

            // Initial render
            renderProducts(allProducts);

            // Apply filters function
            window.applyFilters = function() {
                const formData = new FormData(filterForm);
                const selectedCategories = [];
                const selectedBrands = [];

                // Get selected categories
                const categoryCheckboxes = filterForm.querySelectorAll('input[name="categories[]"]:checked');
                categoryCheckboxes.forEach(cb => selectedCategories.push(cb.value));

                // Get selected brands
                const brandCheckboxes = filterForm.querySelectorAll('input[name="brands[]"]:checked');
                brandCheckboxes.forEach(cb => selectedBrands.push(cb.value));

                // Get price range
                const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
                const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;

                // Filter products
                const filteredProducts = allProducts.filter(product => {
                    // Check if product matches any selected category
                    const categoryMatch = selectedCategories.length === 0 ||
                        selectedCategories.some(category => product.tags.includes(category));

                    // Check if product matches any selected brand
                    const brandMatch = selectedBrands.length === 0 ||
                        selectedBrands.some(brand => product.tags.includes(brand));

                    // Check price range
                    const priceMatch = product.price >= minPrice && product.price <= maxPrice;

                    return categoryMatch && brandMatch && priceMatch;
                });

                // Render filtered products
                renderProducts(filteredProducts);
            };

            // Sort functionality
            document.querySelectorAll('.dropdown-item[data-sort]').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sortType = this.getAttribute('data-sort');
                    document.getElementById('productSort').textContent = 'Sort by: ' + this.textContent;

                    // Get current products
                    const productCards = Array.from(document.querySelectorAll('.product-card')).map(card => {
                        const productId = parseInt(card.closest('.col-md-6').dataset.productId);
                        return allProducts.find(p => p.id === productId);
                    }).filter(p => p);

                    // Sort products
                    const sortedProducts = sortProducts(productCards, sortType);

                    // Re-render sorted products
                    renderProducts(sortedProducts);
                });
            });

            // Reset filters
            resetBtn.addEventListener('click', function() {
                filterForm.reset();
                renderProducts(allProducts);
            });

            // Render products to grid
            function renderProducts(products) {
                let html = '';
                products.forEach(product => {
                    html += `
                <div class="col-md-6 col-lg-4" data-product-id="${product.id}">
                    <div class="product-card">
                        ${product.is_bestseller ? '<div class="product-badge gold-shimmer">BEST SELLER</div>' : ''}
                        ${product.is_new ? '<div class="product-badge gold-shimmer">NEW</div>' : ''}
                        
                        <div class="product-image-container">
                            <img src="${product.front_image}" class="product-front-img" alt="${product.name}">
                            ${product.back_image ? `<img src="${product.back_image}" class="product-back-img" alt="${product.name} Back">` : ''}
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">${product.name}</h5>
                            <div class="product-price">PKR ${product.price.toLocaleString()}</div>
                            <div class="product-colors">
                                ${product.colors.map(color => `<div class="color-dot" style="background-color: ${color};"></div>`).join('')}
                            </div>
                            <div class="text-muted">${product.category} | ${product.collection}</div>
                        </div>
                    </div>
                </div>
                `;
                });

                productGrid.innerHTML = html;
            }

            // Sort products function
            function sortProducts(products, sortType) {
                const sorted = [...products];

                switch (sortType) {
                    case 'best':
                        // Best selling first
                        sorted.sort((a, b) => (b.is_bestseller ? 1 : 0) - (a.is_bestseller ? 1 : 0));
                        break;
                    case 'a-z':
                        sorted.sort((a, b) => a.name.localeCompare(b.name));
                        break;
                    case 'z-a':
                        sorted.sort((a, b) => b.name.localeCompare(a.name));
                        break;
                    case 'low':
                        sorted.sort((a, b) => a.price - b.price);
                        break;
                    case 'high':
                        sorted.sort((a, b) => b.price - a.price);
                        break;
                }

                return sorted;
            }

            // Carousel functionality
            const fabricSlider = document.getElementById('fabricSlider');
            const sliderDots = document.querySelectorAll('.slider-dot');

            fabricSlider.addEventListener('slid.bs.carousel', function() {
                const activeIndex = Array.from(fabricSlider.querySelectorAll('.carousel-item')).findIndex(item => item.classList.contains('active'));

                sliderDots.forEach((dot, index) => {
                    if (index === activeIndex) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            });

            // Click on slider dots to navigate
            sliderDots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    const carousel = new bootstrap.Carousel(fabricSlider);
                    carousel.to(index);
                });
            });
        });
    </script>
</body>

</html>