@extends('layouts.gerant')

@section('title', 'Vue d\'ensemble')

@section('content')
    <div class="p-6">
        <!-- Crisis Mode Banner (hidden by default) -->
        <div id="crisis-banner" class="hidden mb-6 p-4 bg-red-500 bg-opacity-10 dark:bg-red-900 dark:bg-opacity-30 border border-red-500 rounded-lg">
           {{-- Contenu du banner --}}
           <div class="flex items-center">
                <div class="mr-4 bg-red-500 rounded-full p-2">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-red-600 dark:text-red-400">Mode Crise Activé</h3>
                    <p class="text-red-700 dark:text-red-300">Gestion prioritaire des ressources et du personnel. Les alertes vocales sont activées.</p>
                </div>
                <button id="alert-speak-button" class="ml-auto bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition">
                    <i class="fas fa-volume-up"></i>
                </button>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            {{-- Contenu des 4 cartes de stats --}}
             <!-- Current Service Status -->
                <div class="dashboard-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-sm text-gray-500 dark:text-gray-400">Service en cours</h3>
                            <div class="font-bold text-2xl mt-1">Dîner</div>
                            <div class="text-sm mt-1">
                                <span class="font-semibold text-success">24 tables occupées</span> sur 30
                            </div>
                        </div>
                        <div class="bg-primary bg-opacity-10 dark:bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-utensils text-primary text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-primary to-secondary h-2 rounded-full" style="width: 80%"></div>
                        </div>
                        <span class="ml-2 text-xs font-medium">80%</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-warning"></div>
                            <span class="ml-1 text-gray-600 dark:text-gray-300">Temps d'attente moyen: 12 min</span>
                        </div>
                        <span class="text-primary">Détails</span>
                    </div>
                </div>
            <!-- Staff Status -->
                <div class="dashboard-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-sm text-gray-500 dark:text-gray-400">Personnel en service</h3>
                            <div class="font-bold text-2xl mt-1">12</div>
                            <div class="text-sm mt-1">
                                <span class="font-semibold text-danger">1 absence</span> signalée
                            </div>
                        </div>
                        <div class="bg-secondary bg-opacity-10 dark:bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-user-friends text-secondary text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-4 gap-2">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary">5</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Serveurs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-secondary">3</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Cuisine</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-warning">2</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Bar</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-info">2</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Accueil</div>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        <span class="text-success">✓ Équipe complète pour le service</span>
                        <span class="text-primary">Planning</span>
                    </div>
                </div>
            <!-- Upcoming Reservations -->
                <div class="dashboard-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-sm text-gray-500 dark:text-gray-400">Réservations à venir</h3>
                            <div class="font-bold text-2xl mt-1">4</div>
                            <div class="text-sm mt-1">
                                <span class="font-semibold text-warning">1 groupe</span> important
                            </div>
                        </div>
                        <div class="bg-info bg-opacity-10 dark:bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-calendar-check text-info text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">23:30</span>
                            <div class="flex items-center">
                                <div class="priority-indicator priority-high"></div>
                                <span class="text-sm">Table 12 - 8 pers.</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">23:45</span>
                            <div class="flex items-center">
                                <div class="priority-indicator priority-medium"></div>
                                <span class="text-sm">Table 7 - 4 pers.</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">00:15</span>
                            <div class="flex items-center">
                                <div class="priority-indicator priority-low"></div>
                                <span class="text-sm">Table 5 - 2 pers.</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        <span class="text-success">✓ Tables assignées</span>
                        <span class="text-primary">Détails</span>
                    </div>
                </div>
            <!-- Stock Status -->
                <div class="dashboard-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-sm text-gray-500 dark:text-gray-400">État des stocks</h3>
                            <div class="font-bold text-2xl mt-1">95%</div>
                            <div class="text-sm mt-1">
                                <span class="font-semibold text-danger">3 produits</span> en alerte
                            </div>
                        </div>
                        <div class="bg-warning bg-opacity-10 dark:bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-boxes text-warning text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm">Champagne Brut</span>
                            <div class="flex items-center">
                                <div class="w-24 stock-bar mr-2">
                                    <div class="stock-level stock-low" style="width: 15%"></div>
                                </div>
                                <span class="text-xs font-semibold">15%</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm">Filet de bœuf</span>
                            <div class="flex items-center">
                                <div class="w-24 stock-bar mr-2">
                                    <div class="stock-level stock-medium" style="width: 30%"></div>
                                </div>
                                <span class="text-xs font-semibold">30%</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm">Fromage bleu</span>
                            <div class="flex items-center">
                                <div class="w-24 stock-bar mr-2">
                                    <div class="stock-level stock-low" style="width: 10%"></div>
                                </div>
                                <span class="text-xs font-semibold">10%</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        <span class="text-danger">! Commande urgente nécessaire</span>
                        <span class="text-primary">Inventaire</span>
                    </div>
                </div>
        </div>

        <!-- Real-time Alerts and Planning -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            {{-- Contenu des alertes et du planning --}}
             <!-- Alerts System -->
                <div class="dashboard-card p-4 col-span-1">
                    <div class="widget-header">
                        <h2 class="flex items-center">
                            <i class="fas fa-bell-on text-warning mr-2"></i>
                            Alertes en temps réel
                        </h2>
                        <div class="flex items-center">
                            <div class="text-xs px-2 py-1 rounded bg-danger text-white">5 nouvelles</div>
                        </div>
                    </div>
                    <div class="alert-container">
                        <div class="alert-item alert-urgent">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle text-danger mt-1 mr-2"></i>
                                    <div>
                                        <h4 class="font-medium">Stock critique</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">Champagne Brut (2 bouteilles restantes)</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">il y a 5 min</div>
                            </div>
                            <div class="mt-2 flex justify-end space-x-2">
                                <button class="text-xs bg-danger text-white px-2 py-1 rounded hover:bg-red-600">Commander</button>
                                <button class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded">Ignorer</button>
                            </div>
                        </div>
                        
                        <div class="alert-item alert-urgent">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <i class="fas fa-user-clock text-danger mt-1 mr-2"></i>
                                    <div>
                                        <h4 class="font-medium">Absence non planifiée</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">Sophie Renaud (Serveur) - Maladie</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">il y a 25 min</div>
                            </div>
                            <div class="mt-2 flex justify-end space-x-2">
                                <button class="text-xs bg-primary text-white px-2 py-1 rounded hover:bg-blue-600">Remplacer</button>
                                <button class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded">Gérer</button>
                            </div>
                        </div>
                        
                        <div class="alert-item alert-normal">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <i class="fas fa-utensils text-warning mt-1 mr-2"></i>
                                    <div>
                                        <h4 class="font-medium">Temps d'attente élevé</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">Table 8 - Plat principal en attente depuis 18 min</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">il y a 2 min</div>
                            </div>
                            <div class="mt-2 flex justify-end">
                                <button class="text-xs bg-warning text-white px-2 py-1 rounded hover:bg-yellow-600">Vérifier</button>
                            </div>
                        </div>
                        
                        <div class="alert-item alert-normal">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <i class="fas fa-calendar-alt text-warning mt-1 mr-2"></i>
                                    <div>
                                        <h4 class="font-medium">Réservation groupe</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">12 personnes - Arrivée prévue dans 15 min</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">il y a 10 min</div>
                            </div>
                            <div class="mt-2 flex justify-end">
                                <button class="text-xs bg-info text-white px-2 py-1 rounded hover:bg-blue-600">Préparer</button>
                            </div>
                        </div>
                        
                        <div class="alert-item alert-info">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <i class="fas fa-comment-dots text-info mt-1 mr-2"></i>
                                    <div>
                                        <h4 class="font-medium">Nouveau message</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">De: Pierre (Chef) - "Problème avec le four"</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">il y a 12 min</div>
                            </div>
                            <div class="mt-2 flex justify-end">
                                <button class="text-xs bg-info text-white px-2 py-1 rounded hover:bg-blue-600">Répondre</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Staff Schedule -->
                <div class="dashboard-card p-4 col-span-2">
                    <div class="widget-header">
                        <h2 class="flex items-center">
                            <i class="fas fa-calendar-alt text-primary mr-2"></i>
                            Planning du personnel
                        </h2>
                        <div class="flex items-center space-x-2">
                            <button class="text-sm text-primary hover:text-primary-dark flex items-center">
                                <i class="fas fa-plus-circle mr-1"></i> Ajouter
                            </button>
                            <button class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center">
                                <i class="fas fa-filter mr-1"></i> Filtrer
                            </button>
                        </div>
                    </div>
                    <div class="flex mb-4 space-x-2">
                        <button class="text-xs bg-primary text-white px-3 py-1 rounded-full">Aujourd'hui</button>
                        <button class="text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600">Demain</button>
                        <button class="text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600">Cette semaine</button>
                        <button class="text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600">Vue mensuelle</button>
                    </div>
                    <div class="schedule-container">
                        <div class="grid grid-cols-3 mb-2">
                            <div class="p-2 bg-gray-100 dark:bg-gray-800 text-center font-medium text-sm rounded-lg mx-1">Matin (7h-14h)</div>
                            <div class="p-2 bg-gray-100 dark:bg-gray-800 text-center font-medium text-sm rounded-lg mx-1">Après-midi (14h-19h)</div>
                            <div class="p-2 bg-gray-100 dark:bg-gray-800 text-center font-medium text-sm rounded-lg mx-1">Soir (19h-00h)</div>
                        </div>
                        
                        <div class="grid grid-cols-3">
                            <!-- Morning Shift -->
                            <div class="staff-list bg-blue-50 dark:bg-blue-900/30 mx-1 rounded-lg" id="morning-shift">
                                <div class="staff-item shift-morning">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium mr-2">MB</div>
                                            <div>
                                                <p class="font-medium">Michel Bernard</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-300">Chef de rang</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 px-2 py-1 rounded">7h-14h</div>
                                    </div>
                                </div>
                                <div class="staff-item shift-morning">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium mr-2">JD</div>
                                            <div>
                                                <p class="font-medium">Julie Dubois</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-300">Serveuse</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 px-2 py-1 rounded">8h-15h</div>
                                    </div>
                                </div>
                                <div class="staff-item shift-morning">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium mr-2">PL</div>
                                            <div>
                                                <p class="font-medium">Pierre Lambert</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-300">Chef cuisinier</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 px-2 py-1 rounded">7h-14h</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Afternoon Shift -->
                            <div class="staff-list bg-amber-50 dark:bg-amber-900/30 mx-1 rounded-lg" id="afternoon-shift">
                                <div class="staff-item shift-afternoon">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-medium mr-2">LP</div>
                                            <div>
                                                <p class="font-medium">Luc Petit</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-300">Chef de rang</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-amber-100 dark:bg-amber-800 text-amber-700 dark:text-amber-300 px-2 py-1 rounded">14h-21h</div>
                                    </div>
                                </div>
                                <div class="staff-item shift-afternoon">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-medium mr-2">EM</div>
                                            <div>
                                                <p class="font-medium">Emma Martin</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-300">Serveuse</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-amber-100 dark:bg-amber-800 text-amber-700 dark:text-amber-300 px-2 py-1 rounded">14h-20h</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Evening Shift -->
                            <div class="staff-list bg-green-50 dark:bg-green-900/30 mx-1 rounded-lg" id="evening-shift">
                                <div class="staff-item shift-evening">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-medium mr-2">TD</div>
                                            <div>
                                                <p class="font-medium">Thomas Dubois</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-300">Chef de rang</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 px-2 py-1 rounded">18h-00h</div>
                                    </div>
                                </div>
                                <div class="staff-item shift-evening">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-medium mr-2">MS</div>
                                            <div>
                                                <p class="font-medium">Marie Strauss</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-300">Serveuse</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 px-2 py-1 rounded">18h-00h</div>
                                    </div>
                                </div>
                                <div class="staff-item shift-evening">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-medium mr-2">AM</div>
                                            <div>
                                                <p class="font-medium">Alex Martin</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-300">Barman</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 px-2 py-1 rounded">17h-00h</div>
                                    </div>
                                </div>
                                <div class="staff-item shift-evening">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-medium mr-2">SR</div>
                                            <div>
                                                <p class="font-medium line-through">Sophie Renaud</p>
                                                <p class="text-xs text-red-500">Absence - Maladie</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-300 px-2 py-1 rounded">19h-00h</div>
                                    </div>
                                </div>
                                <div class="staff-item border-dashed border-2 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 flex items-center justify-center p-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-plus text-gray-400 mr-2"></i>
                                    <span class="text-gray-500 dark:text-gray-400">Ajouter un remplaçant</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Stock Management and HR Module -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
             {{-- Contenu Stock et RH --}}
            <!-- Intelligent Stock Management -->
                <div class="dashboard-card p-4">
                    <div class="widget-header">
                        <h2 class="flex items-center">
                            <i class="fas fa-boxes text-warning mr-2"></i>
                            Gestion intelligente des stocks
                        </h2>
                        <div class="flex items-center">
                            <button class="text-sm text-warning hover:text-amber-700 dark:hover:text-amber-300 flex items-center">
                                <i class="fas fa-sync-alt mr-1"></i> Mettre à jour
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-4 flex items-center">
                        <div class="flex-1">
                            <input type="text" placeholder="Rechercher un produit" class="w-full p-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm">
                        </div>
                        <div class="ml-2">
                            <button class="p-2 bg-primary text-white rounded-lg">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Produit</th>
                                    <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Niveau</th>
                                    <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Seuil d'alerte</th>
                                    <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="priority-indicator priority-high"></div>
                                            <div>
                                                <p class="font-medium">Champagne Brut</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Boisson - Alcool</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="stock-bar w-24 mr-2">
                                                <div class="stock-level stock-low" style="width: 15%"></div>
                                            </div>
                                            <span>2 btl.</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="text-xs bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 font-semibold py-1 px-2 rounded">Auto: 5 btl.</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <button class="p-1 bg-primary text-white rounded">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            <button class="p-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="priority-indicator priority-high"></div>
                                            <div>
                                                <p class="font-medium">Filet de bœuf</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Viande - Fraîche</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="stock-bar w-24 mr-2">
                                                <div class="stock-level stock-medium" style="width: 30%"></div>
                                            </div>
                                            <span>3.4 kg</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="text-xs bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 font-semibold py-1 px-2 rounded">Auto: 5 kg</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <button class="p-1 bg-primary text-white rounded">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            <button class="p-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="priority-indicator priority-high"></div>
                                            <div>
                                                <p class="font-medium">Fromage bleu</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Produit laitier</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="stock-bar w-24 mr-2">
                                                <div class="stock-level stock-low" style="width: 10%"></div>
                                            </div>
                                            <span>0.8 kg</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="text-xs bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 font-semibold py-1 px-2 rounded">Auto: 3 kg</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <button class="p-1 bg-primary text-white rounded">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            <button class="p-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="priority-indicator priority-medium"></div>
                                            <div>
                                                <p class="font-medium">Truffe noire</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Condiment - Premium</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="stock-bar w-24 mr-2">
                                                <div class="stock-level stock-medium" style="width: 45%"></div>
                                            </div>
                                            <span>0.5 kg</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="text-xs bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 font-semibold py-1 px-2 rounded">Auto: 0.4 kg</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <button class="p-1 bg-primary text-white rounded">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            <button class="p-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="priority-indicator priority-low"></div>
                                            <div>
                                                <p class="font-medium">Riz arborio</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Céréale</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="stock-bar w-24 mr-2">
                                                <div class="stock-level stock-high" style="width: 80%"></div>
                                            </div>
                                            <span>8 kg</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 font-semibold py-1 px-2 rounded">Auto: 3 kg</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <button class="p-1 bg-primary text-white rounded opacity-50 cursor-not-allowed">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            <button class="p-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                            <span>Affichage de 5 produits sur 68</span>
                            <div class="flex items-center text-primary">
                                <span>Voir tout l'inventaire</span>
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-sm font-medium mb-2">À propos des seuils auto-calculés</div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Les seuils d'alerte sont ajustés automatiquement en fonction des tendances de consommation des 30 derniers jours et des réservations à venir.</p>
                    </div>
                </div>
            <!-- HR Module -->
                <div class="dashboard-card p-4">
                    <div class="widget-header">
                        <h2 class="flex items-center">
                            <i class="fas fa-user-tie text-secondary mr-2"></i>
                            Module RH
                        </h2>
                        <div class="flex items-center space-x-3">
                            <button class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                <i class="fas fa-chart-line mr-1"></i> Rapports
                            </button>
                            <button class="text-sm text-secondary hover:text-green-700 dark:hover:text-green-300">
                                <i class="fas fa-plus-circle mr-1"></i> Nouveau
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-4 flex flex-wrap gap-2">
                        <button class="text-xs bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-full dark:bg-opacity-20">Tous</button>
                        <button class="text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-600">En service</button>
                        <button class="text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-600">Congés</button>
                        <button class="text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-600">Formation</button>
                        <button class="text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-600">Problèmes</button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas Dubois" class="w-12 h-12 rounded-full object-cover mr-3">
                                    <div>
                                        <h3 class="font-medium">Thomas Dubois</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Chef de rang</p>
                                        <div class="mt-1">
                                            <span class="badge badge-green">En service</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Performance</div>
                                    <div class="font-bold text-green-500">97%</div>
                                    <div class="text-xs">↑ 4%</div>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                <div>Congés: 12j restants</div>
                                <div>Ancienneté: 3 ans</div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Marie Strauss" class="w-12 h-12 rounded-full object-cover mr-3">
                                    <div>
                                        <h3 class="font-medium">Marie Strauss</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Serveuse</p>
                                        <div class="mt-1">
                                            <span class="badge badge-green">En service</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Performance</div>
                                    <div class="font-bold text-green-500">94%</div>
                                    <div class="text-xs">↑ 2%</div>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                <div>Congés: 8j restants</div>
                                <div>Ancienneté: 2 ans</div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Sophie Renaud" class="w-12 h-12 rounded-full object-cover mr-3">
                                    <div>
                                        <h3 class="font-medium">Sophie Renaud</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Serveuse</p>
                                        <div class="mt-1">
                                            <span class="badge badge-red">Absente</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Performance</div>
                                    <div class="font-bold text-red-500">76%</div>
                                    <div class="text-xs">↓ 8%</div>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                <div>Congés: 15j restants</div>
                                <div>Ancienneté: 6 mois</div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Pierre Lambert" class="w-12 h-12 rounded-full object-cover mr-3">
                                    <div>
                                        <h3 class="font-medium">Pierre Lambert</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Chef cuisinier</p>
                                        <div class="mt-1">
                                            <span class="badge badge-blue">Formation</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Performance</div>
                                    <div class="font-bold text-green-500">90%</div>
                                    <div class="text-xs">↑ 1%</div>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                <div>Congés: 7j restants</div>
                                <div>Ancienneté: 5 ans</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Calendar component -->
                    <div class="mb-2 font-medium text-sm">Calendrier des congés et absences</div>
                    <div id="hr-calendar" class="hr-calendar bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 mb-4"></div>
                    
                    <div class="flex justify-between items-center">
                        <div class="text-xs text-gray-500 dark:text-gray-400">Demandes en attente: 3</div>
                        <button class="text-sm text-primary hover:text-primary-dark flex items-center">
                            <span>Gérer les demandes</span>
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </button>
                    </div>
                </div>
        </div>

        <!-- Encrypted Messaging and Tables Status -->
        <div class="grid grid-cols-1 lg:grid-cols-7 gap-6 mb-6">
             {{-- Contenu Plan de table --}}
            <!-- Tables Layout Status -->
                <div class="dashboard-card p-4 lg:col-span-7">
                    <div class="widget-header">
                        <h2 class="flex items-center">
                            <i class="fas fa-chair text-purple-500 mr-2"></i>
                            Plan des tables
                        </h2>
                        <div class="flex items-center">
                            <button class="text-xs bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 px-3 py-1 rounded-full">Vue temps réel</button>
                        </div>
                    </div>
                    
                    <div class="mb-4 flex flex-wrap gap-2">
                        <div class="flex items-center text-xs">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                            <span>Disponible</span>
                        </div>
                        <div class="flex items-center text-xs">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-1"></div>
                            <span>Occupée</span>
                        </div>
                        <div class="flex items-center text-xs">
                            <div class="w-3 h-3 rounded-full bg-amber-500 mr-1"></div>
                            <span>Commande en cours</span>
                        </div>
                        <div class="flex items-center text-xs">
                            <div class="w-3 h-3 rounded-full bg-red-500 mr-1"></div>
                            <span>Paiement en attente</span>
                        </div>
                        <div class="flex items-center text-xs">
                            <div class="w-3 h-3 rounded-full bg-purple-500 mr-1"></div>
                            <span>Réservée</span>
                        </div>
                    </div>
                    
                    <div class="relative overflow-auto p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800" style="height: 320px;">
                        <!-- Restaurant layout -->
                        <div class="min-w-[600px] h-full relative">
                            <!-- Tables -->
                            <div class="absolute left-[50px] top-[40px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-blue-500 bg-blue-100 dark:bg-blue-900">
                                <div>
                                    <div class="text-center font-bold">T1</div>
                                    <div class="text-xs">4 pers.</div>
                                </div>
                            </div>
                            
                            <div class="absolute left-[150px] top-[40px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-blue-500 bg-blue-100 dark:bg-blue-900">
                                <div>
                                    <div class="text-center font-bold">T2</div>
                                    <div class="text-xs">4 pers.</div>
                                </div>
                            </div>
                            
                            <div class="absolute left-[250px] top-[40px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-amber-500 bg-amber-100 dark:bg-amber-900">
                                <div>
                                    <div class="text-center font-bold">T3</div>
                                    <div class="text-xs">4 pers.</div>
                                </div>
                            </div>
                            
                            <div class="absolute left-[350px] top-[40px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-red-500 bg-red-100 dark:bg-red-900">
                                <div>
                                    <div class="text-center font-bold">T4</div>
                                    <div class="text-xs">4 pers.</div>
                                </div>
                            </div>
                            
                            <div class="absolute left-[50px] top-[140px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-blue-500 bg-blue-100 dark:bg-blue-900">
                                <div>
                                    <div class="text-center font-bold">T5</div>
                                    <div class="text-xs">2 pers.</div>
                                </div>
                            </div>
                            
                            <div class="absolute left-[150px] top-[140px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-green-500 bg-green-100 dark:bg-green-900">
                                <div>
                                    <div class="text-center font-bold">T6</div>
                                    <div class="text-xs">2 pers.</div>
                                </div>
                            </div>
                            
                            <div class="absolute left-[250px] top-[140px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-purple-500 bg-purple-100 dark:bg-purple-900">
                                <div>
                                    <div class="text-center font-bold">T7</div>
                                    <div class="text-xs">4 pers.</div>
                                </div>
                            </div>
                            
                            <!-- Bar area -->
                            <div class="absolute right-[50px] top-[40px] w-80 h-40 flex items-center justify-center border-4 border-gray-500 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <div class="text-center font-bold">BAR</div>
                                    <div class="mt-1 flex items-center justify-center space-x-2">
                                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kitchen area -->
                            <div class="absolute right-[50px] top-[180px] w-80 h-40 flex items-center justify-center border-4 border-gray-500 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <div class="text-center font-bold">CUISINE</div>
                                    <div class="text-xs text-center text-amber-500 mt-1">
                                        <i class="fas fa-fire"></i> 5 commandes en préparation
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Table 8 - Large -->
                            <div class="absolute left-[50px] bottom-[40px] w-[140px] h-[80px] flex items-center justify-center rounded-lg border-4 border-amber-500 bg-amber-100 dark:bg-amber-900">
                                <div>
                                    <div class="text-center font-bold">T8</div>
                                    <div class="text-xs">8 pers.</div>
                                </div>
                            </div>
                            
                            <!-- Tables 9-12 -->
                            <div class="absolute left-[250px] bottom-[40px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-green-500 bg-green-100 dark:bg-green-900">
                                <div>
                                    <div class="text-center font-bold">T9</div>
                                    <div class="text-xs">4 pers.</div>
                                </div>
                            </div>
                            
                            <div class="absolute left-[350px] bottom-[40px] w-20 h-20 flex items-center justify-center rounded-full border-4 border-red-500 bg-red-100 dark:bg-red-900">
                                <div>
                                    <div class="text-center font-bold">T10</div>
                                    <div class="text-xs">4 pers.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap justify-between gap-3">
                            <div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Tables occupées:</span>
                                <span class="font-medium">8/12</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Serveur assigné le plus chargé:</span>
                                <span class="font-medium">Thomas D. (5 tables)</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Table la plus longue:</span>
                                <span class="font-medium">T3 (86 min)</span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Footer (peut être un partial aussi) -->
            <footer class="mt-6 mb-4 text-gray-500 dark:text-gray-400 text-sm">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <p>&copy; 2025 OctoPOS. Tous droits réservés.</p>
                        <p>Version 3.4.2 | Dernière mise à jour: 2025-04-10</p>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary mx-2">Conditions d'utilisation</a>
                        <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary mx-2">Confidentialité</a>
                        <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary mx-2">Assistance</a>
                    </div>
                </div>
            </footer>
    </div>
@endsection

