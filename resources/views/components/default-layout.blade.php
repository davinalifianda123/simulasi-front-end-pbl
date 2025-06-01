<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gudangku</title>
    <!-- Fonts & Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="shortcut icon" href="{{ asset('images/logo-gudangku.svg') }}" type="image/x-icon">
</head>
<body class="text-[#1b1b18] bg-gray-50">
    <!-- Main Layout -->
    <div class="flex h-screen overflow-hidden">
    <!-- Sidebar selain supervisor-->
        <aside class="hidden md:flex md:flex-col md:w-64">            
            <!-- Sidebar content -->
            <div class="flex-1 overflow-y-auto py-4">
                @if ($namaRole == 'SuperAdmin')
                    <x-headers.header-super-admin />    
                @elseif ($namaRole == 'Supervisor')
                    <x-headers.header-supervisor />    
                @else
                    <x-headers.header-admin />    
                @endif
            </div>          
        </aside>

        <!-- Main Content Area - Flexible width, full height -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <!-- Top Navbar -->
            <x-navbar :nama-user="$namaUser" :nama-role="$namaRole"/>

            <!-- Mobile Sidebar Modal (hidden by default) -->
            <div id="mobile-sidebar" class="fixed inset-0 flex z-40 md:hidden transform -translate-x-full transition-transform duration-300 ease-in-out">
                <div class="fixed inset-0" id="sidebar-overlay"></div>
                
                <div class="relative flex flex-col w-72 bg-gray-50 shadow-2xl pt-5">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button id="close-sidebar-button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex-1 h-0 overflow-y-auto">

                        <div class="pt-4">
                            @if ($namaRole == 'SuperAdmin')
                                <x-headers.header-super-admin />    
                            @elseif ($namaRole == 'Supervisor')
                                <x-headers.header-supervisor />    
                            @else
                                <x-headers.header-admin />    
                            @endif
                        </div>
                    </div>
                    
                </div>
                
                <div class="flex-shrink-0 w-14" aria-hidden="true">
                    <!-- Force sidebar to shrink to fit close icon -->
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script>
        // JavaScript for mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const closeSidebarButton = document.getElementById('close-sidebar-button');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            
            // Function to open mobile sidebar
            function openMobileSidebar() {
                mobileSidebar.classList.remove('-translate-x-full');
            }
            
            // Function to close mobile sidebar
            function closeMobileSidebar() {
                mobileSidebar.classList.add('-translate-x-full');
            }
            
            // Event listeners
            mobileMenuButton.addEventListener('click', openMobileSidebar);
            closeSidebarButton.addEventListener('click', closeMobileSidebar);
            sidebarOverlay.addEventListener('click', closeMobileSidebar);
        });
    </script>
</body>
</html>