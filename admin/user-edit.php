<?php
include 'auth_check.php';

// Check if user is admin
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: dashboard');
    exit;
}

include '../db_connect.php';
include 'includes/activity_log.php';

$error = '';
$message = '';

// Get user ID
if(!isset($_GET['id'])) {
    header('Location: users');
    exit;
}

$user_id = intval($_GET['id']);

// Get user data
$stmt = $conn->prepare("SELECT id, username, admin FROM bureau_admin WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    header('Location: users');
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Handle update
if(isset($_POST['update_user'])) {
    // Validate CSRF token
    if(!validateCSRFToken()) {
        $error = 'Beveiligingsfout. Vernieuw de pagina en probeer opnieuw.';
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
    
    // If editing your own account, preserve current admin status
    // Otherwise, get from checkbox
    if($user_id == $_SESSION['admin_id']) {
        $is_admin = $user['admin']; // Keep current value
    } else {
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    }
    
    // Validation
    if(empty($username)) {
        $error = 'Gebruikersnaam is verplicht';
    } elseif(!empty($password) && $password !== $confirm_password) {
        $error = 'Wachtwoorden komen niet overeen';
    } elseif(!empty($password) && strlen($password) < 6) {
        $error = 'Wachtwoord moet minimaal 6 karakters lang zijn';
    } else {
        // Check if username already exists (excluding current user)
        $stmt = $conn->prepare("SELECT id FROM bureau_admin WHERE username = ? AND id != ?");
        $stmt->bind_param('si', $username, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $error = 'Deze gebruikersnaam bestaat al';
            $stmt->close();
        } else {
            $stmt->close();
            
            // Update user
            if(!empty($password)) {
                // Update with new password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE bureau_admin SET username = ?, password = ?, admin = ? WHERE id = ?");
                $stmt->bind_param('ssii', $username, $hashed_password, $is_admin, $user_id);
            } else {
                // Update without password change
                $stmt = $conn->prepare("UPDATE bureau_admin SET username = ?, admin = ? WHERE id = ?");
                $stmt->bind_param('sii', $username, $is_admin, $user_id);
            }
            
            if($stmt->execute()) {
                logActivity($conn, 'update', 'user', $user_id, $username);
                $message = 'Gebruiker succesvol bijgewerkt';
                // Update user data for display
                $user['username'] = $username;
                $user['admin'] = $is_admin;
            } else {
                $error = 'Fout bij bijwerken gebruiker';
            }
            $stmt->close();
        }
    }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker Bewerken - Bureau Jobs Docenten Portal</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <div>
                    <h1>Gebruiker Bewerken</h1>
                    <p>Bewerk gebruiker: <?php echo htmlspecialchars($user['username']); ?></p>
                </div>
            </div>
            
            <?php if($message): ?>
                <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" action="">
                    <?php csrfField(); ?>
                    <div class="form-group">
                        <label>Gebruikersnaam *</label>
                        <input type="text" name="username" required 
                               value="<?php echo htmlspecialchars($user['username']); ?>"
                               placeholder="Voer gebruikersnaam in">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nieuw Wachtwoord</label>
                            <input type="password" name="password" 
                                   placeholder="Laat leeg om niet te wijzigen">
                            <p style="color: #b3b3b3; font-size: 12px; margin-top: 4px;">
                                Laat dit veld leeg als je het wachtwoord niet wilt wijzigen
                            </p>
                        </div>
                        
                        <div class="form-group">
                            <label>Bevestig Nieuw Wachtwoord</label>
                            <input type="password" name="confirm_password" 
                                   placeholder="Herhaal wachtwoord">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_admin" value="1" 
                                   <?php echo ($user['admin'] == 1) ? 'checked' : ''; ?>
                                   <?php echo ($user_id == $_SESSION['admin_id']) ? 'disabled' : ''; ?>
                                   style="width: auto; cursor: pointer;">
                            <span>Administrator Rechten</span>
                        </label>
                        <?php if($user_id == $_SESSION['admin_id']): ?>
                            <p style="color: #ff8f1c; font-size: 12px; margin-top: 4px;">
                                Je kunt je eigen administrator rechten niet wijzigen
                            </p>
                        <?php else: ?>
                            <p style="color: #b3b3b3; font-size: 12px; margin-top: 4px;">
                                Administrators kunnen gebruikers beheren en hebben volledige toegang tot alle functies
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="update_user" class="btn-primary">Wijzigingen Opslaan</button>
                        <a href="users" class="btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

