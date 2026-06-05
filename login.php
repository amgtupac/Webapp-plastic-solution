<?php
require_once __DIR__ . '/auth.php';

$error = '';
$success = '';
$lockoutInfo = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        // Check if account is locked
        $lockoutInfo = checkLoginLockout($email);
        
        if ($lockoutInfo['locked']) {
            $remaining = ceil($lockoutInfo['remaining'] / 60);
            $error = "Account locked. Please try again in $remaining minute(s).";
        } else {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Successful login
                recordLoginAttempt($email, true);
                $_SESSION['user_id'] = $user['id'];
                logUserActivity($user['id'], 'login', 'User logged in successfully');
                
                header('Location: ' . BASE_URL . '/user/dashboard.php');
                exit;
            } else {
                // Failed login
                recordLoginAttempt($email, false);
                $error = 'Invalid email or password.';
                
                // Check if now locked after this attempt
                $lockoutInfo = checkLoginLockout($email);
                if ($lockoutInfo['locked']) {
                    $error = 'Account locked due to too many failed attempts. Please try again in 3 minutes.';
                }
            }
        }
    }
}
?>

<?php
$pageTitle = 'Login';
require_once __DIR__ . '/includes/header.php';
?>

<!-- ADVANCED COMPACT GLASS CARD LAYOUT STRUCTURE -->
<style>
    .auth-viewport-wrapper {
        min-height: calc(100vh - 230px); /* Centers card beautifully between dynamic header/footer buffers */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        position: relative;
    }

    .auth-card {
        width: 100%;
        max-width: 460px;
        background: var(--bg-surface);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-md);
        padding: 2.5rem;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.4);
        position: relative;
        z-index: 5;
        transition: border-color 0.4s ease, box-shadow 0.4s ease;
    }

    /* Interactive edge glow response when inputs draw focus */
    .auth-card:focus-within {
        border-color: var(--glass-border-glow);
        box-shadow: 0 0 40px rgba(16, 185, 129, 0.05), 0 24px 60px rgba(0, 0, 0, 0.5);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, var(--text-main) 40%, var(--text-muted));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
    }

    .auth-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    /* Alert Banners Integrated into Ecosystem */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        line-height: 1.5;
    }

    .alert-error {
        background: rgba(255, 90, 54, 0.1);
        border: 1px solid rgba(255, 90, 54, 0.25);
        color: #FF7253;
    }

    .alert-success {
        background: rgba(0, 242, 254, 0.1);
        border: 1px solid rgba(0, 242, 254, 0.25);
        color: #00F2FE;
    }

    /* Core Input Layout Form Fields */
    .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.85rem;
        letter-spacing: 0.02em;
    }

    .input-field-wrapper {
        position: relative;
    }

    .input-field-wrapper input {
        width: 100%;
        padding: 0.875rem 1rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--glass-border);
        border-radius: var(--radius-sm);
        color: var(--text-main);
        font-family: var(--font-sans);
        font-size: 0.95rem;
        transition: var(--transition-premium);
        outline: none;
    }

    .input-field-wrapper input:focus {
        border-color: var(--accent-glow);
        background: rgba(0, 0, 0, 0.3);
        box-shadow: 0 0 12px rgba(16, 185, 129, 0.15);
    }

    /* Autofill styling overwrite to prevent white browser flash injections */
    .input-field-wrapper input:-webkit-autofill,
    .input-field-wrapper input:-webkit-autofill:hover, 
    .input-field-wrapper input:-webkit-autofill:focus {
        -webkit-text-fill-color: var(--text-main);
        -webkit-box-shadow: 0 0 0px 1000px #0b1411 inset;
        transition: background-color 5000s ease-in-out 0s;
    }

    .btn-submit-full {
        width: 100%;
        padding: 0.875rem;
        background: var(--accent-action);
        color: var(--text-main);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-pill);
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        cursor: pointer;
        box-shadow: 0 8px 24px rgba(255, 90, 54, 0.2);
        transition: var(--transition-premium);
    }

    .btn-submit-full:hover {
        background: var(--accent-hover);
        box-shadow: 0 12px 28px rgba(255, 90, 54, 0.35);
        transform: translateY(-2px);
    }

    .btn-submit-full:active {
        transform: translateY(0);
    }

    .auth-footer {
        margin-top: 2rem;
        text-align: center;
        padding-top: 1.5rem;
        border-top: 1px solid var(--glass-border);
    }

    .auth-footer p {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-bottom: 0.75rem;
    }

    .auth-footer a {
        color: var(--text-main);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition-premium);
    }

    .auth-footer a:hover {
        color: var(--accent-glow);
    }

    .back-home-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.85rem !important;
        color: var(--text-muted) !important;
    }

    .back-home-link:hover {
        color: var(--text-main) !important;
    }

    /* Mobile Contextual Optimization Layout */
    @media (max-width: 500px) {
        .auth-viewport-wrapper {
            padding: 1rem;
        }

        .auth-card {
            padding: 1.75rem 1.25rem;
            border-radius: var(--radius-md);
            box-shadow: none; /* Relieves overhead graphics burden on lower-tier screens */
        }

        .auth-header h1 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="auth-viewport-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <h1>Welcome Back</h1>
            <p>Access your deployment command system</p>
        </div>
        
        <!-- Conditionals Render Inside the Protected Grid Bounds -->
        <?php if ($error): ?>
            <div class="alert alert-error">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span><?= e($error) ?></span>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span><?= e($success) ?></span>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-field-wrapper">
                    <input type="email" name="email" required autofocus value="<?= e($_POST['email'] ?? '') ?>" placeholder="name@domain.com">
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label>Password</label>
                <div class="input-field-wrapper">
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
            </div>
            
            <button type="submit" class="btn-submit-full">Authenticate</button>
        </form>
        
        <div class="auth-footer">
            <p>Don't have an account? <a href="<?= BASE_URL ?>/register.php">Register here</a></p>
            <p style="margin-bottom: 0;">
                <a href="<?= BASE_URL ?>/" class="back-home-link">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Back to Home
                </a>
            </p>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>