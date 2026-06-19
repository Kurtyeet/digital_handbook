# Employee Leave Management Portal

A comprehensive web-based leave management system for staff and faculty built with PHP.

## Features

### Core Features
- User authentication and role-based access control
- Leave application submission and management
- Leave approval workflow
- Leave balance tracking
- Calendar integration
- Email notifications
- Reporting and analytics
- Mobile-responsive design

### User Roles
- **Employee**: Submit leave requests, view leave history, check balances
- **Manager**: Approve/reject leave requests, view team calendars
- **HR Admin**: Manage all leaves, configure leave types, generate reports
- **System Admin**: User management, system configuration

## Technology Stack

- **Backend**: PHP 8.1+
- **Database**: MySQL 8.0+
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Additional**: jQuery, Chart.js, FullCalendar.js

## Installation

1. Clone the repository
2. Configure database settings in `config/database.php`
3. Import the database schema from `database/schema.sql`
4. Set up web server (Apache/Nginx)
5. Configure email settings for notifications

## Directory Structure

```
employee-leave-portal/
├── assets/              # CSS, JS, images
├── config/              # Configuration files
├── database/            # Database schema and migrations
├── includes/            # Common PHP includes
├── modules/             # Feature modules
├── public/              # Public web root
├── uploads/             # File uploads
└── vendor/              # Third-party libraries
```

## Security Features

- Password hashing with bcrypt
- CSRF protection
- SQL injection prevention
- XSS protection
- Session management
- Input validation and sanitization

## Improvements and Recommendations

See the detailed improvement suggestions in the documentation.