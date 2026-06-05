<?php
require_once __DIR__ . '/../auth.php';

trackVisitor();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Name, email, and message are required.';
    } elseif (!validateEmail($email)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($message) < 10) {
        $error = 'Message must be at least 10 characters.';
    } else {
        $db = getDB();
        try {
            $stmt = $db->prepare("
                INSERT INTO contact_messages (name, email, subject, message)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$name, $email, $subject, $message]);
            $success = 'Thank you for your message! We will get back to you soon.';
        } catch (Exception $e) {
            $error = 'Failed to send message. Please try again.';
        }
    }
}
?>

<?php
$pageTitle = 'Contact Us';
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

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 3rem;
    }

    .card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 2.5rem;
    }

    .card h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 0.5rem;
        color: var(--text-bright);
        font-family: inherit;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--cyan-glow);
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

    .contact-info-item {
        margin-bottom: 1.75rem;
    }

    .contact-info-item strong {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .contact-info-item p {
        color: var(--text-gray);
        line-height: 1.6;
    }

    .social-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .social-link:hover {
        border-color: rgba(0, 242, 254, 0.2);
        transform: translateY(-2px);
    }

    .social-link span:last-child {
        font-weight: 600;
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
        .contact-grid {
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
                <span class="section-badge">Transmission Uplink</span>
                <h2 class="section-title">Contact Command</h2>
                <p class="section-subtitle">Establish direct communication channel with mission control. All inquiries processed through secure neural interface.</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?= e($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?= e($success) ?></div>
            <?php endif; ?>

            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="card">
                    <h2>Send Transmission</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label>Operator Name *</label>
                            <input type="text" name="name" required value="<?= e($_POST['name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Comms Frequency (Email) *</label>
                            <input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Subject Designation</label>
                            <input type="text" name="subject" value="<?= e($_POST['subject'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Message Payload *</label>
                            <textarea name="message" rows="6" required><?= e($_POST['message'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Transmit</button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <div class="card" style="margin-bottom: 2rem;">
                        <h2>Command Coordinates</h2>
                        <div class="contact-info-item">
                            <strong>📍 Base Location</strong>
                            <p>Pentecost University<br>Accra, Ghana</p>
                        </div>
                        <div class="contact-info-item">
                            <strong>📧 Digital Frequency</strong>
                            <p>info@plasticpollutions.org</p>
                        </div>
                        <div class="contact-info-item">
                            <strong>📞 Voice Channel</strong>
                            <p>+233 20 000 0000</p>
                        </div>
                        <div class="contact-info-item">
                            <strong>🕐 Operational Hours</strong>
                            <p>Monday - Friday: 09:00 - 17:00 UTC</p>
                        </div>
                    </div>

                    <div class="card">
                        <h2>Network Nodes</h2>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <a href="#" class="social-link">
                                <span>📘</span>
                                <span>Facebook Protocol</span>
                            </a>
                            <a href="#" class="social-link">
                                <span>🐦</span>
                                <span>Twitter Stream</span>
                            </a>
                            <a href="#" class="social-link">
                                <span>📷</span>
                                <span>Visual Network</span>
                            </a>
                            <a href="#" class="social-link">
                                <span>📺</span>
                                <span>Broadcast Channel</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
