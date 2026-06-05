<?php
require_once __DIR__ . '/auth.php';

if (isLoggedIn()) {
    $user = currentUser();
    logUserActivity($user['id'], 'logout', 'User logged out');
}

session_start();
session_unset();
session_destroy();

header('Location: ' . BASE_URL . '/index.php');
exit;
