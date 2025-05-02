<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OctoPOS - Tableau de bord gérant pour la supervision opérationnelle de restaurant">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OctoPOS Dashboard | Gérant')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
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
                        dark: '#1E293B',
                        light: '#F8FAFC',
                        gray: '#64748B',
                        'border-color': '#E2E8F0',
                        'card-bg': '#FFFFFF',
                        background: '#F1F5F9'
                    },
                    animation: {
                        'pulse-short': 'pulse 2s infinite'
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/speech-synthesis-polyfill@0.1.0/dist/speech-synthesis-polyfill.min.js"></script>

    @vite(['resources/css/gerant.css', 'resources/js/gerant.js'])

</head>
<body class="bg-background text-gray-800 dark:bg-dark dark:text-gray-100 font-sans">

    @include('partials.gerants.sidebar')

    @include('partials.gerants.header')

    <main id="main-content" class="ml-64 pt-16 transition-all">

        @yield('content')

        @include('partials.gerants.footer')

    </main>

    @stack('scripts')

</body>
</html>