<?php
include 'auth_check.php';

// Check if user is admin
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: dashboard');
    exit;
}

include '../db_connect.php';
include 'includes/activity_log.php';

$message = '';
$error = '';

// Handle delete
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Prevent deleting yourself
    if($id == $_SESSION['admin_id']) {
        $error = 'Je kunt je eigen account niet verwijderen';
    } else {
        // Get username before deleting
        $stmt = $conn->prepare("SELECT username FROM bureau_admin WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $deletedUser = $result->fetch_assoc();
        $deletedUsername = $deletedUser ? $deletedUser['username'] : 'Onbekend';
        $stmt->close();
        
        $stmt = $conn->prepare("DELETE FROM bureau_admin WHERE id = ?");
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            logActivity($conn, 'delete', 'user', $id, $deletedUsername);
            $message = 'Gebruiker succesvol verwijderd';
        } else {
            $error = 'Fout bij verwijderen gebruiker';
        }
        $stmt->close();
    }
}

// Get all users
$users = $conn->query("SELECT id, username, admin FROM bureau_admin ORDER BY admin DESC, username ASC");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikers - Bureau Jobs Docenten Portal</title>
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
                    <h1>Gebruikers Beheer</h1>
                    <p>Beheer docenten en administratoren</p>
                </div>
            </div>
            
            <?php if($message): ?>
                <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div style="margin-bottom: 24px;">
                <a href="user-add" class="btn-primary">Nieuwe Gebruiker Toevoegen</a>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gebruikersnaam</th>
                            <th>Rol</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($users && $users->num_rows > 0): ?>
                            <?php while($user = $users->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td>
                                        <?php if($user['admin'] == 1): ?>
                                            <span class="badge" style="background: #1db954;">Administrator</span>
                                        <?php else: ?>
                                            <span class="badge" style="background: #3e3e3e;">Docent</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="user-edit?id=<?php echo $user['id']; ?>" class="btn-edit btn-small">Bewerken</a>
                                            <?php if($user['id'] != $_SESSION['admin_id']): ?>
                                                <a href="#" 
                                                   class="btn-delete btn-small" 
                                                   onclick="if(confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?\n\nGebruiker: <?php echo htmlspecialchars($user['username']); ?>\nEmail: <?php echo htmlspecialchars($user['email']); ?>\n\nDit kan niet ongedaan worden gemaakt!')) { window.location.href='users?delete=<?php echo $user['id']; ?>'; } return false;">
                                                    Verwijderen
                                                </a>
                                            <?php else: ?>
                                                <span class="btn-small" style="background: #282828; cursor: not-allowed;">Je account</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">Geen gebruikers gevonden</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

