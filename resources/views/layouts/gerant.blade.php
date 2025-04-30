{{-- resources/views/layouts/gerant.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OctoPOS - Tableau de bord gérant pour la supervision opérationnelle de restaurant">
    {{-- Important pour Laravel, notamment pour les requêtes AJAX si vous en faites --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Titre dynamique, avec une valeur par défaut --}}
    <title>@yield('title', 'OctoPOS Dashboard | Gérant')</title>

    {{-- Preconnects pour améliorer le temps de chargement des ressources externes --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    {{-- Tailwind CSS via CDN --}}
    {{-- Note : Pour une intégration plus poussée, vous pourriez installer Tailwind via npm --}}
    {{-- et le faire compiler par Vite avec PostCSS. Mais le CDN fonctionne aussi. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configuration de Tailwind (gardée ici car elle doit être définie avant le rendu)
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#0288D1',
                            dark: '#026da8',
                            light: 'rgba(2, 136, 209, 0.1)'
                        },
                        secondary: {
                            DEFAULT: '#4CAF50',
                            dark: '#2E7D32'
                        },
                        accent: '#FFC107',
                        danger: '#F44336',
                        success: '#4CAF50',
                        warning: '#FF9800',
                        info: '#2196F3',
                        dark: '#1E293B', // Couleur pour le mode sombre (background typique)
                        light: '#F8FAFC', // Couleur pour le mode clair (background typique)
                        gray: '#64748B', // Gris neutre
                        'border-color': '#E2E8F0', // Couleur de bordure par défaut
                        'card-bg': '#FFFFFF', // Fond des cartes en mode clair
                        background: '#F1F5F9' // Fond général en mode clair
                        // Assurez-vous que les couleurs dark: correspondent bien
                        // dark:bg-gray-900 -> devrait utiliser une couleur définie ici si besoin d'uniformité
                        // dark:bg-gray-800 -> idem
                        // dark:border-gray-700 -> idem
                    },
                    animation: {
                        'pulse-short': 'pulse 2s infinite'
                    }
                }
            }
        }
    </script>

    {{-- Font Awesome via CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">

    {{-- Google Fonts via CDN --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Autres Librairies JS via CDN --}}
    {{-- Celles-ci pourraient aussi être installées via npm et importées dans gerant.js si vous préférez tout gérer via Vite --}}
    {{-- Note: Charger dans le <head> peut ralentir légèrement le premier rendu. Si non critique, envisagez de les mettre avant la fin du <body> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/speech-synthesis-polyfill@0.1.0/dist/speech-synthesis-polyfill.min.js"></script>

    {{-- Inclusion des assets CSS et JS compilés par Vite pour ce layout spécifique --}}
    @vite(['resources/css/gerant.css', 'resources/js/gerant.js'])

</head>
<body class="bg-background text-gray-800 dark:bg-dark dark:text-gray-100 font-sans">

    {{-- Inclusion du partial pour la sidebar --}}
    @include('partials.gerants.sidebar')

    {{-- Inclusion du partial pour le header --}}
    @include('partials.gerants.header')

    {{-- Conteneur principal qui recevra le contenu spécifique de chaque page via @yield --}}
    {{-- Les classes ml-64 et pt-16 compensent la sidebar et le header fixes --}}
    <main id="main-content" class="ml-64 pt-16 transition-all">

        {{-- Injection du contenu de la section 'content' définie dans les vues enfants (ex: dashboard.blade.php) --}}
        @yield('content')

        {{-- Inclusion du partial pour le footer, placé à l'intérieur de <main> ou après selon le design souhaité --}}
        @include('partials.gerants.footer')

    </main>

    {{-- Zone pour injecter des scripts spécifiques à une vue enfant (si nécessaire) --}}
    {{-- Utile pour passer des données PHP à JavaScript, par exemple --}}
    @stack('scripts')

</body>
</html>