{{-- resources/views/gerants/sections/personnel.blade.php --}}
<div id="section-personnel" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion du Personnel</h2>

    {{-- Liste du personnel --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h3 class="text-lg font-semibold flex items-center text-gray-800 dark:text-gray-200 flex-shrink-0">
                <i class="fas fa-users text-blue-500 mr-2"></i>
                Équipe du restaurant
            </h3>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                {{-- Recherche --}}
                <div class="relative flex-grow md:flex-grow-0">
                    <input type="text" placeholder="Rechercher..." class="pl-10 pr-4 py-2 w-full md:w-48 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500" aria-label="Rechercher un employé">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                {{-- Filtre Rôle --}}
                <select class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500" aria-label="Filtrer par rôle">
                    <option value="">Tous les rôles</option>
                    <option value="serveur">Serveur</option>
                    <option value="cuisinier">Cuisinier</option>
                    <option value="barman">Barman</option>
                    <option value="manager">Manager</option>
                </select>
                {{-- Bouton Ajouter --}}
                <button type="button" class="add-employee-button bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="fas fa-plus mr-2"></i> Ajouter
                </button>
            </div>
        </div>

        {{-- Tableau des employés --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Employé</th>
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Contact</th>
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Rôle</th>
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Statut Actuel</th>
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Prochain Service</th>
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    {{-- Les données réelles viendraient d'une boucle @foreach($employees as $employee) --}}
                    {{-- Données exemples (avec data-id pour JS et classe pour select) : --}}
                    <tr data-employee-id="1052" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas Dubois" class="w-10 h-10 rounded-full mr-3 object-cover">
                                <div>
                                    <div class="font-medium text-sm text-gray-900 dark:text-gray-100">Thomas Dubois</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">ID: #1052</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-700 dark:text-gray-300">thomas.dubois@bistro.fr</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">+33 6 12 34 56 78</div>
                        </td>
                        <td class="px-4 py-3">
                            {{-- Classe employee-role-select pour le JS --}}
                            <select class="employee-role-select text-sm px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 w-full max-w-[120px]">
                                <option value="serveur" selected>Serveur</option>
                                <option value="cuisinier">Cuisinier</option>
                                <option value="barman">Barman</option>
                            </select>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300">En service</span>
                        </td>
                        <td class="px-4 py-3">
                            <button type="button" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs flex items-center">
                                <i class="fas fa-calendar-alt mr-1"></i> Aujourd'hui 19h-00h
                            </button>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                <button type="button" class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    {{-- Ajouter d'autres lignes exemples ou la boucle Blade --}}
                     <tr data-employee-id="1078" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3"> <div class="flex items-center"> <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Marie Strauss" class="w-10 h-10 rounded-full mr-3 object-cover"> <div> <div class="font-medium text-sm text-gray-900 dark:text-gray-100">Marie Strauss</div> <div class="text-xs text-gray-500 dark:text-gray-400">ID: #1078</div> </div> </div> </td>
                        <td class="px-4 py-3"> <div class="text-sm text-gray-700 dark:text-gray-300">marie.strauss@bistro.fr</div> <div class="text-xs text-gray-500 dark:text-gray-400">+33 6 98 76 54 32</div> </td>
                        <td class="px-4 py-3"> <select class="employee-role-select text-sm px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 w-full max-w-[120px]"> <option value="serveur" selected>Serveur</option> <option value="cuisinier">Cuisinier</option> <option value="barman">Barman</option> </select> </td>
                        <td class="px-4 py-3"> <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300">En service</span> </td>
                        <td class="px-4 py-3"> <button type="button" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs flex items-center"> <i class="fas fa-calendar-alt mr-1"></i> Aujourd'hui 18h-00h </button> </td>
                        <td class="px-4 py-3"> <div class="flex space-x-1"> <button type="button" class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier"> <i class="fas fa-edit"></i> </button> <button type="button" class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer"> <i class="fas fa-trash"></i> </button> </div> </td>
                    </tr>
                     <tr data-employee-id="1109" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                         <td class="px-4 py-3"> <div class="flex items-center"> <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Sophie Renaud" class="w-10 h-10 rounded-full mr-3 object-cover"> <div> <div class="font-medium text-sm text-gray-900 dark:text-gray-100">Sophie Renaud</div> <div class="text-xs text-gray-500 dark:text-gray-400">ID: #1109</div> </div> </div> </td>
                         <td class="px-4 py-3"> <div class="text-sm text-gray-700 dark:text-gray-300">sophie.renaud@bistro.fr</div> <div class="text-xs text-gray-500 dark:text-gray-400">+33 6 45 67 89 01</div> </td>
                         <td class="px-4 py-3"> <select class="employee-role-select text-sm px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 w-full max-w-[120px]"> <option value="serveur" selected>Serveur</option> <option value="cuisinier">Cuisinier</option> <option value="barman">Barman</option> </select> </td>
                         <td class="px-4 py-3"> <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">Absente</span> </td>
                         <td class="px-4 py-3"> <button type="button" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs flex items-center"> <i class="fas fa-calendar-alt mr-1"></i> Demain 19h-00h </button> </td>
                         <td class="px-4 py-3"> <div class="flex space-x-1"> <button type="button" class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier"> <i class="fas fa-edit"></i> </button> <button type="button" class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer"> <i class="fas fa-trash"></i> </button> </div> </td>
                     </tr>

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
            <div>Affichage de 1-5 employés sur 12</div> {{-- Rendre dynamique --}}
            <div class="flex items-center space-x-1">
                <button class="px-3 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 disabled:opacity-50" disabled>Préc.</button>
                <button class="px-3 py-1 rounded border border-blue-500 bg-blue-500 text-white">1</button>
                <button class="px-3 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">2</button>
                <button class="px-3 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">3</button>
                <button class="px-3 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Suiv.</button>
                 {{-- Utiliser $employees->links() avec pagination Laravel --}}
            </div>
        </div>
    </div>

    {{-- Planification des horaires --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 gap-2">
            <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                Planification Hebdomadaire
            </h3>
            <div class="flex items-center">
                <button type="button" class="add-shift-button text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center font-medium">
                    <i class="fas fa-plus-circle mr-1"></i> Ajouter Créneau
                </button>
            </div>
        </div>

        {{-- Filtres rapides de période --}}
        <div class="flex mb-4 space-x-2 overflow-x-auto py-2">
            <button class="text-xs bg-blue-600 text-white px-3 py-1 rounded-full whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-blue-500">Cette semaine</button>
            <button class="schedule-filter-btn">Sem. Prochaine</button>
            <button class="schedule-filter-btn">Aujourd'hui</button>
            <button class="schedule-filter-btn">Vue Mensuelle</button>
            {{-- Style commun pour les boutons filtre --}}
            <style>.schedule-filter-btn { font-size: 0.75rem; background-color: white; color: #4B5563; padding: 0.25rem 0.75rem; border-radius: 9999px; border: 1px solid #D1D5DB; white-space: nowrap; transition: background-color 0.2s; } .dark .schedule-filter-btn { background-color: #374151; color: #D1D5DB; border-color: #4B5563; } .schedule-filter-btn:hover { background-color: #F3F4F6; } .dark .schedule-filter-btn:hover { background-color: #4B5563; }</style>
        </div>

        {{-- Tableau de planning --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]"> {{-- Très large --}}
                <thead>
                    <tr>
                        <th class="py-2 px-2 sticky left-0 bg-white dark:bg-gray-800 z-10 w-40">Employé</th> {{-- Colonne Employé fixe --}}
                        {{-- Générer les jours de la semaine dynamiquement ? --}}
                        <th class="schedule-header" colspan="2">Lundi 29/04</th>
                        <th class="schedule-header" colspan="2">Mardi 30/04</th>
                        <th class="schedule-header" colspan="2">Mercredi 01/05</th>
                        <th class="schedule-header" colspan="2">Jeudi 02/05</th>
                        <th class="schedule-header" colspan="2">Vendredi 03/05</th>
                        <th class="schedule-header" colspan="2">Samedi 04/05</th>
                        <th class="schedule-header" colspan="2">Dimanche 05/05</th>
                         {{-- Style commun pour header planning --}}
                        <style>.schedule-header { padding: 0.5rem 0.25rem; text-align: center; background-color: #F3F4F6; font-size: 0.75rem; font-weight: 500; border-left: 1px solid #E5E7EB; border-bottom: 1px solid #E5E7EB; } .dark .schedule-header { background-color: #374151; border-color: #4B5563; color: #D1D5DB; }</style>
                    </tr>
                    <tr class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                        <th class="py-1 sticky left-0 bg-white dark:bg-gray-800 z-10 border-b dark:border-gray-700"></th>
                        {{-- Répéter pour chaque jour --}}
                        @for ($i = 0; $i < 7; $i++)
                        <th class="py-1 px-1 text-center border-l border-b dark:border-gray-700">Matin</th>
                        <th class="py-1 px-1 text-center border-l border-b dark:border-gray-700">Soir</th>
                        @endfor
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    {{-- Boucle sur les employés --}}
                    {{-- @foreach($employees as $employee) --}}
                    {{-- Ligne exemple 1 --}}
                    <tr>
                        <td class="py-2 pr-2 sticky left-0 bg-white dark:bg-gray-800 z-10 border-b dark:border-gray-700 w-40 align-top">
                            <div class="flex items-start">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas Dubois" class="w-8 h-8 rounded-full mr-2 mt-1 flex-shrink-0">
                                <div class="font-medium text-sm text-gray-900 dark:text-gray-100 mt-1">Thomas Dubois</div>
                            </div>
                        </td>
                        {{-- Boucle sur les jours/shifts --}}
                        @for ($i = 0; $i < 7; $i++)
                             {{-- Shift Matin --}}
                             <td class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[70px]">
                                <button type="button" class="add-shift-button w-full h-full min-h-[40px] border border-dashed border-gray-300 dark:border-gray-600 rounded flex items-center justify-center text-gray-400 hover:text-blue-500 hover:border-blue-500 dark:hover:border-blue-400">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </td>
                             {{-- Shift Soir --}}
                            <td class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[70px]">
                                @if($i == 0 || $i == 1 || $i == 3 || $i == 4 || $i == 5) {{-- Exemple de créneau assigné --}}
                                <div class="shift-card bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200">
                                    <span>Chef rang</span>
                                    <button class="delete-shift-btn"><i class="fas fa-times"></i></button>
                                </div>
                                @else
                                 <button type="button" class="add-shift-button w-full h-full min-h-[40px] border border-dashed border-gray-300 dark:border-gray-600 rounded flex items-center justify-center text-gray-400 hover:text-blue-500 hover:border-blue-500 dark:hover:border-blue-400">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                                @endif
                            </td>
                        @endfor
                    </tr>
                     {{-- Ligne exemple 2 (Absence) --}}
                     <tr>
                         <td class="py-2 pr-2 sticky left-0 bg-white dark:bg-gray-800 z-10 border-b dark:border-gray-700 w-40 align-top"> <div class="flex items-start"> <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Sophie Renaud" class="w-8 h-8 rounded-full mr-2 mt-1 flex-shrink-0"> <div class="font-medium text-sm text-gray-900 dark:text-gray-100 mt-1">Sophie Renaud</div> </div> </td>
                         @for ($i = 0; $i < 7; $i++)
                             @if($i < 3) {{-- Exemple absence --}}
                             <td colspan="2" class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[140px]">
                                 <div class="shift-card absence-card bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200">
                                     <i class="fas fa-ban mr-1"></i> Absente <span class="text-[10px]">(Maladie)</span>
                                     <button class="delete-shift-btn"><i class="fas fa-times"></i></button>
                                 </div>
                             </td>
                             @else {{-- Exemple dispo/non assigné --}}
                              <td class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[70px]"> <button type="button" class="add-shift-button w-full h-full min-h-[40px] border border-dashed border-gray-300 dark:border-gray-600 rounded flex items-center justify-center text-gray-400 hover:text-blue-500 hover:border-blue-500 dark:hover:border-blue-400"> <i class="fas fa-plus text-xs"></i> </button> </td>
                              <td class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[70px]"> <button type="button" class="add-shift-button w-full h-full min-h-[40px] border border-dashed border-gray-300 dark:border-gray-600 rounded flex items-center justify-center text-gray-400 hover:text-blue-500 hover:border-blue-500 dark:hover:border-blue-400"> <i class="fas fa-plus text-xs"></i> </button> </td>
                             @endif
                             {{-- Ajustement pour ne pas dépasser 7 jours --}}
                              @if ($i == 2 && $i < 3) @php $i = 2; continue; @endphp @endif
                          @endfor
                      </tr>

                    {{-- @endforeach --}}
                     {{-- Style pour les cartes de shift --}}
                    <style>
                        .shift-card { position: relative; padding: 0.3rem 0.4rem; border-radius: 0.25rem; font-size: 0.7rem; line-height: 1.1; text-align: center; min-height: 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
                        .shift-card span { display: block; margin-bottom: 0.1rem; font-weight: 500; }
                        .shift-card .delete-shift-btn { position: absolute; top: 0; right: 0; padding: 0.1rem; line-height: 0.8; color: inherit; opacity: 0.5; background: none; border: none; cursor: pointer; }
                        .shift-card:hover .delete-shift-btn { opacity: 1; }
                         .absence-card { font-weight: 500; }
                    </style>
                </tbody>
            </table>
        </div>
    </div>


    <div id="schedule-modal" tabindex="-1" aria-labelledby="schedule-modal-title" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-5 sm:p-6 max-w-md w-full mx-auto max-h-[90vh] overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex justify-between items-center pb-3 border-b dark:border-gray-600">
                <h3 id="schedule-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Ajouter un créneau</h3>
                <button type="button" id="close-schedule-modal-x" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" aria-label="Fermer">
                     <i class="fas fa-times text-xl"></i>
                 </button>
             </div>
            <div class="mt-4 space-y-4">
                <div>
                    <label for="schedule-employee" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employé</label>
                    <select id="schedule-employee" class="modal-input"> {{-- Utilise style commun --}}
                        <option value="">Sélectionner...</option>
                        {{-- Boucle @foreach($employees as $emp) <option value="{{$emp->id}}">{{$emp->name}}</option> @endforeach --}}
                        <option value="1">Thomas Dubois</option>
                        <option value="2">Marie Strauss</option>
                        <option value="3">Sophie Renaud</option>
                    </select>
                </div>
                <div>
                    <label for="schedule-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" id="schedule-date" class="modal-input">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="schedule-start-time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Heure début</label>
                        <input type="time" id="schedule-start-time" class="modal-input">
                    </div>
                    <div>
                        <label for="schedule-end-time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Heure fin</label>
                        <input type="time" id="schedule-end-time" class="modal-input">
                    </div>
                </div>
                 <div>
                    <label for="schedule-role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rôle (optionnel)</label>
                    <select id="schedule-role" class="modal-input">
                        <option value="">Rôle habituel</option>
                        <option value="chef-rang">Chef de rang</option>
                        <option value="serveur">Serveur</option>
                        <option value="barman">Barman</option>
                        {{-- etc. --}}
                    </select>
                </div>
                 <div>
                    <label for="schedule-notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                    <textarea id="schedule-notes" class="modal-input" rows="2"></textarea>
                </div>
            </div>
             <div class="mt-6 pt-4 border-t dark:border-gray-600 flex justify-end gap-3">
                <button id="cancel-schedule" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Annuler
                </button>
                <button id="save-schedule" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

     <div id="delete-modal" tabindex="-1" aria-labelledby="delete-modal-title" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4">
         <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-5 sm:p-6 max-w-md w-full mx-auto" role="dialog" aria-modal="true">
            <div class="text-center">
                 <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                    <i class="fas fa-user-times text-red-600 dark:text-red-400 text-2xl"></i> {{-- Icone différente --}}
                </div>
                <h3 id="delete-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Supprimer cet employé ?</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Êtes-vous sûr ? Cette action est irréversible et toutes les données associées (horaires, etc.) pourraient être perdues. <span class="employee-name-placeholder font-semibold"></span>
                </p>
                <div class="mt-6 flex justify-center gap-3">
                    <button id="cancel-delete" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Annuler
                    </button>
                    <button id="confirm-delete" type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Supprimer Employé
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>