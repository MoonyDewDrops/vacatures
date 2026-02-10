<?php
/**
 * Contact Form Handler
 * Security: Input validation, file upload security, prepared statements
 */

include 'db_connect.php';

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['stuur-form'])) {
    header('Location: /vacatures/contact');
    exit;
}

// Validate and sanitize inputs
$datum = date('Y-m-d H:i:s');
$naam = isset($_POST['naam']) ? trim(htmlspecialchars($_POST['naam'], ENT_QUOTES, 'UTF-8')) : '';
$email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
$vacature = isset($_POST['vacature']) ? trim(htmlspecialchars($_POST['vacature'], ENT_QUOTES, 'UTF-8')) : '';
$descriptie = isset($_POST['descriptie']) ? trim(htmlspecialchars($_POST['descriptie'], ENT_QUOTES, 'UTF-8')) : '';

// Validate required fields
if (empty($naam) || empty($email) || empty($vacature)) {
    header('Location: /vacatures/contact?error=missing_fields');
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /vacatures/contact?error=invalid_email');
    exit;
}

// Length validation
if (strlen($naam) > 255 || strlen($email) > 255 || strlen($vacature) > 255) {
    header('Location: /vacatures/contact?error=field_too_long');
    exit;
}

$file_path = null;

// Handle file upload with security checks
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['file'];
    
    // Max file size: 10MB
    $max_size = 10 * 1024 * 1024;
    if ($file['size'] > $max_size) {
        header('Location: /vacatures/contact?error=file_too_large');
        exit;
    }
    
    // Allowed file extensions
    $allowed_extensions = ['pdf', 'doc', 'docx', 'txt', 'rtf'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_extension, $allowed_extensions)) {
        header('Location: /vacatures/contact?error=invalid_file_type');
        exit;
    }
    
    // Validate MIME type
    $allowed_mimes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'text/plain',
        'application/rtf',
        'text/rtf'
    ];
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_mimes)) {
        header('Location: /vacatures/contact?error=invalid_file_type');
        exit;
    }
    
    // Create upload directory if it doesn't exist
    $upload_dir = __DIR__ . '/assets/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generate secure filename
    $safe_filename = preg_replace('/[^a-zA-Z0-9._-]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
    $safe_filename = substr($safe_filename, 0, 50); // Limit length
    $unique_filename = uniqid() . '_' . $safe_filename . '.' . $file_extension;
    $upload_path = $upload_dir . $unique_filename;
    
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        $file_path = 'assets/uploads/' . $unique_filename;
    } else {
        header('Location: /vacatures/contact?error=upload_failed');
        exit;
    }
}

// Insert into database using prepared statement
$stmt = $conn->prepare('INSERT INTO bureau_sollicitaties (datum, naam, email, vacature, bestand_pad, descriptie) VALUES (?, ?, ?, ?, ?, ?)');

if (!$stmt) {
    header('Location: /vacatures/contact?error=database_error');
    exit;
}

$stmt->bind_param('ssssss', $datum, $naam, $email, $vacature, $file_path, $descriptie);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header('Location: /vacatures/contact?success=true');
    exit;
} else {
    $stmt->close();
    $conn->close();
    header('Location: /vacatures/contact?error=database_error');
    exit;
}