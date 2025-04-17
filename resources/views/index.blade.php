@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <header class="pt-24 pb-12 gradient-background text-white relative overflow-hidden">
        <!-- Abstract shapes for background -->
        <div class="absolute -top-20 -right-10 w-64 h-64 rounded-full bg-white/10"></div>
        <div class="absolute top-40 -left-20 w-80 h-80 rounded-full bg-white/10"></div>
        <div class="absolute bottom-10 right-20 w-40 h-40 rounded-full bg-white/10"></div>

        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center relative z-10">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 fade-in">Bienvenue chez <span class="text-yellow-200">OctoPOS</span></h1>
                <p class="text-xl text-white/90 mb-6 fade-in">Système de Point de Vente moderne pour votre restaurant</p>
                <div class="flex space-x-4 fade-in">
                    <button class="bg-white text-[#0288D1] hover:bg-gray-100 px-6 py-3 rounded-md transition duration-300 flex items-center shadow-lg">
                        <i class="fas fa-book-open mr-2"></i> Voir le Menu
                    </button>
                    <button class="bg-[#4CAF50]/90 text-white hover:bg-[#4CAF50] backdrop-blur-sm px-6 py-3 rounded-md transition duration-300 flex items-center shadow-lg">
                        <i class="fas fa-chair mr-2"></i> Réserver une Table
                    </button>
                </div>
            </div>
            <div class="md:w-1/2">
                <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80"
                    alt="Restaurant Elegance"
                    class="w-full h-auto rounded-lg shadow-2xl fade-in transform rotate-1"
                    width="1050" height="700" loading="eager">
            </div>
        </div>
        <!-- Wave divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" aria-hidden="true">
                <path fill="#ffffff" fill-opacity="1" d="M0,32L48,53.3C96,75,192,117,288,117.3C384,117,480,75,576,64C672,53,768,75,864,80C960,85,1056,75,1152,69.3C1248,64,1344,64,1392,64L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>
    </header>

    <!-- About Us Section -->
    <section id="about" class="py-20 bg-white relative">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-4 fade-in">À propos de Nous</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#0288D1] to-[#4CAF50] mx-auto mb-12"></div>
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0 fade-in">
                    <div class="relative rounded-xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80"
                            alt="Notre Restaurant"
                            class="w-full h-auto rounded-xl"
                            width="1050" height="700" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 opacity-60 rounded-xl"></div>
                        <button class="absolute inset-0 m-auto w-20 h-20 bg-white rounded-full shadow-xl flex items-center justify-center group" aria-label="Play video">
                            <div class="relative w-16 h-16 flex items-center justify-center bg-gradient-to-r from-[#0288D1] to-[#4CAF50] rounded-full group-hover:from-[#4CAF50] group-hover:to-[#0288D1] transition-all duration-300">
                                <i class="fas fa-play text-white text-xl group-hover:scale-110 transition-transform"></i>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="md:w-1/2 md:pl-12 fade-in">
                    <span class="text-[#0288D1] font-semibold">Notre Histoire</span>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Une Passion pour la Gastronomie</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Fondé en 2020, notre restaurant est né d'une passion pour la cuisine authentique et l'innovation technologique.
                        Nous avons créé un environnement où la tradition culinaire rencontre la modernité du service,
                        offrant une expérience gastronomique inoubliable à nos clients.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Notre philosophie est simple : des ingrédients frais, des plats préparés avec amour,
                        et un service client exceptionnel grâce à notre système OctoPOS spécialement conçu pour optimiser
                        l'expérience des clients et le travail de nos équipes.
                    </p>
                    <button class="bg-white text-gray-800 border-2 border-[#0288D1] hover:bg-gradient-to-r hover:from-[#0288D1] hover:to-[#4CAF50] hover:text-white px-6 py-3 rounded-full transition duration-300 flex items-center shadow-md group">
                        <i class="fas fa-info-circle mr-2 group-hover:rotate-12 transition-transform"></i> En savoir plus
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-20 bg-gray-50 relative">
        <!-- Abstract background elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#0288D1]/5 rounded-bl-full"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#4CAF50]/5 rounded-tr-full"></div>

        <div class="container mx-auto px-4 relative z-10">
            <h2 class="text-3xl font-bold text-center mb-4 fade-in">Notre Menu</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#0288D1] to-[#4CAF50] mx-auto mb-8"></div>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto fade-in">
                Découvrez notre sélection de plats exquis, préparés avec des ingrédients frais et locaux par nos chefs talentueux.
            </p>

            <!-- Menu Categories -->
            <div class="flex flex-wrap justify-center mb-12 fade-in">
                <button class="menu-filter bg-gradient-to-r from-[#0288D1] to-[#026da8] text-white px-6 py-3 m-2 rounded-full shadow-md" data-category="all">
                    <i class="fas fa-utensils mr-1"></i> Tous
                </button>
                <button class="menu-filter bg-white text-gray-700 px-6 py-3 m-2 rounded-full shadow-md hover:bg-gray-100" data-category="appetizers">
                    <i class="fas fa-cheese mr-1"></i> Entrées
                </button>
                <button class="menu-filter bg-white text-gray-700 px-6 py-3 m-2 rounded-full shadow-md hover:bg-gray-100" data-category="main">
                    <i class="fas fa-drumstick-bite mr-1"></i> Plats Principaux
                </button>
                <button class="menu-filter bg-white text-gray-700 px-6 py-3 m-2 rounded-full shadow-md hover:bg-gray-100" data-category="desserts">
                    <i class="fas fa-ice-cream mr-1"></i> Desserts
                </button>
                <button class="menu-filter bg-white text-gray-700 px-6 py-3 m-2 rounded-full shadow-md hover:bg-gray-100" data-category="drinks">
                    <i class="fas fa-glass-martini-alt mr-1"></i> Boissons
                </button>
            </div>

            <!-- Menu Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Menu Item 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom menu-item fade-in" data-category="appetizers">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1546039907-7fa05f864c02?auto=format&fit=crop&w=500&q=60"
                            alt="Salade César" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                            width="500" height="300" loading="lazy">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-xl text-gray-800">Salade César</h3>
                            <span class="text-[#0288D1] font-bold text-lg">8,90 €</span>
                        </div>
                        <p class="text-gray-600 mb-6">Laitue romaine, croûtons, parmesan, poulet grillé et notre sauce César maison.</p>
                        <button class="w-full bg-gradient-to-r from-[#4CAF50] to-[#3d8b40] text-white py-3 rounded-lg transition duration-300 hover:from-[#3d8b40] hover:to-[#4CAF50] flex items-center justify-center shadow-md">
                            <i class="fas fa-cart-plus mr-2"></i> Ajouter au panier
                        </button>
                    </div>
                </div>

                <!-- Menu Item 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom menu-item fade-in" data-category="main">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=500&q=60"
                            alt="Pâtes Carbonara" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                            width="500" height="300" loading="lazy">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-xl text-gray-800">Pâtes Carbonara</h3>
                            <span class="text-[#0288D1] font-bold text-lg">14,50 €</span>
                        </div>
                        <p class="text-gray-600 mb-6">Pâtes fraîches, lardons, crème, œuf, parmesan et poivre noir fraîchement moulu.</p>
                        <button class="w-full bg-gradient-to-r from-[#4CAF50] to-[#3d8b40] text-white py-3 rounded-lg transition duration-300 hover:from-[#3d8b40] hover:to-[#4CAF50] flex items-center justify-center shadow-md">
                            <i class="fas fa-cart-plus mr-2"></i> Ajouter au panier
                        </button>
                    </div>
                </div>

                <!-- Menu Item 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom menu-item fade-in" data-category="desserts">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?auto=format&fit=crop&w=500&q=60"
                            alt="Cheesecake" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                            width="500" height="300" loading="lazy">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-xl text-gray-800">Cheesecake New-York</h3>
                            <span class="text-[#0288D1] font-bold text-lg">7,90 €</span>
                        </div>
                        <p class="text-gray-600 mb-6">Gâteau au fromage crémeux sur une base de biscuits Graham, avec coulis de fruits rouges.</p>
                        <button class="w-full bg-gradient-to-r from-[#4CAF50] to-[#3d8b40] text-white py-3 rounded-lg transition duration-300 hover:from-[#3d8b40] hover:to-[#4CAF50] flex items-center justify-center shadow-md">
                            <i class="fas fa-cart-plus mr-2"></i> Ajouter au panier
                        </button>
                    </div>
                </div>

                <!-- Menu Item 4 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom menu-item fade-in" data-category="drinks">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1527661591475-527312dd65f5?auto=format&fit=crop&w=500&q=60"
                            alt="Cocktail" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                            width="500" height="300" loading="lazy">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-xl text-gray-800">Mojito Classique</h3>
                            <span class="text-[#0288D1] font-bold text-lg">9,50 €</span>
                        </div>
                        <p class="text-gray-600 mb-6">Rhum blanc, menthe fraîche, citron vert, sirop de sucre et eau gazeuse.</p>
                        <button class="w-full bg-gradient-to-r from-[#4CAF50] to-[#3d8b40] text-white py-3 rounded-lg transition duration-300 hover:from-[#3d8b40] hover:to-[#4CAF50] flex items-center justify-center shadow-md">
                            <i class="fas fa-cart-plus mr-2"></i> Ajouter au panier
                        </button>
                    </div>
                </div>

                <!-- Menu Item 5 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom menu-item fade-in" data-category="main">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1565299507177-b0ac66763828?auto=format&fit=crop&w=500&q=60"
                            alt="Steak" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                            width="500" height="300" loading="lazy">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-xl text-gray-800">Entrecôte Grillée</h3>
                            <span class="text-[#0288D1] font-bold text-lg">22,90 €</span>
                        </div>
                        <p class="text-gray-600 mb-6">Entrecôte de bœuf grillée, servie avec frites maison et sauce au poivre.</p>
                        <button class="w-full bg-gradient-to-r from-[#4CAF50] to-[#3d8b40] text-white py-3 rounded-lg transition duration-300 hover:from-[#3d8b40] hover:to-[#4CAF50] flex items-center justify-center shadow-md">
                            <i class="fas fa-cart-plus mr-2"></i> Ajouter au panier
                        </button>
                    </div>
                </div>

                <!-- Menu Item 6 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom menu-item fade-in" data-category="appetizers">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1626700051175-6818013e1d4f?auto=format&fit=crop&w=500&q=60"
                            alt="Bruschetta" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                            width="500" height="300" loading="lazy">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-xl text-gray-800">Bruschetta Tomate</h3>
                            <span class="text-[#0288D1] font-bold text-lg">6,90 €</span>
                        </div>
                        <p class="text-gray-600 mb-6">Pain grillé à l'ail, tomates fraîches, basilic, huile d'olive et réduction balsamique.</p>
                        <button class="w-full bg-gradient-to-r from-[#4CAF50] to-[#3d8b40] text-white py-3 rounded-lg transition duration-300 hover:from-[#3d8b40] hover:to-[#4CAF50] flex items-center justify-center shadow-md">
                            <i class="fas fa-cart-plus mr-2"></i> Ajouter au panier
                        </button>
                    </div>
                </div>
            </div>

            <div class="text-center mt-16">
                <button class="bg-gradient-to-r from-[#0288D1] to-[#026da8] text-white hover:from-[#026da8] hover:to-[#0288D1] px-8 py-3 rounded-full transition duration-300 fade-in shadow-lg">
                    <i class="fas fa-utensils mr-2"></i> Voir tout le menu
                </button>
            </div>
        </div>
    </section>
    <section id="tables" class="py-20 bg-gradient-to-br from-blue-50 to-green-50 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-20 left-10 w-72 h-72 rounded-full bg-gradient-to-r from-[#0288D1]/10 to-[#4CAF50]/10 opacity-50 blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 rounded-full bg-gradient-to-r from-[#0288D1]/10 to-[#4CAF50]/10 opacity-50 blur-3xl"></div>
    
        <div class="container mx-auto px-4 relative z-10">
            <h2 class="text-4xl font-bold text-center mb-4 fade-in bg-gradient-to-r from-[#0288D1] to-[#4CAF50] bg-clip-text text-transparent">Choisissez votre Table</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#0288D1] to-[#4CAF50] mx-auto mb-8"></div>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto fade-in">
                Réservez l'emplacement idéal pour votre expérience culinaire grâce à notre système interactif de sélection de table.
            </p>
    
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-8 max-w-5xl mx-auto fade-in">
               
                <div class="flex flex-wrap justify-between items-center mb-8">
                    <div class="flex flex-wrap items-center gap-4 mb-4 sm:mb-0">
                        <form id="restaurant-filter-form" action="{{ route(name: 'home') }}#tables" method="GET" class="flex flex-wrap gap-4 items-center">
                            <div class="relative">
                                <label for="restaurant-select" class="sr-only">Filtrer par restaurant</label>
                                <select id="restaurant-select" name="restaurant" onchange="this.form.submit()" class="appearance-none pl-4 pr-10 py-2 bg-gray-50 text-gray-700 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0288D1] transition">
                                    <option value="">Tous les restaurants</option>
                                    @foreach($restaurantNames as $id => $name)
                                        <option value="{{ $id }}" {{ $restaurantFilter == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-[#0288D1] text-xs"></i>
                                </div>
                            </div>
                            <!-- Reset link if filter is applied -->
                            @if($restaurantFilter)
                                <a href="{{ route('home') }}#tables" class="px-4 py-2 text-[#0288D1] hover:underline transition">
                                    <i class="fas fa-times-circle mr-1"></i> Réinitialiser
                                </a>
                            @endif
                        </form>
                        
                        <div class="relative">
                            <label for="date-select" class="sr-only">Sélectionner une date</label>
                            <select id="date-select" class="appearance-none pl-4 pr-10 py-2 bg-gray-50 text-gray-700 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0288D1] transition">
                                <option>Aujourd'hui</option>
                                <option>Demain</option>
                                <option>11 Avril 2025</option>
                                <option>12 Avril 2025</option>
                                <option selected>9 Avril 2025</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-[#0288D1] text-xs"></i>
                            </div>
                        </div>
    
                        <div class="relative">
                            <label for="persons-select" class="sr-only">Nombre de personnes</label>
                            <select id="persons-select" name="persons" class="appearance-none pl-4 pr-10 py-2 bg-gray-50 text-gray-700 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0288D1] transition">
                                <option value="1">1 personne</option>
                                <option value="2" selected>2 personnes</option>
                                <option value="3">3 personnes</option>
                                <option value="4">4 personnes</option>
                                <option value="5">5 personnes</option>
                                <option value="6">6 personnes</option>
                                <option value="7">7 personnes</option>
                                <option value="8">8 personnes</option>
                                <option value="9+">9+ personnes</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-[#0288D1] text-xs"></i>
                            </div>
                        </div>
                    </div>
    
                    <div class="flex gap-4">
                        <div class="flex items-center" aria-label="Table disponible">
                            <div class="w-4 h-4 rounded-full bg-gradient-to-br from-[#4CAF50] to-[#2E7D32] mr-2 shadow-sm"></div>
                            <span class="text-sm font-medium">Disponible</span>
                        </div>
                        <div class="flex items-center" aria-label="Table occupée">
                            <div class="w-4 h-4 rounded-full bg-gradient-to-br from-[#F44336] to-[#C62828] mr-2 shadow-sm"></div>
                            <span class="text-sm font-medium">Occupée</span>
                        </div>
                    </div>
                </div>
    
                <!-- Tabs -->
                <div class="flex border-b border-gray-200 mb-8" role="tablist">
                    <button class="py-3 px-6 border-b-2 border-[#0288D1] text-[#0288D1] font-medium" role="tab" aria-selected="true">Vue plan</button>
                    <button class="py-3 px-6 text-gray-500 hover:text-[#0288D1] transition" role="tab" aria-selected="false">Vue liste</button>
                    <button class="py-3 px-6 text-gray-500 hover:text-[#0288D1] transition" role="tab" aria-selected="false">Recommandations</button>
                </div>
    
                <!-- Restaurant Map Layout -->
                <div class="w-full bg-gray-50 rounded-xl p-6 relative mb-10" style="min-height: 520px;">
                    <!-- Restaurant Sections -->
                    <div class="flex flex-col gap-8">
                        
                        <!-- Main Dining Area - SallePrincipale -->
                        <div class="bg-white/80 p-6 rounded-xl shadow-md">
                            <h4 class="text-lg font-bold mb-4 text-gray-800 flex items-center">
                                <span class="w-8 h-8 bg-gradient-to-r from-[#0288D1] to-[#026da8] rounded-lg text-white flex items-center justify-center mr-2">
                                    <i class="fas fa-utensils text-xs" aria-hidden="true"></i>
                                </span>
                                Salle Principale
                            </h4>
    
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @if(isset($tablesByType['SallePrincipale']))
                                    @php
                                        $mainTables = $tablesByType['SallePrincipale'];
                                        $hasMainTables = count($mainTables['available']) > 0 || count($mainTables['unavailable']) > 0;
                                    @endphp
                                    
                                    <!-- Available Tables -->
                                    @foreach($mainTables['available'] as $table)
                                        <button class="table-item table-available rounded-xl overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-lg cursor-pointer text-left" data-table="{{ $table->id }}">
                                            <div class="h-full p-4 flex flex-col justify-between">
                                                <div class="flex justify-between items-start">
                                                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs py-1 px-2 rounded-full">{{ $table->capacite }} pers.</span>
                                                    <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                        <i class="fas fa-chair text-white text-xs" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-end justify-between">
                                                    <div>
                                                        <div class="text-white/80 text-xs">Table</div>
                                                        <div class="text-white font-bold text-lg">{{ str_pad($table->numero, 2, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                    <div class="bg-white/20 backdrop-blur-sm h-8 w-8 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-check text-white" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
    
                                    <!-- Unavailable Tables -->
                                    @foreach($mainTables['unavailable'] as $table)
                                        <div class="table-item table-occupied rounded-xl overflow-hidden transition-all duration-300 text-left" data-table="{{ $table->id }}" aria-label="Table {{ $table->numero }} - Occupée" role="button" aria-disabled="true">
                                            <div class="h-full p-4 flex flex-col justify-between">
                                                <div class="flex justify-between items-start">
                                                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs py-1 px-2 rounded-full">{{ $table->capacite }} pers.</span>
                                                    <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                        <i class="fas fa-chair text-white text-xs" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-end justify-between">
                                                    <div>
                                                        <div class="text-white/80 text-xs">Table</div>
                                                        <div class="text-white font-bold text-lg">{{ str_pad($table->numero, 2, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                    <div class="bg-white/20 backdrop-blur-sm h-8 w-8 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-lock text-white" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Message for no tables - Removed 'hidden' class when there are no tables -->
                                    <div class="msg1 {{ $hasMainTables ? 'hidden' : '' }} col-span-4 text-center py-6 text-gray-500">
                                        <p>Aucune table disponible dans cette section</p>
                                    </div>
                                @else
                                    <div class="col-span-4 text-center py-6 text-gray-500">
                                        <p>Aucune table disponible dans cette section</p>
                                    </div>
                                @endif
                            </div>
                        </div>
    
                        <!-- VIP Section -->
                        <div class="bg-white/80 p-6 rounded-xl shadow-md">
                            <h4 class="text-lg font-bold mb-4 text-gray-800 flex items-center">
                                <span class="w-8 h-8 bg-gradient-to-r from-[#FFC107] to-[#FF9800] rounded-lg text-white flex items-center justify-center mr-2">
                                    <i class="fas fa-crown text-xs" aria-hidden="true"></i>
                                </span>
                                Espace VIP
                            </h4>
    
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @if(isset($tablesByType['Vip']))
                                    @php
                                        $vipTables = $tablesByType['Vip'];
                                        $hasVipTables = count($vipTables['available']) > 0 || count($vipTables['unavailable']) > 0;
                                    @endphp
                                    
                                    <!-- Available Tables -->
                                    @foreach($vipTables['available'] as $table)
                                        <button class="table-item table-available rounded-xl overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-lg cursor-pointer text-left" data-table="{{ $table->id }}" style="background: linear-gradient(135deg, #FFC107 0%, #FF9800 100%);">
                                            <div class="h-full p-4 flex flex-col justify-between">
                                                <div class="flex justify-between items-start">
                                                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs py-1 px-2 rounded-full">{{ $table->capacite }} pers.</span>
                                                    <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                        <i class="fas fa-star text-white text-xs" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-end justify-between">
                                                    <div>
                                                        <div class="text-white/80 text-xs">VIP</div>
                                                        <div class="text-white font-bold text-lg">{{ str_pad($table->numero, 2, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                    <div class="bg-white/20 backdrop-blur-sm h-8 w-8 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-check text-white" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
    
                                    <!-- Unavailable Tables -->
                                    @foreach($vipTables['unavailable'] as $table)
                                        <div class="table-item table-occupied rounded-xl overflow-hidden transition-all duration-300 text-left" data-table="{{ $table->id }}" aria-label="Table VIP {{ $table->numero }} - Occupée" role="button" aria-disabled="true">
                                            <div class="h-full p-4 flex flex-col justify-between">
                                                <div class="flex justify-between items-start">
                                                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs py-1 px-2 rounded-full">{{ $table->capacite }} pers.</span>
                                                    <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                        <i class="fas fa-star text-white text-xs" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-end justify-between">
                                                    <div>
                                                        <div class="text-white/80 text-xs">VIP</div>
                                                        <div class="text-white font-bold text-lg">{{ str_pad($table->numero, 2, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                    <div class="bg-white/20 backdrop-blur-sm h-8 w-8 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-lock text-white" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Message for no VIP tables - Removed 'hidden' class when there are no tables -->
                                    <div class="msg2 {{ $hasVipTables ? 'hidden' : '' }} col-span-4 text-center py-6 text-gray-500">
                                        <p>Aucune table VIP disponible</p>
                                    </div>
                                @else
                                    <div class="col-span-4 text-center py-6 text-gray-500">
                                        <p>Aucune table VIP disponible</p>
                                    </div>
                                @endif 
                            </div>
                        </div>
    
                        <!-- Terrace Section -->
                        <div class="bg-white/80 p-6 rounded-xl shadow-md">
                            <h4 class="text-lg font-bold mb-4 text-gray-800 flex items-center">
                                <span class="w-8 h-8 bg-gradient-to-r from-[#0288D1] to-[#03A9F4] rounded-lg text-white flex items-center justify-center mr-2">
                                    <i class="fas fa-umbrella-beach text-xs" aria-hidden="true"></i>
                                </span>
                                Terrasse
                            </h4>
    
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @if(isset($tablesByType['Terrasse']))
                                    @php
                                        $terraceTables = $tablesByType['Terrasse'];
                                        $hasTerracesTables = count($terraceTables['available']) > 0 || count($terraceTables['unavailable']) > 0;
                                    @endphp
                                    
                                    <!-- Available Tables -->
                                    @foreach($terraceTables['available'] as $table)
                                        <button class="table-item table-available rounded-xl overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-lg cursor-pointer text-left" data-table="{{ $table->id }}">
                                            <div class="h-full p-4 flex flex-col justify-between">
                                                <div class="flex justify-between items-start">
                                                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs py-1 px-2 rounded-full">{{ $table->capacite }} pers.</span>
                                                    <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                        <i class="fas fa-leaf text-white text-xs" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-end justify-between">
                                                    <div>
                                                        <div class="text-white/80 text-xs">Terrasse</div>
                                                        <div class="text-white font-bold text-lg">{{ str_pad($table->numero, 2, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                    <div class="bg-white/20 backdrop-blur-sm h-8 w-8 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-check text-white" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
    
                                    <!-- Unavailable Tables -->
                                    @foreach($terraceTables['unavailable'] as $table)
                                        <div class="table-item table-occupied rounded-xl overflow-hidden transition-all duration-300 text-left" data-table="{{ $table->id }}" aria-label="Table Terrasse {{ $table->numero }} - Occupée" role="button" aria-disabled="true">
                                            <div class="h-full p-4 flex flex-col justify-between">
                                                <div class="flex justify-between items-start">
                                                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs py-1 px-2 rounded-full">{{ $table->capacite }} pers.</span>
                                                    <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                        <i class="fas fa-leaf text-white text-xs" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-end justify-between">
                                                    <div>
                                                        <div class="text-white/80 text-xs">Terrasse</div>
                                                        <div class="text-white font-bold text-lg">{{ str_pad($table->numero, 2, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                    <div class="bg-white/20 backdrop-blur-sm h-8 w-8 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-lock text-white" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Message for no terrace tables - Removed 'hidden' class when there are no tables -->
                                    <div class="msg3 {{ $hasTerracesTables ? 'hidden' : '' }} col-span-4 text-center py-6 text-gray-500">
                                        <p>Aucune table en terrasse disponible</p>
                                    </div>
                                @else
                                    <div class="col-span-4 text-center py-6 text-gray-500">
                                        <p>Aucune table en terrasse disponible</p>
                                    </div>
                                @endif
                            </div>
                        </div>
>>>>>>> 02be7b8243577327ebc4a3ae61381b7d3ce96293
                    </div>
                </div>
    
                <!-- Bottom Actions -->
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="" class="px-6 py-3 bg-white text-gray-700 rounded-full shadow-md hover:shadow-lg transition flex items-center border border-gray-200">
                        <i class="fas fa-list mr-2 text-[#0288D1]" aria-hidden="true"></i> Voir toutes les tables
                    </a>
                    <a href="" class="px-6 py-3 bg-gradient-to-r from-[#0288D1] to-[#026da8] text-white rounded-full shadow-md hover:shadow-lg transition hover:from-[#026da8] hover:to-[#0288D1] flex items-center">
                        <i class="fas fa-calendar-check mr-2" aria-hidden="true"></i> Réserver maintenant
                    </a>
                </div>
            </div>
        </div> 
    </section>
    
   
    <!-- Our Chefs Section -->
    <section id="chefs" class="py-20 bg-gray-50 relative">
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-white to-transparent"></div>

        <div class="container mx-auto px-4 relative z-10">
            <h2 class="text-3xl font-bold text-center mb-4 fade-in">Nos Chefs Talentueux</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#0288D1] to-[#4CAF50] mx-auto mb-8"></div>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto fade-in">
                Découvrez les artistes culinaires qui rendent chaque plat exceptionnel grâce à leur créativité et expertise.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Chef 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom fade-in">
                    <div class="h-72 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=500&q=60"
                             alt="Chef Michel Dubois" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                             width="500" height="400" loading="lazy">
                    </div>
                    <div class="p-8">
                        <h3 class="font-bold text-2xl mb-2 text-gray-800">Chef Michel Dubois</h3>
                        <p class="bg-gradient-to-r from-[#0288D1] to-[#026da8] bg-clip-text text-transparent font-semibold mb-4 text-lg">Chef Exécutif</p>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Avec 20 ans d'expérience dans les restaurants étoilés, le Chef Michel apporte un savoir-faire unique à notre cuisine.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-drumstick-bite mr-2" aria-hidden="true"></i> Viandes
                            </div>
                            <div class="bg-blue-100 text-blue-600 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-fish mr-2" aria-hidden="true"></i> Poissons
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chef 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom fade-in">
                    <div class="h-72 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1581299894007-aaa50297cf16?auto=format&fit=crop&w=500&q=60"
                             alt="Chef Sophie Martin" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                             width="500" height="400" loading="lazy">
                    </div>
                    <div class="p-8">
                        <h3 class="font-bold text-2xl mb-2 text-gray-800">Chef Sophie Martin</h3>
                        <p class="bg-gradient-to-r from-[#0288D1] to-[#026da8] bg-clip-text text-transparent font-semibold mb-4 text-lg">Chef Pâtissière</p>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Formée à l'école de pâtisserie de Paris, Sophie crée des desserts qui sont de véritables œuvres d'art.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-birthday-cake mr-2" aria-hidden="true"></i> Pâtisserie
                            </div>
                            <div class="bg-purple-100 text-purple-600 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-ice-cream mr-2" aria-hidden="true"></i> Desserts glacés
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chef 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom fade-in">
                    <div class="h-72 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1622021142947-da7dedc7c39a?auto=format&fit=crop&w=500&q=60"
                             alt="Chef Carlos Rodriguez" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                             width="500" height="400" loading="lazy">
                    </div>
                    <div class="p-8">
                        <h3 class="font-bold text-2xl mb-2 text-gray-800">Chef Carlos Rodriguez</h3>
                        <p class="bg-gradient-to-r from-[#0288D1] to-[#026da8] bg-clip-text text-transparent font-semibold mb-4 text-lg">Chef de Cuisine</p>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Spécialiste de la cuisine fusion, Carlos mélange habilement les saveurs du monde entier dans ses créations.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-seedling mr-2" aria-hidden="true"></i> Cuisine végétarienne
                            </div>
                            <div class="bg-orange-100 text-orange-600 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-pepper-hot mr-2" aria-hidden="true"></i> Cuisine épicée
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





















    <!-- Contact Section -->
    <section id="contact" class="py-20 gradient-background text-white relative">
        <!-- Wave divider top -->
        <div class="absolute top-0 left-0 right-0 transform rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" aria-hidden="true">
                <path fill="#f9fafb" fill-opacity="1" d="M0,96L48,85.3C96,75,192,53,288,48C384,43,480,53,576,69.3C672,85,768,107,864,101.3C960,96,1056,64,1152,48C1248,32,1344,32,1392,32L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>

        <div class="container mx-auto px-4 relative z-10 mt-12">
            <h2 class="text-3xl font-bold text-center mb-4 fade-in">Contactez-nous</h2>
            <div class="w-24 h-1 bg-white mx-auto mb-8"></div>
            <div class="flex flex-col lg:flex-row">
                <!-- Contact Form -->
                <div class="lg:w-1/2 lg:pr-8 mb-8 lg:mb-0 fade-in">
                    <form id="contact-form" class="bg-white/10 backdrop-blur-lg p-8 rounded-xl shadow-xl">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-white text-sm font-semibold mb-2" for="contact-name">Nom complet</label>
                            <div class="relative">
                                <input class="w-full px-4 py-3 pl-10 bg-white/20 border border-white/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/50 text-white placeholder-white/70"
                                       type="text" id="contact-name" placeholder="Votre nom">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-white/70" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-white text-sm font-semibold mb-2" for="contact-email">Email</label>
                            <div class="relative">
                                <input class="w-full px-4 py-3 pl-10 bg-white/20 border border-white/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/50 text-white placeholder-white/70"
                                       type="email" id="contact-email" placeholder="votre@email.com">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-white/70" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-white text-sm font-semibold mb-2" for="contact-subject">Sujet</label>
                            <div class="relative">
                                <input class="w-full px-4 py-3 pl-10 bg-white/20 border border-white/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/50 text-white placeholder-white/70"
                                       type="text" id="contact-subject" placeholder="Sujet de votre message">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-white/70" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-white text-sm font-semibold mb-2" for="contact-message">Message</label>
                            <div class="relative">
                                <textarea class="w-full px-4 py-3 pl-10 bg-white/20 border border-white/30 rounded-lg h-32 resize-none focus:outline-none focus:ring-2 focus:ring-white/50 text-white placeholder-white/70"
                                          id="contact-message" placeholder="Votre message..."></textarea>
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <i class="fas fa-comment-alt text-white/70" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="send-message" class="w-full bg-white text-[#0288D1] hover:bg-gray-100 py-3 rounded-lg transition duration-300 flex items-center justify-center shadow-lg font-semibold">
                            <i class="fas fa-paper-plane mr-2" aria-hidden="true"></i> Envoyer le message
                        </button>
                    </form>

                    <!-- Success Message -->
                    <div id="contact-success" class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg flex items-center fade-in hidden" role="alert">
                        <i class="fas fa-check-circle text-xl mr-2" aria-hidden="true"></i>
                        <span>Merci pour votre message ! Nous vous répondrons dans les plus brefs délais.</span>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="lg:w-1/2 lg:pl-8 fade-in">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Contact Card 1 -->
                        <div class="contact-card bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
                            <div class="rounded-full bg-white/20 w-14 h-14 flex items-center justify-center mb-4">
                                <i class="fas fa-map-marker-alt text-2xl" aria-hidden="true"></i>
                            </div>
                            <h4 class="font-bold text-lg mb-2">Adresse</h4>
                            <address class="text-white/90 not-italic">
                                123 Avenue de la Gastronomie<br>75001 Paris, France
                            </address>
                        </div>

                        <!-- Contact Card 2 -->
                        <div class="contact-card bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
                            <div class="rounded-full bg-white/20 w-14 h-14 flex items-center justify-center mb-4">
                                <i class="fas fa-phone-alt text-2xl" aria-hidden="true"></i>
                            </div>
                            <h4 class="font-bold text-lg mb-2">Téléphone</h4>
                            <p class="text-white/90">
                                <a href="tel:+33123456789" class="hover:text-white transition-colors">+33 1 23 45 67 89</a>
                            </p>
                        </div>

                        <!-- Contact Card 3 -->
                        <div class="contact-card bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
                            <div class="rounded-full bg-white/20 w-14 h-14 flex items-center justify-center mb-4">
                                <i class="fas fa-envelope text-2xl" aria-hidden="true"></i>
                            </div>
                            <h4 class="font-bold text-lg mb-2">Email</h4>
                            <p class="text-white/90">
                                <a href="mailto:contact@octopos.com" class="hover:text-white transition-colors">contact@octopos.com</a>
                            </p>
                        </div>

                        <!-- Contact Card 4 -->
                        <div class="contact-card bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
                            <div class="rounded-full bg-white/20 w-14 h-14 flex items-center justify-center mb-4">
                                <i class="fas fa-clock text-2xl" aria-hidden="true"></i>
                            </div>
                            <h4 class="font-bold text-lg mb-2">Heures d'ouverture</h4>
                            <p class="text-white/90">Lun - Ven : 11h00 - 22h00<br>Sam - Dim : 10h00 - 23h00</p>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
                        <h4 class="font-bold text-lg mb-4">Notre localisation</h4>
                        <div id="map" class="rounded-lg overflow-hidden h-[300px] shadow-lg"></div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="mt-16 text-center">
                <h4 class="font-bold text-xl mb-6">Suivez-nous sur les réseaux sociaux</h4>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="bg-white/10 backdrop-blur-lg text-white hover:bg-white/30 w-14 h-14 rounded-full flex items-center justify-center hover:scale-110 transition duration-300 shadow-lg" aria-label="Facebook">
                        <i class="fab fa-facebook-f text-xl" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="bg-white/10 backdrop-blur-lg text-white hover:bg-white/30 w-14 h-14 rounded-full flex items-center justify-center hover:scale-110 transition duration-300 shadow-lg" aria-label="Instagram">
                        <i class="fab fa-instagram text-xl" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="bg-white/10 backdrop-blur-lg text-white hover:bg-white/30 w-14 h-14 rounded-full flex items-center justify-center hover:scale-110 transition duration-300 shadow-lg" aria-label="Twitter">
                        <i class="fab fa-twitter text-xl" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="bg-white/10 backdrop-blur-lg text-white hover:bg-white/30 w-14 h-14 rounded-full flex items-center justify-center hover:scale-110 transition duration-300 shadow-lg" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in text-xl" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

       
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" aria-hidden="true">
                <path fill="#1f2937" fill-opacity="1" d="M0,32L48,48C96,64,192,96,288,96C384,96,480,64,576,48C672,32,768,32,864,48C960,64,1056,96,1152,101.3C1248,107,1344,85,1392,74.7L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>
    </section>
@endsection

@section('styles')
<style>
    /* Table styles */
    .table-item {
        height: 140px;
        background: linear-gradient(135deg, #0288D1 0%, #026da8 100%);
    }
    
    .table-occupied {
        background: linear-gradient(135deg, #F44336 0%, #C62828 100%) !important;
        opacity: 0.8;
        cursor: not-allowed;
    }
    
    /* Animations */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle table selection
        const tables = document.querySelectorAll('.table-available');
        tables.forEach(table => {
            table.addEventListener('click', function() {
                const tableId = this.getAttribute('data-table');
                // You can redirect to reservation form with table ID
                // window.location.href = `/reservations/create?table_id=${tableId}`;
                
                // Or toggle selection state
                tables.forEach(t => t.classList.remove('ring-4', 'ring-white'));
                this.classList.add('ring-4', 'ring-white');
            });
        });
    });
</script>
@endsection