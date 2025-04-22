<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="OctoPOS - Système de point de vente pour serveurs">
    <title>OctoPOS | Interface Serveur</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    },
                    colors: {
                        primary: { 50: '#DBEAFE', 100: '#BFDBFE', 500: '#2563EB', 600: '#1D4ED8', 700: '#1E40AF' },
                        secondary: { 50: '#D1FAE5', 100: '#A7F3D0', 500: '#10B981', 600: '#059669', 700: '#047857' },
                        danger: { 500: '#EF4444', 600: '#DC2626', 700: '#B91C1C' },
                        warning: { 500: '#F59E0B', 600: '#D97706', 700: '#B45309' },
                    },
                    animation: {
                        'pulse-danger': 'pulse-danger 1.5s infinite ease-in-out',
                        'blink': 'blink 1.8s infinite ease-in-out',
                    },
                    keyframes: {
                        'pulse-danger': {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(239, 68, 68, 0.6)' },
                            '70%': { boxShadow: '0 0 0 8px rgba(239, 68, 68, 0)' },
                        },
                        'blink': {
                            '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                            '50%': { opacity: '0.6', transform: 'scale(0.9)' },
                        },
                    },
                },
            },
        }
    </script>

    
    @vite(['resources/css/serveur.css', 'resources/js/serveur.js'])

    

</head>
<body class="font-sans text-gray-800 bg-gray-50 antialiased touch-manipulation transition-colors duration-200 dark:bg-gray-900 dark:text-gray-100">

    @yield('content')

</body>
</html>