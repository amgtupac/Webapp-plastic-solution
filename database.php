<?php
// ============================================================
// Database Configuration
// PlasticPollutions - Pentecost University Project
// ============================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'plastic_pollution');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('APP_NAME', 'PlasticPollutions');
define('APP_FULL_NAME', 'PlasticPollutions - Environmental Action Group');
define('UNIVERSITY_NAME', 'Pentecost University');
define('BASE_URL', 'http://localhost/bertina');

// Upload settings
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', BASE_URL . '/uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'txt']);

// Session
define('SESSION_LIFETIME', 3600 * 8); // 8 hours

// Login lockout settings
define('MAX_LOGIN_ATTEMPTS', 3);
define('LOCKOUT_DURATION', 180); // 3 minutes in seconds

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
        }
    }
    return $pdo;
}
