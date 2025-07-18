<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --admin-primary: #3b82f6;
            --admin-secondary: #6366f1;
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
            --admin-danger: #ef4444;
            --admin-dark: #1f2937;
            --admin-light: #f8fafc;
            --sidebar-width: 280px;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--admin-light);
        }
        
        .admin-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--admin-dark) 0%, #374151 100%);
            min-height: 100vh;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        
        .admin-sidebar .brand {
            background: rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
        }
        
        .admin-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .admin-sidebar .nav-link.active {
            background: var(--admin-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .admin-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-bottom: 1px solid #e5e7eb;
        }
        
        .admin-content {
            padding: 30px;
            background: var(--admin-light);
        }
        
        .card {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--admin-primary);
            border-color: var(--admin-primary);
        }
        
        .btn-primary:hover {
            background: #2563eb;
            border-color: #2563eb;
            transform: translateY(-1px);
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            padding: 16px 20px;
        }
        
        .page-title {
            color: var(--admin-dark);
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .sidebar-toggle {
            display: none;
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                position: fixed;
                left: -280px;
                z-index: 1000;
                transition: left 0.3s ease;
            }
            
            .admin-sidebar.show {
                left: 0;
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .admin-content {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="admin-sidebar position-fixed">
            <div class="brand p-4">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-cogs fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h4 class="text-white mb-0">Admin Panel</h4>
                        <small class="text-light opacity-75">{{ Auth::user()->name }}</small>
                    </div>
                </div>
            </div>
            
            <div class="nav flex-column mt-3">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.equipment.index') }}" class="nav-link {{ request()->routeIs('admin.equipment.*') ? 'active' : '' }}">
                    <i class="fas fa-tools me-3"></i>
                    Manajemen Alat Berat
                </a>
                
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog me-3"></i>
                    Pengaturan Website
                </a>
                
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar me-3"></i>
                    Laporan & Analitik
                </a>
                
                <hr class="my-3 mx-3 border-light opacity-25">
                
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt me-3"></i>
                    Lihat Website
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                        <i class="fas fa-sign-out-alt me-3"></i>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
        
        <!-- Main Content -->
        <main class="admin-main w-100">
            <!-- Header -->
            <header class="admin-header">
                <div class="d-flex justify-content-between align-items-center px-4 py-3">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link sidebar-toggle d-md-none me-3" onclick="toggleSidebar()">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="page-title">
                            @yield('page-title', 'Dashboard')
                        </h1>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-3">Selamat datang, {{ Auth::user()->name }}</span>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>
                                Akun
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <div class="admin-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.admin-sidebar').classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.admin-sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 768 && sidebar.classList.contains('show')) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
