<?php
include 'auth_check.php';
include '../db_connect.php';
include 'includes/activity_log.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0) {
    header('Location: submissions.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM bureau_sollicitaties WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$sub = $result->fetch_assoc();
$stmt->close();

if(!$sub) {
    header('Location: submissions.php');
    exit;
}

// Log view activity
logActivity($conn, 'view', 'sollicitatie', $id, $sub['naam'] . ' - ' . $sub['vacature']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inzending Bekijken - Bureau Jobs Docenten Portal</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Inzending Details</h1>
                <a href="submissions" class="btn-secondary">← Terug</a>
            </div>
            
            <div class="detail-card">
                <div class="detail-header">
                    <h2><?php echo htmlspecialchars($sub['naam']); ?></h2>
                    <span class="date-badge"><?php echo date('d-m-Y H:i', strtotime($sub['datum'])); ?></span>
                </div>
                
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Email</label>
                        <a href="mailto:<?php echo htmlspecialchars($sub['email']); ?>"><?php echo htmlspecialchars($sub['email']); ?></a>
                    </div>
                    
                    <div class="detail-item">
                        <label>Vacature</label>
                        <p><?php echo htmlspecialchars($sub['vacature']); ?></p>
                    </div>
                    
                    <?php if($sub['bestand_pad']): ?>
                    <div class="detail-item">
                        <label>Bestand</label>
                        <a href="/vacatures/<?php echo htmlspecialchars($sub['bestand_pad']); ?>" target="_blank" class="btn-secondary">Download Bestand</a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="detail-item full-width">
                        <label>Opmerking</label>
                        <div class="comment-box">
                            <?php echo nl2br(htmlspecialchars($sub['descriptie'])); ?>
                        </div>
                    </div>
                </div>
                
                <div class="detail-actions">
                    <a href="mailto:<?php echo htmlspecialchars($sub['email']); ?>" class="btn-primary">Beantwoorden</a>
                    <a href="#" 
                       class="btn-delete" 
                       onclick="if(confirm('Weet je zeker dat je deze sollicitatie wilt verwijderen?\n\nNaam: <?php echo htmlspecialchars($sub['naam']); ?>\nVacature: <?php echo htmlspecialchars($sub['vacature']); ?>\n\nDit kan niet ongedaan worden gemaakt!')) { window.location.href='submissions?delete=<?php echo $sub['id']; ?>'; } return false;">Verwijderen</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

