-- Bureau Jobs CMS Database Setup
-- Run these SQL queries in phpMyAdmin

-- 1. Create admin users table
CREATE TABLE IF NOT EXISTS `bureau_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Create jobs table (bureau_vacatures)
CREATE TABLE IF NOT EXISTS `bureau_vacatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `salary` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Create form submissions table (bureau_sollicitaties)
CREATE TABLE IF NOT EXISTS `bureau_sollicitaties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `naam` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `vacature` varchar(255) NOT NULL,
  `descriptie` text DEFAULT NULL,
  `bestand_pad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Create login attempts table for brute force protection
CREATE TABLE IF NOT EXISTS `bureau_login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `success` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `ip_address` (`ip_address`),
  KEY `attempt_time` (`attempt_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Create activity log table for audit trail
CREATE TABLE IF NOT EXISTS `bureau_activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `action` varchar(50) NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `entity_name` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `entity_type` (`entity_type`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Create your first admin user
-- Username: admin
-- Password: admin123
-- IMPORTANT: Change this password after first login!
INSERT INTO `bureau_admin` (`username`, `password`, `admin`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Note: The password hash above is for "admin123"
-- After logging in, you should change this password or create a new admin user

-- 5. Insert sample jobs
INSERT INTO `bureau_vacatures` (`title`, `location`, `type`, `description`, `requirements`, `salary`, `image`) VALUES
('Front-end Developer', 'Utrecht', 'Full-time', 
'Bij Het Bureau zijn we op zoek naar creatieve front-end wizards! Kan jij maken wat een designer wil?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the wizard\nWij zijn op zoek naar een code wizard! Iemand die mooie designs kan omzetten in websites.\n\nBen jij iemand die liever programmeert aan de voorkant van websites? Lees dan vooral verder!',
'Basiskennis van HTML, CSS en Javascript.\n\nKennis van PHP, MySQL is een pré.\n\nGevoel voor design en techniek. Omzetten van een design in een technisch wonder!\n\nAffiniteit voor nieuwe front-end technieken. Denk hierbij aan het gebruik van animaties en GitHub.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Back-end Developer', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek naar de technische masters! Kan jij een technische oplossing verzinnen voor klanten?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the master\nWij zijn op zoek naar een code masters! Iemand die de mooiste en beste systemen kan automatiseren of zelf bedenken.\n\nBen jij iemand die liever programmeert en bedenkt hoe een online systeem gaat werken? Lees dan vooral verder!',
'Basiskennis van HTML, CSS, Javascript, GitHub, PHP en MySQL.\n\nKennis van Django en Symfony is een pré.\n\nOplossingsgericht denken. Niet denken in problemen maar in oplossingen!\n\nAffiniteit met nieuwe back-end technieken. Denk hierbij aan OOP, Resque, API-first methode.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Web audiovisueel', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek naar de regisseur van de film "HET BUREAU"!\nKan jij klanten helpen met het visualiseren van hun idee?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the director\nWij zijn op zoek naar een filmregisseur en editor! Iemand die de beste video, foto of geluid kan maken voor een website of social media.\n\nBen jij iemand die alles ziet door een camera? Lees dan vooral verder!',
'Basiskennis van video-editing, foto-editing, animaties maken.\n\nKan werken met Adobe Creative Cloud pakket!\n\nAffiniteit met muziek, films en social media.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Grafisch ontwerper', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek de nieuwe Rembrandt!\nBen jij goed op met het visualiseren op een digitaal canvas?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the artist\nWij zijn op zoek naar een kunstenaar! Iemand die de mooiste posters, visitekaartjes, huisstijlen of logo''s maakt.\n\nBen jij iemand die alles kan tekenen of digitaal kan maken? Lees dan vooral verder!',
'Basiskennis van foto-editing, tekenen, out of the box-denken.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nAffiniteit met design en kunst.\n\nJe kan goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Video specialist', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek naar de nieuwe Peter Jackson!\nKan jij klanten helpen met het visualiseren van hun idee?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the video frame freak\nWij zijn op zoek naar een filmregisseur en editor! Iemand die de beste video, foto of geluid kan maken voor een website of social media.\n\nBen jij iemand die alles ziet door een camera? Lees dan vooral verder!',
'Je laat camera''s doen waarvoor ze gemaakt zijn\n\nJe hebt kennis van premiere pro\n\nJe bent communicatief sterk en kunt zelfstandig en pro-actief aan de slag\n\nJe kunt goed samenwerken met andere mensen!\n\nKennis van live streaming is fijn',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Audio Engineer', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we opzoek naar de nieuwe Bram Krikke voor de BUREAU audio afdeling!!\nKan jij het Bureau of klanten helpen met hun digitale stem?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the #wav-wave\nWij zijn op zoek naar een audio engineer! Iemand die het beste geluid kan vinden of de juiste podcast kan maken.\n\nBen jij iemand met een goed gevoel voor geluid? Lees dan vooral verder!',
'Jij hebt kennis van stemmen en gesprekken opnemen\n\nJij hebt liefde voor sound design\n\nJij kunt audio editen tot een gewenste voice-over en podcast\n\nJe kunt goed samenwerken met andere mensen!\n\nJij weet de juiste sound, de gewenste sfeer te creeeren met geluid',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Front-end designer', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek de nieuwe Mark Zuckerberg!\nBen jij goed met het bedenken van een goede interface?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the astronaut\nWij zijn op zoek naar een astronaut van User Interface design! Iemand die de mooiste en nieuwste interfaces en designs maakt voor websites.\n\nBen jij iemand die creatieve nieuwe ideeën heeft voor websites en interfaces?',
'Basiskennis van User Interface, User Experience, Mobile Design en HTML/CSS.\n\nKennis van Design Thinking is een pré.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nAffiniteit voor digitaal organiseren en usergericht denken.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!\n\nErvaring met CMS Wordpress (plugins, migreren, thema''s maken/aanpassen, content editing en handleidingen maken)',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Conceptor en innovator', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek de nieuwe Steve Jobs!\nBen jij goed met het bedenken van een nieuw product of dienst voor klanten?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the innovator\nWij zijn op zoek naar een innovatie expert! Iemand die de nieuwste en meest creatieve ideeën kan verzinnen en visualiseren.\n\nBen jij iemand die leuke en nieuwe concepten kan bedenken en visualiseren?',
'Basiskennis van Out-of-the-box Thinking, styling en moodboards maken.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nAffiniteit met nieuwe gadgets en ontwikkelingen.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('E-commerce specialist', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek de uitvinder van de nieuwe Bol.com!\nBen jij degene die verstand heeft van online handelen?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the specialist\nWij zijn op zoek naar een e-commerce expert! Iemand die alle ins en outs weet op gebied van online handelen (e-commerce).\n\nBen jij iemand die de best verkopende webshop kan opzetten en bouwen?',
'Basiskennis van WooCommerce, betaalprocessen en SEO.\n\nKennis van SEA, dropshipping, Magento en Prestashop is een pré.\n\nKan werken met Adobe Creative Cloud pakket!\n\nWil leren wat marketing, doelgroepen, user stories en persona''s zijn.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Projectmanager', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek een manager voor een zootje ongeregeld!\nBen jij degene die van structuur en afspraken houdt?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the manager\nWij zijn op zoek naar een manager voor leuke online projecten! Iemand die altijd alle touwtjes in handen wil hebben en graag zaken zelf goed organiseert.\n\nBen jij iemand die gestructureerd kan werken op basis van afspraken en overleg?',
'Basiskennis van projectmanagement software en kennis van programmeren in HTML/CSS/Javascript/PHP/MySQL.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nWil leren wat het betekent om een goede manager te worden.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Hoofdredacteur', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek naar de perfectionist die goed kan organiseren!\nBen jij degene die veel verantwoordelijkheid heeft?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the editor\nWij zijn op zoek naar een perfectionist! Iemand die werk van andere controlleert en kijkt of dit getoond mag worden, aan een klant of online.\n\nBen jij iemand die kritisch is en beslissingen kan maken?',
'Basiskennis van projectmanagement software en kennis van programmeren in HTML/CSS/Javascript/PHP/MySQL.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nJe wilt leren wat het betekent om een goede redacteur te worden.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png'),

('Social media guru', 'Utrecht', 'Full-time',
'Bij Het Bureau zijn we op zoek naar een social media guru!\nBen jij degene die alles afweet van social media?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou''re the #HASHTAGKINGORQUEEN\nWij zijn op zoek naar een specialist in communicatie en social media! Iemand die van social media álles afweet en daar zelf aan bijdraagt.\n\nBen jij iemand die leuke en snappy comebacks heeft op een leuke social media post?',
'Basiskennis van Twitter, Facebook, Instagram, TikTok, Youtube.\n\nKennis van Google Ads en SEO is een pré.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nWil leren hoe je het beste online kan verkopen en reclame maken.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!',
'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden',
'/assets/img/placeholder.png');
