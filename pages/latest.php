<?php
require_once __DIR__ . '/../auth.php';

trackVisitor();

$db = getDB();

// Get published news
$stmt = $db->query("SELECT * FROM news WHERE is_published = 1 ORDER BY created_at DESC");
$news = $stmt->fetchAll();
?>

<?php
$pageTitle = 'Latest News';
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

    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }

    .news-card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
    }

    .news-card:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 242, 254, 0.2);
    }

    .news-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .news-content {
        padding: 1.5rem;
    }

    .news-badge {
        display: inline-block;
        padding: 0.35rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
        background: rgba(0, 242, 254, 0.1);
        color: var(--cyan-glow);
        border: 1px solid rgba(0, 242, 254, 0.2);
    }

    .news-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .news-card p {
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .news-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--text-gray);
        font-size: 0.875rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--dark-card);
        border-radius: 1rem;
        border: 1px solid rgba(255,255,255,0.05);
    }

    .empty-state p {
        color: var(--text-gray);
    }

    @media (max-width: 768px) {
        .news-grid {
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
                <span class="section-badge">Intelligence Feed</span>
                <h2 class="section-title">Latest Intelligence</h2>
                <p class="section-subtitle">Real-time updates on contamination operations, research breakthroughs, and global remediation efforts.</p>
            </div>
            
            <?php if (empty($news)): ?>
                <div class="empty-state">
                    <p>No intelligence reports available at this time.</p>
                </div>
            <?php else: ?>
                <div class="news-grid">
                    <?php foreach ($news as $article): ?>
                        <div class="news-card">
                            <?php if ($article['image_url']): ?>
                                <img src="<?= e($article['image_url']) ?>" alt="<?= e($article['title']) ?>">
                            <?php endif; ?>
                            <div class="news-content">
                                <span class="news-badge"><?= e($article['category']) ?></span>
                                <h3><?= e($article['title']) ?></h3>
                                <p><?= substr(e($article['content']), 0, 150) ?>...</p>
                                <div class="news-meta">
                                    <span>Operator: <?= e($article['author']) ?></span>
                                    <span><?= date('M j, Y', strtotime($article['created_at'])) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
