<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OctoPOS - Tableau de bord gérant">
    <title>OctoPOS Dashboard | @yield('title', 'Gérant')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/speech-synthesis-polyfill@0.1.0/dist/speech-synthesis-polyfill.min.js"></script>

    @vite('resources/css/gerant.css')

    @yield('head-scripts')
</head>
<body>
    @include('partials.gerant.sidebar')
    @include('partials.gerant.header')

    <main class="main-content" id="main-content">
        @yield('content')
    </main>

    @vite('resources/js/gerant.js')
    @yield('page-scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vérifier si le sélecteur de restaurant existe
            const restaurantSelector = document.getElementById('restaurant-selector');
            if (restaurantSelector) {
                // Vérifier s'il y a des options
                if (restaurantSelector.options.length === 0) {
                    console.warn("Aucun restaurant n'a été trouvé dans la base de données");
                    
                    // Ajouter une option par défaut si aucun restaurant n'est disponible
                    const defaultOption = document.createElement('option');
                    defaultOption.text = "Aucun restaurant disponible";
                    defaultOption.value = "";
                    restaurantSelector.appendChild(defaultOption);
                }
                
                // Récupérer le restaurant sauvegardé
                const savedRestaurantId = localStorage.getItem('selectedRestaurantId');
                if (savedRestaurantId && restaurantSelector.options.length > 0) {
                    // Vérifier si l'ID existe dans les options
                    let found = false;
                    for (let i = 0; i < restaurantSelector.options.length; i++) {
                        if (restaurantSelector.options[i].value === savedRestaurantId) {
                            restaurantSelector.selectedIndex = i;
                            found = true;
                            break;
                        }
                    }
                    
                    // Si l'ID sauvegardé n'existe pas, on sélectionne la première option
                    if (!found && restaurantSelector.options.length > 0) {
                        restaurantSelector.selectedIndex = 0;
                        localStorage.setItem('selectedRestaurantId', restaurantSelector.value);
                    }
                }
            }
        });
    </script>
</body>
</html>