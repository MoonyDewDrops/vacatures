<?php
// Get job ID from URL parameter
$job_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$job_id) {
    header("Location: /vacatures/vacatures");
    exit();
}

// Connect to database
require_once 'db_connect.php';

// Fetch job data from database
$stmt = $conn->prepare("SELECT * FROM bureau_vacatures WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();
$stmt->close();

// Check if job exists
if (!$job) {
    header("Location: /vacatures/vacatures");
    exit();
}

// Get job details
$job_title = htmlspecialchars($job['title']);
$job_location = htmlspecialchars($job['location']);
$job_type = htmlspecialchars($job['type']);

// Add bold formatting to key words
$job_description = nl2br(htmlspecialchars($job['description']));
$job_description = preg_replace('/\b(Het Bureau|You\'re|wizard|master|director|artist|specialist|innovator|expert|manager|editor|guru)\b/i', '<strong>$1</strong>', $job_description);

$job_requirements = nl2br(htmlspecialchars($job['requirements']));
$job_requirements = preg_replace('/\b(Basiskennis|Kennis van|pré|HTML|CSS|Javascript|PHP|MySQL|Adobe|Creative Cloud|WordPress|portfolio)\b/i', '<strong>$1</strong>', $job_requirements);

$job_salary = !empty($job['salary']) ? htmlspecialchars($job['salary']) : null;
if ($job_salary) {
    // Format the salary content with better structure
    $job_salary = nl2br($job_salary);
    
    // Enhanced patterns for benefits - bold important terms
    $job_salary = preg_replace(
        '/\b(salaris|bruto|brutosalaris|netto|€\s*\d+[.,]?\d*|euro|maand|jaar|per maand|per jaar|uurloon|bonus|bonusregeling|vakantiegeld|pensioen|pensioenregeling|reiskostenvergoeding|thuiswerkvergoeding|studiebudget|opleidingsbudget|groeimogelijkheden|doorgroeimogelijkheden|carrièremogelijkheden|ontwikkelmogelijkheden|laptop|telefoon|lease auto|leaseauto|auto van de zaak|flexibele werktijden|flexibiliteit|hybride werken|thuiswerken|teamuitjes|uitjes|vrijdagmiddagborrels|borrels|gezonde lunch|lunch|sportabonnement|fitness|fitnessabonnement|korting|personeelskorting|onbeperkt verlof|vakantiedagen|verlof|cao|winstdeling|secundaire arbeidsvoorwaarden|arbeidsvoorwaarden|ondersteuning|begeleiding|creatieve sessies|gezellige werkplek|leuke werkplek|30% dagen|32 uur|36 uur|38 uur|40 uur|24 vakantiedagen|25 vakantiedagen|26 vakantiedagen|27 vakantiedagen|28 vakantiedagen|29 vakantiedagen|30 vakantiedagen|55 vakantiedagen|eindejaarsuitkering|13e maand|8% vakantiegeld|8,33% vakantiegeld|fulltime|parttime|vast contract|tijdelijk contract|ontwikkelmogelijkheden|trainingen|cursussen|conferenties|innovatief|modern|gezellig|ambitieus|dynamisch|internationaal|informeel|redactie skills|betere redacteur|echte redacteur|vaste werkplek)\b/i',
        '<strong>$1</strong>',
        $job_salary
    );
}

$image_url = !empty($job['image']) ? '/vacatures' . htmlspecialchars($job['image']) : '/vacatures/assets/img/placeholder.png';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $job_title; ?> - Het Bureau</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="/vacatures/assets/css/general.css">
    <link rel="stylesheet" href="/vacatures/assets/css/jobdetail.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Buroto', sans-serif;
            background: #000000;
        }

        /* Hero Section - Matching website style */
        #hero-section {
            z-index: 0;
            background: linear-gradient(0deg, rgba(217, 217, 217, 0) 80%, #000000 100%),
                linear-gradient(180deg, rgba(217, 217, 217, 0) 40%, rgba(0, 0, 0, 0.9) 95%),
                url("<?php echo !empty($job['image']) ? '/vacatures' . htmlspecialchars($job['image']) : '/vacatures/assets/img/jobdetail/job-page-banner.jpg'; ?>");
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 130vh;
            padding: 15% 0 10% 5%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            position: relative;
            overflow: hidden;
        }

        
        #hero-content {
            z-index: 2;
            position: relative;
            padding: 0;
        }
        
        #hero-title {
            font-family: "Buroto-Wide";
            font-size: 5.5rem;
            color: #fff;
            margin: 0;
            margin-bottom: 30px;
            line-height: 1.2;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }
        
        .hero-meta {
            font-family: "Buroto";
            font-size: 2.5rem;
            color: #ff8f1c;
            margin: 0;
            font-weight: 600;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }
        


        /* Content Section */
        #job-content-section {
            background-color: #fff;
            padding: 80px 5%;
            margin-top: -7%;
            border-top-right-radius: 120px;
            position: relative;
            z-index: 1;
        }
        
        .job-content-wrapper {
            max-width: 950px;
            margin: 0 auto;
        }
        
        .content-block {
            background: #ffffff;
            padding: 50px;
            margin-bottom: 50px;
        }
        
        .section-title {
            font-family: "Buroto-Wide";
            font-size: 3rem;
            color: #000;
            margin: 0 0 30px 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .section-title svg {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }
        
        .job-description,
        .job-requirements,
        .job-salary {
            font-family: "Buroto", sans-serif;
            font-size: 1.1rem;
            line-height: 1.9;
            color: #2d3748;
        }
        
        .job-description br,
        .job-requirements br,
        .job-salary br {
            display: block;
            content: "";
            margin-top: 15px;
        }
        
        /* Highlighted keywords */
        .job-description strong,
        .job-requirements strong {
            color: #ff8f1c;
            font-weight: 700;
        }
        
        /* Benefits Block */
        .benefits-block {
            background: #000;
            color: #ffffff;
            padding: 50px;
        }
        
        .benefits-block .job-salary {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1rem;
            line-height: 1.9;
        }
        
        .benefits-block .job-salary strong {
            color: #ff8f1c;
            font-weight: 700;
        }
        
        /* Inline icons for benefits */
        .job-salary .benefit-icon,
        .job-requirements .benefit-icon,
        .job-description .benefit-icon {
            width: 20px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
            margin-left: 5px;
        }
        
        /* CTA Section - Simple version matching website */
        #cta-section {
            background: #000000;
            padding: 80px 5%;
            text-align: center;
        }
        
        #cta-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        #cta-title {
            font-family: "Buroto-Wide";
            font-size: 3.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 30px;
        }
        
        #cta-text {
            font-family: "Buroto";
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            line-height: 1.8;
        }
        
        .cta-button {
            font-family: "Buroto";
            font-size: 1.5rem;
            background-color: #ff8f1c;
            color: #000;
            padding: 20px 40px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            background-color: #e67e22;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 143, 28, 0.4);
        }
        
        @media (max-width: 768px) {
            #cta-title {
                font-size: 2.5rem;
            }
            
            #cta-subtitle {
                font-size: 1.2rem;
            }
            
            #cta-text {
                font-size: 1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                gap: 15px;
            }
            
            .cta-button {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
            
            .cta-info {
                flex-direction: column;
                gap: 20px;
                align-items: center;
            }
        }
        
        @media (max-width: 1024px) {
            #hero-section {
                height: 100vh;
                padding-top: 25%;
            }
            
            #hero-title {
                font-size: 4rem;
            }
            
            #hero-subtitle {
                font-size: 9rem;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 768px) {
            #hero-section {
                height: 100vh;
                padding-top: 22%;
                border-bottom-left-radius: 60px;
            }
            
            #hero-title {
                font-size: 3rem;
            }
            
            #hero-subtitle {
                font-size: 6rem;
            }
            
            .hero-meta {
                font-size: 1.5rem;
            }
            
            #job-content-section {
                border-top-right-radius: 60px;
                padding: 50px 5%;
                margin-top: -3%;
            }
            
            .content-block {
                padding: 25px;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            #cta-title {
                font-size: 2.5rem;
            }
            
            #cta-text {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 480px) {
            #hero-section {
                height: 90vh;
                padding-top: 30%;
                padding-left: 5%;
                border-bottom-left-radius: 40px;
            }
            
            #hero-content {
                padding-top: 8rem;
            }
            
            #hero-title {
                font-size: 2.5rem;
                margin-bottom: 15px;
            }
            
            .hero-meta {
                font-size: 1.4rem;
            }
            
            #job-content-section {
                border-top-right-radius: 60px;
                padding: 50px 5%;
                margin-top: -3%;
            }
            
            .content-block {
                padding: 25px;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            #cta-title {
                font-size: 2rem;
            }
            
            #cta-text {
                font-size: 1rem;
            }
            
            .cta-button {
                padding: 15px 30px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <?php include "assets/php/header.php"; ?>
    
    <main>
        <!-- Hero Section -->
        <section id="hero-section">
            <div id="hero-content">
                <h1 id="hero-title"><?php echo $job_title; ?></h1>
                <p class="hero-meta"><?php echo $job_type; ?> • <?php echo $job_location; ?></p>
            </div>
        </section>

        <!-- Job Content Section -->
        <section id="job-content-section">
            <div class="job-content-wrapper">
                <div class="content-block">
                    <h2 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="#ff8f1c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 2V8H20" stroke="#ff8f1c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 13H8" stroke="#ff8f1c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 17H8" stroke="#ff8f1c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 9H9H8" stroke="#ff8f1c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Over de functie
                    </h2>
                    <div class="job-description">
                        <?php echo $job_description; ?>
                    </div>
                </div>
                
                <div class="content-block">
                    <h2 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 11L12 14L22 4" stroke="#ff8f1c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="#ff8f1c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Wij vragen
                    </h2>
                    <div class="job-requirements">
                        <?php echo $job_requirements; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="cta-section">
            <div id="cta-content">
                <h2 id="cta-title">Enthousiast geworden?</h2>
                <p id="cta-text">Solliciteer direct via ons contactformulier!</p>
                <a href="/vacatures/contact?job=<?php echo urlencode($job_title); ?>" class="cta-button">
                    Solliciteer Nu
                    <svg width="75" height="6" viewBox="0 0 91 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 3H91" stroke="black" stroke-width="5" />
                    </svg>
                </a>
            </div>
        </section>
    </main>
    <?php include "assets/php/footer.php"; ?>
</body>
</html>
