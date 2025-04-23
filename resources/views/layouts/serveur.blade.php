<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- Use Laravel's locale helper --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="OctoPOS - Système de point de vente pour serveurs">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OctoPOS') }} | Interface Serveur</title> {{-- Use app name from config --}}

    <!-- Polices -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> {{-- Added integrity/crossorigin --}}

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Inline Tailwind configuration (from your original HTML)
        tailwind.config = {
            darkMode: 'class', // or 'media'
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#DBEAFE',
                            100: '#BFDBFE',
                            500: '#2563EB', // Blue-600
                            600: '#1D4ED8', // Blue-700
                            700: '#1E40AF', // Blue-800
                        },
                        secondary: {
                            50: '#D1FAE5',
                            100: '#A7F3D0',
                            500: '#10B981', // Emerald-500
                            600: '#059669', // Emerald-600
                            700: '#047857', // Emerald-700
                        },
                        danger: {
                            500: '#EF4444', // Red-500
                            600: '#DC2626', // Red-600
                            700: '#B91C1C', // Red-700
                        },
                        warning: {
                            500: '#F59E0B', // Amber-500
                            600: '#D97706', // Amber-600
                            700: '#B45309', // Amber-700
                        },
                    },
                    animation: {
                        'pulse-danger': 'pulse-danger 1.5s infinite ease-in-out',
                        'blink': 'blink 1.8s infinite ease-in-out',
                    },
                    keyframes: {
                        'pulse-danger': {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(239, 68, 68, 0.6)' }, // Red-500 with opacity
                            '70%': { boxShadow: '0 0 0 8px rgba(239, 68, 68, 0)' },
                        },
                        'blink': {
                            '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                            '50%': { opacity: '0.6', transform: 'scale(0.9)' },
                        },
                    },
                },
            },
            /
        }
    </script>

    
    @vite(['resources/css/serveur.css', 'resources/js/serveur.js'])

</head>
<body class="font-sans text-gray-800 bg-gray-50 antialiased touch-manipulation transition-colors duration-200 dark:bg-gray-900 dark:text-gray-100">

    
    @yield('content')

    

</body>
</html>