<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="/vacatures/assets/css/general.css">
    <link rel="stylesheet" href="/vacatures/assets/css/contact.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>

<body>
    <?php include "assets/php/header.php"; ?>
    <main>
        <?php if(isset($_GET['error'])): ?>
        <div id="error-message">
            <div class="error-content">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="#dc3545" stroke-width="2"/>
                    <path d="M15 9l-6 6M9 9l6 6" stroke="#dc3545" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <h2>Er ging iets mis!</h2>
                <p>
                    <?php
                    $error = $_GET['error'];
                    switch($error) {
                        case 'missing_fields':
                            echo 'Vul alle verplichte velden in.';
                            break;
                        case 'invalid_email':
                            echo 'Voer een geldig e-mailadres in.';
                            break;
                        case 'field_too_long':
                            echo 'Een of meer velden zijn te lang.';
                            break;
                        case 'file_too_large':
                            echo 'Het bestand is te groot (maximaal 10MB).';
                            break;
                        case 'invalid_file_type':
                            echo 'Ongeldig bestandstype. Toegestaan: PDF, DOC, DOCX, TXT, RTF.';
                            break;
                        case 'upload_failed':
                            echo 'Het uploaden van het bestand is mislukt. Probeer het opnieuw.';
                            break;
                        case 'database_error':
                            echo 'Er is een technische fout opgetreden. Probeer het later opnieuw.';
                            break;
                        default:
                            echo 'Er is een onbekende fout opgetreden.';
                    }
                    ?>
                </p>
                <button onclick="closeErrorMessage()" class="close-btn error-btn">Sluiten</button>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['success']) && $_GET['success'] === 'true'): ?>
        <div id="success-message">
            <div class="success-content">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="#28a745" stroke-width="2"/>
                    <path d="M8 12l2 2 4-4" stroke="#28a745" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <h2>Formulier Succesvol Verzonden!</h2>
                <p>Bedankt voor je bericht. We nemen zo snel mogelijk contact met je op.</p>
                <button onclick="closeSuccessMessage()" class="close-btn">Sluiten</button>
            </div>
        </div>
        <?php endif; ?>
        <section id="banner-section">
        </section>
        <section id="contact-section">
            <div id="contact-content">
                <div id="contact-title-container">
                    <p id="contact-title">Vul ons</p>
                    <p id="contact-title2">Formulier in!</p>
                    <p id="contact-title-text">Vul het contactformulier in en we komen snel bij je terug!</p>
                </div>
                <form action="/vacatures/send-form.php" enctype="multipart/form-data" method="POST" id="contact-form">
                    <label class="input-label" for="name">Wat is je naam?*</label>
                    <input class="form-text-inp" name="naam" type="text" placeholder="Volledige naam" required>
                    <label class="input-label" for="contact">Wat is je e-mail*</label>
                    <input class="form-text-inp" name="email" type="email" placeholder="janwillem@voorbeeld.com" required>
                    <label class="input-label" for="job">Om welke vacature gaat het?*</label>
                    <select class="form-text-inp" name="vacature" required>
                        <option value="">Selecteer een vacature</option>
                        <?php
                        require_once 'db_connect.php';
                        $result = $conn->query("SELECT id, title FROM bureau_vacatures ORDER BY title ASC");
                        if ($result && $result->num_rows > 0) {
                            while ($job = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($job['title']) . '">' . htmlspecialchars($job['title']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label class="input-label" for="file">CV*</label>
                    <input id="form-file-inp" name="file" type="file" required>
                    <p class="file-size-note">Toegestaan: PDF, DOC, DOCX, TXT, RTF. Maximale bestandsgrootte: 1GB</p>
                    <label class="input-label" for="comment">Opmerking?*</label>
                    <textarea class="form-textarea" name="descriptie" id="" placeholder="Opmerking..."></textarea>
                    <button id="form-submit" type="submit" name="stuur-form">Verstuur<svg width="75" height="6" viewBox="0 0 91 6"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 3H91" stroke="black" stroke-width="5" />
                        </svg></button>
                </form>
            </div>
        </section>
    </main>
    <?php include "assets/php/footer.php"; ?>
    
    <script>
        function closeSuccessMessage() {
            const successMsg = document.getElementById('success-message');
            successMsg.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                successMsg.style.display = 'none';
                // Remove success parameter from URL
                window.history.replaceState({}, document.title, 'contact');
            }, 300);
        }
        
        function closeErrorMessage() {
            const errorMsg = document.getElementById('error-message');
            errorMsg.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                errorMsg.style.display = 'none';
                // Remove error parameter from URL
                window.history.replaceState({}, document.title, 'contact');
            }, 300);
        }
        
        // Auto close after 5 seconds
        if(document.getElementById('success-message')) {
            setTimeout(closeSuccessMessage, 5000);
        }
        
        // Auto close error after 8 seconds
        if(document.getElementById('error-message')) {
            setTimeout(closeErrorMessage, 8000);
        }
        
        // Auto-fill job title from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const jobParam = urlParams.get('job');
        if(jobParam) {
            const vacatureSelect = document.querySelector('select[name="vacature"]');
            if(vacatureSelect) {
                const decodedJob = decodeURIComponent(jobParam);
                // Find and select the matching option
                for(let option of vacatureSelect.options) {
                    if(option.value === decodedJob) {
                        option.selected = true;
                        break;
                    }
                }
            }
        }
    </script>
</body>

</html>