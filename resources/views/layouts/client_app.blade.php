<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- Use Laravel localization --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OctoPOS - Tableau de bord client pour la gestion des réservations et du profil">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- CSRF Token for forms/AJAX --}}

    <title>@yield('title', 'OctoPOS | Espace Client')</title> {{-- Dynamic Title --}}

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <!-- Tailwind CSS (via CDN for simplicity, replace with compiled CSS if using Mix/Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- App Specific CSS -->
    
    @vite('resources/css/client-dashboard.css')

    @stack('styles') {{-- For page-specific CSS --}}

</head>
<body>
    <div class="flex h-screen overflow-hidden">

        @include('partials.client_sidebar') {{-- Include Sidebar Partial --}}

        <!-- Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">

            @include('partials.client_header') {{-- Include Header Partial --}}

            <!-- Main Content Scrollable Area -->
            <main class="main-content" id="main-content">
                 @yield('content') {{-- Page specific content goes here --}}
            </main>

        </div> <!-- End Content Area -->
    </div> <!-- End Flex Container -->

    <!-- App Specific JS -->
    
    @vite('resources/js/client-dashboard.js')

    @stack('scripts') {{-- For page-specific JS --}}
</body>
</html>