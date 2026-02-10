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

if(isset($_POST['add_user'])) {
    // Validate CSRF token
    if(!validateCSRFToken()) {
        $error = 'Beveiligingsfout. Vernieuw de pagina en probeer opnieuw.';
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    
    // Validation
    if(empty($username) || empty($password)) {
        $error = 'Gebruikersnaam en wachtwoord zijn verplicht';
    } elseif($password !== $confirm_password) {
        $error = 'Wachtwoorden komen niet overeen';
    } elseif(strlen($password) < 6) {
        $error = 'Wachtwoord moet minimaal 6 karakters lang zijn';
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM bureau_admin WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $error = 'Deze gebruikersnaam bestaat al';
            $stmt->close();
        } else {
            $stmt->close();
            
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO bureau_admin (username, password, admin) VALUES (?, ?, ?)");
            $stmt->bind_param('ssi', $username, $hashed_password, $is_admin);
            
            if($stmt->execute()) {
                $newUserId = $conn->insert_id;
                logActivity($conn, 'create', 'user', $newUserId, $username);
                $message = 'Gebruiker succesvol aangemaakt';
                // Redirect after 2 seconds
                header("refresh:2;url=users.php");
            } else {
                $error = 'Fout bij aanmaken gebruiker';
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
    <title>Gebruiker Toevoegen - Bureau Jobs Docenten Portal</title>
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
                    <h1>Nieuwe Gebruiker Toevoegen</h1>
                    <p>Voeg een nieuwe docent of administrator toe</p>
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
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                               placeholder="Voer gebruikersnaam in">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Wachtwoord *</label>
                            <input type="password" name="password" required 
                                   placeholder="Minimaal 6 karakters">
                        </div>
                        
                        <div class="form-group">
                            <label>Bevestig Wachtwoord *</label>
                            <input type="password" name="confirm_password" required 
                                   placeholder="Herhaal wachtwoord">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_admin" value="1" 
                                   <?php echo (isset($_POST['is_admin']) && $_POST['is_admin']) ? 'checked' : ''; ?>
                                   style="width: auto; cursor: pointer;">
                            <span>Administrator Rechten</span>
                        </label>
                        <p style="color: #b3b3b3; font-size: 12px; margin-top: 4px;">
                            Administrators kunnen gebruikers beheren en hebben volledige toegang tot alle functies
                        </p>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="add_user" class="btn-primary">Gebruiker Toevoegen</button>
                        <a href="users" class="btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

