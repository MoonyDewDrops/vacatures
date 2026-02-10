<header>
    <a class="header-button" href="/vacatures/vacatures">VACATURE</a>
    <a href="/vacatures/">
        <img id="header-logo" src="/vacatures/assets/img/header-logo.png" alt="logo">
    </a>
    <a class="header-button" href="/vacatures/contact">CONTACT</a>
    <button id="menu-btn" class="mob-btn">
        <svg id="menu-icon" width="45" height="20" viewBox="0 0 55 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.5 0.828613H54.5V7.72861H0.5V0.828613ZM14 18.0786H54.5V24.9786H14V18.0786Z" fill="white" />
        </svg>
    </button>
    
    <!-- Mobile Dropdown Menu -->
    <nav id="mobile-dropdown" class="mobile-dropdown">
        <button id="close-menu-btn" class="close-menu-btn">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M30 10L10 30M10 10L30 30" stroke="white" stroke-width="4" stroke-linecap="round"/>
            </svg>
        </button>
        <a href="/vacatures/vacatures" class="dropdown-link">VACATURE</a>
        <a href="/vacatures/contact" class="dropdown-link">CONTACT</a>
    </nav>
</header>

<script>
    // Toggle mobile menu
    const menuBtn = document.getElementById('menu-btn');
    const closeMenuBtn = document.getElementById('close-menu-btn');
    const mobileDropdown = document.getElementById('mobile-dropdown');
    
    menuBtn.addEventListener('click', function() {
        mobileDropdown.classList.toggle('active');
        menuBtn.classList.toggle('active');
    });

    // Close menu with close button
    closeMenuBtn.addEventListener('click', function() {
        mobileDropdown.classList.remove('active');
        menuBtn.classList.remove('active');
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = mobileDropdown.contains(event.target);
        const isClickOnButton = menuBtn.contains(event.target);
        
        if (!isClickInsideMenu && !isClickOnButton && mobileDropdown.classList.contains('active')) {
            mobileDropdown.classList.remove('active');
            menuBtn.classList.remove('active');
        }
    });

    // Close menu when clicking on a link
    const dropdownLinks = document.querySelectorAll('.dropdown-link');
    dropdownLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileDropdown.classList.remove('active');
            menuBtn.classList.remove('active');
        });
    });
</script>