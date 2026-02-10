<?php
include 'auth_check.php';
include '../db_connect.php';
include 'includes/activity_log.php';

// Get statistics
$total_jobs = $conn->query("SELECT COUNT(*) as count FROM bureau_vacatures")->fetch_assoc()['count'];
$total_submissions = $conn->query("SELECT COUNT(*) as count FROM bureau_sollicitaties")->fetch_assoc()['count'];

// Check if status column exists for submissions stats
$statusColumnExists = $conn->query("SHOW COLUMNS FROM bureau_sollicitaties LIKE 'status'")->num_rows > 0;
if($statusColumnExists) {
    $pending_submissions = $conn->query("SELECT COUNT(*) as count FROM bureau_sollicitaties WHERE status = 'pending' OR status IS NULL")->fetch_assoc()['count'];
    $accepted_submissions = $conn->query("SELECT COUNT(*) as count FROM bureau_sollicitaties WHERE status = 'accepted'")->fetch_assoc()['count'];
    $rejected_submissions = $conn->query("SELECT COUNT(*) as count FROM bureau_sollicitaties WHERE status = 'rejected'")->fetch_assoc()['count'];
} else {
    $pending_submissions = $total_submissions;
    $accepted_submissions = 0;
    $rejected_submissions = 0;
}

// Get recent activity for all users
$recent_activity = getRecentActivity($conn, 15);

// Get user statistics and login attempts if admin
if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    $total_users = $conn->query("SELECT COUNT(*) as count FROM bureau_admin")->fetch_assoc()['count'];
    $total_admins = $conn->query("SELECT COUNT(*) as count FROM bureau_admin WHERE admin = 1")->fetch_assoc()['count'];
    $total_teachers = $conn->query("SELECT COUNT(*) as count FROM bureau_admin WHERE admin = 0")->fetch_assoc()['count'];
    
    // Get failed login attempts in last 24 hours
    $failed_attempts_24h = $conn->query("SELECT COUNT(*) as count FROM bureau_login_attempts WHERE success = 0 AND attempt_time > DATE_SUB(NOW(), INTERVAL 24 HOUR)")->fetch_assoc()['count'];
    
    // Get recent login attempts (last 20)
    $recent_attempts = $conn->query("SELECT * FROM bureau_login_attempts ORDER BY attempt_time DESC LIMIT 20");
}

$recent_submissions = $conn->query("SELECT * FROM bureau_sollicitaties ORDER BY datum DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bureau Jobs Docenten Portal</title>
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
                    <h1>Dashboard</h1>
                    <p>Welkom terug, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                    <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                        <span class="badge" style="background: #1db954; margin-left: 8px;">Administrator</span>
                    <?php else: ?>
                        <span class="badge" style="background: #3e3e3e; margin-left: 8px;">Docent</span>
                    <?php endif; ?>
                    </p>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-content">
                        <h3><?php echo $total_jobs; ?></h3>
                        <p>Totaal Vacatures</p>
                    </div>
                    <a href="jobs" class="stat-link">Bekijk alle →</a>
                </div>
                
                <div class="stat-card">
                    <div class="stat-content">
                        <h3><?php echo $total_submissions; ?></h3>
                        <p>Inzendingen</p>
                        <div style="display: flex; gap: 12px; margin-top: 8px; font-size: 12px;">
                            <span style="color: #f39c12;">⏳ <?php echo $pending_submissions; ?></span>
                            <span style="color: #27ae60;">✅ <?php echo $accepted_submissions; ?></span>
                            <span style="color: #e74c3c;">❌ <?php echo $rejected_submissions; ?></span>
                        </div>
                    </div>
                    <a href="submissions" class="stat-link">Bekijk alle →</a>
                </div>
                
                <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                <div class="stat-card">
                    <div class="stat-content">
                        <h3><?php echo $total_users; ?></h3>
                        <p>Totaal Gebruikers</p>
                    </div>
                    <a href="users" class="stat-link">Bekijk alle →</a>
                </div>
                
                <div class="stat-card">
                    <div class="stat-content">
                        <h3><?php echo $total_admins; ?></h3>
                        <p>Administrators</p>
                    </div>
                    <a href="users" class="stat-link">Beheer →</a>
                </div>
                
                <div class="stat-card" style="<?php echo $failed_attempts_24h > 10 ? 'border-color: #e74c3c;' : ''; ?>">
                    <div class="stat-content">
                        <h3 style="<?php echo $failed_attempts_24h > 10 ? 'color: #e74c3c;' : ''; ?>"><?php echo $failed_attempts_24h; ?></h3>
                        <p>Mislukte Logins (24u)</p>
                    </div>
                    <span class="stat-link" style="opacity: 0.6;">Bekijk hieronder ↓</span>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <h2>Recente Inzendingen</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Naam</th>
                                <th>Email</th>
                                <th>Vacature</th>
                                <th>Status</th>
                                <th>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($recent_submissions->num_rows > 0): ?>
                                <?php while($submission = $recent_submissions->fetch_assoc()): ?>
                                    <?php 
                                        $status = $submission['status'] ?? 'pending';
                                        $statusColor = $status === 'accepted' ? '#27ae60' : ($status === 'rejected' ? '#e74c3c' : '#f39c12');
                                        $statusText = $status === 'accepted' ? 'Geaccepteerd' : ($status === 'rejected' ? 'Afgewezen' : 'In Behandeling');
                                        $statusIcon = $status === 'accepted' ? '✅' : ($status === 'rejected' ? '❌' : '⏳');
                                    ?>
                                    <tr>
                                        <td style="white-space: nowrap;"><?php echo date('d-m-Y', strtotime($submission['datum'])); ?></td>
                                        <td class="truncate-cell" title="<?php echo htmlspecialchars($submission['naam']); ?>"><?php echo htmlspecialchars($submission['naam']); ?></td>
                                        <td class="truncate-cell" title="<?php echo htmlspecialchars($submission['email']); ?>"><?php echo htmlspecialchars($submission['email']); ?></td>
                                        <td class="truncate-cell" title="<?php echo htmlspecialchars($submission['vacature']); ?>"><?php echo htmlspecialchars($submission['vacature']); ?></td>
                                        <td>
                                            <span class="badge" style="background: <?php echo $statusColor; ?>; white-space: nowrap;">
                                                <?php echo $statusIcon; ?> <?php echo $statusText; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="submission-view?id=<?php echo $submission['id']; ?>" class="btn-small">Bekijk</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">Geen inzendingen gevonden</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
            <div class="section">
                <h2>Recente Activiteit</h2>
                <p style="color: #888; margin-bottom: 15px;">Laatste acties in het systeem - alleen zichtbaar voor administrators</p>
                <div class="activity-timeline">
                    <?php if($recent_activity && $recent_activity->num_rows > 0): ?>
                        <?php while($activity = $recent_activity->fetch_assoc()): ?>
                            <div class="activity-item" style="display: flex; align-items: flex-start; padding: 12px 0; border-bottom: 1px solid #2a2a2a;">
                                <span style="font-size: 20px; margin-right: 12px;"><?php echo getActionIcon($activity['action']); ?></span>
                                <div style="flex: 1;">
                                    <div style="margin-bottom: 4px;">
                                        <strong style="color: <?php echo getActionColor($activity['action']); ?>;"><?php echo htmlspecialchars($activity['username']); ?></strong>
                                        <span style="color: #888;"><?php echo getActionText($activity['action'], $activity['entity_type']); ?></span>
                                        <?php if($activity['entity_name']): ?>
                                            <span style="color: #fff;">"<?php echo htmlspecialchars($activity['entity_name']); ?>"</span>
                                        <?php endif; ?>
                                    </div>
                                    <small style="color: #666;"><?php echo date('d-m-Y H:i', strtotime($activity['created_at'])); ?></small>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="color: #888; text-align: center; padding: 20px;">Geen recente activiteit gevonden</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="section">
                <h2>Recente Login Pogingen</h2>
                <p style="color: #888; margin-bottom: 15px;">Laatste 20 login pogingen - alleen zichtbaar voor administrators</p>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Datum/Tijd</th>
                                <th>IP Adres</th>
                                <th>Gebruikersnaam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($recent_attempts && $recent_attempts->num_rows > 0): ?>
                                <?php while($attempt = $recent_attempts->fetch_assoc()): ?>
                                    <tr style="<?php echo $attempt['success'] ? '' : 'background: rgba(231, 76, 60, 0.1);'; ?>">
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($attempt['attempt_time'])); ?></td>
                                        <td><code><?php echo htmlspecialchars($attempt['ip_address']); ?></code></td>
                                        <td><?php echo htmlspecialchars($attempt['username'] ?: '-'); ?></td>
                                        <td>
                                            <?php if($attempt['success']): ?>
                                                <span class="badge" style="background: #1db954;">✓ Succesvol</span>
                                            <?php else: ?>
                                                <span class="badge" style="background: #e74c3c;">✗ Mislukt</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">Geen login pogingen gevonden</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>

