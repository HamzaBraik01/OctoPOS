{{-- resources/views/gerants/reservations.blade.php --}}
<div id="section-reservations" class="section-content p-6"> {{-- 'hidden' sera géré par JS --}}
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion des Réservations</h2>

    <div class="dashboard-card p-4 mb-6">
        <div class="widget-header">
            <h3 class="flex items-center text-base font-semibold"> {{-- Changé h2 en h3 pour la sémantique --}}
                <i class="fas fa-calendar-check text-primary mr-2"></i>
                Réservations à venir
            </h3>
            <div class="flex items-center">
                <button class="text-sm text-primary hover:text-primary-dark dark:text-primary-light dark:hover:text-primary flex items-center focus:outline-none">
                    <i class="fas fa-plus-circle mr-1"></i> Nouvelle réservation
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]"> {{-- min-w pour éviter écrasement sur petit écran --}}
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Heure</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Client</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Table</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Personnes</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium">Statut</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400 font-medium text-right">Actions</th> {{-- Text-right --}}
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-gray-300">
                    {{-- Ces lignes seraient générées par une boucle @foreach en situation réelle --}}
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                        <td class="px-4 py-3 font-medium">23:30</td>
                        <td class="px-4 py-3">Groupe Martinez</td>
                        <td class="px-4 py-3">Table 12</td>
                        <td class="px-4 py-3 text-center">8</td> {{-- Centré --}}
                        <td class="px-4 py-3">
                            <span class="badge badge-purple">Confirmée</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 justify-end"> {{-- justify-end --}}
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-primary/10 text-primary hover:bg-primary/20 rounded focus:outline-none focus:ring-1 focus:ring-primary" aria-label="Modifier">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-success/10 text-success hover:bg-success/20 rounded focus:outline-none focus:ring-1 focus:ring-success" aria-label="Confirmer">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                     <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                        <td class="px-4 py-3 font-medium">23:45</td>
                        <td class="px-4 py-3">Famille Dupont</td>
                        <td class="px-4 py-3">Table 7</td>
                        <td class="px-4 py-3 text-center">4</td>
                        <td class="px-4 py-3">
                            <span class="badge badge-yellow">En attente</span>
                        </td>
                        <td class="px-4 py-3">
                           <div class="flex space-x-2 justify-end">
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-primary/10 text-primary hover:bg-primary/20 rounded focus:outline-none focus:ring-1 focus:ring-primary" aria-label="Modifier">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-success/10 text-success hover:bg-success/20 rounded focus:outline-none focus:ring-1 focus:ring-success" aria-label="Confirmer">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                     <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/20">
                        <td class="px-4 py-3 font-medium">00:15</td>
                        <td class="px-4 py-3">Marc & Julie</td>
                        <td class="px-4 py-3">Table 5</td>
                        <td class="px-4 py-3 text-center">2</td>
                        <td class="px-4 py-3">
                            <span class="badge badge-blue">Nouvelle</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2 justify-end">
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-primary/10 text-primary hover:bg-primary/20 rounded focus:outline-none focus:ring-1 focus:ring-primary" aria-label="Modifier">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button class="p-1.5 h-7 w-7 flex items-center justify-center bg-success/10 text-success hover:bg-success/20 rounded focus:outline-none focus:ring-1 focus:ring-success" aria-label="Confirmer">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                     {{-- Ajouter plus de lignes ou un message si la table est vide --}}
                </tbody>
            </table>
        </div>
         {{-- Ajouter une pagination ici si nécessaire --}}
    </div>
</div>