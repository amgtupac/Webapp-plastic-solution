<?php
require_once __DIR__ . '/../auth.php';

trackVisitor();

$pageTitle = 'How You Can Help';
require_once __DIR__ . '/../includes/header.php';
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

    section {
        padding: 6rem 0;
    }

    .section-header {
        text-align: center;
        max-width: 700px;
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
    .section-subtitle { color: var(--text-gray); font-size: 1.05rem; line-height: 1.7; }

    .card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 2.5rem;
        margin-bottom: 3rem;
    }

    .card h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .card p {
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .grid-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-card {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        padding: 1.5rem;
    }

    .info-card h3 {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .info-card p {
        color: var(--text-gray);
        line-height: 1.6;
        margin: 0;
    }

    .donation-card {
        text-align: center;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 242, 254, 0.2);
        border-radius: 0.75rem;
        padding: 2rem;
    }

    .donation-amount {
        font-size: 2rem;
        font-weight: 800;
        color: var(--cyan-glow);
        margin-bottom: 0.5rem;
    }

    .donation-card p {
        margin-bottom: 1.5rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.875rem 1.5rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: var(--gradient-electric);
        color: #000;
    }

    .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .pledge-list {
        list-style: none;
        margin: 1.5rem 0;
    }

    .pledge-list li {
        padding: 0.75rem 0 0.75rem 2rem;
        position: relative;
        color: var(--text-gray);
        line-height: 1.6;
    }

    .pledge-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--cyan-glow);
        font-weight: 700;
    }

    .pledge-content {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .pledge-content h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .grid-4,
        .grid-2 {
            grid-template-columns: 1fr;
        }
        .section-title {
            font-size: 1.75rem;
        }
    }
</style>

    <section>
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Operational Protocols</span>
                <h2 class="section-title">Mission Support</h2>
                <p class="section-subtitle">Deploy your capabilities in the fight against plastic contamination. Every operator contributes to the global remediation effort.</p>
            </div>

            <!-- Volunteer Section -->
            <div class="card">
                <h2>Field Operations</h2>
                <p>Join our dedicated field unit and execute direct impact operations in your sector.</p>
                <div class="grid-4">
                    <div class="info-card">
                        <h3>🏖️ Coastal Extraction</h3>
                        <p>Deploy to coastline sectors for systematic plastic waste removal operations.</p>
                    </div>
                    <div class="info-card">
                        <h3>🎓 Education Programs</h3>
                        <p>Execute local awareness programs and educational workshops on contamination protocols.</p>
                    </div>
                    <div class="info-card">
                        <h3>📊 Intelligence Gathering</h3>
                        <p>Collect and analyze contamination metrics across multiple vectors.</p>
                    </div>
                    <div class="info-card">
                        <h3>📢 Advocacy Operations</h3>
                        <p>Advocate for policy changes and raise awareness in your community sector.</p>
                    </div>
                </div>
                <div style="margin-top: 2rem;">
                    <?php if (isLoggedIn()): ?>
                        <a href="<?= BASE_URL ?>/contact.php" class="btn btn-primary">Enlist for Operations</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/register.php" class="btn btn-primary">Register to Enlist</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Donation Section -->
            <div class="card">
                <h2>Resource Allocation</h2>
                <p>Financial support enables expanded operational capacity, additional deployment events, and development of advanced remediation technologies.</p>
                <div class="grid-4">
                    <div class="donation-card">
                        <div class="donation-amount">GHS 50</div>
                        <p>Supports one cleanup event</p>
                    </div>
                    <div class="donation-card">
                        <div class="donation-amount">GHS 100</div>
                        <p>Funds educational materials</p>
                    </div>
                    <div class="donation-card">
                        <div class="donation-amount">GHS 500</div>
                        <p>Sponsors a full campaign</p>
                    </div>
                    <div class="donation-card">
                        <div class="donation-amount">Custom</div>
                        <p>Any amount helps</p>
                    </div>
                </div>
                <div style="margin-top: 2rem;">
                    <?php if (isLoggedIn()): ?>
                        <a href="<?= BASE_URL ?>/user/donate.php" class="btn btn-primary">Allocate Resources</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/register.php" class="btn btn-primary">Register to Allocate</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Lifestyle Changes Section -->
            <div class="card">
                <h2>Individual Protocols</h2>
                <p>Execute systematic changes in daily operations to minimize contamination footprint.</p>
                <div class="grid-2">
                    <div class="info-card">
                        <h3>🛍️ Deploy Reusable Bags</h3>
                        <p>Always carry reusable containment systems to avoid single-use plastic deployment.</p>
                    </div>
                    <div class="info-card">
                        <h3>💧 Use Reusable Bottles</h3>
                        <p>Deploy reusable hydration systems instead of single-use plastic containers.</p>
                    </div>
                    <div class="info-card">
                        <h3>☕ Bring Your Own Cup</h3>
                        <p>Deploy reusable beverage containment systems when acquiring refreshments.</p>
                    </div>
                    <div class="info-card">
                        <h3>🍱 Minimize Packaging</h3>
                        <p>Prioritize vendors with minimal packaging or bulk acquisition protocols.</p>
                    </div>
                    <div class="info-card">
                        <h3>🥤 Reject Straws</h3>
                        <p>Refuse plastic straw deployment or utilize reusable alternatives.</p>
                    </div>
                    <div class="info-card">
                        <h3>♻️ Execute Recycling</h3>
                        <p>Learn local recycling protocols and execute proper waste sorting.</p>
                    </div>
                    <div class="info-card">
                        <h3>🧹 Litter Removal</h3>
                        <p>Execute immediate removal of plastic litter when encountered in the field.</p>
                    </div>
                    <div class="info-card">
                        <h3>📱 Disseminate Intelligence</h3>
                        <p>Share contamination data and protocols with your network.</p>
                    </div>
                </div>
            </div>

            <!-- Pledge Section -->
            <div class="card">
                <h2>Zero-Plastic Protocol</h2>
                <p>Commit to reducing your contamination footprint. Sign the operational pledge to systematically minimize single-use plastics.</p>
                <div class="pledge-content">
                    <h3>I pledge to execute the following protocols:</h3>
                    <ul class="pledge-list">
                        <li>Deploy reusable bags during acquisition operations</li>
                        <li>Utilize reusable hydration systems</li>
                        <li>Avoid single-use plastic deployment when possible</li>
                        <li>Execute proper recycling and waste disposal</li>
                        <li>Encourage network to minimize plastic use</li>
                    </ul>
                </div>
                <?php if (isLoggedIn()): ?>
                    <a href="<?= BASE_URL ?>/user/dashboard.php" class="btn btn-primary">Execute Protocol</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/register.php" class="btn btn-primary">Register to Execute</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
