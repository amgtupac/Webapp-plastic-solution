<?php
require_once __DIR__ . '/../auth.php';

requireLogin();

$user = currentUser();
$db = getDB();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $donationType = $_POST['donation_type'] ?? 'one_time';
    $paymentMethod = $_POST['payment_method'] ?? '';
    $message = sanitizeInput($_POST['message'] ?? '');
    
    if ($amount <= 0) {
        $error = 'Please enter a valid donation amount.';
    } elseif (empty($paymentMethod)) {
        $error = 'Please select a payment method.';
    } else {
        try {
            $transactionId = 'TXN-' . strtoupper(uniqid());
            $stmt = $db->prepare("
                INSERT INTO donations (user_id, amount, donation_type, payment_method, transaction_id, status, message)
                VALUES (?, ?, ?, ?, ?, 'completed', ?)
            ");
            $stmt->execute([$user['id'], $amount, $donationType, $paymentMethod, $transactionId, $message]);
            
            logUserActivity($user['id'], 'donation_made', "Donation of GHS $amount made via $paymentMethod");
            $success = 'Thank you for your donation! Transaction ID: ' . $transactionId;
        } catch (Exception $e) {
            $error = 'Failed to process donation. Please try again.';
        }
    }
}

// Get user donation history
$stmt = $db->prepare("
    SELECT * FROM donations 
    WHERE user_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$user['id']]);
$donations = $stmt->fetchAll();

// Calculate total donations
$stmt = $db->prepare("
    SELECT COALESCE(SUM(amount), 0) as total, COUNT(*) as count
    FROM donations 
    WHERE user_id = ? AND status = 'completed'
");
$stmt->execute([$user['id']]);
$donationStats = $stmt->fetch();
?>

<?php
$pageTitle = 'Donate';

if (!isLoggedIn()) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<style>
    :root {
        --dark-space: #070B19;
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
        -webkit-font-smoothing: antialiased;
        margin: 0;
        padding: 0;
    }

    /* Core Container - strictly bounded fluid margins */
    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem;
        box-sizing: border-box;
    }

    section {
        padding: 1rem 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .section-badge {
        color: var(--cyan-glow);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .section-title { 
        font-size: 1.75rem; 
        font-weight: 800; 
        margin: 0.25rem 0 0.5rem 0;
    }
    
    .section-subtitle { 
        color: var(--text-gray); 
        font-size: 0.9rem; 
        line-height: 1.5;
        margin: 0;
    }

    /* Stacked flow layout by default */
    .dashboard-grid {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 1.25rem;
        box-sizing: border-box;
    }

    .card h2 {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0 0 1.25rem 0;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.4rem;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Enforced font-size 16px to prevent forced iOS scaling bounce */
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 0.5rem;
        font-size: 16px; 
        color: var(--text-bright);
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--cyan-glow);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.85rem 1.5rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        box-sizing: border-box;
    }

    .btn-primary {
        background: var(--gradient-electric);
        color: #000;
    }

    .btn-secondary {
        background: rgba(255,255,255,0.05);
        color: var(--text-bright);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .w-full {
        width: 100%;
    }

    /* Quick stats dashboard elements */
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .stat-card {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        padding: 1rem 0.5rem;
        text-align: center;
    }

    .stat-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--cyan-glow);
    }

    .stat-label {
        color: var(--text-gray);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-top: 0.25rem;
    }

    .suggested-amounts {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .suggested-amounts .btn {
        padding: 0.6rem 0.25rem;
        font-size: 0.8rem;
        border-radius: 0.5rem;
    }

    /* Responsive Mobile History Block Engine */
    .mobile-history-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .history-item-card {
        background: rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 0.75rem;
        padding: 1rem;
    }

    .history-card-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .history-card-row:last-child {
        margin-bottom: 0;
    }

    .history-date {
        font-size: 0.8rem;
        color: var(--text-gray);
    }

    .history-amount {
        font-weight: 700;
        color: var(--cyan-glow);
        font-size: 1rem;
    }

    .history-meta-label {
        font-size: 0.8rem;
        color: var(--text-gray);
    }

    .history-meta-value {
        font-size: 0.85rem;
    }

    .badge {
        padding: 0.2rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-success { background: rgba(16, 185, 129, 0.1); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-warning { background: rgba(245, 158, 11, 0.1); color: #F59E0B; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-error { background: rgba(239, 68, 68, 0.1); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.2); }

    .alert {
        padding: 0.875rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        word-break: break-word;
    }

    .alert-error { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #EF4444; }
    .alert-success { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10B981; }

    /* Desktop View Enhancements */
    @media (min-width: 992px) {
        section { padding: 3rem 0; }
        .section-title { font-size: 2.25rem; }
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 2rem;
        }
        .card { padding: 2rem; }
        .stat-value { font-size: 2rem; }
    }
</style>

<section>
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Resource Allocation</span>
            <h2 class="section-title">Contribute to Mission</h2>
            <p class="section-subtitle">Your allocation enables cleanup operations and educational deployments.</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <!-- Donation Form -->
            <div class="card">
                <h2>Resource Allocation</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Allocation Amount (GHS) *</label>
                        <input type="number" name="amount" step="0.01" min="1" required placeholder="50.00" value="<?= e($_GET['amount'] ?? '') ?>">
                        <div class="suggested-amounts">
                            <button type="button" onclick="document.querySelector('input[name=amount]').value = '50'" class="btn btn-secondary">50</button>
                            <button type="button" onclick="document.querySelector('input[name=amount]').value = '100'" class="btn btn-secondary">100</button>
                            <button type="button" onclick="document.querySelector('input[name=amount]').value = '500'" class="btn btn-secondary">500</button>
                            <button type="button" onclick="document.querySelector('input[name=amount]').value = '1000'" class="btn btn-secondary">1k</button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Allocation Type *</label>
                        <select name="donation_type" required>
                            <option value="one_time" <?= ($_GET['donation_type'] ?? '') === 'one-time' ? 'selected' : '' ?>>Single Allocation</option>
                            <option value="monthly" <?= ($_GET['donation_type'] ?? '') === 'monthly' ? 'selected' : '' ?>>Recurring Allocation</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Transfer Method *</label>
                        <select name="payment_method" required>
                            <option value="">Select transfer method</option>
                            <option value="mobile_money">Mobile Money (MTN/Telecel/AT)</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Message (Optional)</label>
                        <textarea name="message" rows="2" placeholder="Add operational notes..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">Allocate Resources</button>
                </form>
            </div>

            <!-- Donation History & Analytics Stats Panel -->
            <div>
                <div class="card" style="margin-bottom: 1.25rem;">
                    <h2>Allocation Summary</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value"><?= formatCurrency($donationStats['total']) ?></div>
                            <div class="stat-label">Total GHS</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $donationStats['count'] ?></div>
                            <div class="stat-label">Transacts</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2>Allocation History</h2>
                    <?php if (empty($donations)): ?>
                        <p style="color: var(--text-gray); font-size: 0.9rem;">No allocations recorded.</p>
                    <?php else: ?>
                        <!-- Completely native mobile stack layouts instead of table code tags -->
                        <div class="mobile-history-list">
                            <?php foreach ($donations as $d): ?>
                            <div class="history-item-card">
                                <div class="history-card-row">
                                    <span class="history-date"><?= date('M j, Y', strtotime($d['created_at'])) ?></span>
                                    <span class="history-amount"><?= formatCurrency($d['amount']) ?></span>
                                </div>
                                <div class="history-card-row" style="margin-top: 0.75rem;">
                                    <span class="history-meta-label">
                                        <?= ucfirst(str_replace('_', '-', $d['donation_type'])) ?> • <?= ucfirst(str_replace('_', ' ', $d['payment_method'])) ?>
                                    </span>
                                    <span class="badge badge-<?= $d['status'] === 'completed' ? 'success' : ($d['status'] === 'pending' ? 'warning' : 'error') ?>">
                                        <?= ucfirst($d['status']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/header.php'; ?>