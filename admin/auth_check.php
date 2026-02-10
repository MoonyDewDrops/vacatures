<?php
/**
 * Authentication Check
 * Include this file at the top of all admin pages that require authentication
 */

session_start();

// Check if user is logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login');
    exit;
}

// Session timeout (30 minutes of inactivity)
$session_timeout = 1800;
if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    session_unset();
    session_destroy();
    header('Location: login?timeout=1');
    exit;
}
$_SESSION['last_activity'] = time();

// Validate session IP (optional but recommended)
if(isset($_SESSION['ip_address'])) {
    $current_ip = $_SERVER['REMOTE_ADDR'];
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $current_ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    // If IP changed significantly, require re-login (prevent session hijacking)
    // Note: This is disabled by default as it can cause issues with mobile users
    // Uncomment if needed:
    // if($_SESSION['ip_address'] !== trim($current_ip)) {
    //     session_unset();
    //     session_destroy();
    //     header('Location: login?security=1');
    //     exit;
    // }
}

// Include CSRF protection
require_once __DIR__ . '/includes/csrf_protection.php';
?>

