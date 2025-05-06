<div id="section-rapports" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Rapports et Analyses</h2>

    {{-- Graphiques de performance --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Performance des Ventes (type bar chart) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 flex flex-col">
            <div class="flex justify-between items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                    <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                    Performance des Ventes
                </h3>
                {{-- Sélecteur période --}}
                <select id="sales-period-selector" class="text-xs p-1 border rounded dark:bg-gray-700 dark:border-gray-600">
                    <option value="week">Cette semaine</option>
                    <option value="month">Ce mois</option>
                    <option value="quarter">Trimestre</option>
                </select>
            </div>
            {{-- Conteneur pour le graphique --}}
            <div class="mt-4 flex-grow min-h-[300px]" id="sales-performance-chart-container">
                <canvas id="sales-performance-chart"></canvas>
            </div>
        </div>

        {{-- Tendances (type line chart) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 flex flex-col">
            <div class="flex justify-between items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                    <i class="fas fa-chart-line text-green-500 mr-2"></i>
                    Tendances Clés
                </h3>
                 <select id="trends-period-selector" class="text-xs p-1 border rounded dark:bg-gray-700 dark:border-gray-600">
                     <option value="6months">6 derniers mois</option>
                     <option value="year">Cette année</option>
                     <option value="lastyear">Année dernière</option>
                 </select>
            </div>
            {{-- Conteneur pour le graphique --}}
            <div class="mt-4 flex-grow min-h-[300px]" id="trends-chart-container">
                <canvas id="trends-chart"></canvas>
            </div>
        </div>
    </div>

    {{-- Rapports Disponibles --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex justify-between items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                <i class="fas fa-file-download text-blue-500 mr-2"></i> {{-- Changed icon --}}
                Rapports à Télécharger
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            {{-- Carte Rapport 1 --}}
            <a href="#" id="ventes-mensuelles-link" class="report-card group bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700">
                <div class="report-card-icon bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                    <i class="fas fa-file-invoice-dollar"></i> {{-- Icone Ventes --}}
                </div>
                <div>
                    <h4 class="report-card-title">Ventes Mensuelles</h4>
                    <p class="report-card-subtitle">Avril 2025 - PDF</p>
                </div>
                <i class="fas fa-download report-card-download-icon"></i>
            </a>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ventesLink = document.getElementById('ventes-mensuelles-link');
                    const restaurantSelector = document.getElementById('header-restaurant-selector');
                    
                    if (ventesLink && restaurantSelector) {
                        ventesLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            
                            // Vérifier si un restaurant est sélectionné
                            if (restaurantSelector.value) {
                                // Rediriger vers la génération de rapport avec l'ID du restaurant
                                window.location.href = "{{ route('rapport.ventes-mensuelles') }}?restaurant_id=" + restaurantSelector.value;
                            } else {
                                // Afficher une alerte si aucun restaurant n'est sélectionné
                                window.showAlert('warning', 'Sélection requise', 'Veuillez sélectionner un restaurant pour générer le rapport.', 5000);
                            }
                        });
                    }
                });
            </script>

             {{-- Style commun pour les cartes de rapport --}}
             <style>
                 .report-card { display: flex; align-items: center; padding: 1rem; border-radius: 0.5rem; transition: all 0.2s ease-in-out; cursor: pointer; }
                 .report-card:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); background-color: white; }
                 .dark .report-card:hover { background-color: #374151; } /* gray-700 */
                 .report-card-icon { flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 0.375rem; margin-right: 0.75rem; font-size: 1.1rem; }
                 .report-card-title { font-medium: 500; color: #1F2937; margin-bottom: 0.1rem; } .dark .report-card-title { color: #F3F4F6; }
                 .report-card-subtitle { font-size: 0.75rem; color: #6B7280; } .dark .report-card-subtitle { color: #9CA3AF; }
                 .report-card-download-icon { margin-left: auto; color: #9CA3AF; transition: color 0.2s; } .dark .report-card-download-icon { color: #6B7280; }
                 .report-card:hover .report-card-download-icon { color: #3B82F6; } /* blue-500 */
             </style>
        </div>
    </div>
</div>