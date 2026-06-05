<?php
require_once __DIR__ . '/../auth.php';

trackVisitor();

$db = getDB();

// Get campaigns
$campaigns = $db->query("SELECT * FROM campaigns ORDER BY start_date DESC")->fetchAll();

$pageTitle = 'Campaigns';
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

    section {
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

    .campaign-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
    }

    .campaign-card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
    }

    .campaign-card:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 242, 254, 0.2);
    }

    .campaign-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .campaign-content {
        padding: 2rem;
    }

    .campaign-badge {
        display: inline-block;
        padding: 0.35rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }

    .campaign-badge.active {
        background: rgba(16, 185, 129, 0.1);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .campaign-badge.completed {
        background: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .campaign-badge.pending {
        background: rgba(245, 158, 11, 0.1);
        color: #F59E0B;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .campaign-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .campaign-card p {
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .campaign-details {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .campaign-details div {
        margin-bottom: 1rem;
    }

    .campaign-details strong {
        color: var(--text-bright);
        font-size: 0.875rem;
    }

    .campaign-details span,
    .campaign-details p {
        color: var(--text-gray);
        font-size: 0.9rem;
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
        width: 100%;
    }

    .btn-primary {
        background: var(--gradient-electric);
        color: #000;
    }

    .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .campaign-grid {
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
                <span class="section-badge">Active Deployments</span>
                <h2 class="section-title">Campaign Operations</h2>
                <p class="section-subtitle">Tactical field deployments executing systematic plastic extraction protocols across targeted waterway vectors.</p>
            </div>
            
            <?php if (empty($campaigns)): ?>
                <div style="text-align: center; padding: 4rem 2rem; background: var(--dark-card); border-radius: 1rem; border: 1px solid rgba(255,255,255,0.05);">
                    <p style="color: var(--text-gray);">No active deployment campaigns at this time.</p>
                </div>
            <?php else: ?>
                <div class="campaign-grid">
                    <?php foreach ($campaigns as $campaign): ?>
                        <div class="campaign-card">
                            <?php if ($campaign['image_url']): ?>
                                <img src="<?= e($campaign['image_url']) ?>" alt="<?= e($campaign['title']) ?>">
                            <?php endif; ?>
                            <div class="campaign-content">
                                <span class="campaign-badge <?= $campaign['status'] ?>"><?= ucfirst($campaign['status']) ?></span>
                                <h3><?= e($campaign['title']) ?></h3>
                                <p><?= e($campaign['description']) ?></p>
                                
                                <div class="campaign-details">
                                    <div>
                                        <strong>Operation Window:</strong><br>
                                        <span><?= date('M j, Y', strtotime($campaign['start_date'])) ?> - <?= date('M j, Y', strtotime($campaign['end_date'])) ?></span>
                                    </div>
                                    
                                    <div>
                                        <strong>Target Objective:</strong><br>
                                        <p><?= e($campaign['target_goal']) ?></p>
                                    </div>
                                    
                                    <div>
                                        <strong>Performance Metrics:</strong><br>
                                        <p><?= e($campaign['impact_metrics']) ?></p>
                                    </div>
                                </div>
                                
                                <a href="<?= BASE_URL ?>/pages/help.php" class="btn btn-primary">Join Operation</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
