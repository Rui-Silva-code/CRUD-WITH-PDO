# PHP CRUD Authentication System with PDO 

> A backend-focused **learning project** built with PHP and MySQL, demonstrating secure authentication, CRUD operations, and basic role-based access control using PDO.


[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Status](https://img.shields.io/badge/Status-Learning%20Project-yellow)](https://github.com/Rui-Silva-code)

---

## About This Project

This is an **educational project** developed to practice and demonstrate practical skills in:
- Secure user authentication and session management
- CRUD (Create, Read, Update, Delete) operations
- Database security with PDO prepared statements
- Role-based access control (User vs Administrator)
- Input validation and output sanitization

**Note:** This project prioritizes learning and code clarity. While it implements security best practices, it is not intended for production use without further hardening.


---

## Features

### 🔐 Authentication & Security
- See the **Security Features** section below for detailed explanations.

### 👤 User Features
- Create personal account
- View and edit profile information
- Schedule appointments/consultations
- Edit appointments (with 3-day advance notice requirement)
- Cancel appointments
- View appointment history

### 👨‍💼 Administrator Features
- Full user management dashboard
- View all registered users
- Edit user profiles
- Delete users (with validation checks)
- Manage all appointments across the system
- Project tracking system
- View consultation statistics

---

## 🔐 Security Features

### What This Project Demonstrates

✅ **Password Security**
- Passwords hashed using `password_hash()` with `PASSWORD_DEFAULT`
- Never stores plain text passwords in database
- Secure verification with `password_verify()`

✅ **SQL Injection Prevention**
- All database queries use PDO prepared statements
- Parameters bound with proper type hints (`:parameter`)
- No direct string concatenation in SQL queries

✅ **Cross-Site Scripting (XSS) Protection**
- All user inputs sanitized before output
- `htmlspecialchars()` applied to user-generated content
- Prevents malicious script injection

✅ **Session Security**
- Proper session initialization and management
- Session variables validated before use
- Secure logout with session destruction

---

## Technology Stack

**Backend:**
- PHP 7.4+
- PDO (PHP Data Objects) for database abstraction
- MySQL 5.7+ with UTF-8 encoding

**Frontend:**
- HTML5 semantic markup
- CSS3 with gradient backgrounds and modern styling
- Vanilla JavaScript for client-side interactions

**Security Implementations:**
- `password_hash()` with `PASSWORD_DEFAULT` algorithm
- Prepared statements for all database queries
- Session management with proper initialization
- Input sanitization and output encoding

---

## 📁 Project Structure

```
crud-auth/
│
├── 📄 Core Files
│   ├── index.php                    # Main entry point / login page
│   ├── basedados.php                # Database connection (PDO configuration)
│   ├── logout.php                   # Session termination
│   └── homepage.php                 # Public homepage (Bootstrap demo)
│
├── 🔐 Authentication
│   ├── login.php                    # Alternative login page
│   ├── pagina_de_registro.html      # User registration form
│   ├── processa_registro.php        # Registration processing
│   ├── processa_login.php           # Login validation
│   └── atualiza_perfil.php          # Profile update handler
│
├── 👤 User Management
│   ├── perfil_utilizador.php        # User profile dashboard
│   ├── editar_perfil.php            # Edit user information
│   └── perfil_admin.php             # Administrator dashboard
│
├── 📅 Appointment System
│   ├── marcar_consulta.php          # Schedule new appointment
│   ├── editar_consulta.php          # Edit existing appointment
│   ├── excluir_consulta.php         # Delete appointment
│   ├── editar_consulta_admin.php    # Admin: edit any appointment
│   └── excluir_consulta_admin.php   # Admin: delete any appointment
│
├── 👥 Admin User Controls
│   ├── editar_perfil_admin.php      # Admin: edit user profile
│   └── excluir_utilizador_admin.php # Admin: delete user
│
├── 📊 Admin Project Management
│   ├── editar_projetos_admin.php    # Edit project information
│   └── excluir_projetos_admin.php   # Delete projects
│
├── 📂 Assets
│   ├── css/                         # Stylesheets
│   ├── imagens/                     # Image uploads (gitignored)
│   └── sql/                         # Database schema files
│       └── casopratico.sql          # Database structure and sample data
│
└── 📋 Configuration
    └── .gitignore                   # Protected files (credentials, uploads)
```

### 🗂️ File Organization Explained

**Core Files:** Application entry points and essential configuration

**Authentication:** All login, registration, and session management logic

**User Management:** Profile viewing and editing for both users and administrators

**Appointment System:** Complete CRUD operations for the consultation booking feature

**Admin Controls:** Elevated privilege operations for user and project management

**Assets:** Static resources and database schemas

---

## 🚀 Installation Guide

## ⚡ Quick Start (Local)

1. Clone the repository
2. Import the database schema
3. Configure `basedados.php`
4. Run using XAMPP or PHP built-in server


### Prerequisites

Ensure you have the following installed:
- **PHP 7.4+** with PDO extension enabled
- **MySQL 5.7+** or MariaDB equivalent
- **Apache** or **Nginx** web server
- Recommended: **XAMPP**, **MAMP**, or **WAMP** for local development

### Step 1: Clone Repository

```bash
git clone https://github.com/Rui-Silva-code/CRUD-Authentication-PHP.git
cd CRUD-Authentication-PHP
```

### Step 2: Database Setup

**2.1. Create Database**

```sql
CREATE DATABASE crud_auth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**2.2. Import Schema**

Using MySQL command line:
```bash
mysql -u root -p crud_auth < sql/casopratico.sql
```

Or import via **phpMyAdmin**:
1. Open phpMyAdmin
2. Select `crud_auth` database
3. Go to "Import" tab
4. Choose `sql/casopratico.sql`
5. Click "Go"

### Step 3: Configure Database Connection

Edit `basedados.php` with your local credentials:

```php
<?php
$servername = "localhost";
$username = "root";           // Your MySQL username
$password = "";               // Your MySQL password (empty for XAMPP default)
$dbname = "crud_auth";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
```

### Step 4: Set Folder Permissions

Ensure the images folder is writable:

```bash
# Linux/Mac
chmod 755 imagens/

# Windows (via folder properties)
Right-click imagens/ → Properties → Security → Edit → Allow "Write"
```

### Step 5: Start Application

**Option A: XAMPP/MAMP**
1. Move project to `htdocs/` or `www/` directory
2. Start Apache and MySQL services
3. Access: `http://localhost/CRUD-Authentication-PHP/`

**Option B: PHP Built-in Server**
```bash
php -S localhost:8000
```
Then access: `http://localhost:8000/`

---



## 📸 Screenshots

**Login Page**
![loginpage](https://github.com/user-attachments/assets/bc43ab26-9ba8-480f-8d4e-9283e0bb701b)

**User Dashboard**
![mainpage](https://github.com/user-attachments/assets/6a1c7176-b807-4992-9648-4056c9635449)

**Registration Page**
![registerpage](https://github.com/user-attachments/assets/cbf7ec53-3720-4dfe-a512-15a067ecbfc0)


---

## 🎓 What I Learned

Building this project provided hands-on experience with:

### Technical Skills
- **Database Design**: Creating normalized schemas with proper relationships
- **Security Best Practices**: Implementing authentication, input validation, and SQL injection prevention
- **PDO vs MySQLi**: Understanding the advantages of PDO for modern PHP development
- **Session Management**: Building secure authentication flows

### Problem-Solving
- **Migration Challenges**: Converting legacy MySQLi code to PDO prepared statements
- **Error Handling**: Implementing try-catch blocks for robust error management
- **Code Organization**: Structuring a multi-page PHP application logically

### Soft Skills
- **Documentation**: Writing clear README and code comments
- **Version Control**: Using Git for tracking changes and managing codebase
- **Self-Learning**: Debugging issues and researching solutions independently

This project helped me identify areas for improvement, particularly in application architecture
and code reuse, which I plan to address in future projects using MVC principles.


---

## 🚧 Known Limitations & Future Improvements

### Current Limitations
This is a **learning project** with some intentional simplifications:
- No email verification system
- Limited password requirements
- Basic error messages
- Single language (Portuguese) in some areas
- No password reset functionality
- No user profile pictures
- Limited input validation rules

### Possible Improvements

**Security Enhancements:**
- [ ] Implement CSRF token protection
- [ ] Add rate limiting for login attempts
- [ ] Strengthen password requirements
- [ ] Add account lockout after failed attempts
- [ ] Implement 2FA (Two-Factor Authentication)

**Features:**
- [ ] Email verification for new accounts
- [ ] Password reset via email
- [ ] User profile picture upload
- [ ] Email notifications for appointments
- [ ] Export user data functionality
- [ ] Activity logging system

**Code Quality:**
- [ ] Migrate to MVC architecture
- [ ] Add PHPUnit tests
- [ ] Implement autoloading (PSR-4)
- [ ] Use environment variables for configuration
- [ ] Add comprehensive error logging

**UI/UX:**
- [ ] Responsive mobile design
- [ ] Dark mode toggle
- [ ] Improved form validation feedback
- [ ] Dashboard charts and statistics
- [ ] Multi-language support (i18n)

---



## 📝 Notes

### For Recruiters & Employers
This project demonstrates:
- ✅ Understanding of web security fundamentals
- ✅ Ability to work with databases and SQL
- ✅ Clean, organized code structure
- ✅ Self-learning and problem-solving skills
- ✅ Awareness of security best practices
- ✅ Commitment to writing maintainable code
