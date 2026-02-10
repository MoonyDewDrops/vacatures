<?php
/**
 * CSRF Protection Functions
 * Prevents Cross-Site Request Forgery attacks
 */

/**
 * Generate a CSRF token and store it in the session
 * @return string The generated token
 */
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Output a hidden CSRF token field for forms
 */
function csrfField() {
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generateCSRFToken()) . '">';
}

/**
 * Validate the CSRF token from a form submission
 * @param string $token The token to validate (from $_POST['csrf_token'])
 * @return bool True if valid, false otherwise
 */
function validateCSRFToken($token = null) {
    if ($token === null) {
        $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    }
    
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Regenerate the CSRF token (call after successful form submission)
 */
function regenerateCSRFToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF or die with error
 * Use this at the start of form processing
 */
function requireValidCSRF() {
    if (!validateCSRFToken()) {
        http_response_code(403);
        die('CSRF token validation failed. Please refresh the page and try again.');
    }
}
