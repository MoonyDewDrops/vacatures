<?php
include 'auth_check.php';
include '../db_connect.php';
include 'includes/activity_log.php';

include 'includes/submission_status.php';

handleSubmissionStatusRequest($conn);

// Handle Delete
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Get submission info before deleting for activity log
    $stmt = $conn->prepare("SELECT naam, vacature FROM bureau_sollicitaties WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sub = $result->fetch_assoc();
    $subName = $sub ? $sub['naam'] . ' - ' . $sub['vacature'] : 'Onbekend';
    $stmt->close();
    
    $stmt = $conn->prepare("DELETE FROM bureau_sollicitaties WHERE id = ?");
    $stmt->bind_param('i', $id);
    if($stmt->execute()) {
        logActivity($conn, 'delete', 'sollicitatie', $id, $subName);
    }
    $stmt->close();
    header('Location: submissions?success=deleted');
    exit;
}

// Get current filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Get submissions based on filter
switch($filter) {
    case 'pending':
        $submissions = $conn->query("SELECT * FROM bureau_sollicitaties WHERE status = 'pending' OR status IS NULL ORDER BY datum DESC");
        break;
    case 'accepted':
        $submissions = $conn->query("SELECT * FROM bureau_sollicitaties WHERE status = 'accepted' ORDER BY datum DESC");
        break;
    case 'rejected':
        $submissions = $conn->query("SELECT * FROM bureau_sollicitaties WHERE status = 'rejected' ORDER BY datum DESC");
        break;
    default:
        $submissions = $conn->query("SELECT * FROM bureau_sollicitaties ORDER BY datum DESC");
}

// Get counts for tabs
$countAll = $conn->query("SELECT COUNT(*) as count FROM bureau_sollicitaties")->fetch_assoc()['count'];
$countPending = $conn->query("SELECT COUNT(*) as count FROM bureau_sollicitaties WHERE status = 'pending' OR status IS NULL")->fetch_assoc()['count'];
$countAccepted = $conn->query("SELECT COUNT(*) as count FROM bureau_sollicitaties WHERE status = 'accepted'")->fetch_assoc()['count'];
$countRejected = $conn->query("SELECT COUNT(*) as count FROM bureau_sollicitaties WHERE status = 'rejected'")->fetch_assoc()['count'];
function submissionStatusMessage(): ?string
{
    if (!isset($_GET['success'])) {
        return null;
    }
    $emailNote = getEmailStatusNote();
    switch ($_GET['success']) {
        case 'deleted':
            return 'Inzending succesvol verwijderd!';
        case 'accepted':
            return 'Sollicitatie geaccepteerd!' . $emailNote;
        case 'rejected':
            return 'Sollicitatie afgewezen.' . $emailNote;
        case 'pending':
            return 'Sollicitatie teruggezet naar In Behandeling.';
        default:
            return 'Actie succesvol uitgevoerd!';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulier Inzendingen - Bureau Jobs Docenten Portal</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Formulier Inzendingen</h1>
                <a href="mail-test" class="btn-secondary">E-mail testen</a>
            </div>

            <?php $statusMessage = submissionStatusMessage(); ?>
            <?php if($statusMessage): ?>
                <div class="success-message"><?php echo htmlspecialchars($statusMessage); ?></div>
            <?php endif; ?>
            
            <!-- Filter Tabs -->
            <div class="filter-tabs" style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                <a href="submissions" class="filter-tab <?php echo $filter === 'all' ? 'active' : ''; ?>" style="padding: 10px 20px; background: <?php echo $filter === 'all' ? '#1db954' : '#2a2a2a'; ?>; color: white; text-decoration: none; border-radius: 6px; font-size: 14px;">
                    📋 Alle (<?php echo $countAll; ?>)
                </a>
                <a href="submissions?filter=pending" class="filter-tab <?php echo $filter === 'pending' ? 'active' : ''; ?>" style="padding: 10px 20px; background: <?php echo $filter === 'pending' ? '#f39c12' : '#2a2a2a'; ?>; color: white; text-decoration: none; border-radius: 6px; font-size: 14px;">
                    ⏳ In Behandeling (<?php echo $countPending; ?>)
                </a>
                <a href="submissions?filter=accepted" class="filter-tab <?php echo $filter === 'accepted' ? 'active' : ''; ?>" style="padding: 10px 20px; background: <?php echo $filter === 'accepted' ? '#27ae60' : '#2a2a2a'; ?>; color: white; text-decoration: none; border-radius: 6px; font-size: 14px;">
                    ✅ Geaccepteerd (<?php echo $countAccepted; ?>)
                </a>
                <a href="submissions?filter=rejected" class="filter-tab <?php echo $filter === 'rejected' ? 'active' : ''; ?>" style="padding: 10px 20px; background: <?php echo $filter === 'rejected' ? '#e74c3c' : '#2a2a2a'; ?>; color: white; text-decoration: none; border-radius: 6px; font-size: 14px;">
                    ❌ Afgewezen (<?php echo $countRejected; ?>)
                </a>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Datum</th>
                            <th>Naam</th>
                            <th>Email</th>
                            <th>Vacature</th>
                            <th>Status</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($submissions->num_rows > 0): ?>
                            <?php while($sub = $submissions->fetch_assoc()): ?>
                                <?php 
                                    $status = $sub['status'] ?? 'pending';
                                    $statusColor = $status === 'accepted' ? '#27ae60' : ($status === 'rejected' ? '#e74c3c' : '#f39c12');
                                    $statusText = $status === 'accepted' ? 'Geaccepteerd' : ($status === 'rejected' ? 'Afgewezen' : 'In Behandeling');
                                    $statusIcon = $status === 'accepted' ? '✅' : ($status === 'rejected' ? '❌' : '⏳');
                                    $viewUrl = 'submission-view?id=' . (int)$sub['id'];
                                ?>
                                <tr class="submission-row" data-href="<?php echo htmlspecialchars($viewUrl); ?>">
                                    <td><?php echo $sub['id']; ?></td>
                                    <td style="white-space: nowrap;"><?php echo date('d-m-Y', strtotime($sub['datum'])); ?></td>
                                    <td class="truncate-cell" title="<?php echo htmlspecialchars($sub['naam']); ?>"><?php echo htmlspecialchars($sub['naam']); ?></td>
                                    <td class="truncate-cell" title="<?php echo htmlspecialchars($sub['email']); ?>"><a href="mailto:<?php echo htmlspecialchars($sub['email']); ?>" onclick="event.stopPropagation();"><?php echo htmlspecialchars($sub['email']); ?></a></td>
                                    <td class="truncate-cell" title="<?php echo htmlspecialchars($sub['vacature']); ?>"><?php echo htmlspecialchars($sub['vacature']); ?></td>
                                    <td>
                                        <span class="badge" style="background: <?php echo $statusColor; ?>; white-space: nowrap;">
                                            <?php echo $statusIcon; ?> <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="<?php echo htmlspecialchars($viewUrl); ?>" class="btn-small" style="background: #3498db;" onclick="event.stopPropagation();">Bekijk</a>
                                        <?php if($status !== 'accepted'): ?>
                                            <a href="submissions?accept=<?php echo $sub['id']; ?>" class="btn-small" style="background: #27ae60;" onclick="event.stopPropagation(); return confirm('Accepteren? De sollicitant ontvangt een e-mail.');">Accept</a>
                                        <?php endif; ?>
                                        <?php if($status !== 'rejected'): ?>
                                            <a href="submissions?reject=<?php echo $sub['id']; ?>" class="btn-small" style="background: #e67e22;" onclick="event.stopPropagation(); return confirm('Afwijzen? De sollicitant ontvangt een e-mail.');">Afwijzen</a>
                                        <?php endif; ?>
                                        <?php if($status !== 'pending'): ?>
                                            <a href="submissions?pending=<?php echo $sub['id']; ?>" class="btn-small" style="background: #7f8c8d;" onclick="event.stopPropagation(); return confirm('Terugzetten?');">Reset</a>
                                        <?php endif; ?>
                                        <a href="#" class="btn-small" style="background: #c0392b;" onclick="event.stopPropagation(); if(confirm('Verwijderen?')) { window.location.href='submissions?delete=<?php echo $sub['id']; ?>'; } return false;">Verwijder</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">Geen inzendingen gevonden</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script>
        document.querySelectorAll('tr.submission-row[data-href]').forEach(function(row) {
            row.addEventListener('click', function(e) {
                if (e.target.closest('a')) return;
                window.location.href = row.getAttribute('data-href');
            });
        });
    </script>
</body>
</html>