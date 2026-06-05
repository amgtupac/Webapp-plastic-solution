<?php
require_once __DIR__ . '/../auth.php';

trackVisitor();

$db = getDB();

// Get petitions
$petitions = $db->query("SELECT * FROM petitions WHERE status = 'active' ORDER BY created_at DESC")->fetchAll();

// Handle petition signing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sign_petition']) && isLoggedIn()) {
    $petitionId = $_POST['petition_id'];
    $user = currentUser();
    
    try {
        $stmt = $db->prepare("INSERT INTO petition_signatures (petition_id, user_id) VALUES (?, ?)");
        $stmt->execute([$petitionId, $user['id']]);
        
        // Update petition signature count
        $db->prepare("UPDATE petitions SET current_signatures = current_signatures + 1 WHERE id = ?")->execute([$petitionId]);
        
        logUserActivity($user['id'], 'petition_signed', "Signed petition ID: $petitionId");
        $success = 'Thank you for signing the petition!';
    } catch (Exception $e) {
        $error = 'You have already signed this petition.';
    }
}
?>

<?php
$pageTitle = 'What to Do About Plastic';
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
        margin-bottom: 2rem;
    }

    .card p {
        color: var(--text-gray);
        line-height: 1.6;
    }

    .grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .grid-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
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
        font-size: 0.95rem;
    }

    .plastic-card {
        text-align: center;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        padding: 1.5rem;
    }

    .plastic-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .plastic-card h3 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .plastic-card p {
        color: var(--text-gray);
        line-height: 1.5;
        margin: 0;
        font-size: 0.875rem;
    }

    .resource-card {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .resource-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .resource-content {
        padding: 1.5rem;
    }

    .resource-content h3 {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .resource-content p {
        color: var(--text-gray);
        line-height: 1.6;
        margin: 0;
        font-size: 0.9rem;
    }

    .petition-card {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .petition-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .petition-card p {
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .progress-bar {
        background: rgba(255,255,255,0.1);
        height: 8px;
        border-radius: 4px;
        margin-top: 0.5rem;
        overflow: hidden;
    }

    .progress-fill {
        background: var(--gradient-electric);
        height: 100%;
        border-radius: 4px;
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
        margin-bottom: 0;
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

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        font-size: 0.9rem;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #EF4444;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #10B981;
    }

    @media (max-width: 768px) {
        .grid-3,
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
                <span class="section-badge">Action Protocols</span>
                <h2 class="section-title">Contamination Countermeasures</h2>
                <p class="section-subtitle">Execute systematic protocols to reduce plastic contamination and achieve measurable impact in your operational sector.</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= e($error) ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= e($success) ?></div>
            <?php endif; ?>

            <!-- Types of Plastics -->
            <div class="card">
                <h2>Plastic Classification Database</h2>
                <div class="grid-3">
                    <div class="plastic-card">
                        <div class="plastic-icon">🥤</div>
                        <h3>PET</h3>
                        <p>Polyethylene Terephthalate - Water bottles, food containers. Recyclable but high landfill rate.</p>
                    </div>
                    <div class="plastic-card">
                        <div class="plastic-icon">🛍️</div>
                        <h3>HDPE</h3>
                        <p>High-Density Polyethylene - Milk jugs, detergent bottles. High recyclability rating.</p>
                    </div>
                    <div class="plastic-card">
                        <div class="plastic-icon">📦</div>
                        <h3>PVC</h3>
                        <p>Polyvinyl Chloride - Pipes, window frames. Difficult recycling, toxic emissions.</p>
                    </div>
                    <div class="plastic-card">
                        <div class="plastic-icon">🥡</div>
                        <h3>LDPE</h3>
                        <p>Low-Density Polyethylene - Bags, food wraps. Limited recycling infrastructure.</p>
                    </div>
                    <div class="plastic-card">
                        <div class="plastic-icon">🍴</div>
                        <h3>PP</h3>
                        <p>Polypropylene - Yogurt containers, caps. Selective regional recycling.</p>
                    </div>
                    <div class="plastic-card">
                        <div class="plastic-icon">📦</div>
                        <h3>PS</h3>
                        <p>Polystyrene - Styrofoam, disposable cups. Non-recyclable, high environmental hazard.</p>
                    </div>
                </div>
            </div>

            <!-- Environmental Impact -->
            <div class="card">
                <h2>Contamination Impact Analysis</h2>
                <div class="grid-4">
                    <div class="info-card">
                        <h3>🌊 Oceanic Infiltration</h3>
                        <p>8+ million tons of plastic enter oceans annually, damaging marine ecosystems and food chains.</p>
                    </div>
                    <div class="info-card">
                        <h3>🐢 Wildlife Casualties</h3>
                        <p>Marine life misidentifies plastic as food, causing injury, starvation, and mortality.</p>
                    </div>
                    <div class="info-card">
                        <h3>🏭 Carbon Emissions</h3>
                        <p>Plastic production and incineration release significant CO2, accelerating climate change.</p>
                    </div>
                    <div class="info-card">
                        <h3>💧 Water System Contamination</h3>
                        <p>Microplastics detected in tap water, bottled water, and human bloodstream.</p>
                    </div>
                </div>
            </div>

            <!-- Educational Resources -->
            <div class="card">
                <h2>Intelligence Resources</h2>
                <div class="grid-2">
                    <div class="resource-card">
                        <img src="https://images.unsplash.com/photo-1621451537084-482c73073a0f?w=400" alt="Plastic recycling">
                        <div class="resource-content">
                            <h3>Recycling Protocols</h3>
                            <p>Learn plastic recycling processes and proper waste separation procedures.</p>
                        </div>
                    </div>
                    <div class="resource-card">
                        <img src="https://images.unsplash.com/photo-1618477461853-cf6ed80faba4?w=400" alt="Ocean cleanup">
                        <div class="resource-content">
                            <h3>Oceanic Remediation</h3>
                            <p>Global initiatives for plastic extraction and contamination prevention.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recycling Methods -->
            <div class="card">
                <h2>Remediation Technologies</h2>
                <div class="grid-4">
                    <div class="info-card">
                        <h3>♻️ Mechanical Processing</h3>
                        <p>Melting and reforming plastic. Common method with quality degradation over cycles.</p>
                    </div>
                    <div class="info-card">
                        <h3>🧪 Chemical Breakdown</h3>
                        <p>Molecular decomposition for new plastic. Higher quality, elevated cost.</p>
                    </div>
                    <div class="info-card">
                        <h3>🔥 Energy Conversion</h3>
                        <p>Incineration for energy generation. Emissions controversy.</p>
                    </div>
                    <div class="info-card">
                        <h3>🌱 Bio-Degradable</h3>
                        <p>Plant-based plastics with natural decomposition. Emerging technology.</p>
                    </div>
                </div>
            </div>

            <!-- Petitions -->
            <div class="card">
                <h2>Active Petitions</h2>
                <?php if (empty($petitions)): ?>
                    <p style="color: var(--text-gray);">No active petitions at this time.</p>
                <?php else: ?>
                    <?php foreach ($petitions as $petition): ?>
                        <div class="petition-card">
                            <h3><?= e($petition['title']) ?></h3>
                            <p><?= e($petition['description']) ?></p>
                            <div style="margin-bottom: 1.5rem;">
                                <strong>Signatures: <?= number_format($petition['current_signatures']) ?> / <?= number_format($petition['target_signatures']) ?></strong>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= min(($petition['current_signatures'] / $petition['target_signatures']) * 100, 100) ?>%;"></div>
                                </div>
                            </div>
                            <?php if (isLoggedIn()): ?>
                                <form method="POST">
                                    <input type="hidden" name="petition_id" value="<?= $petition['id'] ?>">
                                    <input type="hidden" name="sign_petition" value="1">
                                    <button type="submit" class="btn btn-primary">Sign Petition</button>
                                </form>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/login.php" class="btn btn-primary">Login to Sign</a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Donation Section -->
            <div class="card">
                <h2>Resource Allocation</h2>
                <p style="margin-bottom: 2rem;">Financial support enables cleanup operations, educational deployments, and advocacy initiatives.</p>
                <div class="grid-4" style="margin-bottom: 2rem;">
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
                <?php if (isLoggedIn()): ?>
                    <a href="<?= BASE_URL ?>/user/donate.php" class="btn btn-primary">Allocate Resources</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/register.php" class="btn btn-primary">Register to Allocate</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
