{{-- resources/views/gerants/commandes.blade.php --}}
<div id="section-commandes" class="section-content p-6"> {{-- 'hidden' géré par JS --}}
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion des Commandes</h2>

    <div class="dashboard-card p-4 mb-6">
        <div class="widget-header">
            <h3 class="flex items-center text-base font-semibold">
                <i class="fas fa-utensils text-primary mr-2"></i>
                Commandes en cours
            </h3>
            {{-- Optionnel: Filtres (par statut, serveur...) --}}
            <div class="flex items-center space-x-2">
                 <span class="text-sm text-gray-500 dark:text-gray-400">Filtre:</span>
                 <select class="text-sm border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded p-1 focus:outline-none focus:ring-1 focus:ring-primary">
                     <option>Tous</option>
                     <option>En préparation</option>
                     <option>Prêt</option>
                     <option>Retardé</option>
                 </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Table</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Statut</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Temps écoulé</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Serveur</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-gray-300">
                    {{-- Boucle @foreach ($activeOrders as $order) ici --}}
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                        <td class="px-4 py-3 font-medium">Table 3</td>
                        <td class="px-4 py-3">
                            <span class="badge badge-yellow">En préparation</span>
                        </td>
                        {{-- Temps calculé dynamiquement --}}
                        <td class="px-4 py-3 font-medium text-warning dark:text-warning-light">18 min</td>
                        <td class="px-4 py-3">Thomas D.</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 justify-end">
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-primary/10 text-primary hover:bg-primary/20 rounded focus:outline-none focus:ring-1 focus:ring-primary" aria-label="Voir détails">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-success/10 text-success hover:bg-success/20 rounded focus:outline-none focus:ring-1 focus:ring-success" aria-label="Marquer comme prêt">
                                     <i class="fas fa-bell text-xs"></i> {{-- Ou fa-check si prêt --}}
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                        <td class="px-4 py-3 font-medium">Table 8</td>
                        <td class="px-4 py-3">
                            <span class="badge badge-blue">Prêt à servir</span> {{-- Statut différent de l'original --}}
                        </td>
                        <td class="px-4 py-3 font-medium">12 min</td>
                        <td class="px-4 py-3">Marie S.</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 justify-end">
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-primary/10 text-primary hover:bg-primary/20 rounded focus:outline-none focus:ring-1 focus:ring-primary" aria-label="Voir détails">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-success/10 text-success hover:bg-success/20 rounded focus:outline-none focus:ring-1 focus:ring-success" aria-label="Marquer comme servi">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                        <td class="px-4 py-3 font-medium">Table 10</td>
                        <td class="px-4 py-3">
                            <span class="badge badge-red">Retardé</span>
                        </td>
                        <td class="px-4 py-3 font-medium text-danger dark:text-danger-light">25 min</td>
                        <td class="px-4 py-3">Thomas D.</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 justify-end">
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-primary/10 text-primary hover:bg-primary/20 rounded focus:outline-none focus:ring-1 focus:ring-primary" aria-label="Voir détails">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-danger/10 text-danger hover:bg-danger/20 rounded focus:outline-none focus:ring-1 focus:ring-danger" aria-label="Signaler problème">
                                    <i class="fas fa-exclamation-triangle text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    {{-- Fin de la boucle --}}
                     {{-- Message si aucune commande --}}
                        {{-- @empty($activeOrders)
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">Aucune commande en cours.</td>
                            </tr>
                        @endempty --}}
                </tbody>
            </table>
        </div>
         {{-- Pagination si nécessaire --}}
    </div>
     {{-- D'autres widgets : Commandes prêtes, Commandes servies récemment... --}}
</div>