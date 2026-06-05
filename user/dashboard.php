<?php
require_once __DIR__ . '/../auth.php';
requireLogin();

$user = currentUser();
if (!$user) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}
$db = getDB();

$error = '';
$success = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === 'update_profile') {
        $firstName = sanitizeInput($_POST['first_name'] ?? '');
        $lastName = sanitizeInput($_POST['last_name'] ?? '');
        $email = sanitizeInput($_POST['email'] ?? '');
        $phone = sanitizeInput($_POST['phone'] ?? '');
        $address = sanitizeInput($_POST['address'] ?? '');
        
        if (empty($firstName) || empty($lastName) || empty($email)) {
            $error = 'First name, last name, and email are required.';
        } elseif (!validateEmail($email)) {
            $error = 'Please enter a valid email address.';
        } else {
            try {
                $stmt = $db->prepare("
                    UPDATE users 
                    SET first_name = ?, last_name = ?, email = ?, phone = ?, address = ?
                    WHERE id = ?
                ");
                $stmt->execute([$firstName, $lastName, $email, $phone, $address, $user['id']]);
                logUserActivity($user['id'], 'profile_update', 'User updated profile information');
                $success = 'Profile updated successfully.';
                $user = currentUser(); // Refresh user data
            } catch (Exception $e) {
                $error = 'Update failed. Email may already be in use.';
            }
        }
    } elseif ($action === 'change_password') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $error = 'All password fields are required.';
        } elseif (!password_verify($currentPassword, $user['password_hash'])) {
            $error = 'Current password is incorrect.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'New passwords do not match.';
        } else {
            $passwordErrors = validatePassword($newPassword);
            if (!empty($passwordErrors)) {
                $error = implode(' ', $passwordErrors);
            } else {
                $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $stmt->execute([$newHash, $user['id']]);
                logUserActivity($user['id'], 'password_change', 'User changed password');
                $success = 'Password changed successfully.';
            }
        }
    }
}

// Get user donations
$stmt = $db->prepare("
    SELECT * FROM donations 
    WHERE user_id = ? 
    ORDER BY created_at DESC 
    LIMIT 10
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

// Get recent activity
$stmt = $db->prepare("
    SELECT * FROM user_activity 
    WHERE user_id = ? 
    ORDER BY created_at DESC 
    LIMIT 10
");
$stmt->execute([$user['id']]);
$activities = $stmt->fetchAll();
?>

<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- REFINED DYNAMIC ENGINE UI STYLES -->
<style>
    :root {
        --dark-space: #070B19;
        --dark-surface: rgba(17, 24, 39, 0.7);
        --dark-card: rgba(31, 41, 55, 0.4);
        --glass-border: rgba(255, 255, 255, 0.08);
        --cyan-glow: #00F2FE;
        --blue-vibe: #4FACFE;
        --text-bright: #F9FAFB;
        --text-gray: #9CA3AF;
        --gradient-electric: linear-gradient(135deg, #00F2FE 0%, #4FACFE 100%);
        --radius-premium: 1.25rem;
    }

    body {
        background-color: var(--dark-space);
        color: var(--text-bright);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .dashboard-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2.5rem;
        padding: 3rem 2rem;
        max-width: 1440px;
        margin: 0 auto;
        min-height: calc(100vh - 120px);
    }

    /* Fixed Left Column Panel */
    .dashboard-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .user-card {
        background: var(--dark-surface);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-premium);
        padding: 2.5rem 2rem;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .user-avatar {
        width: 88px;
        height: 88px;
        background: var(--gradient-electric);
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.25rem;
        color: #040814;
        font-weight: 800;
        box-shadow: 0 0 30px rgba(0, 242, 254, 0.3);
    }

    .user-card h3 {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.01em;
    }

    .user-card .visitor-id-tag {
        display: inline-block;
        padding: 0.35rem 0.85rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        border-radius: 99px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--cyan-glow);
        margin: 0.5rem 0 0.75rem;
    }

    .user-card .user-email {
        color: var(--text-gray);
        font-size: 0.875rem;
        word-break: break-all;
    }

    .sidebar-menu {
        background: var(--dark-surface);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-premium);
        padding: 1.25rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.95rem 1.25rem;
        color: var(--text-gray);
        font-weight: 600;
        text-decoration: none;
        border-radius: 0.75rem;
        margin-bottom: 0.35rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .sidebar-menu a:hover,
    .sidebar-menu a.active {
        background: rgba(0, 242, 254, 0.08);
        color: var(--cyan-glow);
        transform: translateX(4px);
    }

    .sidebar-menu a.donate-btn {
        background: var(--gradient-electric);
        color: #040814;
        margin-top: 1rem;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(0, 242, 254, 0.2);
    }

    .sidebar-menu a.donate-btn:hover {
        opacity: 0.95;
        transform: translateY(-2px);
    }

    /* Tab Architecture Container logic */
    .dashboard-section {
        display: none; /* Controlled completely via dynamic JS toggle engine */
        animation: contentFadeIn 0.4s ease forwards;
    }

    .dashboard-section.active-view {
        display: block;
    }

    @keyframes contentFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .section-title-block {
        margin-bottom: 2rem;
    }

    .section-title-block h2 {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, #FFF 30%, var(--text-gray));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .card {
        background: var(--dark-surface);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-premium);
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 24px 50px rgba(0, 0, 0, 0.25);
    }

    .card-subtitle {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.75rem;
        letter-spacing: -0.01em;
        border-left: 3px solid var(--cyan-glow);
        padding-left: 0.75rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.6rem;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        color: var(--text-gray);
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.95rem 1.25rem;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        font-size: 0.975rem;
        color: var(--text-bright);
        transition: all 0.25s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--cyan-glow);
        background: rgba(0, 0, 0, 0.45);
        box-shadow: 0 0 14px rgba(0, 242, 254, 0.15);
    }

    .form-group small {
        display: block;
        margin-top: 0.5rem;
        color: var(--text-gray);
        font-size: 0.8rem;
        line-height: 1.4;
    }

    /* Action triggers styling */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.95rem 2.25rem;
        border-radius: 99px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        transition: all 0.25s ease;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: var(--gradient-electric);
        color: #040814;
        box-shadow: 0 8px 20px rgba(0, 242, 254, 0.15);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(0, 242, 254, 0.25);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-bright);
        border: 1px solid var(--glass-border);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* Stats Board Display Layout matrix */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(0, 0, 0, 0.25);
        border: 1px solid var(--glass-border);
        border-radius: 1rem;
        padding: 2rem;
        text-align: left;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 4px; height: 100%;
        background: var(--gradient-electric);
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--text-bright);
        margin-bottom: 0.25rem;
        letter-spacing: -0.02em;
    }

    .stat-label {
        color: var(--text-gray);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Premium Clean Data Tables */
    .table-responsive {
        overflow-x: auto;
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th {
        padding: 1.15rem 1.25rem;
        text-align: left;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-gray);
        border-bottom: 1px solid var(--glass-border);
        background: rgba(0, 0, 0, 0.15);
    }

    td {
        padding: 1.15rem 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        font-size: 0.95rem;
        color: var(--text-bright);
    }

    tr:last-child td {
        border-bottom: none;
    }

    .badge {
        padding: 0.4rem 1rem;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .badge-success { background: rgba(16, 185, 129, 0.1); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.15); }
    .badge-success::before { background: #10B981; }

    .badge-warning { background: rgba(245, 158, 11, 0.1); color: #F59E0B; border: 1px solid rgba(245, 158, 11, 0.15); }
    .badge-warning::before { background: #F59E0B; }

    .badge-error { background: rgba(239, 68, 68, 0.1); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.15); }
    .badge-error::before { background: #EF4444; }

    /* Clean Streamlined Timeline Operations Log */
    .activity-list {
        position: relative;
        padding-left: 1.5rem;
    }

    .activity-list::before {
        content: '';
        position: absolute;
        left: 5px; top: 8px; bottom: 8px;
        width: 2px;
        background: var(--glass-border);
    }

    .activity-item {
        position: relative;
        padding-bottom: 2rem;
    }

    .activity-item:last-child {
        padding-bottom: 0;
    }

    .activity-dot {
        position: absolute;
        left: -20px; top: 6px;
        width: 12px;
        height: 12px;
        background: #070B19;
        border: 3px solid var(--cyan-glow);
        border-radius: 50%;
        z-index: 2;
        box-shadow: 0 0 10px var(--cyan-glow);
    }

    .activity-content strong {
        color: var(--text-bright);
        font-weight: 700;
        font-size: 1rem;
        display: block;
        margin-bottom: 0.25rem;
    }

    .activity-content p {
        color: var(--text-gray);
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 0.4rem;
    }

    .activity-content small {
        color: rgba(156, 163, 175, 0.6);
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Top Stack System Messages */
    .alert {
        padding: 1.15rem 1.5rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        font-size: 0.925rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #F87171;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #34D399;
    }

    /* Responsive View Matrix Layout */
    @media (max-width: 1024px) {
        .dashboard-container {
            grid-template-columns: 1fr;
            padding: 1.5rem 1rem;
        }
        .dashboard-sidebar {
            flex-direction: column;
        }
    }

    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .card {
            padding: 1.5rem;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Sidebar Control Tower Layout Panel -->
    <div class="dashboard-sidebar">
        <div class="user-card">
            <div class="user-avatar">
                <?= strtoupper(substr($user['first_name'] ?? 'U', 0, 1)) ?>
            </div>
            <h3><?= e(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></h3>
            <div class="visitor-id-tag">ID: <?= e($user['visitor_id'] ?? 'N/A') ?></div>
            <div class="user-email"><?= e($user['email'] ?? '') ?></div>
        </div>
        
        <div class="sidebar-menu">
            <a data-target="profile" class="menu-tab-trigger active">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Profile
            </a>
            <a data-target="donations" class="menu-tab-trigger">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Donations
            </a>
            <a data-target="activity" class="menu-tab-trigger">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Activity
            </a>
            <a href="<?= BASE_URL ?>/user/donate.php" class="donate-btn">
                Make a Donation
            </a>
        </div>
    </div>

    <!-- Main Content Workspace Tower Panel -->
    <div class="dashboard-main">
        <?php if ($error): ?>
            <div class="alert alert-error">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <?= e($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <?= e($success) ?>
            </div>
        <?php endif; ?>

        <!-- PROFILE SECTION PANEL -->
        <section id="profile" class="dashboard-section active-view">
            <div class="section-title-block">
                <h2>Operator Profile</h2>
            </div>
            <div class="card">
                <form method="POST">
                    <input type="hidden" name="action" value="update_profile">
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" required value="<?= e($user['first_name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" required value="<?= e($user['last_name'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" required value="<?= e($user['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?= e($user['phone'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" rows="3"><?= e($user['address'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>

            <div class="section-title-block" style="margin-top: 3.5rem;">
                <h2>Security Protocols</h2>
            </div>
            <div class="card">
                <form method="POST">
                    <input type="hidden" name="action" value="change_password">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" required minlength="8" placeholder="••••••••">
                        <small>Must be at least 8 characters with uppercase, lowercase, and number symbols.</small>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" required minlength="8" placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-secondary">Change Password</button>
                </form>
            </div>
        </section>

        <!-- DONATIONS SECTION PANEL -->
        <section id="donations" class="dashboard-section">
            <div class="section-title-block">
                <h2>Resource Allocation History</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?= formatCurrency($donationStats['total']) ?></div>
                    <div class="stat-label">Total Allocated</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= $donationStats['count'] ?></div>
                    <div class="stat-label">Transactions</div>
                </div>
            </div>
            
            <div class="card" style="padding: 1.5rem 0 0 0; overflow: hidden;">
                <div class="card-subtitle" style="margin-left: 2.5rem; margin-right: 2.5rem;">Allocation Tracking Ledger</div>
                <?php if (empty($donations)): ?>
                    <p style="color: var(--text-gray); padding: 0 2.5rem 2.5rem;">No allocations recorded in this sector.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($donations as $d): ?>
                                <tr>
                                    <td><?= date('M j, Y', strtotime($d['created_at'])) ?></td>
                                    <td style="font-weight: 700; color: var(--cyan-glow);"><?= formatCurrency($d['amount']) ?></td>
                                    <td><?= ucfirst($d['donation_type']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $d['status'] === 'completed' ? 'success' : ($d['status'] === 'pending' ? 'warning' : 'error') ?>">
                                            <?= ucfirst($d['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ACTIVITY SECTION PANEL -->
        <section id="activity" class="dashboard-section">
            <div class="section-title-block">
                <h2>Operational Log</h2>
            </div>
            <div class="card">
                <?php if (empty($activities)): ?>
                    <p style="color: var(--text-gray);">No recent operational activity recorded.</p>
                <?php else: ?>
                    <div class="activity-list">
                        <?php foreach ($activities as $a): ?>
                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div class="activity-content">
                                <strong><?= e($a['action']) ?></strong>
                                <?php if ($a['details']): ?>
                                    <p><?= e($a['details']) ?></p>
                                <?php endif; ?>
                                <small><?= timeAgo($a['created_at']) ?></small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<!-- SINGLE-PAGE RUNTIME VIEWPORTS TAB SWITCHING SCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const triggers = document.querySelectorAll(".menu-tab-trigger");
        const sections = document.querySelectorAll(".dashboard-section");

        // Simple URL Hash tracking alignment
        const currentHash = window.location.hash.replace('#', '');
        if (currentHash) {
            const targetSection = document.getElementById(currentHash);
            const targetTrigger = document.querySelector(`[data-target="${currentHash}"]`);
            if (targetSection && targetTrigger) {
                sections.forEach(s => s.classList.remove('active-view'));
                triggers.forEach(t => t.classList.remove('active'));
                targetSection.classList.add('active-view');
                targetTrigger.classList.add('active');
            }
        }

        triggers.forEach(trigger => {
            trigger.addEventListener("click", (e) => {
                e.preventDefault();
                const targetId = trigger.getAttribute("data-target");
                
                // Toggle active triggers
                triggers.forEach(t => t.classList.remove("active"));
                trigger.classList.add("active");

                // Toggle active visual sections
                sections.forEach(sec => sec.classList.remove("active-view"));
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add("active-view");
                    window.location.hash = targetId;
                }
            });
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>