<?php
// Connect to database
require_once 'db_connect.php';

// Fetch all jobs
$result = $conn->query("SELECT * FROM bureau_vacatures ORDER BY id DESC");
$jobs = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Ensure all text fields are properly encoded
        foreach ($row as $key => $value) {
            if (is_string($value)) {
                $row[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
        }
        $jobs[] = $row;
    }
}

// Pre-encode jobs for JavaScript
$jobsJson = json_encode($jobs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
if ($jobsJson === false) {
    // Fallback: try without special encoding
    $jobsJson = json_encode($jobs);
}
if ($jobsJson === false) {
    // Last resort: empty array
    $jobsJson = '[]';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacatures</title>
    <link rel="icon" type="image/png" href="/vacatures/assets/img/favicon.png">
    <link rel="stylesheet" href="/vacatures/assets/css/general.css">
    <link rel="stylesheet" href="/vacatures/assets/css/vacatures.css">
</head>

<body>
    <?php include "assets/php/header.php"; ?>
    <main>
        <section id="banner-section">
            <p id="banner-title">Wij zoeken altijd naar</p>
            <p id="banner-title2">nieuwe talenten!</p>
        </section>

        <section id="job-section">
            <div id="job-section-left">
                <p id="job-section-title">Staat jouw talent erbij?</p>
                <div id="input-wrapper">
                    <input type="text" id="search-bar" placeholder="Zoek op">
                    <svg id="search-icon" width="40" height="41" viewBox="0 0 34 35" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.7935 0.781252C11.7438 0.7801 9.72233 1.25974 7.8916 2.18165C6.06086 3.10355 4.47188 4.44201 3.25232 6.08948C2.03276 7.73696 1.21663 9.64752 0.869493 11.6677C0.522355 13.6878 0.653891 15.7612 1.25353 17.7213C1.85317 19.6814 2.9042 21.4735 4.32218 22.9537C5.74015 24.4338 7.48553 25.5607 9.41809 26.2439C11.3507 26.9271 13.4165 27.1474 15.4497 26.8872C17.4829 26.6271 19.4267 25.8936 21.1249 24.7459L30.4259 34.0467L33.5195 30.9533L24.2909 21.7248C25.7469 19.7773 26.632 17.463 26.8473 15.0411C27.0626 12.6191 26.5996 10.185 25.51 8.0112C24.4205 5.83744 22.7475 4.00981 20.6782 2.73292C18.6089 1.45602 16.2251 0.780252 13.7935 0.781252ZM5.06254 13.8872C5.06252 12.1604 5.57457 10.4723 6.53395 9.03644C7.49333 7.60059 8.85694 6.48148 10.4524 5.82062C12.0478 5.15977 13.8033 4.98685 15.497 5.32374C17.1907 5.66063 18.7464 6.49219 19.9675 7.71327C21.1886 8.93435 22.0202 10.4901 22.3571 12.1838C22.6939 13.8775 22.521 15.633 21.8602 17.2284C21.1993 18.8238 20.0802 20.1875 18.6444 21.1468C17.2085 22.1062 15.5204 22.6183 13.7935 22.6182C11.4787 22.6156 9.25949 21.6949 7.62267 20.0581C5.98586 18.4213 5.06515 16.2021 5.06254 13.8872Z"
                            fill="black" fill-opacity="0.3" />
                    </svg>
                </div>
            </div>
            <div id="job-section-right">
                <svg id="filter-btn" width="42" height="40" viewBox="0 0 38 36" fill="none"
                    xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;">
                    <path
                        d="M36.7292 18H13.0488M4.69021 18H1.27087M4.69021 18C4.69021 16.8919 5.13042 15.8291 5.91401 15.0455C6.6976 14.2619 7.76038 13.8217 8.86854 13.8217C9.9767 13.8217 11.0395 14.2619 11.8231 15.0455C12.6067 15.8291 13.0469 16.8919 13.0469 18C13.0469 19.1082 12.6067 20.171 11.8231 20.9545C11.0395 21.7381 9.9767 22.1783 8.86854 22.1783C7.76038 22.1783 6.6976 21.7381 5.91401 20.9545C5.13042 20.171 4.69021 19.1082 4.69021 18ZM36.7292 30.6634H25.7122M25.7122 30.6634C25.7122 31.7718 25.2709 32.8358 24.4872 33.6196C23.7034 34.4034 22.6404 34.8437 21.532 34.8437C20.4238 34.8437 19.361 34.4015 18.5774 33.618C17.7938 32.8344 17.3536 31.7716 17.3536 30.6634M25.7122 30.6634C25.7122 29.555 25.2709 28.493 24.4872 27.7092C23.7034 26.9254 22.6404 26.4851 21.532 26.4851C20.4238 26.4851 19.361 26.9253 18.5774 27.7089C17.7938 28.4925 17.3536 29.5553 17.3536 30.6634M17.3536 30.6634H1.27087M36.7292 5.3366H30.778M22.4194 5.3366H1.27087M22.4194 5.3366C22.4194 4.22843 22.8596 3.16566 23.6432 2.38207C24.4268 1.59848 25.4895 1.15826 26.5977 1.15826C27.1464 1.15826 27.6897 1.26634 28.1967 1.47632C28.7036 1.6863 29.1642 1.99408 29.5522 2.38207C29.9402 2.77006 30.248 3.23068 30.458 3.73762C30.668 4.24456 30.776 4.78789 30.776 5.3366C30.776 5.8853 30.668 6.42864 30.458 6.93558C30.248 7.44252 29.9402 7.90313 29.5522 8.29112C29.1642 8.67912 28.7036 8.98689 28.1967 9.19687C27.6897 9.40686 27.1464 9.51493 26.5977 9.51493C25.4895 9.51493 24.4268 9.07471 23.6432 8.29112C22.8596 7.50754 22.4194 6.44476 22.4194 5.3366Z"
                        stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
                </svg>
                
                <!-- Filter Menu -->
                <div id="filter-menu" style="display: none; position: absolute; background: white; border: 2px solid black; padding: 15px; border-radius: 8px; z-index: 1000; margin-top: 10px;">
                    <p style="font-weight: bold; margin-bottom: 10px;">Filter op type:</p>
                    <button class="filter-option" data-filter="all" style="display: block; width: 100%; padding: 8px; text-align: left; border: none; background: none; cursor: pointer; font-family: 'Buroto';">Alle vacatures</button>
                    <button class="filter-option" data-filter="Full-time" style="display: block; width: 100%; padding: 8px; text-align: left; border: none; background: none; cursor: pointer; font-family: 'Buroto';">Full-time</button>
                    <button class="filter-option" data-filter="Part-time" style="display: block; width: 100%; padding: 8px; text-align: left; border: none; background: none; cursor: pointer; font-family: 'Buroto';">Part-time</button>
                    <button class="filter-option" data-filter="Stage" style="display: block; width: 100%; padding: 8px; text-align: left; border: none; background: none; cursor: pointer; font-family: 'Buroto';">Stage</button>
                </div>
                
                <div id="job-slider-container">
                    <?php
                    if (!empty($jobs)) {
                        foreach ($jobs as $job) {
                            $jobId = $job['id'];
                            $jobTitle = htmlspecialchars($job['title']);
                            $location = htmlspecialchars($job['location']);
                            $jobType = htmlspecialchars($job['type']);
                            $imageUrl = !empty($job['image']) ? '/vacatures' . htmlspecialchars($job['image']) : '/vacatures/assets/img/placeholder.png';
                    ?>
                        <a href="/vacatures/vacature?id=<?php echo $jobId; ?>" class="job-card" style="text-decoration: none; color: inherit;">
                            <img class="job-card-img" src="<?php echo $imageUrl; ?>" alt="<?php echo $jobTitle; ?>">
                            <div class="job-card-text">
                                <div class="job-card-top-text">
                                    <p class="job-card-title"><?php echo $jobTitle; ?></p>
                                    <p class="job-card-loc"><?php echo $location; ?></p>
                                </div>
                                <div class="job-card-text-bottom">
                                    <p class="job-card-status"><?php echo $jobType; ?></p>
                                    <p class="job-card-link">Bekijk job</p>
                                </div>
                            </div>
                        </a>
                    <?php 
                        }
                    } else {
                        echo '<p style="padding: 20px; text-align: center;">Geen vacatures gevonden.</p>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <?php include "assets/php/footer.php"; ?>
    
    <script>
        const allJobs = <?php echo $jobsJson; ?>;
        let currentFilter = 'all';
        
        // Render jobs function
        function renderJobs(jobs) {
            const container = document.getElementById('job-slider-container');
            if (jobs.length === 0) {
                container.innerHTML = '<p style="padding: 20px; text-align: center;">Geen vacatures gevonden.</p>';
                return;
            }
            
            container.innerHTML = jobs.map(job => {
                const imageUrl = job.image ? '/vacatures' + job.image : '/vacatures/assets/img/placeholder.png';
                const title = job.title || '';
                const location = job.location || '';
                const type = job.type || '';
                return `
                    <a href="/vacatures/vacature?id=${job.id}" class="job-card" style="text-decoration: none; color: inherit;">
                        <img class="job-card-img" src="${imageUrl}" alt="${title}">
                        <div class="job-card-text">
                            <div class="job-card-top-text">
                                <p class="job-card-title">${title}</p>
                                <p class="job-card-loc">${location}</p>
                            </div>
                            <div class="job-card-text-bottom">
                                <p class="job-card-status">${type}</p>
                                <p class="job-card-link">Bekijk job</p>
                            </div>
                        </div>
                    </a>
                `;
            }).join('');
        }
        
        // Filter and search function
        function filterJobs() {
            const searchTerm = document.getElementById('search-bar').value.toLowerCase().trim();
            
            let filtered = allJobs.filter(job => {
                const title = (job.title || '').toLowerCase();
                const location = (job.location || '').toLowerCase();
                const description = (job.description || '').toLowerCase();
                const requirements = (job.requirements || '').toLowerCase();
                const jobType = (job.type || '').toLowerCase();
                
                const matchesSearch = !searchTerm || 
                    title.includes(searchTerm) ||
                    location.includes(searchTerm) ||
                    description.includes(searchTerm) ||
                    requirements.includes(searchTerm);
                
                // Normalize job type for comparison (handle both old and new formats)
                const normalizedJobType = jobType.replace(/\s+/g, '-').replace(/-/g, '');
                const normalizedFilter = currentFilter.toLowerCase().replace(/\s+/g, '-').replace(/-/g, '');
                const matchesFilter = currentFilter === 'all' || 
                                     jobType === currentFilter.toLowerCase() || 
                                     normalizedJobType === normalizedFilter ||
                                     jobType.includes(normalizedFilter) ||
                                     normalizedFilter.includes(jobType);
                
                return matchesSearch && matchesFilter;
            });
            
            renderJobs(filtered);
        }
        
        // Search bar listener
        document.getElementById('search-bar').addEventListener('input', filterJobs);
        
        // Toggle filter menu
        const filterBtn = document.getElementById('filter-btn');
        const filterMenu = document.getElementById('filter-menu');
        
        filterBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            filterMenu.style.display = filterMenu.style.display === 'none' ? 'block' : 'none';
            filterBtn.style.background = filterMenu.style.display === 'none' ? 'none' : '#ff8f1c';
        });
        
        // Filter options
        document.querySelectorAll('.filter-option').forEach(btn => {
            btn.addEventListener('click', function() {
                currentFilter = this.dataset.filter;
                
                // Update active state
                document.querySelectorAll('.filter-option').forEach(b => b.style.background = 'none');
                this.style.background = '#f0f0f0';
                
                filterJobs();
                filterMenu.style.display = 'none';
                filterBtn.style.background = 'none';
            });
        });
        
        // Close filter menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!filterBtn.contains(event.target) && !filterMenu.contains(event.target)) {
                filterMenu.style.display = 'none';
                filterBtn.style.background = 'none';
            }
        });
    </script>
</body>

</html>