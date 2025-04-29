{{-- resources/views/gerants/caisse.blade.php --}}
<div id="section-caisse" class="section-content p-6"> {{-- 'hidden' géré par JS --}}
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Caisse & Paiements</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6"> {{-- lg:grid-cols-2 pour un meilleur layout --}}
        {{-- Transactions du jour --}}
        <div class="dashboard-card p-4">
            <div class="widget-header">
                <h3 class="flex items-center text-base font-semibold">
                    <i class="fas fa-cash-register text-primary mr-2"></i>
                    Transactions récentes
                </h3>
                {{-- Optionnel: Bouton pour voir toutes les transactions --}}
                 <a href="#" class="text-sm text-primary hover:text-primary-dark dark:text-primary-light dark:hover:text-primary flex items-center">
                    Voir tout <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[500px]">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Heure</th>
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Table</th>
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium text-right">Montant</th>
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Paiement</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 dark:text-gray-300">
                        {{-- Boucle @foreach ($recentTransactions as $transaction) ici --}}
                        <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                            <td class="px-4 py-3">22:15</td>
                            <td class="px-4 py-3">Table 4</td>
                            <td class="px-4 py-3 font-medium text-right">128,50 €</td>
                            <td class="px-4 py-3">
                                <span class="badge badge-blue">Carte</span> {{-- Simplifié --}}
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                            <td class="px-4 py-3">21:45</td>
                            <td class="px-4 py-3">Table 9</td>
                            <td class="px-4 py-3 font-medium text-right">85,20 €</td>
                            <td class="px-4 py-3">
                                <span class="badge badge-green">Espèces</span>
                            </td>
                        </tr>
                         <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                            <td class="px-4 py-3">21:30</td>
                            <td class="px-4 py-3">Table 2</td>
                            <td class="px-4 py-3 font-medium text-right">65,00 €</td>
                            <td class="px-4 py-3">
                                <span class="badge badge-yellow">Ticket Resto</span>
                            </td>
                        </tr>
                        {{-- Fin de la boucle --}}
                        {{-- Message si aucune transaction --}}
                        {{-- @empty($recentTransactions)
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">Aucune transaction récente.</td>
                            </tr>
                        @endempty --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Résumé des ventes & Graphique --}}
        <div class="dashboard-card p-4 flex flex-col"> {{-- flex flex-col --}}
            <div class="widget-header">
                <h3 class="flex items-center text-base font-semibold">
                    <i class="fas fa-chart-line text-success mr-2"></i>
                    Résumé des ventes
                </h3>
                 {{-- Sélecteur de période ? --}}
            </div>

            <div class="grid grid-cols-2 gap-4 my-4 text-center">
                 <div>
                    {{-- Donnée dynamique: $salesToday --}}
                    <div class="text-3xl font-bold text-primary dark:text-primary-light">1 250,80 €</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Aujourd'hui</div>
                </div>
                <div>
                     {{-- Donnée dynamique: $salesThisWeek --}}
                    <div class="text-3xl font-bold text-success dark:text-success-light">8 745,25 €</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Cette semaine</div>
                </div>
            </div>

            {{-- Canvas pour graphique, prendra l'espace restant --}}
            <div class="mt-auto flex-grow" style="position: relative; min-height: 200px;"> {{-- flex-grow et position relative pour Chart.js --}}
                <canvas id="sales-chart"></canvas> {{-- Initialisé par JS --}}
            </div>
        </div>
    </div>
     {{-- D'autres widgets pourraient aller ici (ex: répartition par type de paiement) --}}
</div>