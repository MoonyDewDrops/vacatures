<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

session_start();
$error = '';
$lockout_time = 0;

// Security settings
define('MAX_LOGIN_ATTEMPTS', 5);      // Max failed attempts before lockout
define('LOCKOUT_DURATION', 900);       // Lockout duration in seconds (15 minutes)
define('ATTEMPT_WINDOW', 900);         // Time window to count attempts (15 minutes)

// Get client IP address
function getClientIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    return filter_var(trim($ip), FILTER_VALIDATE_IP) ?: '0.0.0.0';
}

// Check if IP is locked out
function isLockedOut($conn, $ip) {
    $window = date('Y-m-d H:i:s', time() - ATTEMPT_WINDOW);
    $stmt = $conn->prepare('SELECT COUNT(*) as attempts, MAX(attempt_time) as last_attempt FROM bureau_login_attempts WHERE ip_address = ? AND attempt_time > ? AND success = 0');
    $stmt->bind_param('ss', $ip, $window);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    if ($result['attempts'] >= MAX_LOGIN_ATTEMPTS) {
        $last_attempt = strtotime($result['last_attempt']);
        $unlock_time = $last_attempt + LOCKOUT_DURATION;
        if (time() < $unlock_time) {
            return $unlock_time - time(); // Return seconds remaining
        }
    }
    return 0;
}

// Log login attempt
function logAttempt($conn, $ip, $username, $success) {
    $stmt = $conn->prepare('INSERT INTO bureau_login_attempts (ip_address, username, success) VALUES (?, ?, ?)');
    $stmt->bind_param('ssi', $ip, $username, $success);
    $stmt->execute();
    $stmt->close();
}

// Clean old login attempts (older than 24 hours)
function cleanOldAttempts($conn) {
    $old = date('Y-m-d H:i:s', time() - 86400);
    $conn->query("DELETE FROM bureau_login_attempts WHERE attempt_time < '$old'");
}

// Check if already logged in
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard');
    exit;
}

// Process login form
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    try {
        require_once '../db_connect.php';
        
        if(!isset($conn)) {
            throw new Exception('Database connection failed');
        }
        
        $ip = getClientIP();
        
        // Clean old attempts periodically
        if (rand(1, 100) <= 5) {
            cleanOldAttempts($conn);
        }
        
        // Check for lockout
        $lockout_time = isLockedOut($conn, $ip);
        if ($lockout_time > 0) {
            $minutes = ceil($lockout_time / 60);
            $error = "Te veel mislukte pogingen. Probeer opnieuw over $minutes minuten.";
        } else {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            if(!empty($username) && !empty($password)) {
                // Add small delay to slow down brute force
                usleep(rand(100000, 300000)); // 100-300ms delay
                
                $stmt = $conn->prepare('SELECT id, username, password, admin FROM bureau_admin WHERE username = ?');
                
                if(!$stmt) {
                    throw new Exception('Database error');
                }
                
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if($result->num_rows === 1) {
                    $admin = $result->fetch_assoc();
                    
                    if(password_verify($password, $admin['password'])) {
                        // Successful login
                        logAttempt($conn, $ip, $username, 1);
                        
                        // Regenerate session ID to prevent session fixation
                        session_regenerate_id(true);
                        
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_id'] = $admin['id'];
                        $_SESSION['admin_username'] = $admin['username'];
                        $_SESSION['is_admin'] = ($admin['admin'] == 1);
                        $_SESSION['login_time'] = time();
                        $_SESSION['ip_address'] = $ip;
                        
                        // Log login activity
                        require_once 'includes/activity_log.php';
                        logActivity($conn, 'login', 'system', $admin['id'], $username);
                        
                        $stmt->close();
                        $conn->close();
                        
                        header('Location: dashboard');
                        exit;
                    } else {
                        // Failed login - wrong password
                        logAttempt($conn, $ip, $username, 0);
                        $error = 'Ongeldige inloggegevens';
                    }
                } else {
                    // Failed login - user not found (use same error to prevent enumeration)
                    logAttempt($conn, $ip, $username, 0);
                    $error = 'Ongeldige inloggegevens';
                }
                
                $stmt->close();
            } else {
                $error = 'Vul alle velden in';
            }
        }
        
        $conn->close();
    } catch (Exception $e) {
        $error = 'Er is een fout opgetreden. Probeer het later opnieuw.';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bureau Jobs</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h1>Bureau Jobs</h1>
            <p class="subtitle">Docenten Portal</p>
            
            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" autocomplete="off">
                <div class="form-group">
                    <label>Gebruikersnaam</label>
                    <input type="text" name="username" required autofocus autocomplete="username">
                </div>
                
                <div class="form-group">
                    <label>Wachtwoord</label>
                    <input type="password" name="password" required autocomplete="current-password">
                </div>
                
                <?php if($lockout_time > 0): ?>
                <button type="submit" name="login" class="btn-primary" style="width: 100%;" disabled>Geblokkeerd</button>
                <?php else: ?>
                <button type="submit" name="login" class="btn-primary" style="width: 100%;">Inloggen</button>
                <?php endif; ?>
            </form>
            
            <?php if($lockout_time > 0): ?>
            <div class="lockout-timer" style="text-align: center; margin-top: 15px; color: #e74c3c; font-size: 14px;">
                <span id="countdown"></span>
            </div>
            <script>
                let seconds = <?php echo $lockout_time; ?>;
                function updateCountdown() {
                    let mins = Math.floor(seconds / 60);
                    let secs = seconds % 60;
                    document.getElementById('countdown').textContent = 
                        'Probeer opnieuw over ' + mins + ':' + (secs < 10 ? '0' : '') + secs;
                    if (seconds > 0) {
                        seconds--;
                        setTimeout(updateCountdown, 1000);
                    } else {
                        location.reload();
                    }
                }
                updateCountdown();
            </script>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

