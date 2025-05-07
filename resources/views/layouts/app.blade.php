<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OctoPOS - Système de Point de Vente moderne et efficace pour restaurants">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS -->
    <title>OctoPOS - Système de Point de Vente pour Restaurants</title>

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons - Using a minified version -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Google Fonts - Optimized import -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Leaflet CSS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Leaflet JS for Map - Defer loading to improve initial page load -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="" defer></script>

    <!-- Custom CSS -->
    @vite('resources/css/style.css')
</head>
<body class="bg-pattern">
    <!-- Navigation Bar -->
    @include('partials.navigation')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Script pour éviter les déconnexions multiples -->
    <script>
        function logoutUser(formId) {
            // Désactiver tous les boutons de déconnexion
            document.querySelectorAll('.logout-link').forEach(link => {
                link.style.pointerEvents = 'none';
                link.parentElement.classList.add('opacity-50', 'cursor-not-allowed');
                link.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Déconnexion...';
            });
            
            // Soumettre le formulaire de déconnexion
            document.getElementById(formId).submit();
            
            // Empêcher la navigation vers d'autres pages pendant la déconnexion
            window.onbeforeunload = function() {
                return "Déconnexion en cours, veuillez patienter...";
            };
            
            // Désactiver temporairement les autres liens de la page
            document.querySelectorAll('a:not(.logout-link)').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            });
            
            return false;
        }
    </script>

    <!-- Custom JavaScript -->
    @vite('resources/js/script.js')
</body>
</html>