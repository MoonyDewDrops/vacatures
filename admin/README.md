# 🏢 Bureau Jobs CMS - Setup Guide

## 📋 Overview
A custom Content Management System (CMS) for managing job vacancies and form submissions. No WordPress needed!

---

## 🚀 Features

### ✅ Job Management
- Create, Edit, Delete job vacancies
- Add job details (title, location, type, salary, description, requirements)
- Upload job images
- View all jobs in organized table

### ✅ Form Submissions
- View all contact form submissions
- Download uploaded files (resumes, portfolios)
- Delete old submissions
- Email integration (click to respond)

### ✅ Secure Login
- Password hashing with PHP's `password_hash()`
- Session-based authentication
- Protected admin pages

### ✅ Dashboard
- Overview statistics
- Recent submissions
- Quick access to all features

---

## 📦 Installation Steps

### Step 1: Database Setup

1. Open **phpMyAdmin**
2. Select your database
3. Go to **SQL** tab
4. Copy and paste the content from `admin/database-setup.sql`
5. Click **Go** to execute

This will create:
- `admin_users` table (for login)
- `jobs` table (for vacancies)
- Add `bestand_pad` column to `bureau_vacatures` (if needed)
- Create default admin user

### Step 2: Default Login Credentials

**Username:** `admin`  
**Password:** `admin123`

⚠️ **IMPORTANT:** Change this password after first login!

### Step 3: Access the CMS

Navigate to: `http://localhost/bureau_jobs/admin/login.php`

Simple login page with clean design - no fancy animations, just functional.

---

## 🔐 Creating New Admin Users

### Using the Admin Panel (Recommended)

1. Login as an existing admin
2. Go to "Gebruikers" (Users) in the sidebar
3. Click "Nieuwe Gebruiker" (New User)
4. Fill in username and password
5. Click "Toevoegen" (Add)

### Using SQL Directly

To create an admin user with password "admin123":
```sql
INSERT INTO bureau_admin (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
```

Note: This hash is for password "admin123". Change the password after first login!

---

## 📁 File Structure

```
admin/
├── login.php              # Login page
├── dashboard.php          # Main dashboard
├── jobs.php               # View all jobs
├── job-add.php           # Add new job
├── job-edit.php          # Edit existing job
├── submissions.php        # View form submissions
├── submission-view.php    # View single submission
├── users.php             # View all admin users
├── user-add.php          # Add new admin user
├── user-edit.php         # Edit admin user
├── logout.php            # Logout handler
├── auth_check.php        # Authentication guard
├── database-setup.sql    # Database setup script with sample jobs
├── css/
│   └── admin-style.css   # CMS styling
└── includes/
    ├── header.php        # Header component
    └── sidebar.php       # Sidebar navigation
```

---

## 🎨 Customization

### Change Colors

Edit `admin/css/admin-style.css`:

```css
:root {
    --primary: #ff8f1c;        /* Your brand color */
    --primary-dark: #e67e22;   /* Darker shade */
    --success: #28a745;        /* Success messages */
    --danger: #dc3545;         /* Delete buttons */
    --dark: #2c3e50;          /* Dark backgrounds */
}
```

### Modify Job Fields

If your `jobs` table has different column names:

1. Update `job-add.php` - form fields and INSERT query
2. Update `job-edit.php` - form fields and UPDATE query
3. Update `jobs.php` - table columns display

---

## 🔧 Database Schema

### bureau_admin Table
```sql
id          INT PRIMARY KEY AUTO_INCREMENT
username    VARCHAR(255)
password    VARCHAR(255)  -- Hashed with password_hash()
```

### jobs Table
```sql
id            INT PRIMARY KEY AUTO_INCREMENT
title         VARCHAR(255)
location      VARCHAR(100)
type          VARCHAR(50)  -- Fulltime, Parttime, etc.
description   TEXT
requirements  TEXT
salary        VARCHAR(100)
image         VARCHAR(255)
created_at    TIMESTAMP
updated_at    TIMESTAMP
```

### bureau_vacatures Table (Form Submissions)
```sql
id            INT PRIMARY KEY AUTO_INCREMENT
datum         TIMESTAMP
naam          VARCHAR(255)
email         VARCHAR(255)
vacature      VARCHAR(255)
descriptie    TEXT
bestand_pad   VARCHAR(255)  -- File upload path
```

---

## 🛡️ Security Features

✅ **Password Hashing** - Uses PHP's `password_hash()` with bcrypt  
✅ **Session Management** - Secure session-based authentication  
✅ **SQL Injection Protection** - Prepared statements throughout  
✅ **XSS Protection** - `htmlspecialchars()` on all outputs  
✅ **Authentication Guards** - All admin pages check login status  

---

## 📝 Usage Guide

### Adding a New Job

1. Login to CMS
2. Click **Vacatures** in sidebar
3. Click **+ Nieuwe Vacature**
4. Fill in all required fields
5. Click **Vacature Toevoegen**

### Viewing Form Submissions

1. Click **Inzendingen** in sidebar
2. View all submissions in table
3. Click **Bekijk** to see full details
4. Click **Download** to get uploaded files
5. Click **Beantwoorden** to send email

### Managing Jobs

1. Go to **Vacatures**
2. Click **Bewerk** to edit a job
3. Click **Verwijder** to delete (with confirmation)

---

## 🌐 Integration with Your Website

Your website should now fetch jobs from the `jobs` table instead of WordPress.

### Example: Get Jobs for Homepage

```php
<?php
include 'db_connect.php';

// Get all active jobs
$jobs = $conn->query("SELECT * FROM jobs ORDER BY created_at DESC LIMIT 10");

while($job = $jobs->fetch_assoc()) {
    echo '<div class="job-card">';
    echo '<h3>' . htmlspecialchars($job['title']) . '</h3>';
    echo '<p>' . htmlspecialchars($job['location']) . '</p>';
    echo '</div>';
}
?>
```

---

## ⚠️ Troubleshooting

### Can't Login?
- Check database connection in `db_connect.php`
- Verify `admin_users` table exists
- Confirm you're using username: `admin`, password: `admin123`

### "Headers already sent" error?
- Remove any whitespace before `<?php` in auth_check.php
- Check for `echo` statements before `header()` calls

### Jobs not showing?
- Verify `jobs` table exists and has data
- Check column names match your code
- Look at browser console for JavaScript errors

### File uploads not working?
- Check `assets/uploads/` folder exists
- Verify folder has write permissions (777 on Linux)
- Check `php.ini` upload_max_filesize setting

---

## 📞 Next Steps

1. ✅ Run `database-setup.sql` in phpMyAdmin
2. ✅ Login with default credentials
3. ✅ Create your first job
4. ✅ Test form submission
5. ✅ Change admin password
6. ✅ Update your website to use new `jobs` table

---

## 🎉 You're Done!

Your custom CMS is ready to use. No more WordPress! 

**Access:** `http://localhost/bureau_jobs/admin/login.php`

---

**Built with ❤️ for Bureau Jobs**
