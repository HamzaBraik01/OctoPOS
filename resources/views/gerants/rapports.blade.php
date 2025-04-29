{{-- resources/views/gerants/rapports.blade.php --}}
<div id="section-rapports" class="section-content p-6"> {{-- 'hidden' géré par JS --}}
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Rapports et Analyses</h2>

    {{-- Grille pour les graphiques principaux --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Performance des ventes --}}
        <div class="dashboard-card p-4 flex flex-col">
            <div class="widget-header">
                <h3 class="flex items-center text-base font-semibold">
                    <i class="fas fa-chart-bar text-primary mr-2"></i> {{-- Changé pour fa-chart-bar --}}
                    Performance des ventes (7 jours)
                </h3>
                 {{-- Optionnel: Sélecteur de période --}}
            </div>
            <div class="mt-4 flex-grow" style="position: relative; min-height: 300px;">
                <canvas id="sales-performance-chart"></canvas> {{-- Initialisé par JS --}}
            </div>
        </div>

        {{-- Tendances (Clients & Ticket Moyen) --}}
        <div class="dashboard-card p-4 flex flex-col">
            <div class="widget-header">
                <h3 class="flex items-center text-base font-semibold">
                    <i class="fas fa-chart-line text-success mr-2"></i>
                    Tendances (6 mois)
                </h3>
                 {{-- Optionnel: Changer les métriques --}}
            </div>
            <div class="mt-4 flex-grow" style="position: relative; min-height: 300px;">
                <canvas id="trends-chart"></canvas> {{-- Initialisé par JS --}}
            </div>
        </div>
    </div>

    {{-- Rapports disponibles --}}
    <div class="dashboard-card p-4">
        <div class="widget-header">
            <h3 class="flex items-center text-base font-semibold">
                <i class="fas fa-file-alt text-info mr-2"></i>
                Rapports disponibles
            </h3>
            <a href="#" class="text-sm text-primary hover:text-primary-dark dark:text-primary-light dark:hover:text-primary flex items-center">
                Générer un rapport <i class="fas fa-cogs ml-1 text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            {{-- Boucle @foreach ($availableReports as $report) ici --}}
            {{-- Rapport 1 --}}
            <a href="#" class="block border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/20 hover:shadow-sm transition duration-200 group">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg mr-3 flex-shrink-0">
                        <i class="fas fa-file-invoice-dollar text-blue-600 dark:text-blue-400 text-lg"></i> {{-- Icône plus spécifique --}}
                    </div>
                    <div class="flex-grow">
                         {{-- Titre dynamique --}}
                        <h4 class="font-medium text-sm group-hover:text-primary dark:group-hover:text-primary-light">Rapport de vente mensuel</h4>
                         {{-- Info dynamique --}}
                        <p class="text-xs text-gray-500 dark:text-gray-400">Avril 2025</p>
                    </div>
                     <i class="fas fa-download text-gray-400 ml-2 group-hover:text-primary dark:group-hover:text-primary-light transition-colors"></i>
                </div>
            </a>

            {{-- Rapport 2 --}}
            <a href="#" class="block border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/20 hover:shadow-sm transition duration-200 group">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg mr-3 flex-shrink-0">
                         <i class="fas fa-boxes-stacked text-green-600 dark:text-green-400 text-lg"></i> {{-- Icône plus spécifique --}}
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-medium text-sm group-hover:text-primary dark:group-hover:text-primary-light">Analyse des stocks</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Mis à jour: 14:30</p>
                    </div>
                     <i class="fas fa-download text-gray-400 ml-2 group-hover:text-primary dark:group-hover:text-primary-light transition-colors"></i>
                </div>
            </a>

            {{-- Rapport 3 --}}
            <a href="#" class="block border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/20 hover:shadow-sm transition duration-200 group">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg mr-3 flex-shrink-0">
                         <i class="fas fa-user-check text-purple-600 dark:text-purple-400 text-lg"></i> {{-- Icône plus spécifique --}}
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-medium text-sm group-hover:text-primary dark:group-hover:text-primary-light">Performance du personnel</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Trimestre 1 2025</p>
                    </div>
                    <i class="fas fa-download text-gray-400 ml-2 group-hover:text-primary dark:group-hover:text-primary-light transition-colors"></i>
                </div>
            </a>
            {{-- Fin de la boucle --}}
            {{-- Message si aucun rapport --}}
             {{-- @empty($availableReports)
                <p class="text-center py-4 text-gray-500 col-span-full">Aucun rapport disponible pour le moment.</p>
            @endempty --}}
        </div>
    </div>
</div>