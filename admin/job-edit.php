<?php
include 'auth_check.php';
include '../db_connect.php';
include 'includes/activity_log.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0) {
    header('Location: jobs');
    exit;
}

if(isset($_POST['update_job'])) {
    // Validate CSRF token
    if(!validateCSRFToken()) {
        $error = 'Beveiligingsfout. Vernieuw de pagina en probeer opnieuw.';
    } else {
        $title = trim($_POST['title']);
        $location = trim($_POST['location']);
        $type = $_POST['type'];
        $description = trim($_POST['description']);
        $requirements = trim($_POST['requirements']);
        $salary = trim($_POST['salary']);
    
    // Handle image upload
    $image = $_POST['existing_image']; // Keep existing image by default
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/img/jobs/';
        if(!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if(in_array($fileExtension, $allowedExtensions)) {
            $fileName = uniqid('job_') . '.' . $fileExtension;
            $uploadPath = $uploadDir . $fileName;
            
            if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                // Delete old image if it exists
                if(!empty($image) && file_exists('..' . $image)) {
                    unlink('..' . $image);
                }
                $image = '/assets/img/jobs/' . $fileName;
            }
        }
    } elseif(!empty($_POST['image_url'])) {
        $image = trim($_POST['image_url']);
    }
    
    $stmt = $conn->prepare('UPDATE bureau_vacatures SET title=?, location=?, type=?, description=?, requirements=?, salary=?, image=? WHERE id=?');
    $stmt->bind_param('sssssssi', $title, $location, $type, $description, $requirements, $salary, $image, $id);
    
    if($stmt->execute()) {
        logActivity($conn, 'update', 'vacature', $id, $title);
    }
    $stmt->close();
    
    header('Location: jobs?success=updated');
    exit;
    }
}

// Get job data
$stmt = $conn->prepare("SELECT * FROM bureau_vacatures WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();
$stmt->close();

if(!$job) {
    header('Location: jobs');
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacature Bewerken - Bureau Jobs Docenten Portal</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Vacature Bewerken</h1>
                <a href="jobs" class="btn-secondary">← Terug</a>
            </div>
            
            <div class="form-container">
                <form method="POST" action="" enctype="multipart/form-data">
                    <?php csrfField(); ?>
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($job['image']); ?>">
                    <div class="form-group">
                        <label>Vacature Titel *</label>
                        <input type="text" name="title" required value="<?php echo htmlspecialchars($job['title']); ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Locatie *</label>
                            <input type="text" name="location" required value="<?php echo htmlspecialchars($job['location']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Type *</label>
                            <select name="type" required>
                                <option value="Full-time" <?php if($job['type'] == 'Full-time' || $job['type'] == 'Fulltime') echo 'selected'; ?>>Full-time</option>
                                <option value="Part-time" <?php if($job['type'] == 'Part-time' || $job['type'] == 'Parttime') echo 'selected'; ?>>Part-time</option>
                                <option value="Stage" <?php if($job['type'] == 'Stage') echo 'selected'; ?>>Stage</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Salaris</label>
                        <input type="text" name="salary" value="<?php echo htmlspecialchars($job['salary']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Huidige Afbeelding</label>
                        <?php if(!empty($job['image'])): ?>
                            <img src="/vacatures<?php echo htmlspecialchars($job['image']); ?>" alt="Current" style="max-width: 200px; display: block; margin: 10px 0; border: 1px solid #ddd; padding: 5px;">
                        <?php else: ?>
                            <p>Geen afbeelding</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Nieuwe Afbeelding Upload (optioneel)</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small>Upload een nieuwe afbeelding (JPG, PNG, GIF, WEBP) om de huidige te vervangen</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Of gebruik een afbeelding URL (optioneel)</label>
                        <input type="text" name="image_url" placeholder="/assets/img/placeholder.png">
                        <small>Optioneel: Link naar een afbeelding (gebruikt alleen als geen nieuw bestand is geüpload)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Beschrijving *</label>
                        <textarea name="description" rows="6" required><?php echo htmlspecialchars($job['description']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Vereisten *</label>
                        <textarea name="requirements" rows="6" required><?php echo htmlspecialchars($job['requirements']); ?></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="update_job" class="btn-primary">Wijzigingen Opslaan</button>
                        <a href="jobs" class="btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

