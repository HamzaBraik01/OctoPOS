{{-- resources/views/gerants/sections/reservations.blade.php --}}
<div id="section-reservations" class="section-content p-6"> {{-- Retrait de 'hidden' ici, le JS gère l'affichage initial --}}
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion des Réservations</h2>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 gap-2">
            <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                <i class="fas fa-calendar-check text-blue-500 mr-2"></i>
                Réservations à venir
            </h3>
            <div class="flex items-center">
                <button class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center font-medium">
                    <i class="fas fa-plus-circle mr-1"></i> Nouvelle réservation
                </button>
                {{-- Ajouter ici la logique modale ou lien pour une nouvelle réservation --}}
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]"> {{-- min-w pour éviter compression excessive --}}
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Heure</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Client</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Table</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Pers.</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Statut</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    {{-- Les données réelles viendraient d'une boucle @foreach($reservations as $resa) --}}
                    {{-- Données exemples : --}}
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100">23:30</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Groupe Martinez</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Table 12</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 text-center">8</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300">Confirmée</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                <button class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-1.5 text-xs bg-green-500 hover:bg-green-600 text-white rounded" title="Marquer Arrivé">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Annuler">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100">23:45</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Famille Dupont</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Table 7</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 text-center">4</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300">En attente</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                <button class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-1.5 text-xs bg-green-500 hover:bg-green-600 text-white rounded" title="Confirmer">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Annuler">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                     <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100">00:15</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Marc & Julie</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Table 5</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 text-center">2</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">Nouvelle</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                <button class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier/Voir">
                                    <i class="fas fa-eye"></i> {{-- ou fa-edit --}}
                                </button>
                                <button class="p-1.5 text-xs bg-green-500 hover:bg-green-600 text-white rounded" title="Confirmer">
                                    <i class="fas fa-check"></i>
                                </button>
                                 <button class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Refuser">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    {{-- Fin des données exemples --}}
                </tbody>
            </table>
            {{-- Ajouter une pagination ici si nécessaire --}}
             {{-- $reservations->links() --}}
        </div>
    </div>
     {{-- Potentiellement ajouter un calendrier FullCalendar ici --}}
</div>