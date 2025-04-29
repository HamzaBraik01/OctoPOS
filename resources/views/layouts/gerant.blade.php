<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- Utilise la langue de l'app Laravel --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OctoPOS - Tableau de bord gérant pour la supervision opérationnelle de restaurant">
    {{-- Le titre peut être dynamique --}}
    <title>{{ $title ?? 'OctoPOS Dashboard | Gérant' }}</title>

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <!-- Tailwind CSS (via CDN ou via Vite/Mix) -->
    {{-- Option 1: CDN (simple) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Option 2: Vite (recommandé pour prod) --}}
    {{-- @vite('resources/css/app.css') --}} {{-- Assurez-vous que Tailwind est configuré dans votre projet --}}

    <!-- Votre CSS spécifique au gérant (via Vite/Mix ou asset()) -->
    {{-- Option 1: asset() (nécessite que le fichier soit dans /public/css) --}}
     <link rel="stylesheet" href="{{ asset('css/gerant.css') }}">
    {{-- Option 2: Vite (recommandé) --}}
    {{-- @vite('resources/css/gerant.css') --}}

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Permet d'ajouter des styles spécifiques à une page --}}
    @stack('styles')

</head>
<body class="antialiased"> {{-- Ajout de antialiased pour un meilleur rendu des polices --}}

    <!-- Sidebar Navigation -->
    @include('partials.gerants.sidebar')

    <!-- Top Header -->
    @include('partials.gerants.header')

    <!-- Main Dashboard Content -->
    <main class="main-content" id="main-content">
        @yield('content') {{-- C'est ici que le contenu spécifique de la page sera injecté --}}

        <!-- Footer -->
        @include('partials.gerants.footer')
    </main>

    <!-- Scripts -->
    <!-- Librairies JS externes (Chart.js, FullCalendar, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    {{-- Speech Synthesis Polyfill (si vraiment nécessaire) --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/speech-synthesis-polyfill@0.1.0/dist/speech-synthesis-polyfill.min.js"></script> --}}


    <!-- Votre JS spécifique au gérant (via Vite/Mix ou asset()) -->
    {{-- Option 1: asset() (nécessite que le fichier soit dans /public/js) --}}
    <script src="{{ asset('js/gerant.js') }}" defer></script> {{-- defer est important --}}
    {{-- Option 2: Vite (recommandé) --}}
    {{-- @vite('resources/js/gerant.js') --}}

    {{-- Permet d'ajouter des scripts spécifiques à une page --}}
    @stack('scripts')

</body>
</html>