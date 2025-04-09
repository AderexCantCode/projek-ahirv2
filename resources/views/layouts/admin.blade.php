<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Game Top-up') }} - Admin</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>
<body class="font-poppins antialiased bg-gray-100">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-indigo-800 shadow-md transition duration-150 ease-in-out z-30" id="sidebar">
            <div class="flex items-center justify-center h-16 bg-indigo-900">
                <div class="text-white font-bold text-xl">Admin Panel</div>
            </div>
            <nav class="mt-5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-6 text-white hover:bg-indigo-700 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="mx-3">Dashboard</span>
                </a>
                <a href="{{ route('admin.games.index') }}" class="flex items-center mt-1 py-3 px-6 text-white hover:bg-indigo-700 {{ request()->routeIs('admin.games*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-gamepad w-5"></i>
                    <span class="mx-3">Games</span>
                </a>
                <a href="{{ route('home') }}" class="flex items-center mt-1 py-3 px-6 text-white hover:bg-indigo-700">
                    <i class="fas fa-home w-5"></i>
                    <span class="mx-3">Back to Site</span>
                </a>
                <a href="#" class="flex items-center mt-1 py-3 px-6 text-white hover:bg-indigo-700" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span class="mx-3">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </div>

        <!-- Content -->
        <div class="ml-64">
            <!-- Top navigation -->
            <div class="bg-white h-16 shadow-sm flex items-center justify-between px-6">
                <div class="flex items-center">
                    <button id="sidebar-toggle" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 mr-2">{{ Auth::user()->name }}</span>
                </div>
            </div>

            <!-- Page content -->
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-ml-64');
                });
            }
        });
    </script>
</body>
</html>