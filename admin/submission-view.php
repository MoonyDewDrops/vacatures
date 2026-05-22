<?php
include 'auth_check.php';
include '../db_connect.php';
include 'includes/activity_log.php';
include 'includes/submission_status.php';
handleSubmissionStatusRequest($conn);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0) {
    header('Location: submissions');
    exit;
}

$sub = getSubmissionById($conn, $id);

if(!$sub) {
    header('Location: submissions');
    exit;
}

// Log view activity
logActivity($conn, 'view', 'sollicitatie', $id, $sub['naam'] . ' - ' . $sub['vacature']);

$status = $sub['status'] ?? 'pending';
$statusColor = $status === 'accepted' ? '#27ae60' : ($status === 'rejected' ? '#e74c3c' : '#f39c12');
$statusText = $status === 'accepted' ? 'Geaccepteerd' : ($status === 'rejected' ? 'Afgewezen' : 'In Behandeling');
$statusIcon = $status === 'accepted' ? '✅' : ($status === 'rejected' ? '❌' : '⏳');

$fileUrl = null;
$fileExt = null;
$fileName = null;
if (!empty($sub['bestand_pad'])) {
    $fileUrl = '/vacatures/' . ltrim($sub['bestand_pad'], '/');
    $fileName = basename($sub['bestand_pad']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
}

$statusMessage = null;
if (isset($_GET['success'])) {
    $emailNote = getEmailStatusNote();
    switch ($_GET['success']) {
        case 'accepted':
            $statusMessage = 'Sollicitatie geaccepteerd!' . $emailNote;
            break;
        case 'rejected':
            $statusMessage = 'Sollicitatie afgewezen.' . $emailNote;
            break;
        case 'pending':
            $statusMessage = 'Sollicitatie teruggezet naar In Behandeling.';
            break;
    }
}
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

            <?php if($statusMessage): ?>
                <div class="success-message"><?php echo htmlspecialchars($statusMessage); ?></div>
            <?php endif; ?>
            
            <div class="detail-card">
                <div class="detail-header">
                    <div>
                        <h2><?php echo htmlspecialchars($sub['naam']); ?></h2>
                        <span class="badge" style="background: <?php echo $statusColor; ?>; margin-top: 8px; display: inline-block;">
                            <?php echo $statusIcon; ?> <?php echo $statusText; ?>
                        </span>
                    </div>
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

                    <div class="detail-item">
                        <label>Status</label>
                        <p><?php echo $statusIcon . ' ' . htmlspecialchars($statusText); ?></p>
                    </div>
                    
                    <?php if($fileUrl): ?>
                    <div class="detail-item full-width">
                        <label>Bijgevoegd bestand</label>
                        <p><?php echo htmlspecialchars($fileName); ?></p>
                        <div class="file-preview-meta">
                            <span style="color: #b3b3b3; font-size: 13px;"><?php echo strtoupper(htmlspecialchars($fileExt)); ?> bestand</span>
                            <a href="<?php echo htmlspecialchars($fileUrl); ?>" target="_blank" rel="noopener" class="btn-secondary">Openen / downloaden</a>
                        </div>
                        <?php if($fileExt === 'pdf'): ?>
                        <div class="file-preview">
                            <iframe src="<?php echo htmlspecialchars($fileUrl); ?>" title="CV preview"></iframe>
                        </div>
                        <?php elseif(in_array($fileExt, ['txt'], true)): ?>
                        <div class="file-preview" style="padding: 16px; max-height: 320px; overflow: auto;">
                            <pre style="color: #fff; white-space: pre-wrap; margin: 0; font-size: 13px;"><?php
                                $txtPath = dirname(__DIR__) . '/' . ltrim($sub['bestand_pad'], '/');
                                if (is_readable($txtPath)) {
                                    echo htmlspecialchars(file_get_contents($txtPath));
                                } else {
                                    echo 'Bestand kon niet worden geladen.';
                                }
                            ?></pre>
                        </div>
                        <?php else: ?>
                        <p style="color: #888; margin-top: 10px; font-size: 13px;">Voorbeeldweergave is alleen beschikbaar voor PDF en TXT. Gebruik de knop hierboven om het bestand te openen.</p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="detail-item full-width">
                        <label>Opmerking / motivatie</label>
                        <div class="comment-box">
                            <?php if(!empty(trim($sub['descriptie'] ?? ''))): ?>
                                <?php echo nl2br(htmlspecialchars($sub['descriptie'])); ?>
                            <?php else: ?>
                                <em style="color: #888;">Geen opmerking ingevuld.</em>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="detail-actions">
                    <div class="status-actions">
                        <?php if($status !== 'accepted'): ?>
                            <a href="submission-view?accept=<?php echo $id; ?>&from=view" class="btn-small" style="background: #27ae60; padding: 10px 18px;" onclick="return confirm('Accepteren? De sollicitant ontvangt een e-mail.');">✅ Accepteren</a>
                        <?php endif; ?>
                        <?php if($status !== 'rejected'): ?>
                            <a href="submission-view?reject=<?php echo $id; ?>&from=view" class="btn-small" style="background: #e67e22; padding: 10px 18px;" onclick="return confirm('Afwijzen? De sollicitant ontvangt een e-mail.');">❌ Afwijzen</a>
                        <?php endif; ?>
                        <?php if($status !== 'pending'): ?>
                            <a href="submission-view?pending=<?php echo $id; ?>&from=view" class="btn-small" style="background: #7f8c8d; padding: 10px 18px;" onclick="return confirm('Terugzetten naar In Behandeling?');">↩ Reset</a>
                        <?php endif; ?>
                    </div>
                    <a href="mailto:<?php echo htmlspecialchars($sub['email']); ?>" class="btn-primary">Beantwoorden</a>
                    <a href="#" 
                       class="btn-delete" 
                       onclick="if(confirm('Weet je zeker dat je deze sollicitatie wilt verwijderen?\n\nNaam: <?php echo htmlspecialchars($sub['naam'], ENT_QUOTES); ?>\nVacature: <?php echo htmlspecialchars($sub['vacature'], ENT_QUOTES); ?>\n\nDit kan niet ongedaan worden gemaakt!')) { window.location.href='submissions?delete=<?php echo $sub['id']; ?>'; } return false;">Verwijderen</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
