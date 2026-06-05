<?php
if (!isset($pageTitle)) {
    $pageTitle = 'PlasticPollutions';
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($pageDescription)): ?>
        <meta name="description" content="<?= e($pageDescription) ?>">
    <?php endif; ?>
    <?php if (isset($pageKeywords)): ?>
        <meta name="keywords" content="<?= e($pageKeywords) ?>">
    <?php endif; ?>
    <title><?= e($pageTitle) ?> — CYCLE-0</title>
    
    <!-- Modern High-End Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    
    <!-- Premium Dark Glassmorphic Architecture Layout Styles -->
    <style>
        :root {
            --bg-deep: #070B19;
            --bg-surface: rgba(17, 24, 39, 0.45);
            --bg-surface-hover: rgba(31, 41, 55, 0.65);
            
            --text-main: #F9FAFB;
            --text-muted: #9CA3AF;
            
            --accent-glow: #00F2FE;
            --accent-action: #FF5A36;
            --accent-hover: #FF7253;
            --glass-border: rgba(255, 255, 255, 0.05);
            --glass-border-glow: rgba(0, 242, 254, 0.25);
            
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --max-width: 1280px;
            
            --radius-sm: 0.5rem;
            --radius-md: 1rem;
            --radius-pill: 9999px;
            --transition-premium: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Smooth Loading Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        /* Initial page load animation */
        main > section,
        main > .container > section {
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        main > section:nth-child(1) { animation-delay: 0.1s; }
        main > section:nth-child(2) { animation-delay: 0.2s; }
        main > section:nth-child(3) { animation-delay: 0.3s; }
        main > section:nth-child(4) { animation-delay: 0.4s; }
        main > section:nth-child(5) { animation-delay: 0.5s; }

        /* Ambient structural backdrop blooms */
        body {
            background-color: var(--bg-deep);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(16, 185, 129, 0.04) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(255, 90, 36, 0.03) 0%, transparent 40%);
            color: var(--text-main);
            font-family: var(--font-sans);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1 0 auto;
            position: relative;
            z-index: 10;
        }

        /* ==========================================================================
           1. GLASSMORPHIC NAVBAR ARCHITECTURE
           ========================================================================== */
        
        .navbar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 1.25rem 1.5rem;
            transition: var(--transition-premium);
        }

        /* Floating glass container effect on scroll */
        .navbar-wrapper.is-scrolled {
            padding: 0.75rem 1.5rem;
        }

        .navbar {
            max-width: var(--max-width);
            margin: 0 auto;
            background: var(--bg-surface);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-md);
            padding: 0.75rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition-premium);
        }

        .navbar-wrapper.is-scrolled .navbar {
            background: rgba(8, 14, 12, 0.75);
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
        }

        /* Brand Typography & Core Layout */
        .nav-brand a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.03em;
            text-transform: uppercase;
        }

        .brand-icon {
            color: var(--accent-glow);
            display: flex;
            align-items: center;
            filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.4));
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .nav-brand a:hover .brand-icon {
            transform: rotate(180deg) scale(1.1);
        }

        .brand-text {
            background: linear-gradient(135deg, var(--text-main) 30%, var(--text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Desktop Nav Link Items */
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            list-style: none;
        }

        .nav-menu a:not(.btn) {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition-premium);
            padding: 0.625rem 1rem;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            border: 1px solid transparent;
        }

        .nav-menu a:not(.btn):hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.03);
        }

        /* Submenu Dropdown Glass System */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(16px);
            background: rgba(12, 22, 19, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-md);
            padding: 0.5rem;
            min-width: 250px;
            box-shadow: 0 24px 50px rgba(0, 0, 0, 0.6);
            list-style: none;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition-premium);
        }

        .dropdown-toggle svg {
            margin-left: 0.5rem;
            transition: transform 0.4s ease;
            color: var(--text-muted);
        }

        @media (min-width: 969px) {
            .dropdown:hover .dropdown-menu {
                opacity: 1;
                visibility: visible;
                transform: translateX(-50%) translateY(10px);
                border-color: var(--glass-border-glow);
                box-shadow: 0 0 30px rgba(16, 185, 129, 0.05), 0 24px 50px rgba(0, 0, 0, 0.6);
            }
            .dropdown:hover .dropdown-toggle {
                color: var(--text-main);
                background: rgba(255, 255, 255, 0.03);
            }
            .dropdown:hover .dropdown-toggle svg {
                transform: rotate(180deg);
                color: var(--accent-glow);
            }
        }

        .dropdown-menu a {
            display: block;
            padding: 0.75rem 1.25rem;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text-muted) !important;
            font-size: 0.85rem !important;
            font-weight: 500;
        }

        .dropdown-menu a:hover {
            background: rgba(16, 185, 129, 0.1) !important;
            color: var(--accent-glow) !important;
            transform: translateX(4px);
        }

        /* Redesigned Minimal Action Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.5rem;
            border-radius: var(--radius-pill);
            font-size: 0.815rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            text-decoration: none;
            transition: var(--transition-premium);
        }

        .btn-primary {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-main) !important;
            border: 1px solid var(--glass-border);
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .btn-action {
            background: var(--accent-action);
            color: var(--text-main) !important;
            box-shadow: 0 8px 24px rgba(255, 90, 54, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-action:hover {
            background: var(--accent-hover);
            box-shadow: 0 12px 28px rgba(255, 90, 54, 0.4);
            transform: translateY(-2px);
        }

        /* Mobile Layout & Breakpoint Adaptations */
        .nav-toggle {
            display: none;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            z-index: 1100;
            padding: 0.625rem;
            transition: var(--transition-premium);
        }

        .nav-toggle span {
            display: block;
            width: 20px;
            height: 2px;
            background-color: var(--text-main);
            transition: var(--transition-premium);
        }

        .nav-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(4, 7, 6, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 999;
            opacity: 0;
            transition: var(--transition-premium);
        }

        @media (max-width: 1024px) {
            .nav-toggle {
                display: flex;
            }

            .nav-backdrop.is-active {
                display: block;
                opacity: 1;
            }

            .nav-menu {
                display: none;
                position: fixed;
                top: 1.25rem;
                right: 1.25rem;
                width: calc(100% - 2.5rem);
                max-width: 340px;
                height: calc(100vh - 2.5rem);
                background: rgba(12, 22, 19, 0.95);
                backdrop-filter: blur(30px);
                -webkit-backdrop-filter: blur(30px);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: var(--radius-md);
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                padding: 5rem 2rem 2rem 2rem;
                gap: 1.25rem;
                box-shadow: 0 30px 60px rgba(0,0,0,0.8);
                z-index: 1050;
                overflow-y: auto;
            }

            .nav-menu.is-active {
                display: flex;
            }

            .nav-menu > li {
                width: 100%;
            }

            .nav-menu a:not(.btn) {
                display: flex;
                justify-content: space-between;
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
                color: var(--text-main);
                width: 100%;
                background: rgba(255, 255, 255, 0.02);
            }

            .dropdown-menu {
                position: static;
                transform: none !important;
                box-shadow: none;
                border: none;
                border-left: 2px solid rgba(16, 185, 129, 0.2);
                padding: 0.25rem 0 0 0.75rem;
                margin-top: 0.5rem;
                display: none;
                opacity: 1;
                visibility: visible;
                background: transparent;
                min-width: auto;
            }

            .dropdown.is-open .dropdown-menu {
                display: block;
            }
            
            .dropdown.is-open .dropdown-toggle svg {
                transform: rotate(180deg);
                color: var(--accent-glow);
            }

            .nav-toggle.is-active span:nth-child(1) {
                transform: translateY(7px) rotate(45deg);
            }

            .nav-toggle.is-active span:nth-child(2) {
                opacity: 0;
            }

            .nav-toggle.is-active span:nth-child(3) {
                transform: translateY(-7px) rotate(-45deg);
            }
        }
    </style>
</head>
<body>

    <!-- REDESIGNED APPARATUS NAVBAR START -->
    <div class="navbar-wrapper" id="navbarWrapper">
        <nav class="navbar">
            <div class="nav-brand">
                <a href="<?= rtrim(BASE_URL, '/') ?>/">
                    <span class="brand-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                    </span>
                    <span class="brand-text">Cycle-0</span>
                </a>
            </div>

            <!-- Interactive Hamburger -->
            <button class="nav-toggle" aria-label="Toggle Menu System" aria-expanded="false" onclick="toggleNav()">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Dimmer Layer -->
            <div class="nav-backdrop" id="navBackdrop" onclick="toggleNav()"></div>

            <ul class="nav-menu" id="navMenu">
                <li><a href="<?= rtrim(BASE_URL, '/') ?>/">Home</a></li>
                <li class="dropdown" onclick="toggleMobileDropdown(event)">
                    <a href="#" class="dropdown-toggle" onclick="event.preventDefault();">
                        Solutions
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/what-to-do.php">Interceptor Blueprint</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/strategy.php">Our Strategy</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/campaigns.php">Active Deployments</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/developers.php">Our Team</a></li>
                    </ul>
                </li>
                <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/latest.php">Field Logs</a></li>
                <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/help.php">How You Can Help</a></li>
                <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/contact.php">Contact Us</a></li>
                
                <?php if (isLoggedIn()): ?>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/user/dashboard.php" class="btn btn-primary">Dashboard</a></li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/logout.php" class="btn btn-action">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/login.php" class="btn btn-action">Support Mission</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- Space-buffer calculated for floating header layout elements -->
    <div style="height: 110px;"></div>

    <!-- Client-Side Architecture Controls -->
    <script>
        // Track layout positions to transform glass density dynamically on user scroll
        window.addEventListener('scroll', () => {
            const wrapper = document.getElementById('navbarWrapper');
            if (window.scrollY > 20) {
                wrapper.classList.add('is-scrolled');
            } else {
                wrapper.classList.remove('is-scrolled');
            }
        });

        function toggleNav() {
            const menu = document.getElementById('navMenu');
            const toggle = document.querySelector('.nav-toggle');
            const backdrop = document.getElementById('navBackdrop');
            
            menu.classList.toggle('is-active');
            toggle.classList.toggle('is-active');
            backdrop.classList.toggle('is-active');
            toggle.setAttribute('aria-expanded', menu.classList.contains('is-active'));
            document.body.style.overflow = menu.classList.contains('is-active') ? 'hidden' : '';
        }

        function toggleMobileDropdown(event) {
            if (window.innerWidth <= 1024) {
                event.stopPropagation();
                event.currentTarget.classList.toggle('is-open');
            }
        }

        // Structural intercept links click listeners to cleanup layout context states
        document.querySelectorAll('.nav-menu a:not(.dropdown-toggle)').forEach(link => {
            link.addEventListener('click', () => {
                const menu = document.getElementById('navMenu');
                const toggle = document.querySelector('.nav-toggle');
                const backdrop = document.getElementById('navBackdrop');
                
                menu.classList.remove('is-active');
                toggle.classList.remove('is-active');
                backdrop.classList.remove('is-active');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });
    </script>

    <!-- MAIN BODY START -->
    <main>