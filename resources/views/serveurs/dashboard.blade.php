@extends('layouts.serveur')

@section('title', 'OctoPOS | Interface Serveur')

@section('content')

    <!-- Tabs Navigation -->
    <div class="tabs" role="tablist" aria-label="Navigation principale">
        <button class="tab" role="tab" aria-selected="true" aria-controls="tables-tab" data-tab="tables" id="tab-tables">
            <i class="fas fa-th-large" aria-hidden="true"></i> Tables
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="orders-tab" data-tab="orders" id="tab-orders" tabindex="-1">
            <i class="fas fa-utensils" aria-hidden="true"></i> Commande
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="payment-tab" data-tab="payment" id="tab-payment" tabindex="-1">
            <i class="fas fa-cash-register" aria-hidden="true"></i> Paiement
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="receipt-tab" data-tab="receipt" id="tab-receipt" tabindex="-1">
            <i class="fas fa-receipt" aria-hidden="true"></i> Tickets
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="stats-tab" data-tab="stats" id="tab-stats" tabindex="-1">
            <i class="fas fa-chart-line" aria-hidden="true"></i> Stats
        </button>
    </div>

    <!-- Main Content Area (Tab Panels) -->
    <div class="main-content">

        {{-- NOUVELLE SECTION TABLES-TAB INTÉGRÉE --}}
        <div id="tables-tab" class="tab-content" role="tabpanel" aria-labelledby="tab-tables">
            <div class="table-controls">
                <div class="view-toggle" role="group" aria-label="Changer la vue des tables">
                    <button class="view-btn active" aria-pressed="true" aria-label="Vue grille">
                        <i class="fas fa-th-large" aria-hidden="true"></i>
                    </button>
                    <button class="view-btn" aria-pressed="false" aria-label="Vue liste">
                        <i class="fas fa-list" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="status-legend" aria-label="Légende des statuts de table">
                    <div class="status-item"><div class="status-color color-free"></div><span>Libre</span></div>
                    <div class="status-item"><div class="status-color color-occupied"></div><span>Occupée</span></div>
                    <div class="status-item"><div class="status-color color-reserved"></div><span>Réservée</span></div>
                </div>
            </div>

            {{-- Affiche le nom du restaurant s'il est sélectionné --}}
            @if(isset($selectedRestaurant) && $selectedRestaurant)
                <div class="restaurant-heading">
                    <h2>{{ $selectedRestaurant->nom }}</h2>
                </div>
            @endif

            <div class="tables-grid">
                {{-- Vérifie si les tables existent et s'il y en a au moins une --}}
                @if(isset($tables) && count($tables) > 0)
                    {{-- Boucle sur chaque table --}}
                    @foreach($tables as $table)
                        @php
                            // Définit la classe CSS et l'aria-label en fonction du statut
                            $statusClass = '';
                            $ariaLabel = "Table {$table->numero}, {$table->capacite} personnes, ";

                            if($table->status === 'libre') {
                                $statusClass = 'table-free';
                                $ariaLabel .= 'Libre';
                            } elseif($table->status === 'occupee') {
                                $statusClass = 'table-occupied';
                                // Ajoute le temps d'occupation s'il existe
                                $occupationTime = $table->occupation_time ?? 'N/A';
                                $ariaLabel .= "Occupée depuis {$occupationTime} minutes";
                                // Ajoute la classe 'urgent' si nécessaire
                                if(!empty($table->is_urgent)) { // Utilise !empty pour vérifier si la propriété existe et est vraie
                                    $statusClass .= ' table-urgent';
                                    $ariaLabel .= ', Urgent';
                                }
                            } elseif($table->status === 'reservee') {
                                $statusClass = 'table-reserved';
                                // Ajoute l'heure de réservation si elle existe
                                $reservationTime = $table->reservation_time ? \Carbon\Carbon::parse($table->reservation_time)->format('H:i') : 'N/A';
                                $ariaLabel .= "Réservée pour {$reservationTime}";
                            }

                            // Ajoute le type de table à l'aria-label s'il existe
                            if(!empty($table->typeTable)) {
                                $ariaLabel .= ", Type: {$table->typeTable}";
                            }
                        @endphp

                        <div class="table-item {{ $statusClass }}" data-table="{{ $table->id }}" tabindex="0" role="button" aria-label="{{ $ariaLabel }}">
                            <div class="table-number">T{{ $table->numero }}</div>
                            <div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> {{ $table->capacite }}</div>

                            {{-- Affiche le temps si occupée --}}
                            @if($table->status === 'occupee' && isset($table->occupation_time))
                                <div class="table-time"><i class="fas fa-clock" aria-hidden="true"></i> {{ $table->occupation_time }} min</div>
                            {{-- Affiche l'heure de réservation si réservée --}}
                            @elseif($table->status === 'reservee' && $table->reservation_time)
                                <div class="table-time"><i class="fas fa-calendar-alt" aria-hidden="true"></i> {{ \Carbon\Carbon::parse($table->reservation_time)->format('H:i') }}</div>
                            @endif

                            {{-- Affiche le type de table s'il existe --}}
                            @if(!empty($table->typeTable))
                                <div class="table-type" style="font-size: 0.8em; margin-top: 5px; color: var(--text-muted);">{{ $table->typeTable }}</div>
                            @endif
                        </div>
                    @endforeach
                {{-- Message si aucun restaurant n'est sélectionné --}}
                @elseif(!isset($selectedRestaurant) || !$selectedRestaurant)
                    <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">
                        <i class="fas fa-utensils" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                        <p>Veuillez sélectionner un restaurant pour afficher les tables.</p> {{-- Message mis à jour --}}
                    </div>
                {{-- Message si le restaurant sélectionné n'a pas de tables --}}
                @else
                    <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">
                        <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                        <p>Aucune table n'est configurée pour le restaurant "{{ $selectedRestaurant->nom }}".</p> {{-- Message mis à jour --}}
                    </div>
                @endif
            </div>
        </div>
        {{-- FIN DE LA NOUVELLE SECTION TABLES-TAB --}}


        {{-- CONTENU ORIGINAL DES AUTRES ONGLETS --}}
        <div id="orders-tab" class="tab-content" role="tabpanel" aria-labelledby="tab-orders" hidden>
            <div class="order-header">
                <div class="table-info">
                    <div class="table-icon" aria-hidden="true"><i class="fas fa-chair"></i></div>
                    <div>
                        <div class="table-number-info">Sélectionner une table</div>
                        <div class="table-meta">
                            {{-- Rempli par JS --}}
                        </div>
                    </div>
                </div>
                <button id="back-to-tables" class="back-btn">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    <span>Retour</span>
                </button>
            </div>

            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search search-icon" aria-hidden="true"></i>
                    <input type="search" class="search-input" placeholder="Rechercher un plat..." aria-label="Rechercher un plat">
                </div>
                <button class="voice-btn" aria-label="Recherche vocale">
                    <i class="fas fa-microphone" aria-hidden="true"></i>
                </button>
            </div>

            <div class="categories" role="tablist" aria-label="Filtrer par catégorie">
                {{-- !!! En Production: Remplacer par une boucle @foreach($categories as $category) !!! --}}
                <button class="category active" role="tab" aria-selected="true">Tous</button>
                <button class="category" role="tab" aria-selected="false">Entrées</button>
                <button class="category" role="tab" aria-selected="false">Plats</button>
                <button class="category" role="tab" aria-selected="false">Desserts</button>
                <button class="category" role="tab" aria-selected="false">Boissons</button>
                <button class="category" role="tab" aria-selected="false">Vins</button>
                <button class="category" role="tab" aria-selected="false">Menu du jour</button>
                {{-- !!! Fin de la boucle @endforeach !!! --}}
            </div>

            <div class="menu-grid">
                {{-- Menu items statiques (à remplacer par une boucle dynamique en production) --}}
                <div class="menu-item" data-id="1" data-name="Salade César" data-price="14.50" {{-- data-category="Entrées" --}} tabindex="0" role="button" aria-label="Ajouter Salade César, 14,50€">
                    <div class="menu-img-container">
                        {{-- Si image locale: <img src="{{ asset('images/menu/' . $item->image_path) }}" alt="{{ $item->name }}"> --}}
                        <img src="https://source.unsplash.com/800x600/?cesar-salad" alt="Salade César" class="menu-img">
                        {{-- Condition pour badge @if($item->is_vegan) --}}
                        <div class="menu-badge badge-vegan" title="Vegan">
                            <i class="fas fa-leaf" aria-hidden="true"></i>
                        </div>
                        {{-- @endif --}}
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Salade César</div>
                        <div class="menu-price">14,50€</div> {{-- Formatter le prix si nécessaire {{ number_format($item->price, 2, ',', ' ') }}€ --}}
                    </div>
                </div>
                <div class="menu-item" data-id="2" data-name="Soupe à l'oignon" data-price="10.50" {{-- data-category="Entrées" --}} tabindex="0" role="button" aria-label="Ajouter Soupe à l'oignon, 10,50€">
                    <div class="menu-img-container">
                        <img src="https://source.unsplash.com/800x600/?onion-soup" alt="Soupe à l'oignon" class="menu-img">
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Soupe à l'oignon</div>
                        <div class="menu-price">10,50€</div>
                    </div>
                </div>
                <div class="menu-item" data-id="3" data-name="Filet de Boeuf" data-price="26.90" {{-- data-category="Plats" --}} tabindex="0" role="button" aria-label="Ajouter Filet de Boeuf, 26,90€">
                    <div class="menu-img-container">
                        <img src="https://source.unsplash.com/800x600/?beef-steak" alt="Filet de Boeuf" class="menu-img">
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Filet de Boeuf</div>
                        <div class="menu-price">26,90€</div>
                    </div>
                </div>
                <div class="menu-item" data-id="4" data-name="Risotto aux Cèpes" data-price="19.90" {{-- data-category="Plats" --}} tabindex="0" role="button" aria-label="Ajouter Risotto aux Cèpes, 19,90€">
                    <div class="menu-img-container">
                        <img src="https://source.unsplash.com/800x600/?risotto" alt="Risotto aux Cèpes" class="menu-img">
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Risotto aux Cèpes</div>
                        <div class="menu-price">19,90€</div>
                    </div>
                </div>
                <div class="menu-item" data-id="5" data-name="Saumon Grillé" data-price="22.50" {{-- data-category="Plats" --}} tabindex="0" role="button" aria-label="Ajouter Saumon Grillé, 22,50€, contient des allergènes">
                    <div class="menu-img-container">
                        <img src="https://source.unsplash.com/800x600/?grilled-salmon" alt="Saumon Grillé" class="menu-img">
                        {{-- Condition pour badge @if($item->has_allergens) --}}
                        <div class="menu-badge badge-allergic" title="Contient des allergènes (poisson)">
                            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                        </div>
                        {{-- @endif --}}
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Saumon Grillé</div>
                        <div class="menu-price">22,50€</div>
                    </div>
                </div>
                <div class="menu-item" data-id="6" data-name="Crème Brûlée" data-price="8.90" {{-- data-category="Desserts" --}} tabindex="0" role="button" aria-label="Ajouter Crème Brûlée, 8,90€">
                    <div class="menu-img-container">
                        <img src="https://source.unsplash.com/800x600/?creme-brulee" alt="Crème Brûlée" class="menu-img">
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Crème Brûlée</div>
                        <div class="menu-price">8,90€</div>
                    </div>
                </div>
                {{-- Fin du menu statique --}}
            </div>
        </div>

        <!-- Payment Tab Content -->
        <div id="payment-tab" class="tab-content" role="tabpanel" aria-labelledby="tab-payment" hidden>
            <h2 class="summary-title">Mode de paiement</h2>
            <div class="payment-methods" role="radiogroup" aria-labelledby="payment-method-label">
                <div id="payment-method-label" class="visually-hidden">Choisir un mode de paiement</div>
                <div class="payment-method active" data-method="cash" role="radio" aria-checked="true" tabindex="0">
                    <div class="payment-icon"><i class="fas fa-money-bill-wave" aria-hidden="true"></i></div>
                    <div class="payment-name">Espèces</div>
                </div>
                <div class="payment-method" data-method="card" role="radio" aria-checked="false" tabindex="-1">
                    <div class="payment-icon"><i class="fas fa-credit-card" aria-hidden="true"></i></div>
                    <div class="payment-name">Carte Bancaire</div>
                </div>
                <div class="payment-method" data-method="split" role="radio" aria-checked="false" tabindex="-1">
                    <div class="payment-icon"><i class="fas fa-users" aria-hidden="true"></i></div>
                    <div class="payment-name">Addition Partagée</div>
                </div>
                <div class="payment-method" data-method="mobile" role="radio" aria-checked="false" tabindex="-1">
                    <div class="payment-icon"><i class="fas fa-mobile-alt" aria-hidden="true"></i></div>
                    <div class="payment-name">Paiement Mobile</div>
                </div>
            </div>

            <div class="payment-summary">
                <div class="summary-title">Récapitulatif <span class="table-number-payment" style="font-weight: normal; color: var(--text-muted);">(Table ?)</span></div>
                <div class="subtotal-row"><div class="subtotal-label">Articles</div><div class="subtotal-value cart-item-count">0</div></div>
                <div class="subtotal-row"><div class="subtotal-label">Sous-total</div><div class="subtotal-value cart-subtotal">0,00€</div></div>
                <div class="subtotal-row"><div class="subtotal-label">TVA (10%)</div><div class="subtotal-value cart-tax">0,00€</div></div>
                <div class="total-row"><div class="total-label">Total à payer</div><div class="total-value cart-grand-total">0,00€</div></div>
            </div>

            <div class="cash-payment-details" style="display: block;"> {{-- Affiché par défaut si 'cash' est actif par défaut --}}
                <div class="amount-field">
                    <span>€</span>
                    <input type="text" class="amount-input" value="0,00" inputmode="decimal" aria-label="Montant reçu en espèces">
                </div>
                <div class="numpad" aria-label="Clavier numérique pour le montant reçu">
                    <button class="numkey" data-key="7">7</button> <button class="numkey" data-key="8">8</button> <button class="numkey" data-key="9">9</button>
                    <button class="numkey" data-key="4">4</button> <button class="numkey" data-key="5">5</button> <button class="numkey" data-key="6">6</button>
                    <button class="numkey" data-key="1">1</button> <button class="numkey" data-key="2">2</button> <button class="numkey" data-key="3">3</button>
                    <button class="numkey" data-key="0">0</button> <button class="numkey" data-key="00">00</button> <button class="numkey" data-key="C" aria-label="Effacer">C</button>
                </div>
                <div class="change-panel">
                    <div class="change-title"><div class="change-label">Monnaie à rendre</div><div class="change-amount">0,00€</div></div>
                    <div class="bills-display" aria-label="Détail de la monnaie à rendre">
                        {{-- Rempli par JS --}}
                    </div>
                    <label class="tip-option" for="round-tip">
                        <input type="checkbox" class="tip-checkbox" id="round-tip">
                        <span class="tip-label">Arrondir pour pourboire (<span class="tip-amount">0,00€</span>)</span>
                    </label>
                </div>
            </div>

            <div class="modal-actions">
                <button class="btn btn-outline" id="cancel-payment"><i class="fas fa-times" aria-hidden="true"></i> Annuler</button>
                <button class="btn btn-primary" id="complete-payment"><i class="fas fa-check" aria-hidden="true"></i> Valider Paiement</button>
            </div>
        </div>

        <!-- Receipt Tab Content -->
        <div id="receipt-tab" class="tab-content" role="tabpanel" aria-labelledby="tab-receipt" hidden>
            <div class="receipt-container" style="max-width: 600px; margin: auto;">
                <div class="receipt">
                    <div class="receipt-header">
                        <div class="receipt-logo">OctoPOS</div>
                        <div class="receipt-restaurant">{{-- Config::get('restaurant.name', 'Le Bistro Gourmand') --}}Le Bistro Gourmand</div>
                        <div class="receipt-address">{{-- Config::get('restaurant.address', '123 Rue de la Saveur, 75001 Paris') --}}123 Rue de la Saveur, 75001 Paris</div>
                        <div class="receipt-info">Tel: {{-- Config::get('restaurant.phone', '01 98 76 54 32') --}}01 98 76 54 32</div>
                        <div class="receipt-info">Table: <span class="receipt-table-num">?</span> - Serveur: {{-- Auth::user()->name ?? 'Serveur' --}}Hamza B.</div>
                        <div class="receipt-info receipt-datetime">--/--/---- --:--:--</div>
                    </div>

                    <div class="receipt-body">
                        <div class="receipt-items" aria-label="Articles commandés">
                            <div class="receipt-item" style="color: var(--text-muted); text-align: center; grid-column: 1 / -1; padding: 1rem 0;">Aucun article</div>
                        </div>
                        <div class="receipt-subtotals" aria-label="Totaux">
                            <div class="receipt-item">
                                <div class="item-name">Sous-total HT:</div>
                                <div class="item-price receipt-subtotal-val">0,00€</div>
                            </div>
                            <div class="receipt-item">
                                <div class="item-name">TVA (10%):</div>
                                <div class="item-price receipt-tax-val">0,00€</div>
                            </div>
                            <div class="receipt-item" style="font-weight: bold; border-top: 1px solid var(--border-color); padding-top: var(--spacing-sm); margin-top: var(--spacing-sm);">
                                <div class="item-name">TOTAL TTC:</div>
                                <div class="item-price receipt-total-val">0,00€</div>
                            </div>
                            <div class="receipt-item receipt-payment-details" style="display: none;">
                                <div class="item-name">Payé (...):</div>
                                <div class="item-price receipt-paid-val">0,00€</div>
                            </div>
                            <div class="receipt-item receipt-payment-details" style="display: none;">
                                <div class="item-name">Rendu:</div>
                                <div class="item-price receipt-change-val">0,00€</div>
                            </div>
                        </div>
                    </div>

                    <div class="receipt-footer">
                        <div class="receipt-message">Merci de votre visite et à bientôt !</div>
                        <div class="receipt-message">TVA N° {{-- Config::get('restaurant.vat_number', 'FR123456789') --}}FR123456789</div>
                        <div class="receipt-qr" aria-label="QR Code pour laisser un avis">
                            <i class="fas fa-qrcode" style="font-size: 4rem; color: var(--text-muted);"></i>
                        </div>
                        <div class="receipt-message">Scannez pour laisser votre avis</div>
                    </div>
                </div>

                <div class="receipt-actions">
                    <button class="btn btn-primary action-btn" aria-label="Imprimer le ticket">
                        <i class="fas fa-print" aria-hidden="true"></i> Imprimer
                    </button>
                    <button class="btn btn-outline action-btn" aria-label="Envoyer le ticket par Email">
                        <i class="fas fa-envelope" aria-hidden="true"></i> Email
                    </button>
                    <button class="btn btn-outline action-btn" aria-label="Envoyer le ticket par SMS">
                        <i class="fas fa-mobile-alt" aria-hidden="true"></i> SMS
                    </button>
                </div>

                <div class="payment-success-panel" style="display: none;">
                    <div class="payment-success-title">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        Paiement réussi!
                    </div>
                    <div class="payment-success-message">
                        La table <span class="receipt-table-num">?</span> est maintenant marquée comme libre et prête pour les prochains clients.
                    </div>
                    <div class="modal-actions" style="margin-top: 1rem;">
                        <button class="btn btn-outline" id="clean-table-btn">
                            <i class="fas fa-broom" aria-hidden="true"></i> Marquer comme nettoyée
                        </button>
                        <button class="btn btn-secondary" id="back-to-tables-btn">
                            <i class="fas fa-th-large" aria-hidden="true"></i> Retour aux tables
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Tab Content -->
        <div id="stats-tab" class="tab-content" role="tabpanel" aria-labelledby="tab-stats" hidden>
            <div class="payment-summary">
                <div class="summary-title"><i class="fas fa-calendar-day" aria-hidden="true"></i> Statistiques du Jour</div>
                <div class="subtotal-row"><div class="subtotal-label">Tables servies</div><div class="subtotal-value">{{-- $stats['tables_served'] ?? 12 --}}12</div></div>
                <div class="subtotal-row"><div class="subtotal-label">Clients servis</div><div class="subtotal-value">{{-- $stats['customers_served'] ?? 43 --}}43</div></div>
                <div class="subtotal-row"><div class="subtotal-label">Chiffre d'affaires</div><div class="subtotal-value">{{-- number_format($stats['revenue'] ?? 678.50, 2, ',', ' ') --}}678,50€</div></div>
                <div class="subtotal-row"><div class="subtotal-label">Ticket moyen</div><div class="subtotal-value">{{-- number_format($stats['average_ticket'] ?? 56.54, 2, ',', ' ') --}}56,54€</div></div>
                <div class="subtotal-row"><div class="subtotal-label">Pourboires estimés</div><div class="subtotal-value">{{-- number_format($stats['estimated_tips'] ?? 32.70, 2, ',', ' ') --}}32,70€</div></div>
            </div>

            <div class="payment-summary">
                <div class="summary-title"><i class="fas fa-tachometer-alt" aria-hidden="true"></i> Performance Personnelle</div>

                <div style="margin-bottom: 1rem;">
                    <div class="subtotal-row">
                        <div class="subtotal-label">Temps moyen prise de commande</div>
                        <div class="subtotal-value">2.1 min <span style="color: var(--success);">(Rapide)</span></div>
                    </div>
                    <div class="progress-bar-container" aria-label="Performance Temps de commande, 90%">
                        <div class="progress-bar" style="width: 90%; background-color: var(--success);"></div>
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <div class="subtotal-row">
                        <div class="subtotal-label">Satisfaction client (avis récents)</div>
                        <div class="subtotal-value">4.7 / 5 <i class="fas fa-star" style="color: var(--warning);"></i></div>
                    </div>
                    <div class="progress-bar-container" aria-label="Satisfaction client, 94%">
                        <div class="progress-bar" style="width: 94%; background-color: var(--primary);"></div>
                    </div>
                </div>
                <div>
                    <div class="subtotal-row">
                        <div class="subtotal-label">Ventes additionnelles (Menu / Suggestions)</div>
                        <div class="subtotal-value">15% <span style="color: var(--secondary);">(Bon)</span></div>
                    </div>
                    <div class="progress-bar-container" aria-label="Performance Ventes additionnelles, 75%">
                        <div class="progress-bar" style="width: 75%; background-color: var(--secondary);"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- FIN DU CONTENU ORIGINAL DES AUTRES ONGLETS --}}

    </div> {{-- Fin de .main-content --}}


    {{-- PANIER (ORIGINAL) --}}
    <div class="cart" id="cart-panel" aria-labelledby="cart-heading" style="display: none;">
        <div class="cart-header" role="button" aria-expanded="false" aria-controls="cart-details">
            <div class="cart-handle" aria-hidden="true"></div>
            <div class="cart-summary">
                <div>
                    <span class="cart-title" id="cart-heading">Table <span class="cart-table-id">N/A</span></span>
                    <span class="cart-count">(0 articles)</span>
                </div>
                <div style="display: flex; align-items: center;">
                    <span class="cart-total">0,00€</span>
                    <button class="cart-toggle-btn" aria-label="Afficher/Masquer le détail du panier">
                        <i class="fas fa-chevron-up" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="cart-details" hidden>
            <div class="cart-content">
                <div class="cart-empty-message" style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    <i class="fas fa-shopping-cart" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                    <p>Le panier est vide.</p>
                </div>
            </div>

            <div class="cart-footer">
                <div class="subtotal-row">
                    <span class="subtotal-label">Sous-total</span>
                    <span class="subtotal-value cart-subtotal-footer">0,00€</span>
                </div>
                <div class="subtotal-row">
                    <span class="subtotal-label">TVA (10%)</span>
                    <span class="subtotal-value cart-tax-footer">0,00€</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-value cart-grand-total-footer">0,00€</span>
                </div>
                <div class="cart-actions">
                    <button class="btn btn-outline" id="cancel-order-btn" disabled>
                        <i class="fas fa-trash-alt" aria-hidden="true"></i> Annuler
                    </button>
                    <button class="btn btn-primary" id="send-to-kitchen-btn" disabled>
                        <i class="fas fa-paper-plane" aria-hidden="true"></i> Envoyer
                    </button>
                    <button class="btn btn-secondary" id="go-to-payment-btn" style="grid-column: 1 / -1; margin-top: var(--spacing-sm);" disabled>
                        <i class="fas fa-credit-card" aria-hidden="true"></i> Aller au Paiement
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALE DE PERSONNALISATION (ORIGINALE) --}}
    <div class="modal-overlay" id="customization-overlay">
        <div class="modal" id="customization-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title-label">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-label">Personnaliser l'article</h3>
                <button class="modal-close" aria-label="Fermer la fenêtre de personnalisation">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="option-section">
                    <h4 class="option-title">Cuisson</h4>
                    <div class="option-grid" role="radiogroup" aria-labelledby="cooking-level-label">
                        <div id="cooking-level-label" class="visually-hidden">Choisir la cuisson</div>
                        <button class="option-item" role="radio" aria-checked="false" data-option="Bleu">Bleu</button>
                        <button class="option-item" role="radio" aria-checked="false" data-option="Saignant">Saignant</button>
                        <button class="option-item" role="radio" aria-checked="false" data-option="À point">À point</button>
                        <button class="option-item" role="radio" aria-checked="false" data-option="Bien cuit">Bien cuit</button>
                    </div>
                </div>
                <div class="option-section">
                    <h4 class="option-title">Accompagnement</h4>
                    <div class="option-grid" role="radiogroup" aria-labelledby="side-dish-label">
                        <div id="side-dish-label" class="visually-hidden">Choisir l'accompagnement</div>
                        <button class="option-item" role="radio" aria-checked="false" data-option="Frites">Frites</button>
                        <button class="option-item" role="radio" aria-checked="false" data-option="Légumes">Légumes</button>
                        <button class="option-item" role="radio" aria-checked="false" data-option="Purée">Purée</button>
                        <button class="option-item" role="radio" aria-checked="false" data-option="Gratin">Gratin</button>
                    </div>
                </div>
                <div class="option-section">
                    <h4 class="option-title">Extras</h4>
                    <div class="extras-list" role="group" aria-labelledby="extras-label">
                        <div id="extras-label" class="visually-hidden">Choisir les extras</div>
                        <label class="extra-item" role="checkbox" aria-checked="false" tabindex="0">
                            <div class="extra-label">
                                <div class="checkbox" aria-hidden="true"></div>
                                <span>Sauce béarnaise</span>
                            </div>
                            <div class="extra-price">+2,50€</div>
                        </label>
                        <label class="extra-item" role="checkbox" aria-checked="false" tabindex="0">
                            <div class="extra-label">
                                <div class="checkbox" aria-hidden="true"></div>
                                <span>Supplément frites</span>
                            </div>
                            <div class="extra-price">+3,00€</div>
                        </label>
                        <label class="extra-item" role="checkbox" aria-checked="false" tabindex="0">
                            <div class="extra-label">
                                <div class="checkbox" aria-hidden="true"></div>
                                <span>Sans sel</span>
                            </div>
                            <div class="extra-price"></div>
                        </label>
                    </div>
                </div>
                <div class="option-section">
                    <h4 class="option-title" id="notes-label">Notes spéciales</h4>
                    <textarea class="notes-field" placeholder="Allergies, instructions spéciales..." aria-labelledby="notes-label"></textarea>
                </div>
            </div>

            <div class="modal-actions">
                <button class="btn btn-outline modal-cancel-btn">Annuler</button>
                <button class="btn btn-primary add-to-cart-btn">
                    <i class="fas fa-plus" aria-hidden="true"></i> Ajouter à la commande
                </button>
            </div>
        </div>
    </div>

@endsection