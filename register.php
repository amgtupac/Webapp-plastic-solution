<?php
require_once __DIR__ . '/auth.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = sanitizeInput($_POST['first_name'] ?? '');
    $lastName = sanitizeInput($_POST['last_name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!validateEmail($email)) {
        $error = 'Please enter a valid email address.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $passwordErrors = validatePassword($password);
        if (!empty($passwordErrors)) {
            $error = implode(' ', $passwordErrors);
        } else {
            $db = getDB();
            
            // Check if email already exists
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = 'Email already registered.';
            } else {
                // Generate visitor ID (PU + 6 digits)
                $visitorId = generateVisitorId();
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                
                try {
                    $stmt = $db->prepare("
                        INSERT INTO users (visitor_id, first_name, last_name, email, password_hash)
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([$visitorId, $firstName, $lastName, $email, $passwordHash]);
                    
                    // Log activity
                    $userId = $db->lastInsertId();
                    logUserActivity($userId, 'registration', "User registered with visitor ID: $visitorId");
                    
                    $success = 'Registration successful! Your Visitor ID is: ' . $visitorId . '. Please login.';
                    
                    // Redirect to login after 3 seconds
                    header("refresh:3;url=" . BASE_URL . "/login.php");
                    
                } catch (Exception $e) {
                    $error = 'Registration failed. Please try again.';
                }
            }
        }
    }
}
?>

<?php
$pageTitle = 'Register';
require_once __DIR__ . '/includes/header.php';
?>

<!-- ADVANCED COMPACT GLASS CARD LAYOUT STRUCTURE -->
<style>
    .auth-viewport-wrapper {
        min-height: calc(100vh - 230px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1rem;
        position: relative;
    }

    .auth-card {
        width: 100%;
        max-width: 540px; /* Slightly widened to gracefully handle split grid inputs */
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

    /* System Status Alerts */
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

    /* Layout Input Grid Form Sets */
    .form-grid-2x2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .no-margin-b {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.85rem;
        letter-spacing: 0.02em;
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

    /* Input Context Sub-notes */
    .form-group small {
        display: block;
        margin-top: 0.5rem;
        color: var(--text-muted);
        font-size: 0.775rem;
        line-height: 1.4;
    }

    /* Browser Autofill Overrides */
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
        margin-top: 0.5rem;
    }

    .btn-submit-full:hover {
        background: var(--accent-hover);
        box-shadow: 0 12px 28px rgba(255, 90, 54, 0.35);
        transform: translateY(-2px);
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

    /* Mobile Contextual Responsiveness */
    @media (max-width: 600px) {
        .auth-viewport-wrapper {
            padding: 1rem;
        }

        .auth-card {
            padding: 2rem 1.25rem;
            box-shadow: none;
        }

        .form-grid-2x2 {
            grid-template-columns: 1fr; /* Form grid fields collapse to single stacks safely */
            gap: 0;
        }

        .form-grid-2x2 .form-group:first-child {
            margin-bottom: 1.5rem;
        }

        .auth-header h1 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="auth-viewport-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <h1>Create Account</h1>
            <p>Register to join the environmental mission control</p>
        </div>
        
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
            <!-- Split Input Matrix for First/Last Names -->
            <div class="form-grid-2x2">
                <div class="form-group no-margin-b">
                    <label>First Name</label>
                    <div class="input-field-wrapper">
                        <input type="text" name="first_name" required value="<?= e($_POST['first_name'] ?? '') ?>" placeholder="Kofi">
                    </div>
                </div>
                <div class="form-group no-margin-b">
                    <label>Last Name</label>
                    <div class="input-field-wrapper">
                        <input type="text" name="last_name" required value="<?= e($_POST['last_name'] ?? '') ?>" placeholder="Mensah">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-field-wrapper">
                    <input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>" placeholder="name@domain.com">
                </div>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div class="input-field-wrapper">
                    <input type="password" name="password" required minlength="8" placeholder="••••••••">
                </div>
                <small>Requires 8 or more characters containing uppercase, lowercase, and numeric values.</small>
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label>Confirm Password</label>
                <div class="input-field-wrapper">
                    <input type="password" name="confirm_password" required minlength="8" placeholder="••••••••">
                </div>
            </div>
            
            <button type="submit" class="btn-submit-full">Create Account</button>
        </form>
        
        <div class="auth-footer">
            <p>Already have an account? <a href="<?= BASE_URL ?>/login.php">Login here</a></p>
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