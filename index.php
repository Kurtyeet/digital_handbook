<?php
/**
 * Main Index File - Employee Leave Management Portal
 * Handles routing and session management
 */

session_start();

// Load configuration
require_once 'config/config.php';
require_once 'includes/User.php';
require_once 'includes/LeaveRequest.php';

// Simple routing
$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? 'index';

// Check if user is logged in for protected pages
$protectedPages = ['dashboard', 'leave', 'profile', 'admin', 'reports'];
if (in_array($page, $protectedPages) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

// Role-based access control
function checkRole($requiredRole) {
    if (!isset($_SESSION['user_role'])) {
        return false;
    }
    
    $roleHierarchy = [
        'employee' => 1,
        'supervisor' => 2,
        'hr_admin' => 3,
        'system_admin' => 4
    ];
    
    $userLevel = $roleHierarchy[$_SESSION['user_role']] ?? 0;
    $requiredLevel = $roleHierarchy[$requiredRole] ?? 5;
    
    return $userLevel >= $requiredLevel;
}

// Handle CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Include header
include 'public/header.php';

// Route to appropriate page
switch ($page) {
    case 'login':
        include 'modules/auth/login.php';
        break;
        
    case 'logout':
        include 'modules/auth/logout.php';
        break;
        
    case 'dashboard':
        include 'modules/dashboard/index.php';
        break;
        
    case 'leave':
        switch ($action) {
            case 'apply':
                include 'modules/leave/apply.php';
                break;
            case 'history':
                include 'modules/leave/history.php';
                break;
            case 'balance':
                include 'modules/leave/balance.php';
                break;
            case 'approve':
                if (checkRole('supervisor')) {
                    include 'modules/leave/approve.php';
                } else {
                    include 'public/access_denied.php';
                }
                break;
            default:
                include 'modules/leave/index.php';
        }
        break;
        
    case 'profile':
        include 'modules/profile/index.php';
        break;
        
    case 'admin':
        if (checkRole('hr_admin')) {
            switch ($action) {
                case 'users':
                    include 'modules/admin/users.php';
                    break;
                case 'leave_types':
                    include 'modules/admin/leave_types.php';
                    break;
                case 'holidays':
                    include 'modules/admin/holidays.php';
                    break;
                case 'settings':
                    if (checkRole('system_admin')) {
                        include 'modules/admin/settings.php';
                    } else {
                        include 'public/access_denied.php';
                    }
                    break;
                default:
                    include 'modules/admin/index.php';
            }
        } else {
            include 'public/access_denied.php';
        }
        break;
        
    case 'reports':
        if (checkRole('supervisor')) {
            include 'modules/reports/index.php';
        } else {
            include 'public/access_denied.php';
        }
        break;
        
    case 'calendar':
        include 'modules/calendar/index.php';
        break;
        
    default:
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=dashboard');
        } else {
            header('Location: index.php?page=login');
        }
        exit;
}

// Include footer
include 'public/footer.php';
?>