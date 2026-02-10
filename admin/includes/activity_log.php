<?php
/**
 * Activity Logging System
 * Tracks all user actions in the admin panel
 */

/**
 * Log an activity to the database
 * 
 * @param mysqli $conn Database connection
 * @param string $action Action type: 'create', 'update', 'delete', 'view', 'login', 'logout'
 * @param string $entity_type Entity type: 'vacature', 'sollicitatie', 'user'
 * @param int|null $entity_id ID of the affected entity
 * @param string|null $entity_name Name/title of the affected entity
 * @param string|null $details Additional details (JSON or text)
 * @return bool Success status
 */
function logActivity($conn, $action, $entity_type, $entity_id = null, $entity_name = null, $details = null) {
    // Get current user info from session
    $user_id = isset($_SESSION['admin_id']) ? (int)$_SESSION['admin_id'] : 0;
    $username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Unknown';
    
    // Get client IP
    $ip_address = getClientIPAddress();
    
    // Prepare and execute insert
    $stmt = $conn->prepare('INSERT INTO bureau_activity_log (user_id, username, action, entity_type, entity_id, entity_name, details, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    
    if (!$stmt) {
        return false;
    }
    
    $stmt->bind_param('isssisss', $user_id, $username, $action, $entity_type, $entity_id, $entity_name, $details, $ip_address);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}

/**
 * Get client IP address safely
 */
function getClientIPAddress() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    
    return filter_var(trim($ip), FILTER_VALIDATE_IP) ?: '0.0.0.0';
}

/**
 * Get recent activity for dashboard
 * 
 * @param mysqli $conn Database connection
 * @param int $limit Number of activities to fetch
 * @return mysqli_result|false
 */
function getRecentActivity($conn, $limit = 20) {
    $limit = (int)$limit;
    $stmt = $conn->prepare("SELECT * FROM bureau_activity_log ORDER BY created_at DESC LIMIT ?");
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Get human-readable action text in Dutch
 */
function getActionText($action, $entity_type) {
    $actions = [
        'create' => [
            'vacature' => 'heeft vacature aangemaakt',
            'user' => 'heeft gebruiker aangemaakt',
            'sollicitatie' => 'heeft sollicitatie toegevoegd'
        ],
        'update' => [
            'vacature' => 'heeft vacature bijgewerkt',
            'user' => 'heeft gebruiker bijgewerkt',
            'sollicitatie' => 'heeft sollicitatie bijgewerkt'
        ],
        'delete' => [
            'vacature' => 'heeft vacature verwijderd',
            'user' => 'heeft gebruiker verwijderd',
            'sollicitatie' => 'heeft sollicitatie verwijderd'
        ],
        'view' => [
            'vacature' => 'heeft vacature bekeken',
            'sollicitatie' => 'heeft sollicitatie bekeken',
            'user' => 'heeft gebruiker bekeken'
        ],
        'login' => [
            'system' => 'is ingelogd'
        ],
        'logout' => [
            'system' => 'is uitgelogd'
        ]
    ];
    
    return $actions[$action][$entity_type] ?? "$action $entity_type";
}

/**
 * Get icon class for action type
 */
function getActionIcon($action) {
    $icons = [
        'create' => '➕',
        'update' => '✏️',
        'delete' => '🗑️',
        'view' => '👁️',
        'login' => '🔐',
        'logout' => '🚪'
    ];
    
    return $icons[$action] ?? '📋';
}

/**
 * Get color class for action type
 */
function getActionColor($action) {
    $colors = [
        'create' => '#1db954',
        'update' => '#ff8f1c',
        'delete' => '#e74c3c',
        'view' => '#3498db',
        'login' => '#9b59b6',
        'logout' => '#95a5a6'
    ];
    
    return $colors[$action] ?? '#888';
}
