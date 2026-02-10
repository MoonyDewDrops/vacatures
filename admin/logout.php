<?php
session_start();

// Log logout activity before destroying session
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    require_once '../db_connect.php';
    require_once 'includes/activity_log.php';
    logActivity($conn, 'logout', 'system', $_SESSION['admin_id'], $_SESSION['admin_username']);
    $conn->close();
}

session_destroy();
header('Location: login');
exit;
?>

