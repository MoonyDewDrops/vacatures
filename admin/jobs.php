<?php
include 'auth_check.php';
include '../db_connect.php';
include 'includes/activity_log.php';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Get job title before deleting for activity log
    $stmt = $conn->prepare("SELECT title FROM bureau_vacatures WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $job = $result->fetch_assoc();
    $jobTitle = $job ? $job['title'] : 'Onbekend';
    $stmt->close();
    
    $stmt = $conn->prepare("DELETE FROM bureau_vacatures WHERE id = ?");
    $stmt->bind_param('i', $id);
    if($stmt->execute()) {
        logActivity($conn, 'delete', 'vacature', $id, $jobTitle);
    }
    $stmt->close();
    header('Location: jobs?success=deleted');
    exit;
}

// Get all jobs
$jobs = $conn->query("SELECT * FROM bureau_vacatures ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacatures Beheren - Bureau Jobs Docenten Portal</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Vacatures Beheren</h1>
                <a href="job-add" class="btn-primary">+ Nieuwe Vacature</a>
            </div>
            
            <?php if(isset($_GET['success'])): ?>
                <div class="success-message">
                    <?php 
                    if($_GET['success'] == 'added') echo 'Vacature succesvol toegevoegd!';
                    if($_GET['success'] == 'updated') echo 'Vacature succesvol bijgewerkt!';
                    if($_GET['success'] == 'deleted') echo 'Vacature succesvol verwijderd!';
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titel</th>
                            <th>Locatie</th>
                            <th>Type</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($jobs->num_rows > 0): ?>
                            <?php while($job = $jobs->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $job['id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($job['title']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                                    <td><span class="badge"><?php echo htmlspecialchars($job['type']); ?></span></td>
                                    <td class="actions">
                                        <a href="job-edit?id=<?php echo $job['id']; ?>" class="btn-small btn-edit">Bewerk</a>
                                        <a href="#" 
                                           class="btn-small btn-delete" 
                                           onclick="if(confirm('Weet je zeker dat je deze vacature wilt verwijderen?\n\nVacature: <?php echo htmlspecialchars($job['title']); ?>\n\nDit kan niet ongedaan worden gemaakt!')) { window.location.href='jobs?delete=<?php echo $job['id']; ?>'; } return false;">Verwijder</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">
                                    Geen vacatures gevonden. <a href="job-add">Voeg er een toe!</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

