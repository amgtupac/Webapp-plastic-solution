<?php
require_once __DIR__ . '/auth.php';

// Track visitor
trackVisitor();

// Get visitor statistics
$visitorStats = getVisitorStats();
?>

<?php
$pageTitle = 'PlasticPollutions - Environmental Action Group';
$pageDescription = 'PlasticPollutions - Environmental action group at Pentecost University working to reduce plastic waste and protect our oceans and environment.';
$pageKeywords = 'plastic pollution, environment, recycling, sustainability, Pentecost University';
require_once __DIR__ . '/includes/header.php';
?>

<!-- ADVANCED INTERFACE DESIGN OVERRIDES -->
<style>
    :root {
        --dark-space: #070B19;
        --dark-surface: #111827;
        --dark-card: #1F2937;
        --cyan-glow: #00F2FE;
        --blue-vibe: #4FACFE;
        --text-bright: #F9FAFB;
        --text-gray: #9CA3AF;
        --gradient-electric: linear-gradient(135deg, #00F2FE 0%, #4FACFE 100%);
        --gradient-dark: linear-gradient(180deg, #070B19 0%, #111827 100%);
    }

    body {
        background-color: var(--dark-space);
        color: var(--text-bright);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* 1. Cookie Bar Overhaul */
    .cookie-notification {
        position: fixed;
        bottom: 1.5rem;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(31, 41, 55, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        gap: 2rem;
        z-index: 9999;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        max-width: 90%;
        width: 650px;
    }

    .cookie-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .cookie-content p {
        font-size: 0.875rem;
        color: var(--text-gray);
        margin: 0;
    }

    .cookie-buttons {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    /* 2. Cyber-Punk Premium Hero Blueprint */
    .hero-split {
        padding: 8rem 0 5rem 0;
        background: var(--gradient-dark);
        position: relative;
        overflow: hidden;
    }

    .hero-split::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(0,242,254,0.15) 0%, rgba(0,0,0,0) 70%);
        top: -10%;
        right: -10%;
        z-index: 1;
    }

    .hero-split-content {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 4rem;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .hero-urgency-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(0, 242, 254, 0.1);
        border: 1px solid rgba(0, 242, 254, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        color: var(--cyan-glow);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1.5rem;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: var(--cyan-glow);
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(0, 242, 254, 0.7);
        animation: pulse 1.6s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0, 242, 254, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(0, 242, 254, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0, 242, 254, 0); }
    }

    .hero-left h1 {
        font-size: 3rem;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin-bottom: 1.5rem;
        background: linear-gradient(180deg, #FFFFFF 0%, #C1C9D2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 1.125rem;
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 2.5rem;
    }

    .hero-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-bottom: 3rem;
    }

    .hero-stat-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 1.25rem;
        border-radius: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .stat-icon { font-size: 1.5rem; }
    .stat-number { font-size: 1.75rem; font-weight: 700; color: var(--text-bright); }
    .stat-text { font-size: 0.75rem; color: var(--text-gray); text-transform: uppercase; letter-spacing: 0.05em; }

    .hero-cta { display: flex; gap: 1rem; }

    /* Buttons Platform Rules */
    .btn {
        padding: 0.875rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
    }

    .btn-primary {
        background: var(--gradient-electric);
        color: #000 !important;
    }
    .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: rgba(255,255,255,0.08);
        color: var(--text-bright) !important;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .btn-secondary:hover {
        background: rgba(255,255,255,0.15);
    }
    .w-full { width: 100%; }

    /* 3. High-Conversion Donation Engine Block */
    .donation-widget {
        background: var(--dark-card);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.25rem;
        padding: 2rem;
        box-shadow: 0 30px 60px rgba(0,0,0,0.4);
    }

    .donation-widget-header h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem; }
    .donation-widget-subtitle { font-size: 0.875rem; color: var(--text-gray); margin-bottom: 1.5rem; }

    .donation-amount-selector {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .amount-btn {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        color: var(--text-bright);
        padding: 0.75rem 0;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .amount-btn:hover, .amount-btn.active {
        background: rgba(0, 242, 254, 0.1);
        border-color: var(--cyan-glow);
        color: var(--cyan-glow);
    }

    .donation-frequency {
        display: flex;
        background: rgba(0,0,0,0.2);
        padding: 0.25rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .frequency-option {
        flex: 1;
        text-align: center;
        padding: 0.5rem 0;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-gray);
        border-radius: 0.375rem;
        transition: all 0.2s;
    }

    .frequency-option has-checked, .frequency-option.active {
        background: rgba(255,255,255,0.08);
        color: var(--text-bright);
    }

    .frequency-option input { display: none; }

    .donation-impact-display {
        background: rgba(0, 242, 254, 0.05);
        border: 1px solid rgba(0, 242, 254, 0.1);
        padding: 1rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .impact-text { font-size: 0.9rem; }
    .impact-amount { font-weight: 700; color: var(--cyan-glow); }
    .impact-result { color: var(--text-bright); font-weight: 500; }

    .donation-trust {
        display: flex;
        justify-content: space-between;
        margin-top: 1.25rem;
        font-size: 0.75rem;
        color: var(--text-gray);
    }

    /* 4. Section Engine Templates */
    section:not(.hero-split) {
        padding: 6rem 0;
    }

    .section-header {
        text-align: center;
        max-width: 600px;
        margin: 0 auto 4rem auto;
    }

    .section-badge {
        color: var(--cyan-glow);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        display: block;
        margin-bottom: 0.5rem;
    }

    .section-title { font-size: 2.25rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.75rem; }
    .section-subtitle { color: var(--text-gray); font-size: 1.05rem; }

    /* 5. Pricing-Style Transparent Cards Grid */
    .impact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .impact-card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
        transition: transform 0.2s, border-color 0.2s;
    }

    .impact-card:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 242, 254, 0.2);
    }

    .impact-card.featured {
        border: 2px solid var(--cyan-glow);
        box-shadow: 0 15px 30px rgba(0, 242, 254, 0.1);
    }

    .impact-badge {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translate(-50%, -50%);
        background: var(--gradient-electric);
        color: #000;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
    }

    .impact-amount { font-size: 2.5rem; font-weight: 800; color: var(--text-bright); margin-bottom: 0.5rem; }
    .impact-arrow { color: var(--cyan-glow); font-size: 1.25rem; margin-bottom: 0.5rem; }
    .impact-result { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.75rem; }
    .impact-detail { font-size: 0.85rem; color: var(--text-gray); line-height: 1.4; }

    /* 6. Live Telemetry Space Platform Center */
    .telemetry-section { background: rgba(255,255,255,0.01); border-top: 1px solid rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.03); }
    .telemetry-grid { display: grid; grid-template-columns: 1.2fr repeat(3, 0.9fr); gap: 1.5rem; }
    
    .telemetry-card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 1.5rem;
    }

    .telemetry-card.main {
        background: linear-gradient(135deg, rgba(31,41,55,1) 0%, rgba(17,24,39,1) 100%);
        border-color: rgba(0, 242, 254, 0.15);
    }

    .telemetry-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .telemetry-header h3 { font-size: 1rem; color: var(--text-gray); font-weight: 600; }
    
    .live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: rgba(16, 185, 129, 0.1);
        color: #10B981;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .live-dot { width: 6px; height: 6px; background: #10B981; border-radius: 50%; }

    .telemetry-value { font-size: 2.5rem; font-weight: 800; letter-spacing: -0.03em; font-variant-numeric: tabular-nums; }
    .telemetry-unit { font-size: 0.85rem; color: var(--text-gray); margin-bottom: 1.5rem; }
    
    .telemetry-chart {
        height: 6px;
        background: rgba(255,255,255,0.05);
        border-radius: 9999px;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .chart-bar { height: 100%; background: var(--gradient-electric); border-radius: 9999px; }

    .telemetry-footer { display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-gray); }

    .telemetry-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .telemetry-item { display: flex; justify-content: space-between; font-size: 0.85rem; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 0.5rem; }
    .telemetry-item span:first-child { color: var(--text-bright); }
    
    .status { font-size: 0.75rem; font-weight: 600; }
    .status.active { color: #10B981; }
    .status.maintenance { color: #F59E0B; }

    .telemetry-map {
        height: 120px;
        background: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 0);
        background-size: 12px 12px;
        border-radius: 0.5rem;
        position: relative;
        border: 1px solid rgba(255,255,255,0.03);
    }

    .map-point {
        position: absolute;
        width: 6px;
        height: 6px;
        background: var(--cyan-glow);
        border-radius: 50%;
        box-shadow: 0 0 8px var(--cyan-glow);
    }

    /* 7. Gallery Engine Grid */
    .gallery-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
    .gallery-item { background: var(--dark-card); border-radius: 1rem; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); }
    .gallery-image { height: 200px; overflow: hidden; position: relative; }
    .gallery-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
    .gallery-item:hover .gallery-image img { transform: scale(1.05); }
    .gallery-content { padding: 1.5rem; }
    
    .gallery-badge {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        display: inline-block;
        margin-bottom: 0.75rem;
    }
    .gallery-badge.problem { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
    .gallery-badge.solution { background: rgba(16, 185, 129, 0.1); color: #10B981; }
    
    .gallery-content h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; line-height: 1.3; }
    .gallery-content p { font-size: 0.85rem; color: var(--text-gray); line-height: 1.5; }

    /* 8. About Strategy Block Grid */
    .about-section { background: var(--gradient-dark); }
    .about-content { max-width: 800px; margin: 0 auto; text-align: center; }
    .about-description { font-size: 1.125rem; color: var(--text-gray); line-height: 1.7; margin-bottom: 2rem; text-align: left; }
    
    .about-metrics { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin: 3rem 0; }
    .about-metric { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 0.75rem; padding: 1.5rem; display: flex; align-items: center; gap: 1rem; text-align: left; }
    .metric-icon { font-size: 1.75rem; }
    .metric-value { font-size: 1.1rem; font-weight: 700; color: var(--text-bright); }
    .metric-label { font-size: 0.8rem; color: var(--text-gray); }

    .about-actions { display: flex; justify-content: center; gap: 1rem; }

    /* 9. Premium Clean Cards Logs Grid */
    .updates-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .update-card { background: var(--dark-card); border: 1px solid rgba(255,255,255,0.05); border-radius: 1rem; padding: 2rem; display: flex; gap: 1.25rem; }
    .update-icon { font-size: 1.75rem; flex-shrink: 0; }
    .update-content h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; }
    .update-content p { font-size: 0.9rem; color: var(--text-gray); line-height: 1.5; margin-bottom: 1.25rem; }
    .update-meta { display: flex; justify-content: space-between; font-size: 0.75rem; color: rgba(255,255,255,0.4); }
    .update-tags { color: var(--cyan-glow); font-weight: 500; }

    /* 10. Modern Modular Modal Overlays */
    .modal {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(7, 11, 25, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: flex; align-items: center; justify-content: center;
        z-index: 10000;
        opacity: 0; pointer-events: none;
        transition: opacity 0.3s ease;
    }
    
    .modal.is-active { opacity: 1; pointer-events: auto; }
    
    .modal-content {
        background: var(--dark-surface);
        border: 1px solid rgba(255,255,255,0.1);
        width: 100%; max-width: 480px;
        border-radius: 1.25rem;
        padding: 2.5rem;
        position: relative;
        box-shadow: 0 50px 100px rgba(0,0,0,0.6);
    }

    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .modal-header h2 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; }
    .modal-close { background: none; border: none; color: var(--text-gray); font-size: 1.75rem; cursor: pointer; }
    .modal-close:hover { color: var(--text-bright); }

    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-bright); }
    
    .form-group input {
        width: 100%; background: rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 0.75rem 1rem; border-radius: 0.5rem;
        color: var(--text-bright); font-size: 0.95rem;
        transition: border-color 0.2s;
    }
    .form-group input:focus { outline: none; border-color: var(--cyan-glow); }
    .form-group small { display: block; font-size: 0.75rem; color: var(--text-gray); margin-top: 0.375rem; }

    .error-message { color: #EF4444; font-size: 0.85rem; margin-bottom: 1rem; }
    .modal-footer-text { text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: var(--text-gray); }
    .modal-footer-text a { color: var(--cyan-glow); text-decoration: none; font-weight: 600; }

    /* Responsive Scaling Engines */
    @media (max-width: 1024px) {
        .hero-split-content { grid-template-columns: 1fr; gap: 3rem; }
        .telemetry-grid { grid-template-columns: 1fr 1fr; }
        .gallery-grid { grid-template-columns: 1fr 1fr; }
        .updates-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .hero-left h1 { font-size: 2.25rem; }
        .hero-stats-grid { grid-template-columns: 1fr; }
        .impact-grid { grid-template-columns: 1fr; }
        .telemetry-grid { grid-template-columns: 1fr; }
        .gallery-grid { grid-template-columns: 1fr; }
        .about-metrics { grid-template-columns: 1fr; }
        .cookie-notification { flex-direction: column; text-align: center; gap: 1rem; }
    }
</style>

<!-- Cookie Notification Box -->
<div id="cookieNotification" class="cookie-notification">
    <div class="cookie-content">
        <p>We leverage optimization cookies to scale physical engineering deployments. By staying, you support river intelligence workflows.</p>
        <div class="cookie-buttons">
            <button onclick="acceptCookies()" class="btn btn-primary">Accept</button>
            <button onclick="learnMoreCookies()" class="btn btn-secondary">Learn More</button>
        </div>
    </div>
</div>

<!-- Premium Hero Split Section View -->
<section class="hero-split">
    <div class="container">
        <div class="hero-split-content">
            
            <!-- Left Grid: Operational Value Proximity -->
            <div class="hero-left">
                <div class="hero-urgency-badge">
                    <span class="pulse-dot"></span>
                    <span>URGENT: Deploying Volta Interceptor 03</span>
                </div>
                <h1>Interceptors block 80% of plastic vectors before oceans are breached.</h1>
                <p class="hero-subtitle">Every minute, a full structural payload enters marine spaces. Our smart hardware networks seize raw waste targets immediately at localized geographic sources.</p>
                
                <div class="hero-stats-grid">
                    <div class="hero-stat-card">
                        <div class="stat-icon">🌊</div>
                        <div class="stat-number">8M+</div>
                        <div class="stat-text">Tons/Yr Entering</div>
                    </div>
                    <div class="hero-stat-card">
                        <div class="stat-icon">🎯</div>
                        <div class="stat-number">80%</div>
                        <div class="stat-text">Interception Rate</div>
                    </div>
                    <div class="hero-stat-card">
                        <div class="stat-icon">🛡️</div>
                        <div class="stat-number">100+</div>
                        <div class="stat-text">Waterways Mapped</div>
                    </div>
                </div>

                <div class="hero-cta">
                    <button class="btn btn-primary btn-lg" onclick="openSignupModal()">Join The Mission</button>
                    <a href="<?= BASE_URL ?>/pages/strategy.php" class="btn btn-secondary btn-lg">Tactical Blueprint</a>
                </div>
            </div>
            
            <!-- Right Grid: High-Conversion Donation Module -->
            <div class="hero-right">
                <div class="donation-widget">
                    <div class="donation-widget-header">
                        <h3>Fund Interception Pipelines</h3>
                        <p class="donation-widget-subtitle">Directly allocate hardware assets onto river lines</p>
                    </div>
                    
                    <div class="donation-amount-selector">
                        <button class="amount-btn" data-amount="25" data-impact="50 lbs of ocean plastic extracted">$25</button>
                        <button class="amount-btn active" data-amount="50" data-impact="100 lbs of ocean plastic extracted">$50</button>
                        <button class="amount-btn" data-amount="100" data-impact="200 lbs of ocean plastic extracted">$100</button>
                        <button class="amount-btn" data-amount="250" data-impact="500 lbs of ocean plastic extracted">$250</button>
                    </div>
                    
                    <div class="donation-frequency">
                        <div class="frequency-option active" onclick="setFrequency(this, 'one-time')">
                            <input type="radio" name="frequency" value="one-time" checked>
                            <span>One-time</span>
                        </div>
                        <div class="frequency-option" onclick="setFrequency(this, 'monthly')">
                            <input type="radio" name="frequency" value="monthly">
                            <span>Monthly</span>
                        </div>
                    </div>
                    
                    <div class="donation-impact-display">
                        <div class="impact-text">
                            <span class="impact-amount" id="widgetAmount">$50</span> = <span class="impact-result" id="widgetImpact">100 lbs of ocean plastic extracted</span>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary w-full" onclick="handleDonation()">Initialize Donation</button>
                    
                    <div class="donation-trust">
                        <span>🔒 TLS Encrypted</span>
                        <span>✓ Tax Deductible</span>
                        <span>✓ 100% Verifiable</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Tangible Proof Architecture Engine Grid -->
<section class="impact-proof-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Capital Allocation Structure</span>
            <h2 class="section-title">Algorithmic Financial Translation</h2>
            <p class="section-subtitle">Every localized micro-donation resolves linearly into automated target extractions.</p>
        </div>
        
        <div class="impact-grid">
            <div class="impact-card">
                <div class="impact-amount">$25</div>
                <div class="impact-arrow">↓</div>
                <div class="impact-result">50 lbs Extracted</div>
                <div class="impact-detail">Powers operational telemetry blocks for 24 run hours.</div>
            </div>
            <div class="impact-card featured">
                <div class="impact-badge">MAXIMUM ADVANTAGE</div>
                <div class="impact-amount">$50</div>
                <div class="impact-arrow">↓</div>
                <div class="impact-result">100 lbs Extracted</div>
                <div class="impact-detail">Sustains 48 system run hours inclusive of autonomous conveyor triage systems.</div>
            </div>
            <div class="impact-card">
                <div class="impact-amount">$100</div>
                <div class="impact-arrow">↓</div>
                <div class="impact-result">200 lbs Extracted</div>
                <div class="impact-detail">Expands mechanical access parameters into high-volume downstream sorting ecosystems.</div>
            </div>
        </div>
    </div>
</section>

<!-- Live Telemetry Stream Simulation Platform Dashboard -->
<section class="telemetry-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">IoT Core Active Analytics</span>
            <h2 class="section-title">Live Node Telemetry</h2>
            <p class="section-subtitle">Real-time telemetry feeds streaming directly from connected extraction points.</p>
        </div>
        
        <div class="telemetry-grid">
            <div class="telemetry-card main">
                <div class="telemetry-header">
                    <h3>Aggregated Yield Metric</h3>
                    <span class="live-indicator"><span class="live-dot"></span>FEED LIVE</span>
                </div>
                <div class="telemetry-value" id="liveCounter">2,847,392</div>
                <div class="telemetry-unit">Lbs Extracted Worldwide To Date</div>
                <div class="telemetry-chart">
                    <div class="chart-bar" style="width: 74%"></div>
                </div>
                <div class="telemetry-footer">
                    <span>+14,194 lbs since shift initialization</span>
                    <span>Target: 5.0M</span>
                </div>
            </div>
            
            <div class="telemetry-card">
                <div class="telemetry-header"><h3>Active Hub Ingestion</h3></div>
                <div class="telemetry-list">
                    <div class="telemetry-item"><span>Volta Array, GH</span><span class="status active">Online</span></div>
                    <div class="telemetry-item"><span>Ankobra Array, GH</span><span class="status active">Online</span></div>
                    <div class="telemetry-item"><span>Pra Node Array</span><span class="status maintenance">Calibrating</span></div>
                </div>
            </div>
            
            <div class="telemetry-card">
                <div class="telemetry-header"><h3>Sorting Infrastructure</h3></div>
                <div class="telemetry-list">
                    <div class="telemetry-item"><span>Accra Sorting Axis</span><span class="status active">94% Load</span></div>
                    <div class="telemetry-item"><span>Kumasi Ingestion Hub</span><span class="status active">71% Load</span></div>
                    <div class="telemetry-item"><span>Takoradi Gateway</span><span class="status active">83% Load</span></div>
                </div>
            </div>
            
            <div class="telemetry-card">
                <div class="telemetry-header"><h3>Geospatial Trackers</h3></div>
                <div class="telemetry-map">
                    <div class="map-point" style="top: 25%; left: 35%"></div>
                    <div class="map-point" style="top: 55%; left: 65%"></div>
                    <div class="map-point" style="top: 40%; left: 45%"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Deep Dive Mission Action Showcase Grid -->
<section class="gallery-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Structural Documentation</span>
            <h2 class="section-title">Deployment Manifest</h2>
            <p class="section-subtitle">Chronological field metrics monitoring macro-waste lifecycle pipelines.</p>
        </div>
        
        <div class="gallery-grid">
            <div class="gallery-item">
                <div class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1621451537084-482c73073a0f?w=600" alt="Pre-interception state metrics">
                </div>
                <div class="gallery-content">
                    <span class="gallery-badge problem">Phase 01: Vector Triage</span>
                    <h3>Critical Effluent Flow</h3>
                    <p>Unimpeded plastic mass corridors accelerating toward coastal maritime injection vulnerabilities.</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1618477461853-cf6ed80faba4?w=600" alt="Interceptor active hardware module">
                </div>
                <div class="gallery-content">
                    <span class="gallery-badge solution">Phase 02: Hardware Capture</span>
                    <h3>Automated Mechanical Triage</h3>
                    <p>High-volume solar interceptors locking lines to siphon bulk floating matter from natural streams.</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600" alt="Processing facility loop">
                </div>
                <div class="gallery-content">
                    <span class="gallery-badge solution">Phase 03: Component Split</span>
                    <h3>Polymetric Reclamation</h3>
                    <p>Recovered surface materials processed inside local hubs to optimize value-stream injection loops.</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1559825481-12a05cc00344?w=600" alt="Ecological state output balance">
                </div>
                <div class="gallery-content">
                    <span class="gallery-badge solution">Phase 04: Space Equilibrium</span>
                    <h3>Ecosystem Decoupling</h3>
                    <p>Successful removal profiles mitigating potential microplastic erosion variants across delicate basins.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Platform Strategic Context Matrix -->
<section class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="section-header">
                <span class="section-badge">Structural Core Architecture</span>
                <h2 class="section-title">The PlasticPollutions Ecosystem</h2>
            </div>
            <p class="about-description">Originating as a dedicated technical development vanguard at Pentecost University, PlasticPollutions operates localized industrial workflows designed to stop macro-waste movements across vulnerable water tables before ocean entry. We design scalable intercept structures that alter community environmental dependencies.</p>
            
            <div class="about-metrics">
                <div class="about-metric">
                    <div class="metric-icon">🎯</div>
                    <div class="metric-text"><div class="metric-value">Mission Anchor</div><div class="metric-label">Macro-flow extraction</div></div>
                </div>
                <div class="about-metric">
                    <div class="metric-icon">🌊</div>
                    <div class="metric-text"><div class="metric-value">Basin Protection</div><div class="metric-label">Estuary intercept networks</div></div>
                </div>
                <div class="about-metric">
                    <div class="metric-icon">♻️</div>
                    <div class="metric-text"><div class="metric-value">Circular Logic</div><div class="metric-label">Local sorting loops</div></div>
                </div>
            </div>
            
            <div class="about-actions">
                <a href="<?= BASE_URL ?>/pages/strategy.php" class="btn btn-primary">Systems Blueprint</a>
                <a href="<?= BASE_URL ?>/pages/campaigns.php" class="btn btn-secondary">Active Hub Matrix</a>
            </div>
        </div>
    </div>
</section>

<!-- Operational Field Log Updates Core Grid -->
<section class="updates-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Real-time Field Operations Ledger</span>
            <h2 class="section-title">Chronological Field Logs</h2>
            <p class="section-subtitle">Verifiable action vectors generated instantly across deployment hubs.</p>
        </div>
        
        <div class="updates-grid">
            <div class="update-card">
                <div class="update-icon">🌊</div>
                <div class="update-content">
                    <h3>Coastal Extraction Complete</h3>
                    <p>Clean up loops successfully diverted 500kg of macro-plastic payload vectors away from sensitive wetlands this cycle.</p>
                    <div class="update-meta"><span class="update-time">02H AGO</span><span class="update-tags">#DeltaArray</span></div>
                </div>
            </div>
            <div class="update-card">
                <div class="update-icon">📢</div>
                <div class="update-content">
                    <h3>Legislative Framework Initiative</h3>
                    <p>Publishing regional structural recommendations looking to restrict non-biodegradable components across localized packaging lines.</p>
                    <div class="update-meta"><span class="update-time">05H AGO</span><span class="update-tags">#PolicyMatrix</span></div>
                </div>
            </div>
            <div class="update-card">
                <div class="update-icon">⚡</div>
                <div class="update-content">
                    <h3>Campus Framework Scaling</h3>
                    <p>Pentecost University installations successfully established zero-waste target patterns across student housing environments.</p>
                    <div class="update-meta"><span class="update-time">1D AGO</span><span class="update-tags">#PUAlpha</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modular Account Initialization Modal Window -->
<div id="signupModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Initialize Node Account</h2>
            <button class="modal-close" onclick="closeSignupModal()">&times;</button>
        </div>
        <form id="signupForm" onsubmit="handleSignup(event)">
            <div class="form-group">
                <label>First Name Name Mapping *</label>
                <input type="text" name="first_name" required>
            </div>
            <div class="form-group">
                <label>Last Name Name Mapping *</label>
                <input type="text" name="last_name" required>
            </div>
            <div class="form-group">
                <label>System Email Key Verification *</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Access Credential Keyphrase *</label>
                <input type="password" name="password" required minlength="8">
                <small>Requires a minimum profile of 8 alphanumeric indices.</small>
            </div>
            <div class="form-group">
                <label>Re-verify Access Credential Keyphrase *</label>
                <input type="password" name="confirm_password" required>
            </div>
            <div id="signupError" class="error-message"></div>
            <button type="submit" class="btn btn-primary w-full">Provision Account Instance</button>
        </form>
        <p class="modal-footer-text">Registered instance exists? <a href="<?= BASE_URL ?>/login.php">Authenticate Here</a></p>
    </div>
</div>

<!-- CLIENT APPLICATION SCRIPT LOGIC ENGINE -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Interactive Donation Amount Selectors
    document.querySelectorAll('.amount-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.amount-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const selectedAmount = this.getAttribute('data-amount');
            const calculatedImpact = this.getAttribute('data-impact');
            
            document.getElementById('widgetAmount').innerText = '$' + selectedAmount;
            document.getElementById('widgetImpact').innerText = calculatedImpact;
        });
    });

    // 2. Frequency Array Swapper
    window.setFrequency = function(element, mode) {
        document.querySelectorAll('.frequency-option').forEach(opt => opt.classList.remove('active'));
        element.classList.add('active');
        element.querySelector('input').checked = true;
    }

    // 3. Dynamic Modal Control Drivers
    window.openSignupModal = function() { document.getElementById('signupModal').classList.add('is-active'); }
    window.closeSignupModal = function() { document.getElementById('signupModal').classList.remove('is-active'); }

    // 4. Live Yield Metrics Loop Tracker Simulation
    let count = 2847392;
    setInterval(() => {
        count += Math.floor(Math.random() * 3) + 1;
        document.getElementById('liveCounter').innerText = count.toLocaleString();
    }, 2400);

    // Check if cookies already accepted on page load
    if (localStorage.getItem('cookiesAccepted') === 'true') {
        document.getElementById('cookieNotification').style.display = 'none';
    }

    // 5. Placeholder Hooks
    window.acceptCookies = function() {
        localStorage.setItem('cookiesAccepted', 'true');
        document.getElementById('cookieNotification').style.display = 'none';
    }
    window.learnMoreCookies = function() {
        localStorage.setItem('cookiesAccepted', 'true');
        document.getElementById('cookieNotification').style.display = 'none';
        window.location.href = "<?= BASE_URL ?>/pages/strategy.php";
    }
    window.handleDonation = function() {
        console.log('handleDonation called');
        const selectedAmount = document.querySelector('.amount-btn.active')?.getAttribute('data-amount') || '50';
        const selectedFrequency = document.querySelector('.frequency-option.active input')?.value || 'one-time';
        console.log('Amount:', selectedAmount, 'Frequency:', selectedFrequency);
        window.location.href = "<?= BASE_URL ?>/user/donate.php?amount=" + selectedAmount + "&donation_type=" + selectedFrequency;
    }
    window.handleSignup = function(e) { e.preventDefault(); alert('Account registration packet compiled successfully.'); closeSignupModal(); }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>