{{-- resources/views/gerants/personnel.blade.php --}}
<div id="section-personnel" class="section-content p-6"> {{-- 'hidden' géré par JS --}}
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion du Personnel</h2>

    {{-- Carte principale --}}
    <div class="dashboard-card p-4 mb-6">
        <div class="widget-header">
            <h3 class="flex items-center text-base font-semibold">
                <i class="fas fa-users text-primary mr-2"></i>
                Équipe en service aujourd'hui
            </h3>
            <div class="flex items-center">
                <a href="#" class="text-sm text-primary hover:text-primary-dark dark:text-primary-light dark:hover:text-primary flex items-center mr-4 focus:outline-none">
                    <i class="fas fa-user-plus mr-1"></i> Ajouter employé
                </a>
                 <a href="#" class="text-sm text-primary hover:text-primary-dark dark:text-primary-light dark:hover:text-primary flex items-center focus:outline-none">
                    <i class="fas fa-calendar-alt mr-1"></i> Gérer planning
                </a>
            </div>
        </div>

        {{-- Grille du personnel --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
            {{-- Boucle @foreach ($staffOnDuty as $staffMember) ici --}}
            <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm flex items-center space-x-3 hover:shadow-md transition-shadow duration-200">
                {{-- Image dynamique --}}
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Photo de Thomas Dubois" class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                <div class="flex-grow">
                    {{-- Nom dynamique --}}
                    <h4 class="font-medium text-sm leading-tight">Thomas Dubois</h4>
                    {{-- Rôle dynamique --}}
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-tight mb-1">Chef de rang</p>
                    {{-- Statut dynamique --}}
                    {{-- @if($staffMember->status == 'en_service') --}}
                        <span class="badge badge-green">En service</span>
                    {{-- @elseif($staffMember->status == 'pause')
                        <span class="badge badge-yellow">En pause</span>
                    @else
                        <span class="badge badge-gray">Hors service</span>
                    @endif --}}
                </div>
                 {{-- Bouton action rapide (optionnel) --}}
                 <button class="text-gray-400 hover:text-primary focus:outline-none" aria-label="Options pour Thomas Dubois">
                     <i class="fas fa-ellipsis-v"></i>
                 </button>
            </div>

            <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm flex items-center space-x-3 hover:shadow-md transition-shadow duration-200">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Photo de Marie Strauss" class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                <div class="flex-grow">
                    <h4 class="font-medium text-sm leading-tight">Marie Strauss</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-tight mb-1">Serveuse</p>
                    <span class="badge badge-green">En service</span>
                </div>
                 <button class="text-gray-400 hover:text-primary focus:outline-none" aria-label="Options pour Marie Strauss">
                     <i class="fas fa-ellipsis-v"></i>
                 </button>
            </div>

            <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm flex items-center space-x-3 opacity-60 hover:shadow-md transition-shadow duration-200"> {{-- Opacity pour absent --}}
                <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Photo de Sophie Renaud" class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                <div class="flex-grow">
                    <h4 class="font-medium text-sm leading-tight">Sophie Renaud</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-tight mb-1">Serveuse</p>
                    <span class="badge badge-red">Absente</span>
                </div>
                 <button class="text-gray-400 hover:text-primary focus:outline-none" aria-label="Options pour Sophie Renaud">
                     <i class="fas fa-ellipsis-v"></i>
                 </button>
            </div>

             <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm flex items-center space-x-3 hover:shadow-md transition-shadow duration-200">
                <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Photo de Pierre Lambert" class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                <div class="flex-grow">
                    <h4 class="font-medium text-sm leading-tight">Pierre Lambert</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-tight mb-1">Chef Cuisinier</p>
                    <span class="badge badge-blue">Formation</span>
                </div>
                 <button class="text-gray-400 hover:text-primary focus:outline-none" aria-label="Options pour Pierre Lambert">
                     <i class="fas fa-ellipsis-v"></i>
                 </button>
            </div>
            {{-- Fin de la boucle --}}
             {{-- Message si personne --}}
             {{-- @empty($staffOnDuty)
                <p class="text-center py-4 text-gray-500 col-span-full">Aucun employé en service pour le moment.</p>
            @endempty --}}
        </div>

        {{-- Calendrier des congés et absences --}}
        <div>
            <h4 class="mb-2 font-medium text-sm text-gray-700 dark:text-gray-300">Calendrier des absences</h4>
            {{-- Le conteneur du calendrier est stylé pour s'intégrer --}}
            <div id="hr-calendar" class="hr-calendar bg-gray-50 dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                {{-- Initialisé par JS (FullCalendar) --}}
                <div class="text-center text-gray-500 p-4">Chargement du calendrier...</div>
            </div>
        </div>
    </div>
     {{-- D'autres sections possibles : demandes de congé, évaluations... --}}
</div>