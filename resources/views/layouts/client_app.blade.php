<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- Use Laravel localization --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OctoPOS - Tableau de bord client pour la gestion des réservations et du profil">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- CSRF Token for forms/AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <!-- Custom Modal Alert Style -->
    <style>
        .custom-alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .custom-alert-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .custom-alert {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 400px;
            padding: 1.5rem;
            transform: translateY(-20px);
            transition: transform 0.3s;
        }
        
        .custom-alert-overlay.active .custom-alert {
            transform: translateY(0);
        }
        
        .custom-alert-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ffebee;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
        }
        
        .custom-alert-icon i {
            color: #d32f2f;
            font-size: 1.5rem;
        }
        
        .custom-alert-title {
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        
        .custom-alert-message {
            text-align: center;
            color: #666;
            margin-bottom: 1.5rem;
        }
        
        .custom-alert-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .custom-alert-btn {
            flex: 1;
            padding: 0.5rem;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            text-align: center;
        }
        
        .custom-alert-btn-cancel {
            background-color: #f5f5f5;
            color: #333;
        }
        
        .custom-alert-btn-cancel:hover {
            background-color: #e0e0e0;
        }
        
        .custom-alert-btn-confirm {
            background-color: #d32f2f;
            color: white;
        }
        
        .custom-alert-btn-confirm:hover {
            background-color: #b71c1c;
        }
        
        .custom-alert-success {
            background-color: rgba(76, 175, 80, 0.9);
            color: white;
            padding: 1rem;
            border-radius: 4px;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            min-width: 300px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            animation: slideUp 0.3s, fadeOut 0.5s 2.5s;
            animation-fill-mode: forwards;
        }
        
        @keyframes slideUp {
            from { transform: translate(-50%, 20px); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; visibility: hidden; }
        }
    </style>

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
                 @yield('content')
            </main>

        </div> <!-- End Content Area -->
    </div> <!-- End Flex Container -->

    <!-- Custom Alert Modal -->
    <div id="custom-alert-overlay" class="custom-alert-overlay">
        <div class="custom-alert">
            <div class="custom-alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="custom-alert-title">Êtes-vous sûr?</div>
            <div class="custom-alert-message">Voulez-vous vraiment annuler cette réservation?</div>
            <div class="custom-alert-buttons">
                <div class="custom-alert-btn custom-alert-btn-cancel" onclick="closeCustomAlert()">Non, conserver</div>
                <div id="custom-alert-confirm-btn" class="custom-alert-btn custom-alert-btn-confirm">Oui, annuler!</div>
            </div>
        </div>
    </div>

    <!-- App Specific JS -->
    @vite('resources/js/client-dashboard.js')

    @stack('scripts') {{-- For page-specific JS --}}
</body>
</html>