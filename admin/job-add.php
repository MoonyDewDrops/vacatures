<?php
include 'auth_check.php';
include '../db_connect.php';
include 'includes/activity_log.php';

$error = '';
$success = '';

if(isset($_POST['add_job'])) {
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
    $image = '';
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
                $image = '/assets/img/jobs/' . $fileName;
            } else {
                $error = 'Fout bij uploaden van afbeelding';
            }
        } else {
            $error = 'Alleen JPG, PNG, GIF en WEBP bestanden zijn toegestaan';
        }
    } elseif(!empty($_POST['image_url'])) {
        $image = trim($_POST['image_url']);
    }
    
    if(empty($title) || empty($location) || empty($type) || empty($description) || empty($requirements)) {
        $error = 'Vul alle verplichte velden in';
    } else {
        // Check which columns exist in the table
        $columns_result = $conn->query("SHOW COLUMNS FROM bureau_vacatures");
        $existing_columns = [];
        while($col = $columns_result->fetch_assoc()) {
            $existing_columns[] = $col['Field'];
        }
        
        // Build dynamic query based on existing columns
        $columns = ['title', 'location', 'type', 'description', 'requirements'];
        $values = [$title, $location, $type, $description, $requirements];
        $types = 'sssss';
        
        if(in_array('salary', $existing_columns)) {
            $columns[] = 'salary';
            $values[] = $salary;
            $types .= 's';
        }
        
        if(in_array('image', $existing_columns)) {
            $columns[] = 'image';
            $values[] = $image;
            $types .= 's';
        }
        
        $sql = "INSERT INTO bureau_vacatures (" . implode(', ', $columns) . ") VALUES (" . str_repeat('?, ', count($columns) - 1) . "?)";
        
        $stmt = $conn->prepare($sql);
        if($stmt) {
            $stmt->bind_param($types, ...$values);
            
            if($stmt->execute()) {
                $newJobId = $conn->insert_id;
                logActivity($conn, 'create', 'vacature', $newJobId, $title);
                header('Location: jobs?success=added');
                exit;
            } else {
                $error = 'Fout bij toevoegen vacature: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = 'Fout bij voorbereiden query: ' . $conn->error;
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
    <title>Vacature Toevoegen - Bureau Jobs Docenten Portal</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Nieuwe Vacature Toevoegen</h1>
                <a href="jobs" class="btn-secondary">← Terug</a>
            </div>
            
            <?php if($error): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                    <br><br>
                    <details style="margin-top: 10px;">
                        <summary style="cursor: pointer; color: #ff8f1c;">Show Debug Info</summary>
                        <pre style="background: #1a1a1a; padding: 10px; margin-top: 10px; border-radius: 4px; font-size: 12px; overflow-x: auto;">
<?php
if(isset($_POST['add_job'])) {
    echo "Submitted Data:\n";
    echo "Title: " . (isset($_POST['title']) ? $_POST['title'] : 'NOT SET') . "\n";
    echo "Location: " . (isset($_POST['location']) ? $_POST['location'] : 'NOT SET') . "\n";
    echo "Type: " . (isset($_POST['type']) ? $_POST['type'] : 'NOT SET') . "\n";
    echo "Description: " . (isset($_POST['description']) ? substr($_POST['description'], 0, 50) . '...' : 'NOT SET') . "\n";
    echo "Requirements: " . (isset($_POST['requirements']) ? substr($_POST['requirements'], 0, 50) . '...' : 'NOT SET') . "\n";
}
?>
                        </pre>
                    </details>
                </div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" action="" enctype="multipart/form-data">
                    <?php csrfField(); ?>
                    <div class="form-group">
                        <label>Vacature Titel *</label>
                        <input type="text" name="title" required placeholder="Front-end Developer">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Locatie *</label>
                            <input type="text" name="location" required placeholder="Utrecht">
                        </div>
                        
                        <div class="form-group">
                            <label>Type *</label>
                            <select name="type" required>
                                <option value="">Selecteer type</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Stage">Stage</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Salaris (optioneel)</label>
                        <input type="text" name="salary" placeholder="Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies">
                        <small>Optioneel: Laat leeg of vul in wat er wordt geboden</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Afbeelding Upload (optioneel)</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small>Upload een afbeelding (JPG, PNG, GIF, WEBP)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Of gebruik een afbeelding URL (optioneel)</label>
                        <input type="text" name="image_url" placeholder="/assets/img/placeholder.png">
                        <small>Optioneel: Link naar een afbeelding (gebruikt alleen als geen bestand is geüpload)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Beschrijving *</label>
                        <textarea name="description" rows="8" required placeholder="Bij Het Bureau zijn we op zoek naar creatieve front-end wizards! Kan jij maken wat een designer wil?

Binnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!

You're the wizard
Wij zijn op zoek naar een code wizard! Iemand die mooie designs kan omzetten in websites.

Ben jij iemand die liever programmeert aan de voorkant van websites? Lees dan vooral verder!"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Vereisten *</label>
                        <textarea name="requirements" rows="8" required placeholder="Basiskennis van HTML, CSS en Javascript.

Kennis van PHP, MySQL is een pré.

Gevoel voor design en techniek. Omzetten van een design in een technisch wonder!

Affiniteit voor nieuwe front-end technieken. Denk hierbij aan het gebruik van animaties en GitHub.

Je kunt goed samenwerken met andere mensen!

Een eigen portfolio waarin wij je skills kunnen zien!"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="add_job" class="btn-primary">Vacature Toevoegen</button>
                        <a href="jobs" class="btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

