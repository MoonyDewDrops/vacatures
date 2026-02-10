# Bureau Jobs - Developer Guide

## Project Overview
A job board website for Bureau with job listings, application submissions, and admin panel management.

**Live URL:** `https://bureau.gluwebsite.nl/vacatures/`  
**Local Path:** `/vacatures/` (subfolder deployment)

---

## Technology Stack
- **Backend:** PHP 7.4+
- **Database:** MySQL (u230752_live)
- **Frontend:** HTML, CSS, JavaScript (Vanilla)
- **Fonts:** Buroto (body/headings), Buroto-Wide (large headings), Better-Times (decorative)
- **Colors:** Black (#000), White (#fff), Orange (#ff8f1c, #ff6b35, #e67e0f)

---

## Project Structure

```
bureau_jobs/
├── admin/                      # Admin panel (requires login)
│   ├── auth_check.php         # Authentication middleware
│   ├── login.php              # Admin login page
│   ├── dashboard.php          # Admin dashboard
│   ├── jobs.php               # Manage jobs list
│   ├── job-add.php            # Add new job
│   ├── job-edit.php           # Edit existing job
│   ├── submissions.php        # View applications
│   ├── submission-view.php    # View single application
│   ├── users.php              # Manage admin users
│   ├── user-add.php           # Add new admin
│   ├── user-edit.php          # Edit admin user
│   ├── logout.php             # Logout handler
│   ├── css/admin-style.css    # Admin panel styles
│   └── includes/
│       ├── header.php         # Admin header
│       └── sidebar.php        # Admin navigation
│
├── assets/
│   ├── css/
│   │   ├── general.css        # Global styles (header, footer, animations)
│   │   ├── home.css           # Homepage styles
│   │   ├── vacatures.css      # Job listings page styles
│   │   ├── contact.css        # Contact form styles
│   │   └── jobdetail.css      # Job detail page styles (vacature.php)
│   ├── php/
│   │   ├── header.php         # Main site header with navigation
│   │   └── footer.php         # Main site footer
│   ├── img/
│   │   ├── home/              # Homepage images
│   │   ├── vacatures/         # Job listings page images
│   │   ├── contact/           # Contact page images
│   │   ├── jobdetail/         # Job detail page images
│   │   ├── jobs/              # Uploaded job images (from admin)
│   │   ├── favicon.png        # Site favicon
│   │   ├── header-logo.png    # Header logo
│   │   └── placeholder.png    # Default job image
│   └── fonts/
│       ├── buroto-fonts/      # Buroto font family
│       └── better-times/      # Better Times decorative font
│
├── bureau/                     # Empty directory with .htaccess for URL rewriting
├── home.php                    # Homepage
├── vacatures.php              # Job listings page
├── vacature.php               # Single job detail page
├── contact.php                # Contact/application form
├── send-form.php              # Form submission handler
├── db_connect.php             # Database connection
├── admin.text                 # Admin credentials (DO NOT COMMIT TO PUBLIC REPO)
└── .htaccess                  # URL rewriting rules

```

---

## Database Schema

### Table: `bureau_vacatures`
Stores all job postings.

| Column       | Type         | Description                        |
|--------------|--------------|------------------------------------|
| id           | INT          | Primary key, auto-increment        |
| title        | VARCHAR(255) | Job title                          |
| location     | VARCHAR(255) | Job location                       |
| type         | VARCHAR(50)  | "Full-time", "Part-time", "Stage"  |
| description  | TEXT         | Job description (HTML)             |
| requirements | TEXT         | Job requirements (HTML)            |
| salary       | TEXT         | Salary information (optional)      |
| image        | VARCHAR(255) | Image path (e.g., /vacatures/assets/img/jobs/file.jpg) |
| created_at   | TIMESTAMP    | Creation timestamp                 |

### Table: `bureau_submissions`
Stores job application submissions.

| Column       | Type         | Description                        |
|--------------|--------------|------------------------------------|
| id           | INT          | Primary key, auto-increment        |
| job_id       | INT          | Related job ID (nullable)          |
| job_title    | VARCHAR(255) | Job title submitted for            |
| name         | VARCHAR(255) | Applicant name                     |
| email        | VARCHAR(255) | Applicant email                    |
| phone        | VARCHAR(50)  | Phone number                       |
| message      | TEXT         | Application message                |
| cv_path      | VARCHAR(255) | Path to uploaded CV                |
| submitted_at | TIMESTAMP    | Submission timestamp               |

### Table: `bureau_admin`
Admin and teacher user accounts.

| Column       | Type         | Description                        |
|--------------|--------------|------------------------------------
| id           | INT          | Primary key, auto-increment        |
| username     | VARCHAR(255) | Username (unique)                  |
| password     | VARCHAR(255) | Bcrypt hashed password             |
| admin        | TINYINT(1)   | 1 = Admin, 0 = Teacher             |

### Table: `bureau_activity_log`
Audit trail for all admin actions.

| Column       | Type         | Description                        |
|--------------|--------------|------------------------------------
| id           | INT          | Primary key, auto-increment        |
| user_id      | INT          | ID of user who performed action    |
| username     | VARCHAR(255) | Username at time of action         |
| action       | VARCHAR(50)  | create, update, delete, view, login, logout |
| entity_type  | VARCHAR(50)  | vacature, sollicitatie, user, system |
| entity_id    | INT          | ID of affected entity (nullable)   |
| entity_name  | VARCHAR(255) | Name/title of affected entity      |
| details      | TEXT         | Additional details (optional)      |
| ip_address   | VARCHAR(45)  | Client IP address                  |
| created_at   | TIMESTAMP    | When action occurred               |

### Table: `bureau_login_attempts`
Tracks login attempts for brute force protection.

| Column       | Type         | Description                        |
|--------------|--------------|------------------------------------|
| id           | INT          | Primary key, auto-increment        |
| ip_address   | VARCHAR(45)  | Client IP address                  |
| username     | VARCHAR(255) | Username attempted (nullable)      |
| attempt_time | TIMESTAMP    | Time of attempt                    |
| success      | TINYINT(1)   | 1 = successful, 0 = failed         |

### Table: `bureau_sollicitaties`
Stores job application submissions.

| Column       | Type         | Description                        |
|--------------|--------------|------------------------------------|
| id           | INT          | Primary key, auto-increment        |
| datum        | TIMESTAMP    | Submission timestamp               |
| naam         | VARCHAR(255) | Applicant name                     |
| email        | VARCHAR(255) | Applicant email                    |
| vacature     | VARCHAR(255) | Job title submitted for            |
| descriptie   | TEXT         | Application message                |
| bestand_pad  | VARCHAR(255) | Path to uploaded CV                |

---

## Key Features

### 1. URL Structure
All URLs use clean routing via `.htaccess` with `/vacatures/` prefix:
- `/vacatures/` → home.php
- `/vacatures/vacatures` → vacatures.php
- `/vacatures/vacature?id=1` → vacature.php
- `/vacatures/contact` → contact.php
- `/vacatures/admin/` → admin/dashboard.php

### 2. Job Filtering (JavaScript)
Located in `vacatures.php` (bottom script section):
- Real-time search by job title
- Filter by job type (Full-time, Part-time, Stage)
- No page reload required

**Important:** Job types must match exactly: "Full-time", "Part-time", or "Stage" (case-sensitive)

### 3. Image Upload System
Admin panel supports two methods:
- **File Upload:** Saves to `/assets/img/jobs/` directory
- **URL Input:** Stores external image URL
- Path stored in database includes `/vacatures/assets/img/jobs/` prefix
- Frontend uses path: `/vacatures/assets/img/jobs/filename.jpg`

### 4. Dynamic Job Detail Page
`vacature.php` fetches job by ID parameter and displays:
- Hero section with uploaded job image as background
- Job description and requirements
- Call-to-action button linking to contact form
- Pre-fills job title in contact form via URL parameter

### 5. Contact Form
Features:
- Pre-fills job title if coming from job detail page
- CV/Resume file upload (PDF, DOC, DOCX)
- Email validation
- Success modal on submission
- Files saved to `/assets/uploads/`

### 6. Admin Authentication
- Session-based authentication
- `auth_check.php` included on all admin pages
- Passwords hashed with `password_hash()` (bcrypt)
- Login credentials stored in `admin.text` (for reference only, use database)

---

## Responsive Breakpoints

### General
- **Desktop:** Default styles
- **Medium (≤1000px):** Logo and button size adjustments
- **Mobile (≤650px):** Hamburger menu, centered logo

### Homepage (home.css)
- **Tablet (750-1000px):** Reduced font sizes, adjusted sections
- **Small Tablet (481-750px):** Further size reductions
- **Mobile (≤480px):** Single column, minimal font sizes

### Vacatures Page (vacatures.css)
- **≤1024px:** Stacked layout, job cards full-width, min-height: auto
- **≤768px:** Smaller banner, reduced paddings
- **≤480px:** Optimized for mobile, increased touch targets

### Vacature Detail (vacature.php)
- **≤1024px:** Hero height: 100vh
- **≤768px:** Hero height: 100vh, reduced title sizes
- **≤480px:** Hero height: 90vh, mobile-optimized content

### Contact Page (contact.css)
- **≤1200px:** Form width adjustments
- **≤1024px:** Stacked layout
- **≤768px:** Reduced banner height
- **≤480px:** Mobile-optimized forms, larger inputs

---

## Design System

### Typography Scale
- **Hero Titles:** 5.5rem (Buroto-Wide)
- **Decorative Text:** 12rem+ (Better-Times)
- **Section Titles:** 3rem (Buroto-Wide)
- **Body Text:** 1.1rem (Buroto)
- **Buttons:** 1.5rem (Buroto)

### Spacing
- **Section Padding:** 5% horizontal, varies vertical
- **Card Padding:** 20-50px depending on size
- **Gaps:** 30-60px between elements

### Overlapping Sections
Many pages use negative margin-top (-5% to -15%) to create overlapping white sections on top of hero images with rounded corners (border-top-right-radius: 120px).

### Animations
Defined in `general.css`:
- `fadeIn` - Opacity and translateY
- `slideInLeft/Right` - Horizontal slide
- `scaleUp` - Scale from 0.8 to 1
- `bounce` - Vertical bounce
- `pulse` - Scale pulse

Applied with `animation: fadeIn 1s ease-out;` or similar.

---

## Common Tasks

### Adding a New Job
1. Login to `/admin/`
2. Navigate to "Jobs" → "Add New Job"
3. Fill in all required fields
4. Upload image or provide URL
5. Select job type (Full-time/Part-time/Stage)
6. Click "Add Job"

### Editing Job Types
Job types are stored as strings in the database. Ensure consistency:
- Use exactly: "Full-time", "Part-time", or "Stage"
- JavaScript filter in `vacatures.php` is case-sensitive
- Update both database and filter buttons if adding new types

### Modifying Styles
- **Global changes:** Edit `assets/css/general.css`
- **Page-specific:** Edit respective CSS file (home.css, vacatures.css, etc.)
- **Admin panel:** Edit `admin/css/admin-style.css`
- **Responsive:** Add/modify `@media` queries in respective files

### Database Connection
Edit `db_connect.php` for database credentials:
```php
$servername = "localhost";
$username = "u230752_live";
$password = "[password]";
$dbname = "u230752_live";
```

---

## Security Notes

⚠️ **Important Security Considerations:**

1. **Admin Credentials:** `admin.text` contains plaintext passwords - NEVER commit to public repositories
2. **File Uploads:** Validate file types and sizes in `send-form.php` and admin upload handlers
3. **SQL Injection:** Use prepared statements (already implemented with `mysqli`)
4. **XSS Prevention:** Use `htmlspecialchars()` when outputting user data (already implemented)
5. **Session Security:** Sessions expire after 30 minutes of inactivity, use HTTPS in production
6. **File Permissions:** Ensure upload directories are writable but not executable

### Brute Force Protection
The login system includes protection against brute force attacks:

- **Max Attempts:** 5 failed login attempts per IP address
- **Lockout Duration:** 15 minutes after exceeding max attempts
- **Attempt Window:** Attempts are counted within a 15-minute window
- **Rate Limiting:** 100-300ms random delay on each login attempt
- **Session Fixation Prevention:** Session ID is regenerated after successful login
- **Error Obfuscation:** Same error message for wrong password and non-existent user
- **Login Logging:** All attempts (successful and failed) are logged in `bureau_login_attempts`
- **Auto-cleanup:** Login attempts older than 24 hours are automatically deleted

### CSRF Protection
All admin forms are protected against Cross-Site Request Forgery attacks:

- **Token Generation:** Secure random tokens generated with `random_bytes()`
- **Token Validation:** All POST forms validate CSRF token before processing
- **Helper Functions:** `csrfField()` outputs hidden field, `validateCSRFToken()` validates
- **Location:** `admin/includes/csrf_protection.php`

To add CSRF protection to a new form:
```php
// In the form
<form method="POST">
    <?php csrfField(); ?>
    <!-- form fields -->
</form>

// In form processing
if(isset($_POST['submit'])) {
    if(!validateCSRFToken()) {
        $error = 'Security error';
    } else {
        // Process form
    }
}
```

### File Upload Security
The contact form (`send-form.php`) includes comprehensive file upload security:

- **File Size Limit:** Maximum 10MB
- **Allowed Extensions:** pdf, doc, docx, txt, rtf
- **MIME Type Validation:** Checks actual file content, not just extension
- **Secure Filenames:** Sanitized and prefixed with unique ID
- **Input Validation:** All form fields sanitized and validated

### Session Security
- **Timeout:** Sessions expire after 30 minutes of inactivity
- **Session Regeneration:** New session ID generated on login
- **IP Tracking:** Optional IP validation to prevent session hijacking (disabled by default)

### Activity Logging System
All admin actions are logged for audit purposes:

- **What's Logged:** Create, update, delete operations on jobs, submissions, and users
- **Login/Logout:** All authentication events tracked
- **Information Captured:** User ID, username, action, entity type/ID/name, IP address, timestamp
- **Dashboard Display:** Recent activity visible to all users, detailed login attempts for admins only

### Admin Dashboard Security Features
- Failed login attempts visible to administrators only (not teachers)
- Real-time count of failed attempts in last 24 hours
- Table showing last 20 login attempts with IP addresses
- Visual warning when failed attempts exceed threshold
- Activity timeline showing who did what and when

---

## Troubleshooting

### Images Not Showing
- Check path starts with `/assets/` (no prefix needed)
- Verify file exists in correct directory
- Check file permissions (should be readable)
- Inspect browser console for 404 errors

### Filter Not Working
- Verify job `type` field in database matches exactly: "Full-time", "Part-time", or "Stage"
- Check JavaScript console for errors
- Ensure `allJobs` JSON is properly encoded in `vacatures.php`

### Responsive Issues
- Test at specific breakpoints: 1024px, 768px, 480px
- Check for fixed widths that should be percentages
- Verify `box-sizing: border-box` is applied
- Look for `overflow-x: hidden` on containers

### Forms Not Submitting
- Check `send-form.php` for error messages
- Verify upload directory exists and is writable
- Check file size limits in PHP config
- Ensure database connection is active

---

## Development Workflow

1. **Local Development:**
   - Use XAMPP or similar local server
   - Database: Import from `admin/database-setup.sql`
   - All paths use `/vacatures/` prefix

2. **Testing:**
   - Test all responsive breakpoints
   - Verify file uploads work
   - Test form submissions
   - Check admin panel functionality
   - Test job filtering and search
   - Test login brute force protection (5 failed attempts = lockout)

3. **Deployment:**
   - Update `db_connect.php` with production credentials
   - Set proper file permissions
   - Test upload directories are writable
   - Verify `.htaccess` rules work on production server
   - Ensure `RewriteBase /vacatures/` is set in .htaccess
   - Create `bureau_login_attempts` table for security logging
   - Remove debug files if any

---

## Contact & Support

For questions about this codebase, refer to:
- Git commit history for recent changes
- Inline comments in complex code sections
- This documentation for architecture overview

**Last Updated:** December 2025
