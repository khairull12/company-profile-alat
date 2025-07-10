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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-4">
                <h1 class="text-xl font-bold">Admin Panel</h1>
                <p class="text-sm text-gray-400">{{ Auth::user()->name }}</p>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.equipment.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.equipment.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tools mr-3"></i>
                    Alat Berat
                </a>
                
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.bookings.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Booking
                </a>
                
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-cog mr-3"></i>
                    Pengaturan
                </a>
                
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.reports.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Laporan
                </a>
                
                <hr class="my-4 border-gray-600">
                
                <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-home mr-3"></i>
                    Kembali ke Website
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>
            </header>
            
            <!-- Content -->
            <div class="p-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
