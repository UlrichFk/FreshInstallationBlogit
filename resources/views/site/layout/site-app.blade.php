<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @if(Request::segment(1)=='blog')
        <title>{{$row->seo_title}}</title>
        @if($row->author_name!='')
            <meta name="author" content="{{$row->author_name}}">
        @else
            <meta name="author" content="{{setting('site_seo_title')}}">
        @endif
        <meta name="description" content="{{$row->seo_description}}">
        @if($row->seo_keyword!='')
            <meta name="keywords" content="{{$row->seo_keyword}}">
        @else
            <meta name="keywords" content="{{setting('site_seo_keyword')}}">
        @endif
    @else
        @if(isset($row) && $row!='')
            <title>@if(isset($row->meta_char) && $row->meta_char!=''){{$row->meta_char}}@endif</title>
            <meta name="author" content="{{setting('site_seo_title')}}">
            <meta name="description" content="@if(isset($row->meta_desc) && $row->meta_desc!=''){{$row->meta_desc}}@endif">
            <meta name="keywords" content="@if(isset($row->meta_keywords) && $row->meta_keywords!=''){{$row->meta_keywords}}@endif">
        @else
            <title>{{setting('site_seo_title')}}</title>
            <meta name="author" content="{{setting('site_seo_title')}}">
            <meta name="description" content="{{setting('site_seo_description')}}">
            <meta name="keywords" content="{{setting('site_seo_keyword')}}">
        @endif            
    @endif
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @if(setting('site_favicon')!='')
        <link rel="icon" type="image/x-icon" href="{{url('uploads/setting/'.setting('site_favicon'))}}" />
    @else
        <link rel="icon" type="image/x-icon" href="{{url('uploads/no-favicon.png')}}" />
    @endif

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    
    <!-- Core CSS -->
    <link href="{{ asset('site-assets/css/lib.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('site-assets/slick/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site-assets/slick/slick-theme.css')}}">
    <link rel="stylesheet" href="{{ asset('site-assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css">

    <style>
        /* ==============================================
           FRI VERDEN MEDIA INSPIRED DESIGN SYSTEM
           ============================================== */
        
        :root {
            /* Colors inspired by friverdenmedia.com */
            --primary-color: #1a1a2e;
            --secondary-color: #16213e; 
            --accent-color: #3498db;
            --accent-secondary: #2c80b6;
            --text-primary: #ffffff;
            --text-secondary: #e0e0e0;
            --text-muted: #b0b0b0;
            --text-dark: #2c3e50;
            --border-color: #34495e;
            --card-bg: #2c3e50;
            --card-bg-light: #34495e;
            --hover-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --gradient-accent: linear-gradient(135deg, #3498db 0%, #2c80b6 100%);
            --gradient-hero: linear-gradient(135deg, rgba(26, 26, 46, 0.95) 0%, rgba(22, 33, 62, 0.95) 100%);
            
            /* Shadows */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
            --shadow-2xl: 0 25px 50px rgba(0, 0, 0, 0.25);
            
            /* Border Radius */
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-2xl: 24px;
            --radius-full: 9999px;
            
                    /* Transitions */
        --transition-fast: all 0.2s ease;
        --transition-normal: all 0.3s ease;
        
        /* Spacing */
        --space-1: 0.25rem;
        --space-2: 0.5rem;
        --space-3: 0.75rem;
        --space-4: 1rem;
        --space-5: 1.25rem;
        --space-6: 1.5rem;
        --space-8: 2rem;
        --space-10: 2.5rem;
        --space-12: 3rem;
        --space-16: 4rem;
        --space-20: 5rem;
            --transition-slow: all 0.5s ease;
            
            /* Typography */
            --font-primary: 'Inter', sans-serif;
            --font-display: 'Playfair Display', serif;
            
            /* Spacing */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;
            --space-20: 5rem;
            --space-24: 6rem;
        }
        
        /* ==============================================
           LOADING SYSTEM - SPINNER LOGIC
           ============================================== */
        
        /* Global Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition-normal);
        }
        
        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Main Site Loader */
        .site-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            transition: var(--transition-slow);
        }
        
        .site-loader.load-complete {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        
        /* Spinner Container */
        .spinner-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: var(--space-4);
        }

        /* Spinner Components */
        .spinner {
            display: inline-block;
            width: 60px;
            height: 60px;
            border: 4px solid rgba(52, 152, 219, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent-color);
            animation: spin 1s ease-in-out infinite;
        }
        
        .spinner-large {
            width: 80px;
            height: 80px;
            border-width: 6px;
        }
        
        .spinner-small {
            width: 30px;
            height: 30px;
            border-width: 3px;
        }
        
        .spinner-text {
            margin-top: var(--space-4);
            color: var(--text-secondary);
            font-size: 1.1rem;
            font-weight: 500;
            text-align: center;
        }
        
        /* Line Scale Loader */
        .line-scale {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }
        
        .line-scale div {
            width: 4px;
            height: 20px;
            background: var(--accent-color);
            border-radius: 2px;
            animation: line-scale 1.2s ease-in-out infinite;
        }
        
        .line-scale div:nth-child(1) { animation-delay: 0s; }
        .line-scale div:nth-child(2) { animation-delay: 0.1s; }
        .line-scale div:nth-child(3) { animation-delay: 0.2s; }
        .line-scale div:nth-child(4) { animation-delay: 0.3s; }
        .line-scale div:nth-child(5) { animation-delay: 0.4s; }
        
        /* Pulse Loader */
        .pulse-loader {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--accent-color);
            animation: pulse 1.5s ease-in-out infinite;
        }
        
        /* Content Loading States */
        .content-loading {
            position: relative;
            min-height: 200px;
        }
        
        .content-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(44, 62, 80, 0.1);
            backdrop-filter: blur(2px);
            border-radius: var(--radius-lg);
        }
        
        .content-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 3px solid rgba(52, 152, 219, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent-color);
            animation: spin 1s linear infinite;
        }
        
        /* Button Loading States */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.8;
        }
        
        .btn-loading .btn-text {
            opacity: 0;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-radius: 50%;
            border-top-color: currentColor;
            animation: spin 0.8s linear infinite;
        }
        
        /* Form Loading States */
        .form-loading {
            position: relative;
            pointer-events: none;
        }
        
        .form-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(2px);
            border-radius: var(--radius-lg);
            z-index: 1;
        }
        
        .form-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 3px solid rgba(52, 152, 219, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent-color);
            animation: spin 1s linear infinite;
            z-index: 2;
        }
        
        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, var(--card-bg-light) 25%, var(--card-bg) 50%, var(--card-bg-light) 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: var(--radius-md);
        }
        
        .skeleton-text {
            height: 1rem;
            margin-bottom: var(--space-2);
        }
        
        .skeleton-text:last-child {
            width: 60%;
        }
        
        .skeleton-image {
            width: 100%;
            height: 200px;
            border-radius: var(--radius-lg);
        }
        
        /* Loading Animations */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @keyframes line-scale {
            0%, 40%, 100% {
                transform: scaleY(0.4);
            }
            20% {
                transform: scaleY(1);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
        }
        
        @keyframes skeleton-loading {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Progress Bar */
        .progress-bar {
            width: 100%;
            height: 8px;
            background: var(--card-bg-light);
            border-radius: var(--radius-full);
            overflow: hidden;
            position: relative;
            margin: var(--space-4) 0;
        }

        .progress-fill {
            height: 100%;
            background: var(--gradient-accent);
            border-radius: var(--radius-full);
            transition: width 0.3s ease;
            position: relative;
        }

        .progress-text {
            position: absolute;
            top: -25px;
            right: 0;
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Loading Utilities */
        .loading-hidden {
            display: none !important;
        }
        
        .loading-visible {
            display: block !important;
        }
        
        .loading-opacity {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Skeleton Container */
        .skeleton-container {
            pointer-events: none;
        }

        /* Enhanced Form Loading */
        .form-loading .form-control,
        .form-loading .btn {
            opacity: 0.6;
        }

        /* Loading for Images */
        .image-loading {
            position: relative;
            min-height: 200px;
        }

        .image-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--card-bg-light);
            border-radius: var(--radius-lg);
        }

        .image-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 3px solid rgba(52, 152, 219, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent-color);
            animation: spin 1s linear infinite;
        }
        
        /* ==============================================
           BACK TO TOP BUTTON
           ============================================== */
        
        .back-to-top-btn {
            position: fixed;
            bottom: var(--space-6);
            right: var(--space-6);
            width: 50px;
            height: 50px;
            background: var(--gradient-accent);
            color: white;
            border: none;
            border-radius: var(--radius-full);
            cursor: pointer;
            transition: var(--transition-normal);
            z-index: 1000;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            pointer-events: none;
        }
        
        .back-to-top-btn:hover {
            background: linear-gradient(135deg, var(--accent-secondary), var(--accent-color));
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }
        
        .back-to-top-btn.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        .back-to-top-btn i {
            transition: var(--transition-fast);
        }
        
        .back-to-top-btn:hover i {
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .back-to-top-btn {
                bottom: var(--space-4);
                right: var(--space-4);
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
        }
        
        /* Debug styles - remove in production */
        /* .back-to-top-btn {
            border: 2px solid red !important;
        } */

        /* ==============================================
           GLOBAL STYLES
           ============================================== */
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-primary);
            background: var(--primary-color);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
            font-size: 16px;
            font-weight: 400;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display);
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: var(--space-4);
            color: var(--text-primary);
        }

        h1 { font-size: 3.5rem; }
        h2 { font-size: 2.75rem; }
        h3 { font-size: 2.25rem; }
        h4 { font-size: 1.875rem; }
        h5 { font-size: 1.5rem; }
        h6 { font-size: 1.25rem; }

        p {
            margin-bottom: var(--space-4);
            color: var(--text-secondary);
            line-height: 1.7;
        }

        a {
            color: var(--accent-color);
            text-decoration: none;
            transition: var(--transition-fast);
        }

        a:hover {
            color: var(--accent-secondary);
            text-decoration: none;
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 var(--space-4);
        }

        .container-fluid {
            width: 100%;
            padding: 0 var(--space-4);
        }

        /* ==============================================
           HEADER STYLES
           ============================================== */
        
        .header-main {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition-normal);
        }

        .header-main.scrolled {
            background: rgba(26, 26, 46, 0.98);
            box-shadow: var(--shadow-lg);
        }

        .navbar {
            padding: var(--space-4) 0;
            background: transparent;
            border: none;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-primary);
            text-decoration: none;
        }

        .navbar-brand img {
            max-height: 45px;
            width: auto;
            border-radius: var(--radius-md);
        }

        .navbar-brand:hover {
            color: var(--text-primary);
            transform: scale(1.02);
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: var(--space-2);
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-4);
            color: var(--accent-secondary);
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: var(--radius-lg);
            transition: var(--transition-fast);
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--accent-color);
            background: rgba(52, 152, 219, 0.1);
        }

        /* Special Navigation Links */
        .nav-link.premium-link {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            font-weight: 700;
            box-shadow: var(--shadow-md);
        }

        .nav-link.premium-link:hover {
            background: linear-gradient(135deg, #e67e22, #d35400);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .nav-link.donate-link {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            font-weight: 700;
            box-shadow: var(--shadow-md);
        }

        .nav-link.donate-link:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            padding: var(--space-4) 0;
            min-width: 250px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition-fast);
            z-index: 1000;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-5);
            color: var(--text-secondary);
            transition: var(--transition-fast);
        }

        .dropdown-item:hover {
            background: var(--accent-color);
            color: var(--text-primary);
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
            opacity: 0.7;
        }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .user-menu-item {
            position: relative;
        }

        .user-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            background: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: var(--transition-fast);
            cursor: pointer;
        }

        .user-icon:hover {
            background: var(--accent-secondary);
            transform: scale(1.1);
        }

        .search-icon {
            background: transparent;
            border: 2px solid var(--border-color);
        }

        .search-icon:hover {
            border-color: var(--accent-color);
            background: rgba(52, 152, 219, 0.1);
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            gap: 4px;
            background: none;
            border: none;
            cursor: pointer;
            padding: var(--space-2);
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 3px;
            background: var(--text-primary);
            transition: var(--transition-fast);
        }

        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Search Box */
        .search-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition-normal);
        }

        .search-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .search-box {
            max-width: 600px;
            width: 90%;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: var(--space-5) var(--space-6);
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: var(--radius-2xl);
            color: var(--text-primary);
            font-size: 1.2rem;
            outline: none;
            transition: var(--transition-fast);
        }

        .search-input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
        }

        .search-close {
            position: absolute;
            top: 50%;
            right: var(--space-4);
            transform: translateY(-50%);
            background: var(--accent-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .search-close:hover {
            background: var(--accent-secondary);
            transform: translateY(-50%) scale(1.1);
        }

        /* ==============================================
           MAIN CONTENT AREA
           ============================================== */
        
        .main-content {
            margin-top: 90px;
            min-height: calc(100vh - 90px);
            position: relative;
        }

        /* ==============================================
           CARD COMPONENTS
           ============================================== */
        
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            overflow: hidden;
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
            border-color: var(--accent-color);
        }

        .card-header {
            padding: var(--space-6);
            border-bottom: 1px solid var(--border-color);
            background: var(--card-bg-light);
        }

        .card-body {
            padding: var(--space-6);
        }

        .card-footer {
            padding: var(--space-6);
            border-top: 1px solid var(--border-color);
            background: var(--card-bg-light);
        }

        /* ==============================================
           BUTTON COMPONENTS
           ============================================== */
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-5);
            border: none;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: var(--transition-fast);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: var(--gradient-accent);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2c80b6, #2471a3);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .btn-secondary {
            background: var(--card-bg);
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: var(--accent-color);
            border: 2px solid var(--accent-color);
        }

        .btn-outline:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-2px);
        }

        /* ==============================================
           FORM COMPONENTS
           ============================================== */
        
        .form-control {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: var(--radius-lg);
            color: var(--text-primary);
            font-size: 1rem;
            transition: var(--transition-fast);
            outline: none;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        /* ==============================================
           UTILITY CLASSES
           ============================================== */
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }

        .mt-0 { margin-top: 0; }
        .mt-1 { margin-top: var(--space-1); }
        .mt-2 { margin-top: var(--space-2); }
        .mt-3 { margin-top: var(--space-3); }
        .mt-4 { margin-top: var(--space-4); }
        .mt-5 { margin-top: var(--space-5); }
        .mt-6 { margin-top: var(--space-6); }
        .mt-8 { margin-top: var(--space-8); }

        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: var(--space-1); }
        .mb-2 { margin-bottom: var(--space-2); }
        .mb-3 { margin-bottom: var(--space-3); }
        .mb-4 { margin-bottom: var(--space-4); }
        .mb-5 { margin-bottom: var(--space-5); }
        .mb-6 { margin-bottom: var(--space-6); }
        .mb-8 { margin-bottom: var(--space-8); }

        .p-0 { padding: 0; }
        .p-1 { padding: var(--space-1); }
        .p-2 { padding: var(--space-2); }
        .p-3 { padding: var(--space-3); }
        .p-4 { padding: var(--space-4); }
        .p-5 { padding: var(--space-5); }
        .p-6 { padding: var(--space-6); }
        .p-8 { padding: var(--space-8); }

        .d-none { display: none; }
        .d-block { display: block; }
        .d-flex { display: flex; }
        .d-grid { display: grid; }

        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }

        .items-center { align-items: center; }
        .items-start { align-items: flex-start; }
        .items-end { align-items: flex-end; }

        .flex-col { flex-direction: column; }
        .flex-wrap { flex-wrap: wrap; }

        .gap-1 { gap: var(--space-1); }
        .gap-2 { gap: var(--space-2); }
        .gap-3 { gap: var(--space-3); }
        .gap-4 { gap: var(--space-4); }
        .gap-5 { gap: var(--space-5); }
        .gap-6 { gap: var(--space-6); }

        /* ==============================================
           RESPONSIVE DESIGN
           ============================================== */
        
        @media (max-width: 1024px) {
            .container {
                max-width: 95%;
            }
            
            h1 { font-size: 3rem; }
            h2 { font-size: 2.25rem; }
            h3 { font-size: 1.875rem; }
        }

        @media (max-width: 768px) {
            .navbar-nav {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
            
            .navbar {
                padding: var(--space-3) 0;
            }
            
            .main-content {
                margin-top: 70px;
            }
            
            h1 { font-size: 2.5rem; }
            h2 { font-size: 2rem; }
            h3 { font-size: 1.5rem; }
            
            .container-fluid {
                padding: 0 var(--space-3);
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 var(--space-3);
            }
            
            h1 { font-size: 2rem; }
            h2 { font-size: 1.75rem; }
            h3 { font-size: 1.25rem; }
            
            .card-header,
            .card-body,
            .card-footer {
                padding: var(--space-4);
            }
        }

        /* ==============================================
           ANIMATIONS
           ============================================== */
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        /* ==============================================
           CUSTOM SCROLLBAR
           ============================================== */
        
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--secondary-color);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: var(--radius-full);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-secondary);
        }

        /* ==============================================
           ENHANCED LOADING STATES
           ============================================== */
        
        .loading {
            opacity: 0.7;
            pointer-events: none;
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid var(--accent-color);
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Enhanced loading states for different elements */
        .loading-card {
            position: relative;
            overflow: hidden;
        }

        .loading-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* ==============================================
           TOASTR CUSTOM STYLES
           ============================================== */
        
        .toast-success {
            background: var(--success-color);
            border-radius: var(--radius-lg);
        }

        .toast-error {
            background: var(--danger-color);
            border-radius: var(--radius-lg);
        }

        .toast-warning {
            background: var(--warning-color);
            border-radius: var(--radius-lg);
        }

        .toast-info {
            background: var(--accent-color);
            border-radius: var(--radius-lg);
        }

        /* ==============================================
           ERROR AND SUCCESS STATES
           ============================================== */
        
        .alert {
            padding: var(--space-4);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-4);
            border: 1px solid transparent;
            font-weight: 500;
        }

        .alert-danger {
            background: rgba(231, 76, 60, 0.1);
            border-color: var(--danger-color);
            color: var(--danger-color);
        }

        .alert-success {
            background: rgba(39, 174, 96, 0.1);
            border-color: var(--success-color);
            color: var(--success-color);
        }

        .alert-warning {
            background: rgba(243, 156, 18, 0.1);
            border-color: var(--warning-color);
            color: var(--warning-color);
        }

        .alert-info {
            background: rgba(52, 152, 219, 0.1);
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        /* Loading error states */
        .loading-error {
            text-align: center;
            padding: var(--space-8);
            color: var(--text-secondary);
        }

        .loading-error .error-icon {
            font-size: 3rem;
            color: var(--danger-color);
            margin-bottom: var(--space-4);
        }

        .loading-error .error-message {
            font-size: 1.1rem;
            margin-bottom: var(--space-4);
        }

        .loading-error .retry-button {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: var(--space-3) var(--space-5);
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .loading-error .retry-button:hover {
            background: var(--accent-secondary);
            transform: translateY(-2px);
        }
    </style>

    <script>
        var base_url = "{{url('')}}";
        window.translations = {
            locale: '{{ app()->getLocale() }}',
            messages: @json(__('lang'))
        };
    </script>
    
    <?php echo setting('google_analytics_code'); ?>
</head>
<body>
    <!-- Site Loader -->
    <div id="site-loader" class="site-loader">
        <div class="spinner-container">
            <div class="spinner spinner-large"></div>
            <div class="spinner-text">Chargement...</div>
        </div>
    </div>

    <!-- Global Loading Overlay -->
    <div id="global-loading" class="loading-overlay">
        <div class="spinner-container">
            <div class="spinner spinner-large"></div>
            <div class="spinner-text">Traitement en cours...</div>
        </div>
    </div>

    <!-- Header -->
    @include('site.layout.components.header')
    
    <!-- Search Overlay -->
    <div id="search-overlay" class="search-overlay">
        <div class="search-box">
            <form action="{{url('search-blog')}}" method="get">
                <input type="text" class="search-input" placeholder="{{ __("lang.site_search_articles") }}" name="keyword" required>
                <button type="button" class="search-close" onclick="closeSearch()">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('site.layout.components.footer')
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top-btn" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Scripts -->
    <script src="{{ asset('site-assets/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{ asset('site-assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('site-assets/js/lib.js')}}"></script>
    <script type="text/javascript" src="{{ asset('site-assets/slick/slick.min.js')}}"></script>
    <script src="{{ asset('site-assets/js/functions.js')}}"></script>
    <script src="{{ asset('site-assets/js/toastr.min.js')}}"></script>
    <script src="{{ asset('site-assets/js/validation.js')}}"></script>
    <script src="{{ asset('site-assets/js/script.js')}}"></script>
    <script src="{{ asset('site-assets/js/header-functions.js')}}"></script>
    
    <script>        
        <?php if(Session::has('success')){ ?>
            toastr.success("<?php echo Session::get('success'); ?>");
        <?php }else if(Session::has('error')){  ?>
            toastr.error("<?php echo Session::get('error'); ?>");
        <?php } ?>
    </script>

    <script>
        // ==============================================
        // LOADING SYSTEM - SPINNER LOGIC
        // ==============================================
        
        // Loading Manager Class
        class LoadingManager {
            constructor() {
                this.siteLoader = document.getElementById('site-loader');
                this.globalLoading = document.getElementById('global-loading');
                this.loadingStates = new Map();
                this.initialize();
            }

            initialize() {
                // Hide site loader after page load
                window.addEventListener('load', () => {
                    this.hideSiteLoader();
                });

                // Auto-hide site loader after 3 seconds (fallback)
                setTimeout(() => {
                    this.hideSiteLoader();
                }, 3000);
            }

            // Site Loader (initial page load)
            showSiteLoader() {
                if (this.siteLoader) {
                    this.siteLoader.classList.remove('load-complete');
                }
            }

            hideSiteLoader() {
                if (this.siteLoader) {
                    this.siteLoader.classList.add('load-complete');
                }
            }

            // Global Loading Overlay (for AJAX, forms, etc.)
            showGlobalLoading(message = 'Traitement en cours...') {
                if (this.globalLoading) {
                    const textElement = this.globalLoading.querySelector('.spinner-text');
                    if (textElement) {
                        textElement.textContent = message;
                    }
                    this.globalLoading.classList.add('active');
                }
            }

            hideGlobalLoading() {
                if (this.globalLoading) {
                    this.globalLoading.classList.remove('active');
                }
            }

            // Button Loading States
            setButtonLoading(button, isLoading, loadingText = 'Chargement...') {
                if (!button) return;

                if (isLoading) {
                    button.classList.add('btn-loading');
                    button.disabled = true;
                    
                    // Store original text
                    const originalText = button.textContent;
                    button.setAttribute('data-original-text', originalText);
                    
                    // Add loading text element
                    const loadingSpan = document.createElement('span');
                    loadingSpan.className = 'btn-text';
                    loadingSpan.textContent = loadingText;
                    button.appendChild(loadingSpan);
                } else {
                    button.classList.remove('btn-loading');
                    button.disabled = false;
                    
                    // Restore original text
                    const originalText = button.getAttribute('data-original-text');
                    if (originalText) {
                        button.textContent = originalText;
                        button.removeAttribute('data-original-text');
                    }
                }
            }

            // Form Loading States
            setFormLoading(form, isLoading) {
                if (!form) return;

                if (isLoading) {
                    form.classList.add('form-loading');
                    form.querySelectorAll('input, button, select, textarea').forEach(element => {
                        element.disabled = true;
                    });
                } else {
                    form.classList.remove('form-loading');
                    form.querySelectorAll('input, button, select, textarea').forEach(element => {
                        element.disabled = false;
                    });
                }
            }

            // Content Loading States
            setContentLoading(container, isLoading) {
                if (!container) return;

                if (isLoading) {
                    container.classList.add('content-loading');
                } else {
                    container.classList.remove('content-loading');
                }
            }

            // Skeleton Loading
            showSkeleton(container, skeletonHTML) {
                if (!container) return;
                
                container.innerHTML = skeletonHTML;
                container.classList.add('skeleton-container');
            }

            hideSkeleton(container) {
                if (!container) return;
                
                container.classList.remove('skeleton-container');
            }

            // Progress Loading
            showProgress(container, progress = 0) {
                if (!container) return;
                
                let progressBar = container.querySelector('.progress-bar');
                if (!progressBar) {
                    progressBar = document.createElement('div');
                    progressBar.className = 'progress-bar';
                    progressBar.innerHTML = `
                        <div class="progress-fill"></div>
                        <div class="progress-text">${progress}%</div>
                    `;
                    container.appendChild(progressBar);
                }
                
                const progressFill = progressBar.querySelector('.progress-fill');
                const progressText = progressBar.querySelector('.progress-text');
                
                if (progressFill) progressFill.style.width = `${progress}%`;
                if (progressText) progressText.textContent = `${progress}%`;
            }

            // Loading with timeout
            showLoadingWithTimeout(message, timeout = 5000) {
                this.showGlobalLoading(message);
                setTimeout(() => {
                    this.hideGlobalLoading();
                }, timeout);
            }

            // Loading for specific operations
            async withLoading(operation, loadingMessage = 'Traitement en cours...') {
                try {
                    this.showGlobalLoading(loadingMessage);
                    const result = await operation();
                    return result;
                } finally {
                    this.hideGlobalLoading();
                }
            }
        }

        // Initialize Loading Manager
        const loadingManager = new LoadingManager();

        // ==============================================
        // GLOBAL JAVASCRIPT VARIABLES
        // ==============================================
        
        var page_name = "home";
        var category_name = "";
        
        <?php if(Request::segment(1)==''){ ?>
            page_name = "home";
        <?php }else if(Request::segment(1)=='category'){ ?>
            page_name = "category";
            category_name = "<?php echo Request::segment(2); ?>";
        <?php }else if(Request::segment(3)!=''){ ?>
            page_name = "subcategory";
            category_name = "<?php echo Request::segment(3); ?>";
        <?php }else if(Request::segment(1)=='all-blogs'){ ?>
            page_name = "allblogs";
        <?php }?>

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header-main');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Back to top functionality
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Debug function to test back to top button (remove in production)
        function testBackToTop() {
            const backToTopBtn = document.getElementById('back-to-top');
            if (backToTopBtn) {
                backToTopBtn.classList.add('show');
                console.log('Back to top button should be visible now');
            } else {
                console.error('Back to top button not found');
            }
        }
        
        // Show/hide back to top button based on scroll position
        window.addEventListener('scroll', function() {
            const backToTopBtn = document.getElementById('back-to-top');
            if (backToTopBtn) {
                if (window.pageYOffset > 300) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            }
        });

        // Search functionality
        function openSearch() {
            document.getElementById('search-overlay').classList.add('active');
            setTimeout(() => {
                document.querySelector('.search-input').focus();
            }, 100);
        }

        function closeSearch() {
            document.getElementById('search-overlay').classList.remove('active');
        }

        // Close search on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearch();
            }
        });

        // Mobile menu toggle - Updated to match header structure
        function toggleMobileMenu() {
            const mobileNav = document.getElementById('mobile-nav');
            const mobileToggle = document.querySelector('.mobile-toggle');
            
            // Vérifier que les éléments existent avant de les manipuler
            if (!mobileNav) {
                console.warn('Mobile nav element not found');
                return;
            }
            
            if (!mobileToggle) {
                console.warn('Mobile toggle element not found');
                return;
            }
            
            mobileNav.classList.toggle('active');
            mobileToggle.classList.toggle('active');
            
            // Prevent body scroll when mobile menu is open
            if (mobileNav.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        // Header functions are now handled by header-functions.js

        // Initialize when document is ready
        $(document).ready(function() {
            // Enhanced form loading management
            $('form').on('submit', function(e) {
                const form = this;
                const submitBtn = form.querySelector('button[type="submit"]');
                
                // Show form loading state
                loadingManager.setFormLoading(form, true);
                
                // Show button loading state if submit button exists
                if (submitBtn) {
                    loadingManager.setButtonLoading(submitBtn, true, 'Envoi en cours...');
                }
                
                // Auto-hide loading after 30 seconds (fallback)
                setTimeout(() => {
                    loadingManager.setFormLoading(form, false);
                    if (submitBtn) {
                        loadingManager.setButtonLoading(submitBtn, false);
                    }
                }, 30000);
            });

            // Initialize tooltips and other components
            $('[data-toggle="tooltip"]').tooltip();
            
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(e) {
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    e.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 90
                    }, 1000);
                }
            });

            // Initialize back to top button
            const backToTopBtn = document.getElementById('back-to-top');
            if (backToTopBtn) {
                // Check initial scroll position
                if (window.pageYOffset > 300) {
                    backToTopBtn.classList.add('show');
                }
                
                // Add click event listener
                backToTopBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    scrollToTop();
                });
            }

            // Event listeners are now handled by header-functions.js
        });

        // ==============================================
        // LOADING UTILITY FUNCTIONS
        // ==============================================
        
        // Global loading functions for easy access
        function showLoading(message = 'Chargement...') {
            loadingManager.showGlobalLoading(message);
        }
        
        function hideLoading() {
            loadingManager.hideGlobalLoading();
        }
        
        function setButtonLoadingState(button, isLoading, text = 'Chargement...') {
            loadingManager.setButtonLoading(button, isLoading, text);
        }
        
        function setFormLoadingState(form, isLoading) {
            loadingManager.setFormLoading(form, isLoading);
        }
        
        function setContentLoadingState(container, isLoading) {
            loadingManager.setContentLoading(container, isLoading);
        }
        
        // AJAX wrapper with loading
        function ajaxWithLoading(options) {
            const defaultOptions = {
                showLoading: true,
                loadingMessage: 'Traitement en cours...',
                hideLoading: true,
                onSuccess: null,
                onError: null,
                onComplete: null,
                retryOnError: false,
                maxRetries: 3
            };
            
            const config = { ...defaultOptions, ...options };
            let retryCount = 0;
            
            function executeAjax() {
                if (config.showLoading) {
                    loadingManager.showGlobalLoading(config.loadingMessage);
                }
                
                $.ajax({
                    ...config,
                    success: function(data) {
                        if (config.onSuccess) config.onSuccess(data);
                    },
                    error: function(xhr, status, error) {
                        if (config.retryOnError && retryCount < config.maxRetries) {
                            retryCount++;
                            console.warn(`Retry attempt ${retryCount} for AJAX request`);
                            setTimeout(executeAjax, 1000 * retryCount); // Exponential backoff
                            return;
                        }
                        
                        if (config.onError) config.onError(xhr, status, error);
                        console.error('AJAX Error:', error);
                        
                        // Show error message if no custom error handler
                        if (!config.onError) {
                            showLoadingError('Erreur lors du traitement de la requête', error);
                        }
                    },
                    complete: function() {
                        if (config.hideLoading) {
                            loadingManager.hideGlobalLoading();
                        }
                        if (config.onComplete) config.onComplete();
                    }
                });
            }
            
            executeAjax();
        }
        
        // Error handling functions
        function showLoadingError(message, error = null, retryFunction = null) {
            const errorContainer = document.createElement('div');
            errorContainer.className = 'loading-error';
            errorContainer.innerHTML = `
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="error-message">${message}</div>
                ${error ? `<div class="error-details">${error}</div>` : ''}
                ${retryFunction ? '<button class="retry-button" onclick="this.parentElement.remove(); ' + retryFunction.name + '()">Réessayer</button>' : ''}
            `;
            
            // Find a suitable container to show the error
            const mainContent = document.querySelector('.main-content') || document.body;
            mainContent.appendChild(errorContainer);
            
            // Auto-remove after 10 seconds
            setTimeout(() => {
                if (errorContainer.parentElement) {
                    errorContainer.remove();
                }
            }, 10000);
        }
        
        // Image loading helper
        function setImageLoading(imageElement, isLoading) {
            if (!imageElement) return;
            
            if (isLoading) {
                imageElement.classList.add('image-loading');
            } else {
                imageElement.classList.remove('image-loading');
            }
        }
        
        // Skeleton loading helpers
        function showSkeletonLoading(container, type = 'default') {
            const skeletonTemplates = {
                default: `
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                `,
                card: `
                    <div class="skeleton skeleton-image"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text" style="width: 60%;"></div>
                `,
                list: `
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                `
            };
            
            loadingManager.showSkeleton(container, skeletonTemplates[type] || skeletonTemplates.default);
        }
        
        function hideSkeletonLoading(container) {
            loadingManager.hideSkeleton(container);
        }
        
        // Progress loading helper
        function showProgressLoading(container, progress) {
            loadingManager.showProgress(container, progress);
        }
        
        // Loading with timeout helper
        function showLoadingWithTimeout(message, timeout = 5000) {
            loadingManager.showLoadingWithTimeout(message, timeout);
        }
        
        // Async operation with loading
        async function withLoading(operation, loadingMessage = 'Traitement en cours...') {
            return await loadingManager.withLoading(operation, loadingMessage);
        }
        
        // ==============================================
        // AUTO-LOADING FOR COMMON ELEMENTS
        // ==============================================
        
        // Auto-loading for images
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[data-src]');
            images.forEach(img => {
                setImageLoading(img, true);
                
                const imageLoader = new Image();
                imageLoader.onload = function() {
                    img.src = this.src;
                    img.removeAttribute('data-src');
                    setImageLoading(img, false);
                };
                imageLoader.onerror = function() {
                    setImageLoading(img, false);
                    img.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjMzQ0OTVlIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iI2YzOWMxMiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vbiB0cm91dsOpZTwvdGV4dD48L3N2Zz4=';
                };
                imageLoader.src = img.getAttribute('data-src');
            });
        });
        
        // Auto-loading for lazy-loaded content
        const observerOptions = {
            root: null,
            rootMargin: '50px',
            threshold: 0.1
        };
        
        const contentObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    if (element.dataset.lazyLoad) {
                        // Trigger lazy loading
                        const loadFunction = window[element.dataset.lazyLoad];
                        if (typeof loadFunction === 'function') {
                            loadFunction(element);
                        }
                    }
                }
            });
        }, observerOptions);
        
        // Observe elements with lazy-load attribute
        document.addEventListener('DOMContentLoaded', function() {
            const lazyElements = document.querySelectorAll('[data-lazy-load]');
            lazyElements.forEach(element => {
                contentObserver.observe(element);
            });
        });
    </script>

    <?php if(isset($show_pagination) && $show_pagination==1){ 
        if(Request::segment(1)=='' || Request::segment(1)=='category' || Request::segment(1)=='all-blogs'){ ?>
        <script>
            var page = 1;
            var scrollThreshold = 500; 
            var scrollMore = 0; 
            $(document).ready(function () {
                $(window).scroll(function () {
                    if ($(document).height() - $(window).height() - $(window).scrollTop() <= scrollThreshold) {
                        if(scrollMore!=1){
                            page++;
                            fetchPosts(page);
                        }                        
                    }
                });
            });
            function fetchPosts(page) {
                // Show content loading state
                const loadListContainer = document.querySelector('.loadList');
                if (loadListContainer) {
                    loadingManager.setContentLoading(loadListContainer, true);
                }
                
                // Show global loading with progress
                loadingManager.showGlobalLoading('Chargement des articles...');
                
                $.ajax({
                    url: base_url+'/fetch?page=' + page +'&page_name='+page_name+'&category='+category_name,
                    type: 'get',
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(evt) {
                            if (evt.lengthComputable) {
                                const percentComplete = (evt.loaded / evt.total) * 100;
                                if (loadListContainer) {
                                    loadingManager.showProgress(loadListContainer, Math.round(percentComplete));
                                }
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (data) {                   
                        if (data.html == "") {
                            scrollMore = 1;
                        } else {
                            $('.loadList').append(data.html);
                        }                       
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching posts:', error);
                        // Show error message
                        if (loadListContainer) {
                            loadingManager.showSkeleton(loadListContainer, 
                                '<div class="alert alert-danger">Erreur lors du chargement des articles</div>'
                            );
                        }
                    },
                    complete: function() {
                        // Hide all loading states
                        loadingManager.hideGlobalLoading();
                        if (loadListContainer) {
                            loadingManager.setContentLoading(loadListContainer, false);
                        }
                    }
                });
            }
        </script>
    <?php } } ?>
</body>
</html>