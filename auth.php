<?php
require_once __DIR__ . '/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => SESSION_LIFETIME,
        'cookie_httponly'  => true,
        'cookie_samesite'  => 'Strict',
    ]);
}

// ─── Auth helpers ────────────────────────────────────────────
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function currentUser(): ?array {
    if (!isLoggedIn()) return null;
    static $user = null;
    if ($user === null) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch() ?: null;
    }
    return $user;
}

function requireLogin(string $redirect = '/index.php'): void {
    if (!isLoggedIn()) {
        header("Location: $redirect");
        exit;
    }
}

// ─── Login lockout mechanism ─────────────────────────────────
function checkLoginLockout(string $email): array {
    $db = getDB();
    $stmt = $db->prepare("SELECT login_attempts, locked_until FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user) return ['locked' => false];
    
    // Check if currently locked
    if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
        $remaining = strtotime($user['locked_until']) - time();
        return ['locked' => true, 'remaining' => $remaining];
    }
    
    // Reset if lockout period has passed
    if ($user['locked_until'] && strtotime($user['locked_until']) <= time()) {
        $db->prepare("UPDATE users SET login_attempts = 0, locked_until = NULL WHERE email = ?")->execute([$email]);
    }
    
    return ['locked' => false];
}

function recordLoginAttempt(string $email, bool $success): void {
    $db = getDB();
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    
    // Log attempt
    $stmt = $db->prepare("INSERT INTO login_attempts (email, ip_address, success) VALUES (?, ?, ?)");
    $stmt->execute([$email, $ip, $success ? 1 : 0]);
    
    if (!$success) {
        // Increment failed attempts
        $stmt = $db->prepare("UPDATE users SET login_attempts = login_attempts + 1 WHERE email = ?");
        $stmt->execute([$email]);
        
        // Check if should lock
        $stmt = $db->prepare("SELECT login_attempts FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $attempts = $stmt->fetchColumn();
        
        if ($attempts >= MAX_LOGIN_ATTEMPTS) {
            $lockUntil = date('Y-m-d H:i:s', time() + LOCKOUT_DURATION);
            $db->prepare("UPDATE users SET locked_until = ? WHERE email = ?")->execute([$lockUntil, $email]);
        }
    } else {
        // Reset on successful login
        $db->prepare("UPDATE users SET login_attempts = 0, locked_until = NULL, last_login = NOW() WHERE email = ?")->execute([$email]);
    }
}

function logUserActivity(int $userId, string $action, string $details = ''): void {
    $db = getDB();
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $stmt = $db->prepare("INSERT INTO user_activity (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userId, $action, $details, $ip]);
}

// ─── Visitor ID Generator (PU + 6 digits) ───────────────────
function generateVisitorId(): string {
    $db = getDB();
    do {
        $id = 'PU' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $stmt = $db->prepare("SELECT id FROM users WHERE visitor_id = ?");
        $stmt->execute([$id]);
    } while ($stmt->fetch());
    return $id;
}

// ─── Input sanitization ─────────────────────────────────────
function sanitizeInput(string $input): string {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePassword(string $password): array {
    $errors = [];
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters';
    if (!preg_match('/[A-Z]/', $password)) $errors[] = 'Password must contain at least one uppercase letter';
    if (!preg_match('/[a-z]/', $password)) $errors[] = 'Password must contain at least one lowercase letter';
    if (!preg_match('/[0-9]/', $password)) $errors[] = 'Password must contain at least one number';
    return $errors;
}

// ─── Visitor counter ────────────────────────────────────────
function trackVisitor(): void {
    $db = getDB();
    $today = date('Y-m-d');
    
    $stmt = $db->prepare("INSERT INTO visitor_stats (visit_date, page_visits, unique_visitors) VALUES (?, 1, 1) 
                         ON DUPLICATE KEY UPDATE page_visits = page_visits + 1");
    $stmt->execute([$today]);
}

function getVisitorStats(): array {
    $db = getDB();
    $stmt = $db->query("SELECT SUM(page_visits) as total_visits, SUM(unique_visitors) as total_unique FROM visitor_stats");
    return $stmt->fetch() ?: ['total_visits' => 0, 'total_unique' => 0];
}

// ─── Escape helper ───────────────────────────────────────────
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// ─── Time helpers ─────────────────────────────────────────────
function timeAgo(string $datetime): string {
    $diff = time() - strtotime($datetime);
    if ($diff < 60)     return 'just now';
    if ($diff < 3600)   return floor($diff/60) . 'm ago';
    if ($diff < 86400)  return floor($diff/3600) . 'h ago';
    if ($diff < 604800) return floor($diff/86400) . 'd ago';
    return date('M j, Y', strtotime($datetime));
}

// ─── Format currency ────────────────────────────────────────
function formatCurrency(float $amount): string {
    return 'GHS ' . number_format($amount, 2);
}
