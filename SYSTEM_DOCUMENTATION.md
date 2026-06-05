# PlasticPollutions Web Application - System Documentation

## Project Overview

PlasticPollutions is a web application developed for Pentecost University's environmental action group. The application aims to reduce plastic waste, promote sustainable practices, and engage the community in environmental conservation efforts.

## System Architecture

### Folder Structure

```
bertina/
├── assets/
│   ├── css/
│   │   └── style.css          # Main stylesheet with responsive design
│   └── js/
│       └── main.js            # JavaScript for interactive features
├── pages/                    # Content pages
│   ├── campaigns.php         # Campaign details and impact
│   ├── contact.php           # Contact form and information
│   ├── developers.php        # Team profiles
│   ├── help.php              # Volunteer and donation options
│   ├── latest.php            # Blog-style news
│   ├── strategy.php          # Organization strategy and goals
│   └── what-to-do.php        # Information about plastic pollution
├── user/                     # User-specific pages
│   ├── dashboard.php          # User dashboard with profile, donations, activity
│   └── donate.php            # Donation form and history
├── uploads/                  # File upload directory
├── auth.php                  # Authentication and session management
├── database.php              # Database configuration
├── database.sql              # Database schema and seed data
├── index.php                 # Home page
├── login.php                 # Login page
├── logout.php                # Logout handler
├── register.php              # Registration page
├── PROJECT_REPORT.md         # 500-word project report
└── README.md                 # Project README
```

## Database Schema

### Tables

1. **users** - User accounts and profiles
   - id, visitor_id, first_name, last_name, email, password_hash, phone, address, is_active, created_at

2. **donations** - Donation records
   - id, user_id, amount, donation_type, payment_method, transaction_id, status, message, created_at

3. **petitions** - Environmental petitions
   - id, title, description, target_signatures, current_signatures, status, created_at

4. **petition_signatures** - Petition signatures
   - id, petition_id, user_id, signed_at

5. **campaigns** - Environmental campaigns
   - id, title, description, start_date, end_date, target_goal, impact_metrics, status, image_url

6. **news** - News articles
   - id, title, content, category, author, image_url, is_published, created_at

7. **contact_messages** - Contact form submissions
   - id, name, email, subject, message, created_at

8. **visitor_counter** - Website visitor tracking
   - id, ip_address, visit_date, unique_visits, total_visits

9. **user_activity** - User activity logging
   - id, user_id, action, details, created_at

10. **env_stats** - Environmental statistics for display
    - id, stat_name, stat_value, unit, description

## Core Components

### Authentication System (auth.php)

**Features:**
- Session management with 8-hour lifetime
- Login lockout mechanism (3 failed attempts = 3-minute lock)
- Password hashing using PHP's password_hash()
- Visitor ID generation (PU + 6 digits)
- Input sanitization and validation
- User activity logging

**Key Functions:**
- `getDB()` - Establishes PDO database connection
- `isLoggedIn()` - Checks if user is logged in
- `requireLogin()` - Redirects to login if not authenticated
- `currentUser()` - Returns current logged-in user data
- `generateVisitorId()` - Generates unique visitor IDs
- `checkLoginLockout()` - Checks if account is locked
- `recordLoginAttempt()` - Records login success/failure
- `logUserActivity()` - Logs user actions
- `trackVisitor()` - Tracks website visitors
- `getVisitorStats()` - Returns visitor statistics

### Security Features

1. **Password Security**
   - Passwords hashed using bcrypt (PASSWORD_DEFAULT)
   - Minimum 8 characters with uppercase, lowercase, and number requirements
   - Password change functionality in dashboard

2. **Login Lockout**
   - Tracks failed login attempts per email
   - Locks account for 3 minutes after 3 failed attempts
   - Prevents brute force attacks

3. **Input Validation**
   - Email validation using regex
   - Password strength validation
   - Input sanitization to prevent XSS
   - SQL injection prevention using prepared statements

4. **Session Management**
   - Secure session configuration
   - Session lifetime: 8 hours
   - Automatic session cleanup

### User Dashboard (user/dashboard.php)

**Features:**
- Profile management (name, email, phone, address)
- Password change functionality
- Donation history display
- Total donation statistics
- Recent activity log
- Link to donation page

**Sections:**
1. **Profile** - Update personal information
2. **Donations** - View donation history and totals
3. **Activity** - View recent account activity

### Donation System (user/donate.php)

**Features:**
- One-time and monthly donation options
- Multiple payment methods (Mobile Money, Bank Transfer, Card, Cash)
- Suggested donation amounts
- Donation history tracking
- Transaction ID generation

**Payment Methods:**
- Mobile Money (MTN/Vodafone/AirtelTigo)
- Bank Transfer
- Credit/Debit Card
- Cash

### Home Page (index.php)

**Features:**
- Responsive navigation with dropdown menus
- Sign-up modal with validation
- Image slider with environmental messages
- Animated environmental statistics counters
- Cookie notification with accept/learn more
- Simulated Twitter feed
- Social media links
- Visitor statistics display

**Interactive Elements:**
- Auto-advancing image slider (5-second intervals)
- Animated counters triggered on scroll
- Cookie notification with localStorage persistence
- Mobile-responsive navigation toggle

### Content Pages (pages/)

**what-to-do.php**
- Information about plastic types
- Environmental impact education
- Recycling methods explained
- Petition signing system
- Donation options

**contact.php**
- Contact form with validation
- Contact information display
- Social media links

**latest.php**
- Blog-style news display
- Article cards with images
- Category badges
- Author and date information

**strategy.php**
- Organization vision and goals
- Policies and approaches
- Long-term vision timeline

**campaigns.php**
- Campaign details
- Impact metrics
- Progress tracking
- Target goals

**help.php**
- Volunteer opportunities
- Donation information
- Lifestyle change suggestions
- Plastic-free pledge

**developers.php**
- Team member profiles
- Roles and responsibilities
- Project information

## How the System Works

### User Flow

1. **Registration**
   - User fills registration form
   - System validates input (email format, password strength)
   - Generates unique Visitor ID (PU + 6 digits)
   - Hashes password using bcrypt
   - Stores user in database
   - Logs registration activity
   - Redirects to login

2. **Login**
   - User enters email and password
   - System checks for lockout status
   - Verifies password hash
   - On success: Creates session, logs activity, redirects to dashboard
   - On failure: Records attempt, checks lockout threshold

3. **Dashboard Access**
   - User must be logged in
   - Displays profile information
   - Shows donation history
   - Shows recent activity
   - Allows profile updates and password changes

4. **Donation**
   - User selects amount and payment method
   - System generates transaction ID
   - Records donation in database
   - Updates donation statistics
   - Logs donation activity
   - Displays confirmation

### Visitor Tracking

1. **Tracking Mechanism**
   - Tracks IP addresses
   - Records visit date
   - Counts unique visitors
   - Counts total visits
   - Displays statistics on home page

2. **Implementation**
   - Uses visitor_counter table
   - Checks for existing IP on same day
   - Updates counts accordingly
   - Provides real-time statistics

### Petition System

1. **Petition Creation**
   - Admin creates petition with title, description, target signatures
   - Stored in petitions table

2. **Petition Signing**
   - Logged-in users can sign petitions
   - System checks for duplicate signatures
   - Updates current signature count
   - Logs signing activity
   - Displays progress bar

### Activity Logging

1. **Logged Actions**
   - Registration
   - Login/Logout
   - Profile updates
   - Password changes
   - Donations
   - Petition signings

2. **Storage**
   - Stored in user_activity table
   - Includes action type and details
   - Timestamped for chronological display
   - Displayed in user dashboard

## Frontend Technologies

### CSS (assets/css/style.css)

**Features:**
- CSS variables for theming
- Responsive design with media queries
- Mobile-first approach
- Flexbox and Grid layouts
- Smooth transitions and animations

**Key Components:**
- Navigation bar with dropdowns
- Hero section with slider
- Statistics cards
- Forms and inputs
- Tables and badges
- Modals and alerts
- Dashboard layout

### JavaScript (assets/js/main.js)

**Features:**
- Cookie notification management
- Navigation toggle for mobile
- Image slider with auto-advance
- Sign-up modal control
- Animated counters with intersection observer
- Smooth scroll for anchor links
- Dropdown menu handling

## Configuration

### Database Configuration (database.php)

**Settings:**
- DB_HOST: localhost
- DB_NAME: plasticpollutions
- DB_USER: root
- DB_PASS: (empty by default)
- BASE_URL: http://localhost/bertina
- APP_NAME: PlasticPollutions
- Session lifetime: 8 hours
- Upload settings: 5MB max size

## Security Best Practices Implemented

1. **SQL Injection Prevention**
   - All database queries use prepared statements
   - PDO with parameter binding

2. **XSS Prevention**
   - Output escaping using e() function
   - Input sanitization

3. **CSRF Protection**
   - Session-based authentication
   - Form validation

4. **Password Security**
   - Bcrypt hashing
   - Password strength requirements
   - Secure password change process

5. **Session Security**
   - Secure session configuration
   - Automatic session timeout
   - Activity logging

## Deployment Instructions

1. **Database Setup**
   - Import database.sql into MySQL
   - Configure database.php with credentials
   - Ensure uploads directory exists and is writable

2. **Web Server Configuration**
   - Place files in web root (e.g., htdocs/bertina)
   - Ensure PHP 7.4+ is installed
   - Enable PDO MySQL extension

3. **Access**
   - Open browser to http://localhost/bertina
   - Register new account or use default admin
   - Default admin: admin@plasticpollutions.org / Admin@1234

## Maintenance

### Regular Tasks
- Monitor visitor statistics
- Review user activity logs
- Update environmental statistics
- Manage petitions and campaigns
- Process donations (if manual verification needed)

### Backup Recommendations
- Regular database backups
- File system backups
- User activity log archival

## Future Enhancements

1. **Payment Integration**
   - Integrate actual payment gateways (PayPal, Stripe)
   - Mobile money API integration

2. **Email Notifications**
   - Email verification for registration
   - Donation receipts
   - Activity notifications

3. **Admin Panel**
   - Content management system
   - User management
   - Analytics dashboard

4. **Mobile App**
   - React Native mobile application
   - Push notifications
   - Offline functionality

## Contact Information

- **Project:** PlasticPollutions
- **Institution:** Pentecost University
- **Faculty:** Engineering, Science and Computing
- **Course:** PUIS304 - Plastic Pollutions
- **Level:** Level 300
- **Academic Year:** 2025/2026
