<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Penyewaan Alat Berat')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #0ea5e9;
            --secondary-color: #0284c7;
            --accent-color: #06b6d4;
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-lighter: #334155;
            --text-light: #ffffff;
            --text-muted: #ffffff;
            --success-color: #10b981;
            --warning-color: #f59e0b;
        }
        
        /* Global Styles */
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-light);
            line-height: 1.6;
            padding-top: 76px; /* Account for fixed navbar */
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1e293b 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.5;
        }
        
        .company-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-circle {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 8px 32px rgba(14, 165, 233, 0.3);
        }
        
        .company-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-light);
        }
        
        .company-tagline {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin: 0;
            font-weight: 400;
        }
        
        .hero-description {
            font-size: 1.1rem;
            color: var(--text-muted);
            max-width: 600px;
        }
        
        .hero-stats .stat-item {
            text-align: center;
            padding: 1rem 0;
        }
        
        .hero-stats .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }
        
        .hero-stats .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin: 0;
        }
        
        /* Hero Form */
        .hero-form-container {
            position: relative;
            z-index: 2;
        }
        
        .hero-form {
            background: rgba(30, 41, 59, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .form-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.2rem;
        }
        
        .form-header h4 {
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }
        
        .form-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin: 0;
        }
        
        /* Statistics Section */
        .stats-section {
            padding: 6rem 0;
            background: var(--dark-bg);
        }
        
        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .stat-card {
            background: var(--dark-card);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
        }
        
        .stat-card .stat-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-card .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .stat-card .stat-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }
        
        .stat-card .stat-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin: 0;
        }
        
        /* Responsive Grid Improvements */
        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: 1.5rem;
            }
            
            .stat-card .stat-number {
                font-size: 2rem;
            }
            
            .stat-card .stat-icon {
                width: 60px;
                height: 60px;
                font-size: 1.3rem;
            }
        }
        
        @media (max-width: 576px) {
            .stat-card {
                padding: 1.5rem;
            }
            
            .stat-card .stat-number {
                font-size: 1.8rem;
            }
        }
        
        /* About Section */
        .about-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--dark-card) 0%, var(--dark-bg) 100%);
        }
        
        .about-content .about-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 1rem;
        }
        
        .about-content .about-text {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        
        .timeline-info {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .timeline-item {
            flex: 1;
        }
        
        .timeline-year {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .timeline-content h5 {
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .timeline-content p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin: 0;
        }
        
        .company-building {
            padding-left: 2rem;
        }
        
        .building-card {
            background: var(--dark-card);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }
        
        .building-header {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 1rem 1.5rem;
            text-align: center;
        }
        
        .building-header h4 {
            margin: 0;
            font-weight: 600;
        }
        
        .building-content {
            padding: 1.5rem;
        }
        
        .building-info h5 {
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }
        
        .building-info p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        /* Values Section */
        .values-section {
            padding: 6rem 0;
            background: var(--dark-bg);
        }
        
        .value-card {
            background: var(--dark-card);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
        }
        
        .value-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: white;
        }
        
        .value-content h4 {
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .value-content p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
            flex-grow: 1;
        }
        
        /* Responsive Grid for Value Cards */
        @media (max-width: 768px) {
            .value-card {
                margin-bottom: 1.5rem;
            }
            
            .value-icon {
                width: 60px;
                height: 60px;
                font-size: 1.3rem;
                margin-bottom: 1rem;
            }
            
            .value-content h4 {
                font-size: 1.2rem;
            }
            
            .value-content p {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .value-card {
                padding: 1.5rem;
            }
        }
        
        /* Vision Mission Section */
        .vision-mission-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--dark-card) 0%, var(--dark-bg) 100%);
        }
        
        .vision-mission-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .vm-card {
            background: var(--dark-card);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }
        
        .vm-header {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .vm-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .vm-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.3rem;
        }
        
        .vm-body {
            padding: 2rem;
        }
        
        .vm-body p {
            color: var(--text-muted);
            line-height: 1.7;
            margin: 0;
        }
        
        .vm-body ul {
            color: var(--text-muted);
            padding-left: 1.5rem;
            margin: 0;
        }
        
        .vm-body li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="cta-grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23cta-grid)"/></svg>');
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
        }
        
        .cta-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 2rem;
            color: white;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin: 1rem 0;
        }
        
        .cta-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }
        
        .cta-actions {
            margin-top: 2rem;
        }
        
        /* Button Styles */
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(14, 165, 233, 0.3);
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(14, 165, 233, 0.3);
        }
        
        /* Form Styles */
        .form-control, .form-select {
            background: var(--dark-lighter);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 8px;
            color: var(--text-light);
            padding: 0.75rem;
        }
        
        .form-control:focus, .form-select:focus {
            background: var(--dark-lighter);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.25);
            color: var(--text-light);
        }
        
        .form-label {
            color: var(--text-light);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            right: 2rem;
            z-index: 10;
        }
        
        .scroll-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(30, 41, 59, 0.9);
            color: var(--text-light);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            border: 1px solid rgba(148, 163, 184, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .scroll-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(14, 165, 233, 0.3);
        }
        
        .scroll-btn i {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-5px);
            }
            60% {
                transform: translateY(-3px);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                min-height: auto;
                padding: 4rem 0;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .cta-title {
                font-size: 2rem;
            }
            
            .vision-mission-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .timeline-info {
                flex-direction: column;
                gap: 1rem;
            }
            
            .company-building {
                padding-left: 0;
                margin-top: 2rem;
            }
            
            .hero-stats {
                margin-top: 2rem;
            }
        }
        
        /* Navbar dark theme */
        .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar.fixed-top {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        
        .navbar-brand {
            color: var(--text-light) !important;
            font-weight: 700;
        }
        
        .navbar-nav .nav-link {
            color: var(--text-muted) !important;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .dropdown-menu {
            background: var(--dark-card);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        
        .dropdown-item {
            color: var(--text-muted);
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary-color);
        }
        
        .dropdown-divider {
            border-color: rgba(148, 163, 184, 0.1);
        }
        
        /* Footer dark theme */
        footer {
            background: var(--dark-card) !important;
            border-top: 1px solid rgba(148, 163, 184, 0.1);
            color: var(--text-muted);
        }
        
        footer h5 {
            color: var(--text-light);
        }
        
        footer a {
            color: var(--text-muted);
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: var(--primary-color);
        }
        
        /* Global Grid Improvements */
        .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
        }
        
        /* Enhanced Card Layouts */
        .card {
            background: var(--dark-card);
            border: 1px solid rgba(148, 163, 184, 0.1);
            color: var(--text-light);
        }
        
        .card-body {
            color: var(--text-light);
        }
        
        .card-text {
            color: var(--text-muted);
        }
        
        /* Better spacing for grid items */
        .col-lg-3, .col-lg-4, .col-lg-6, .col-md-6, .col-sm-12 {
            padding-bottom: 1.5rem;
        }
        
        /* Ensure equal height for all cards in a row */
        .equal-height {
            display: flex;
            flex-wrap: wrap;
        }
        
        .equal-height .col-lg-3,
        .equal-height .col-lg-4,
        .equal-height .col-lg-6,
        .equal-height .col-md-6 {
            display: flex;
            align-items: stretch;
        }
        
        .equal-height .col-lg-3 > *,
        .equal-height .col-lg-4 > *,
        .equal-height .col-lg-6 > *,
        .equal-height .col-md-6 > * {
            flex: 1;
        }
        
        /* Enhanced Text Contrast */
        .text-white-important {
            color: #ffffff !important;
        }
        
        .text-light-important {
            color: var(--text-light) !important;
        }
        
        /* Better responsive text sizing */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem !important;
            }
            
            .section-subtitle {
                font-size: 1rem !important;
            }
            
            .hero-title {
                font-size: 2.5rem !important;
            }
            
            .hero-subtitle {
                font-size: 1.1rem !important;
            }
        }
        
        @media (max-width: 576px) {
            .section-title {
                font-size: 1.75rem !important;
            }
            
            .hero-title {
                font-size: 2rem !important;
            }
            
            .hero-subtitle {
                font-size: 1rem !important;
            }
            
            .col-lg-3, .col-lg-4, .col-lg-6, .col-md-6 {
                padding-bottom: 1rem;
            }
        }

        /* Dark Mode Overrides */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .text-dark {
            color: var(--text-light) !important;
        }

        /* Breadcrumb Dark Mode */
        .breadcrumb {
            background: var(--dark-card);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--text-muted);
        }

        /* Equipment Detail Page Specific */
        .equipment-meta, .equipment-info {
            background: var(--dark-card) !important;
            border: 1px solid rgba(148, 163, 184, 0.1) !important;
            color: var(--text-light) !important;
        }

        .equipment-meta strong, .equipment-info strong {
            color: var(--text-light) !important;
        }

        .equipment-details h1, .equipment-details h2, .equipment-details h3, 
        .equipment-details h4, .equipment-details h5, .equipment-details h6 {
            color: var(--text-light) !important;
        }

        .equipment-details p {
            color: var(--text-muted) !important;
        }

        .equipment-details .description p {
            color: var(--text-muted) !important;
        }

        .equipment-details .specifications strong {
            color: var(--text-light) !important;
        }

        /* Price and Badge Styling */
        .price-info .text-primary {
            color: var(--primary-color) !important;
        }

        .badge.bg-primary {
            background-color: var(--primary-color) !important;
        }

        .badge.bg-success {
            background-color: var(--success-color) !important;
        }

        /* Button Dark Mode */
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="d-flex align-items-center">
                    <div class="logo-circle me-2" style="width: 40px; height: 40px; font-size: 1rem;">
                        D
                    </div>
                    <div>
                        <div style="font-size: 1.1rem; font-weight: 700; line-height: 1;">PT. Dhiva Sarana</div>
                        <div style="font-size: 0.8rem; color: var(--primary-color); line-height: 1;">Transport Konstruksi</div>
                    </div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('equipment.*') ? 'active' : '' }}" href="{{ route('equipment.index') }}">Katalog Alat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vision-mission') ? 'active' : '' }}" href="{{ route('vision-mission') }}">Visi & Misi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2"></i>Profil
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        {{-- Registration disabled: hide sign-up link --}}
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
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>{{ \App\Models\Setting::get('company_name', 'Alat Berat') }}</h5>
                    <p>{{ \App\Models\Setting::get('company_description', 'Penyedia layanan penyewaan alat berat terpercaya.') }}</p>
                </div>
                <div class="col-md-4">
                    <h5>Kontak</h5>
                    <p>
                        <i class="fas fa-map-marker-alt me-2"></i>
                        {{ \App\Models\Setting::get('company_address', 'Alamat Perusahaan') }}
                    </p>
                    <p>
                        <i class="fas fa-phone me-2"></i>
                        {{ \App\Models\Setting::get('company_phone', 'Nomor Telepon') }}
                    </p>
                    <p>
                        <i class="fas fa-envelope me-2"></i>
                        {{ \App\Models\Setting::get('company_email', 'Email') }}
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light">Beranda</a></li>
                        <li><a href="{{ route('equipment.index') }}" class="text-light">Katalog Alat</a></li>
                        <li><a href="{{ route('about') }}" class="text-light">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('company_name', 'Alat Berat') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
