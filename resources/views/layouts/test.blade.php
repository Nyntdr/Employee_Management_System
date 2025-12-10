<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        * {
            font-family: inherit;
        }
        
        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #2c3e50 0%, #1a2530 100%);
            padding-top: 80px;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }
        
        .sidebar a {
            display: block;
            color: #ecf0f1;
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-left: 4px solid #3498db;
        }
        
        .sidebar a.active {
            background-color: rgba(52, 152, 219, 0.2);
            border-left: 4px solid #3498db;
        }
        
        .sidebar .nav-item {
            margin-bottom: 5px;
        }
        
        /* Main Content Area */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            transition: margin-left 0.3s;
        }
        
        /* Top Navigation Bar */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: linear-gradient(90deg, #3498db 0%, #2980b9 100%);
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0 20px;
        }
        
        .top-navbar .navbar-brand {
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        .top-navbar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            transition: color 0.3s;
        }
        
        .top-navbar .nav-link:hover {
            color: white;
        }
        
        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .logout-btn:hover {
            background-color: #c0392b;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar.active {
                width: 250px;
            }
            
            .main-content.active {
                margin-left: 250px;
            }
            
            .menu-toggle {
                display: block !important;
            }
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Content Card */
        .content-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }
        
        /* Status Indicators */
        .status-done::after {
            content: " ✅";
            font-size: 0.9em;
        }
        
        .status-pending::after {
            content: " ⏳";
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <!-- Top Navigation Bar -->
    <nav class="top-navbar navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="menu-toggle me-3" id="menuToggle">
                <i class="bi bi-list"></i>
            </button>
            
            <a class="navbar-brand" href="#">
                <i class="bi bi-building me-2"></i>N:Company EMS
            </a>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person-circle me-1"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#">
                            <i class="bi bi-bell me-1"></i>Notification
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="px-3 py-4">
            <div class="text-center mb-4">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi bi-building text-white" style="font-size: 2rem;"></i>
                </div>
                <h5 class="text-white mt-3 mb-0">Admin Panel</h5>
                <small class="text-muted">Employee Management System</small>
            </div>
            
            <nav class="nav flex-column">
                <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs('dashboard')) active @endif">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a href="{{ route('employees.index') }}" class="nav-link @if(request()->routeIs('employees.*')) active @endif status-done">
                    <i class="bi bi-people me-2"></i>Employees
                </a>
                <a href="{{ route('departments.index') }}" class="nav-link @if(request()->routeIs('departments.*')) active @endif status-done">
                    <i class="bi bi-diagram-3 me-2"></i>Departments
                </a>
                <a href="{{ route('notices.index') }}" class="nav-link @if(request()->routeIs('notices.*')) active @endif status-done">
                    <i class="bi bi-megaphone me-2"></i>Notices
                </a>
                <a href="#" class="nav-link status-pending">
                    <i class="bi bi-pc-display me-2"></i>Assets
                </a>
                <a href="#" class="nav-link status-pending">
                    <i class="bi bi-cash-coin me-2"></i>Salaries
                </a>
                <a href="#" class="nav-link status-pending">
                    <i class="bi bi-calendar-check me-2"></i>Attendances
                </a>
                <a href="{{ route('events.index') }}" class="nav-link @if(request()->routeIs('events.*')) active @endif status-done">
                    <i class="bi bi-calendar-event me-2"></i>Events
                </a>
            </nav>
            
            <div class="mt-5 px-3">
                <div class="card bg-dark border-0">
                    <div class="card-body text-center">
                        <small class="text-muted">System Status</small>
                        <div class="d-flex justify-content-center align-items-center mt-2">
                            <div class="bg-success rounded-circle me-2" style="width: 10px; height: 10px;"></div>
                            <small class="text-white">All Systems Operational</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('page-title', 'Dashboard')</li>
                    </ol>
                </nav>
            </div>
            
            <!-- Main Content Area -->
            <div class="content-card">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle sidebar on mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuToggle.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                mainContent.classList.remove('active');
            }
        });
        
        // Add active class to current page link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>

</html>