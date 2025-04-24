<<<<<<< HEAD
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

            <div class="tables-grid">

                <div class="table-item table-free" data-table="1" tabindex="0" role="button" aria-label="Table 1, 4 personnes, Libre">
                    <div class="table-number">T1</div>
                    <div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> 4</div>
                </div>
                <div class="table-item table-occupied" data-table="2" tabindex="0" role="button" aria-label="Table 2, 2 personnes, Occupée depuis 35 minutes">
                    <div class="table-number">T2</div>
                    <div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> 2</div>
                    <div class="table-time"><i class="fas fa-clock" aria-hidden="true"></i> 35 min</div>
                </div>
                <div class="table-item table-occupied table-urgent" data-table="3" tabindex="0" role="button" aria-label="Table 3, 6 personnes, Occupée depuis 52 minutes, Urgent">
                    <div class="table-number">T3</div>
                    <div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> 6</div>
                    <div class="table-time"><i class="fas fa-clock" aria-hidden="true"></i> 52 min</div>
                </div>
                <div class="table-item table-reserved" data-table="4" tabindex="0" role="button" aria-label="Table 4, 4 personnes, Réservée pour 19:30">
                    <div class="table-number">T4</div>
                    <div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> 4</div>
                    <div class="table-time"><i class="fas fa-calendar-alt" aria-hidden="true"></i> 19:30</div>
                </div>
                <div class="table-item table-free" data-table="5" tabindex="0" role="button" aria-label="Table 5, 2 personnes, Libre"> <div class="table-number">T5</div><div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> 2</div></div>
                <div class="table-item table-free" data-table="6" tabindex="0" role="button" aria-label="Table 6, 4 personnes, Libre"> <div class="table-number">T6</div><div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> 4</div></div>
                <div class="table-item table-reserved" data-table="7" tabindex="0" role="button" aria-label="Table 7, 2 personnes, Réservée pour 20:15"> <div class="table-number">T7</div><div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> 2</div><div class="table-time"><i class="fas fa-calendar-alt" aria-hidden="true"></i> 20:15</div></div>
                <div class="table-item table-free" data-table="8" tabindex="0" role="button" aria-label="Table 8, 6 personnes, Libre"> <div class="table-number">T8</div><div class="table-capacity"><i class="fas fa-users" aria-hidden="true"></i> 6</div></div>
            </div>
        </div>
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

    </div>


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
=======
@extends('layouts.serveur') 

@section('content')
    
    <div class="flex flex-col h-screen overflow-hidden">
        <!-- Header -->
        <header class="flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200 sticky top-0 z-10 transition-colors dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center">
                <div class="relative mr-2">
                    <i class="fas fa-utensils text-2xl absolute -top-0.5 -left-0.5 text-secondary-500 opacity-30 z-10" aria-hidden="true"></i>
                    <i class="fas fa-utensils text-2xl relative text-primary-500 z-20" aria-hidden="true"></i>
                </div>
                <div class="text-xl font-extrabold bg-gradient-to-r from-primary-500 to-secondary-500 bg-clip-text text-transparent">{{ $restaurantName ?? 'OctoPOS' }}</div>
            </div>

            <div class="flex items-center gap-2">
                <div class="text-sm text-gray-500 whitespace-nowrap dark:text-gray-400 datetime">Loading...</div>

                <div class="flex items-center">
                    <button id="theme-toggle" class="w-11 h-11 rounded-full flex items-center justify-center ml-1 bg-transparent border-none text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition-colors relative dark:hover:bg-gray-700 dark:hover:text-gray-200" aria-label="Basculer le thème sombre/clair">
                        <i class="fas fa-moon"></i> 
                    </button>
                    <button id="contrast-toggle" class="w-11 h-11 rounded-full flex items-center justify-center ml-1 bg-transparent border-none text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition-colors relative dark:hover:bg-gray-700 dark:hover:text-gray-200" aria-label="Basculer le mode contraste élevé" aria-pressed="false">
                        <i class="fas fa-adjust"></i>
                    </button>
                    <button id="notifications" class="w-11 h-11 rounded-full flex items-center justify-center ml-1 bg-transparent border-none text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition-colors relative dark:hover:bg-gray-700 dark:hover:text-gray-200" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        @php $notificationCount = $notificationCount ?? 3; @endphp {{-- Example: Get count from controller later --}}
                        @if($notificationCount > 0)
                            <span class="absolute top-1 right-1 min-w-[18px] h-[18px] rounded-full bg-danger-500 text-white text-xs font-semibold flex items-center justify-center px-1">{{ $notificationCount }}</span>
                        @endif
                    </button>
                </div>

                {{-- User Info Placeholders --}}
                <div class="flex items-center pl-2 ml-2 border-l border-gray-200 dark:border-gray-700">
                    @php
                        $userName = $userName ?? 'Hamza Br';
                        $userRole = $userRole ?? 'Serveur';
                        // Generate initials safely
                        $nameParts = explode(' ', trim($userName), 2);
                        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                        if (empty(trim($initials))) $initials = 'U'; // Default if name is weird
                    @endphp
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 text-white flex items-center justify-center font-bold text-sm mr-3 flex-shrink-0" aria-hidden="true">{{ $initials }}</div>
                    <div class="hidden sm:block">
                        <div class="font-bold text-sm leading-tight text-gray-800 dark:text-gray-100">{{ $userName }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $userRole }}</div>
                    </div>
                    <button class="w-11 h-11 rounded-full flex items-center justify-center ml-1 bg-transparent border-none text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition-colors relative dark:hover:bg-gray-700 dark:hover:text-gray-200" aria-label="Menu utilisateur">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Tabs Navigation (Desktop) -->
        {{-- Hidden on mobile (md:hidden on bottom nav shows), visible medium and up --}}
        <div class="hidden md:flex overflow-x-auto scrollbar-hide bg-white border-b border-gray-200 sticky top-[57px] z-[9] transition-colors dark:bg-gray-800 dark:border-gray-700" role="tablist" aria-label="Navigation principale">
            {{-- Add unique IDs like "-desktop" --}}
            <button class="py-3 px-5 whitespace-nowrap text-primary-500 font-semibold text-sm border-b-[3px] border-primary-500 -mb-px transition-colors" role="tab" aria-selected="true" aria-controls="tables-tab" data-tab="tables" id="tab-tables-desktop">
                <i class="fas fa-th-large mr-2" aria-hidden="true"></i> Tables
            </button>
            <button class="py-3 px-5 whitespace-nowrap text-gray-500 font-semibold text-sm border-b-[3px] border-transparent -mb-px hover:text-gray-800 transition-colors dark:hover:text-gray-200" role="tab" aria-selected="false" aria-controls="orders-tab" data-tab="orders" id="tab-orders-desktop" tabindex="-1">
                <i class="fas fa-utensils mr-2" aria-hidden="true"></i> Commande
            </button>
            <button class="py-3 px-5 whitespace-nowrap text-gray-500 font-semibold text-sm border-b-[3px] border-transparent -mb-px hover:text-gray-800 transition-colors dark:hover:text-gray-200" role="tab" aria-selected="false" aria-controls="payment-tab" data-tab="payment" id="tab-payment-desktop" tabindex="-1">
                <i class="fas fa-cash-register mr-2" aria-hidden="true"></i> Paiement
            </button>
            <button class="py-3 px-5 whitespace-nowrap text-gray-500 font-semibold text-sm border-b-[3px] border-transparent -mb-px hover:text-gray-800 transition-colors dark:hover:text-gray-200" role="tab" aria-selected="false" aria-controls="receipt-tab" data-tab="receipt" id="tab-receipt-desktop" tabindex="-1">
                <i class="fas fa-receipt mr-2" aria-hidden="true"></i> Tickets
            </button>
            <button class="py-3 px-5 whitespace-nowrap text-gray-500 font-semibold text-sm border-b-[3px] border-transparent -mb-px hover:text-gray-800 transition-colors dark:hover:text-gray-200" role="tab" aria-selected="false" aria-controls="stats-tab" data-tab="stats" id="tab-stats-desktop" tabindex="-1">
                <i class="fas fa-chart-line mr-2" aria-hidden="true"></i> Stats
            </button>
        </div>

        <!-- Main Content -->
        {{-- Adjust padding-bottom for bottom nav: pb-[56px] on mobile, pb-0 on medium+ --}}
        <div class="flex-1 overflow-hidden relative pb-[56px] md:pb-0">

            <!-- Tables Tab Content -->
            {{-- Update labelledby to include both desktop and mobile tab ids --}}
            <div id="tables-tab" class="h-full w-full absolute top-0 left-0 p-4 overflow-y-auto" role="tabpanel" aria-labelledby="tab-tables-desktop tab-tables-mobile">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                    {{-- View Controls --}}
                    <div class="flex bg-white border border-gray-200 rounded-md overflow-hidden dark:bg-gray-800 dark:border-gray-700">
                        <button class="py-2 px-3 border-none bg-primary-500 text-white cursor-pointer transition-colors" aria-pressed="true" aria-label="Vue grille">
                            <i class="fas fa-th-large" aria-hidden="true"></i>
                        </button>
                        <button class="py-2 px-3 border-none bg-transparent text-gray-500 hover:bg-gray-100 cursor-pointer transition-colors dark:hover:bg-gray-700" aria-pressed="false" aria-label="Vue liste">
                            <i class="fas fa-list" aria-hidden="true"></i>
                        </button>
                    </div>
                    {{-- Legend --}}
                    <div class="flex flex-wrap gap-4 items-center" aria-label="Légende des statuts de table">
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                            <div class="w-3 h-3 rounded-full bg-secondary-500 mr-1.5"></div>
                            <span>Libre</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                            <div class="w-3 h-3 rounded-full bg-danger-500 mr-1.5"></div>
                            <span>Occupée</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                            <div class="w-3 h-3 rounded-full bg-warning-500 mr-1.5"></div>
                            <span>Réservée</span>
                        </div>
                    </div>
                </div>
                {{-- Table Grid --}}
                {{-- Removed pb-[60px] as padding is on parent now --}}
                {{-- Ideally, tables should be generated dynamically from Controller data --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!-- Table 1 -->
                    <div class="aspect-square bg-white rounded-md flex flex-col items-center justify-center cursor-pointer p-2 text-center shadow-sm border-2 border-secondary-500 transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] dark:bg-gray-800" data-table="1" tabindex="0" role="button" aria-label="Table 1, 4 personnes, Libre">
                        <div class="text-2xl font-extrabold mb-0.5 text-gray-800 dark:text-gray-100">T1</div>
                        <div class="text-xs text-gray-500 mb-1 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i> 4</div>
                    </div>
                    <!-- Table 2 -->
                    <div class="aspect-square bg-white rounded-md flex flex-col items-center justify-center cursor-pointer p-2 text-center shadow-sm border-2 border-danger-500 transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] dark:bg-gray-800" data-table="2" tabindex="0" role="button" aria-label="Table 2, 2 personnes, Occupée depuis 35 minutes">
                        <div class="text-2xl font-extrabold mb-0.5 text-gray-800 dark:text-gray-100">T2</div>
                        <div class="text-xs text-gray-500 mb-1 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i> 2</div>
                        <div class="text-xs font-semibold text-danger-500"><i class="fas fa-clock" aria-hidden="true"></i> 35 min</div>
                    </div>
                    <!-- Table 3 -->
                    <div class="aspect-square bg-white rounded-md flex flex-col items-center justify-center cursor-pointer p-2 text-center shadow-sm border-2 border-danger-500 transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] animate-pulse-danger dark:bg-gray-800" data-table="3" tabindex="0" role="button" aria-label="Table 3, 6 personnes, Occupée depuis 52 minutes, Urgent">
                        <div class="text-2xl font-extrabold mb-0.5 text-gray-800 dark:text-gray-100">T3</div>
                        <div class="text-xs text-gray-500 mb-1 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i> 6</div>
                        <div class="text-xs font-semibold text-danger-500"><i class="fas fa-clock" aria-hidden="true"></i> 52 min</div>
                    </div>
                    <!-- Table 4 -->
                    <div class="aspect-square bg-white rounded-md flex flex-col items-center justify-center cursor-pointer p-2 text-center shadow-sm border-2 border-warning-500 transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] dark:bg-gray-800" data-table="4" tabindex="0" role="button" aria-label="Table 4, 4 personnes, Réservée pour 19:30">
                        <div class="text-2xl font-extrabold mb-0.5 text-gray-800 dark:text-gray-100">T4</div>
                        <div class="text-xs text-gray-500 mb-1 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i> 4</div>
                        <div class="text-xs font-semibold text-warning-500"><i class="fas fa-calendar-alt" aria-hidden="true"></i> 19:30</div>
                    </div>
                    <!-- Table 5 -->
                    <div class="aspect-square bg-white rounded-md flex flex-col items-center justify-center cursor-pointer p-2 text-center shadow-sm border-2 border-secondary-500 transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] dark:bg-gray-800" data-table="5" tabindex="0" role="button" aria-label="Table 5, 2 personnes, Libre">
                        <div class="text-2xl font-extrabold mb-0.5 text-gray-800 dark:text-gray-100">T5</div>
                        <div class="text-xs text-gray-500 mb-1 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i> 2</div>
                    </div>
                    <!-- Table 6 -->
                    <div class="aspect-square bg-white rounded-md flex flex-col items-center justify-center cursor-pointer p-2 text-center shadow-sm border-2 border-secondary-500 transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] dark:bg-gray-800" data-table="6" tabindex="0" role="button" aria-label="Table 6, 4 personnes, Libre">
                        <div class="text-2xl font-extrabold mb-0.5 text-gray-800 dark:text-gray-100">T6</div>
                        <div class="text-xs text-gray-500 mb-1 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i> 4</div>
                    </div>
                    <!-- Table 7 -->
                    <div class="aspect-square bg-white rounded-md flex flex-col items-center justify-center cursor-pointer p-2 text-center shadow-sm border-2 border-warning-500 transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] dark:bg-gray-800" data-table="7" tabindex="0" role="button" aria-label="Table 7, 2 personnes, Réservée pour 20:15">
                        <div class="text-2xl font-extrabold mb-0.5 text-gray-800 dark:text-gray-100">T7</div>
                        <div class="text-xs text-gray-500 mb-1 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i> 2</div>
                        <div class="text-xs font-semibold text-warning-500"><i class="fas fa-calendar-alt" aria-hidden="true"></i> 20:15</div>
                    </div>
                    <!-- Table 8 -->
                    <div class="aspect-square bg-white rounded-md flex flex-col items-center justify-center cursor-pointer p-2 text-center shadow-sm border-2 border-secondary-500 transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] dark:bg-gray-800" data-table="8" tabindex="0" role="button" aria-label="Table 8, 6 personnes, Libre">
                        <div class="text-2xl font-extrabold mb-0.5 text-gray-800 dark:text-gray-100">T8</div>
                        <div class="text-xs text-gray-500 mb-1 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i> 6</div>
                    </div>
                </div>
            </div>

            <!-- Orders Tab Content -->
            <div id="orders-tab" class="h-full w-full absolute top-0 left-0 p-4 overflow-y-auto" role="tabpanel" aria-labelledby="tab-orders-desktop tab-orders-mobile" hidden>
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200 gap-4 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-md flex items-center justify-center flex-shrink-0 text-2xl dark:bg-primary-900 dark:text-primary-300" aria-hidden="true">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div>
                            {{-- JS updates this title --}}
                            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sélectionner une table</div>
                            {{-- JS updates this meta info --}}
                            <div class="flex flex-wrap text-gray-500 text-sm gap-0 gap-x-2 dark:text-gray-400 table-meta"></div>
                        </div>
                    </div>
                    <button id="back-to-tables" class="h-11 min-w-11 rounded-md border border-gray-200 bg-white flex items-center justify-center text-gray-500 cursor-pointer px-4 gap-2 transition-colors hover:bg-gray-100 hover:text-gray-800 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        <span class="hidden sm:inline">Retour</span>
                    </button>
                </div>
                <!-- Search Bar -->
                <div class="flex gap-2 mb-4">
                    <div class="relative flex-1">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm dark:text-gray-400" aria-hidden="true"></i>
                        <input type="search" class="w-full h-11 pl-11 pr-4 border border-gray-200 rounded-md bg-white text-gray-800 text-base transition-colors focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-primary-900" placeholder="Rechercher un plat..." aria-label="Rechercher un plat">
                    </div>
                    <button class="w-11 h-11 flex-shrink-0 bg-primary-500 text-white border-none rounded-md flex items-center justify-center cursor-pointer transition-colors hover:bg-primary-600 active:scale-95" aria-label="Recherche vocale">
                        <i class="fas fa-microphone" aria-hidden="true"></i>
                    </button>
                </div>
                <!-- Categories -->
                <div class="flex overflow-x-auto gap-2 mb-4 pb-1 scrollbar-hide" role="tablist" aria-label="Filtrer par catégorie">
                    {{-- data-category is crucial for JS filtering --}}
                    <button class="flex-none py-2 px-4 bg-primary-50 text-primary-500 rounded-full font-semibold text-sm whitespace-nowrap cursor-pointer border border-primary-500 transition-colors" role="tab" aria-selected="true" data-category="Tous">Tous</button>
                    <button class="flex-none py-2 px-4 bg-gray-100 text-gray-500 rounded-full font-semibold text-sm whitespace-nowrap cursor-pointer border border-transparent hover:bg-gray-200 hover:text-gray-800 transition-colors dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" role="tab" aria-selected="false" data-category="Entrées">Entrées</button>
                    <button class="flex-none py-2 px-4 bg-gray-100 text-gray-500 rounded-full font-semibold text-sm whitespace-nowrap cursor-pointer border border-transparent hover:bg-gray-200 hover:text-gray-800 transition-colors dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" role="tab" aria-selected="false" data-category="Plats">Plats</button>
                    <button class="flex-none py-2 px-4 bg-gray-100 text-gray-500 rounded-full font-semibold text-sm whitespace-nowrap cursor-pointer border border-transparent hover:bg-gray-200 hover:text-gray-800 transition-colors dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" role="tab" aria-selected="false" data-category="Desserts">Desserts</button>
                    <button class="flex-none py-2 px-4 bg-gray-100 text-gray-500 rounded-full font-semibold text-sm whitespace-nowrap cursor-pointer border border-transparent hover:bg-gray-200 hover:text-gray-800 transition-colors dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" role="tab" aria-selected="false" data-category="Boissons">Boissons</button>
                    <button class="flex-none py-2 px-4 bg-gray-100 text-gray-500 rounded-full font-semibold text-sm whitespace-nowrap cursor-pointer border border-transparent hover:bg-gray-200 hover:text-gray-800 transition-colors dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" role="tab" aria-selected="false" data-category="Vins">Vins</button>
                    <button class="flex-none py-2 px-4 bg-gray-100 text-gray-500 rounded-full font-semibold text-sm whitespace-nowrap cursor-pointer border border-transparent hover:bg-gray-200 hover:text-gray-800 transition-colors dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" role="tab" aria-selected="false" data-category="Menu du jour">Menu du jour</button>
                </div>
                <!-- Menu Grid -->
                 {{-- Ideally, menu items should be generated dynamically from Controller data --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    {{-- Add data-category to each item --}}
                    <div class="bg-white rounded-md shadow-sm overflow-hidden cursor-pointer transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] flex flex-col dark:bg-gray-800" data-id="1" data-name="Salade César" data-price="14.50" data-category="Entrées" tabindex="0" role="button" aria-label="Ajouter Salade César, 14,50€">
                        <div class="relative overflow-hidden">
                            {{-- Replace with asset() helper if image is local: <img src="{{ asset('images/menu/cesar.jpg') }}" ... > --}}
                            <img src="https://source.unsplash.com/800x600/?cesar-salad" alt="Salade César fraîche avec poulet grillé et croûtons" class="w-full aspect-[4/3] object-cover transition-all duration-200 hover:brightness-85 hover:scale-103">
                            <div class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/90 flex items-center justify-center shadow backdrop-blur-sm text-xs text-secondary-500" title="Vegan"><i class="fas fa-leaf" aria-hidden="true"></i></div>
                        </div>
                        <div class="p-2 px-4 flex-grow"><div class="font-semibold mb-1 leading-tight text-gray-800 overflow-hidden text-ellipsis line-clamp-2 min-h-[2.6em] dark:text-gray-100">Salade César</div><div class="text-primary-500 font-bold text-base mt-auto">14,50€</div></div>
                    </div>
                    <div class="bg-white rounded-md shadow-sm overflow-hidden cursor-pointer transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] flex flex-col dark:bg-gray-800" data-id="2" data-name="Soupe à l'oignon" data-price="10.50" data-category="Entrées" tabindex="0" role="button" aria-label="Ajouter Soupe à l'oignon, 10,50€">
                        <div class="relative overflow-hidden"><img src="https://source.unsplash.com/800x600/?onion-soup" alt="Soupe à l'oignon gratinée avec du fromage fondant" class="w-full aspect-[4/3] object-cover transition-all duration-200 hover:brightness-85 hover:scale-103"></div>
                        <div class="p-2 px-4 flex-grow"><div class="font-semibold mb-1 leading-tight text-gray-800 overflow-hidden text-ellipsis line-clamp-2 min-h-[2.6em] dark:text-gray-100">Soupe à l'oignon</div><div class="text-primary-500 font-bold text-base mt-auto">10,50€</div></div>
                    </div>
                    <div class="bg-white rounded-md shadow-sm overflow-hidden cursor-pointer transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] flex flex-col dark:bg-gray-800" data-id="3" data-name="Filet de Boeuf" data-price="26.90" data-category="Plats" tabindex="0" role="button" aria-label="Ajouter Filet de Boeuf, 26,90€">
                        <div class="relative overflow-hidden"><img src="https://source.unsplash.com/800x600/?beef-steak" alt="Filet de bœuf grillé servi avec des frites" class="w-full aspect-[4/3] object-cover transition-all duration-200 hover:brightness-85 hover:scale-103"></div>
                        <div class="p-2 px-4 flex-grow"><div class="font-semibold mb-1 leading-tight text-gray-800 overflow-hidden text-ellipsis line-clamp-2 min-h-[2.6em] dark:text-gray-100">Filet de Boeuf</div><div class="text-primary-500 font-bold text-base mt-auto">26,90€</div></div>
                    </div>
                    <div class="bg-white rounded-md shadow-sm overflow-hidden cursor-pointer transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] flex flex-col dark:bg-gray-800" data-id="4" data-name="Risotto aux Cèpes" data-price="19.90" data-category="Plats" tabindex="0" role="button" aria-label="Ajouter Risotto aux Cèpes, 19,90€">
                        <div class="relative overflow-hidden"><img src="https://source.unsplash.com/800x600/?risotto" alt="Risotto crémeux aux cèpes frais et parmesan" class="w-full aspect-[4/3] object-cover transition-all duration-200 hover:brightness-85 hover:scale-103"></div>
                        <div class="p-2 px-4 flex-grow"><div class="font-semibold mb-1 leading-tight text-gray-800 overflow-hidden text-ellipsis line-clamp-2 min-h-[2.6em] dark:text-gray-100">Risotto aux Cèpes</div><div class="text-primary-500 font-bold text-base mt-auto">19,90€</div></div>
                    </div>
                    <div class="bg-white rounded-md shadow-sm overflow-hidden cursor-pointer transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] flex flex-col dark:bg-gray-800" data-id="5" data-name="Saumon Grillé" data-price="22.50" data-category="Plats" tabindex="0" role="button" aria-label="Ajouter Saumon Grillé, 22,50€, contient des allergènes">
                        <div class="relative overflow-hidden"><img src="https://source.unsplash.com/800x600/?grilled-salmon" alt="Pavé de saumon grillé avec légumes vapeur" class="w-full aspect-[4/3] object-cover transition-all duration-200 hover:brightness-85 hover:scale-103"><div class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/90 flex items-center justify-center shadow backdrop-blur-sm text-xs text-danger-500 animate-blink" title="Contient des allergènes (poisson)"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></div></div>
                        <div class="p-2 px-4 flex-grow"><div class="font-semibold mb-1 leading-tight text-gray-800 overflow-hidden text-ellipsis line-clamp-2 min-h-[2.6em] dark:text-gray-100">Saumon Grillé</div><div class="text-primary-500 font-bold text-base mt-auto">22,50€</div></div>
                    </div>
                    <div class="bg-white rounded-md shadow-sm overflow-hidden cursor-pointer transition hover:-translate-y-1 hover:shadow-md active:scale-[0.97] flex flex-col dark:bg-gray-800" data-id="6" data-name="Crème Brûlée" data-price="8.90" data-category="Desserts" tabindex="0" role="button" aria-label="Ajouter Crème Brûlée, 8,90€">
                        <div class="relative overflow-hidden"><img src="https://source.unsplash.com/800x600/?creme-brulee" alt="Crème brûlée classique avec une croûte caramélisée" class="w-full aspect-[4/3] object-cover transition-all duration-200 hover:brightness-85 hover:scale-103"></div>
                        <div class="p-2 px-4 flex-grow"><div class="font-semibold mb-1 leading-tight text-gray-800 overflow-hidden text-ellipsis line-clamp-2 min-h-[2.6em] dark:text-gray-100">Crème Brûlée</div><div class="text-primary-500 font-bold text-base mt-auto">8,90€</div></div>
                    </div>
                    {{-- Add other menu items here, each with a data-category attribute --}}
                </div>
            </div>

            <!-- Payment Tab Content -->
            <div id="payment-tab" class="h-full w-full absolute top-0 left-0 p-4 overflow-y-auto" role="tabpanel" aria-labelledby="tab-payment-desktop tab-payment-mobile" hidden>
                <h2 class="font-bold mb-4 text-lg text-gray-800 flex items-center gap-2 dark:text-gray-100">Mode de paiement</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6" role="radiogroup" aria-labelledby="payment-method-label">
                    <div id="payment-method-label" class="visually-hidden">Choisir un mode de paiement</div>
                    {{-- Payment Method Options --}}
                    <div class="bg-white border-2 border-primary-500 rounded-md p-4 flex flex-col items-center text-center cursor-pointer relative bg-primary-50 dark:bg-gray-800 dark:border-primary-600 dark:bg-primary-900/30" data-method="cash" role="radio" aria-checked="true" tabindex="0">
                        <div class="text-3xl text-primary-500 mb-2 dark:text-primary-400"><i class="fas fa-money-bill-wave" aria-hidden="true"></i></div>
                        <div class="font-semibold text-sm text-gray-800 dark:text-gray-100">Espèces</div>
                        <div class="absolute top-2 right-2 text-primary-500 text-base dark:text-primary-400"><i class="fas fa-check-circle" aria-hidden="true"></i></div>
                    </div>
                    <div class="bg-white border-2 border-gray-200 rounded-md p-4 flex flex-col items-center text-center cursor-pointer relative hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" data-method="card" role="radio" aria-checked="false" tabindex="-1">
                        <div class="text-3xl text-gray-500 mb-2 dark:text-gray-400"><i class="fas fa-credit-card" aria-hidden="true"></i></div>
                        <div class="font-semibold text-sm text-gray-800 dark:text-gray-100">Carte Bancaire</div>
                    </div>
                    <div class="bg-white border-2 border-gray-200 rounded-md p-4 flex flex-col items-center text-center cursor-pointer relative hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" data-method="split" role="radio" aria-checked="false" tabindex="-1">
                        <div class="text-3xl text-gray-500 mb-2 dark:text-gray-400"><i class="fas fa-users" aria-hidden="true"></i></div>
                        <div class="font-semibold text-sm text-gray-800 dark:text-gray-100">Addition Partagée</div>
                    </div>
                    <div class="bg-white border-2 border-gray-200 rounded-md p-4 flex flex-col items-center text-center cursor-pointer relative hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" data-method="mobile" role="radio" aria-checked="false" tabindex="-1">
                        <div class="text-3xl text-gray-500 mb-2 dark:text-gray-400"><i class="fas fa-mobile-alt" aria-hidden="true"></i></div>
                        <div class="font-semibold text-sm text-gray-800 dark:text-gray-100">Paiement Mobile</div>
                    </div>
                </div>
                 {{-- Payment Summary (Totals updated by JS) --}}
                <div class="bg-white rounded-md p-4 shadow-sm mb-4 dark:bg-gray-800">
                    <div class="font-bold mb-4 text-lg text-gray-800 flex items-center gap-2 dark:text-gray-100">Récapitulatif <span class="font-normal text-gray-500 table-number-payment dark:text-gray-400">(Table N/A)</span></div>
                    <div class="flex justify-between text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">Articles</div><div class="font-medium text-gray-800 cart-item-count dark:text-gray-200">0</div></div>
                    <div class="flex justify-between text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">Sous-total</div><div class="font-medium text-gray-800 cart-subtotal dark:text-gray-200">0,00€</div></div>
                    <div class="flex justify-between text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">TVA (10%)</div><div class="font-medium text-gray-800 cart-tax dark:text-gray-200">0,00€</div></div>
                    <div class="flex justify-between font-bold mt-3 pt-3 border-t border-gray-200 dark:border-gray-700"><div class="text-base text-gray-800 dark:text-gray-100">Total à payer</div><div class="text-xl text-primary-500 cart-grand-total dark:text-primary-400">0,00€</div></div>
                </div>
                <!-- Cash Payment Section (JS shows/hides) -->
                <div class="cash-payment-details" style="display: block;"> {{-- Default visible for cash --}}
                    <div class="relative mb-4">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-gray-500 dark:text-gray-400">€</span>
                        <input type="text" class="w-full h-[50px] py-3 px-4 pl-10 text-right text-2xl font-bold border border-gray-200 rounded-md bg-white text-gray-800 transition-colors focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-primary-900 amount-input" value="0,00" inputmode="decimal" aria-label="Montant reçu en espèces">
                    </div>
                    {{-- Numpad --}}
                    <div class="grid grid-cols-3 gap-2 mb-4 numpad" aria-label="Clavier numérique pour le montant reçu">
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="7">7</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="8">8</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="9">9</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="4">4</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="5">5</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="6">6</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="1">1</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="2">2</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="3">3</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="0">0</button>
                        <button class="aspect-[1.5/1] text-2xl font-semibold bg-white border border-gray-200 rounded-md cursor-pointer text-gray-800 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 numkey" data-key="00">00</button>
                        <button class="aspect-[1.5/1] text-2xl font-bold bg-white border border-gray-200 rounded-md cursor-pointer text-danger-500 flex items-center justify-center transition-colors hover:bg-gray-100 active:bg-gray-200 active:scale-[0.96] dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 numkey" data-key="C" aria-label="Effacer">C</button>
                    </div>
                    {{-- Change Display --}}
                    <div class="bg-secondary-50 rounded-md p-4 mb-4 border border-secondary-600 dark:bg-secondary-900/30 dark:border-secondary-700">
                        <div class="flex justify-between items-center mb-2">
                            <div class="font-semibold text-secondary-700 dark:text-secondary-300">Monnaie à rendre</div>
                            <div class="font-bold text-xl text-secondary-700 change-amount dark:text-secondary-300">0,00€</div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-2 bills-display" aria-label="Détail de la monnaie à rendre">
                            <!-- Filled by JS -->
                        </div>
                        <label class="flex items-center mt-4 cursor-pointer tip-option" for="round-tip">
                            <input type="checkbox" class="w-[18px] h-[18px] mr-3 accent-secondary-600 tip-checkbox" id="round-tip">
                            <span class="text-secondary-700 font-medium text-sm dark:text-secondary-300">Arrondir pour pourboire (<span class="tip-amount">0,00€</span>)</span>
                        </label>
                    </div>
                </div>
                {{-- Payment Actions --}}
                <div class="flex gap-2 mt-4">
                    <button class="flex-1 py-3 px-4 h-11 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer border border-gray-200 bg-white text-gray-800 transition-colors hover:bg-gray-100 active:scale-[0.97] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700" id="cancel-payment">
                        <i class="fas fa-times" aria-hidden="true"></i> Annuler
                    </button>
                    <button class="flex-1 py-3 px-4 h-11 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer bg-primary-500 border border-primary-500 text-white transition-colors hover:bg-primary-600 hover:border-primary-600 active:scale-[0.97]" id="complete-payment">
                        <i class="fas fa-check" aria-hidden="true"></i> Valider Paiement
                    </button>
                </div>
            </div>

            <!-- Receipt Tab Content -->
            <div id="receipt-tab" class="h-full w-full absolute top-0 left-0 p-4 overflow-y-auto" role="tabpanel" aria-labelledby="tab-receipt-desktop tab-receipt-mobile" hidden>
                <div class="max-w-[600px] mx-auto">
                    {{-- Receipt Paper --}}
                    <div class="max-w-[360px] mx-auto mb-6 bg-white rounded-md shadow-md overflow-hidden dark:bg-gray-800">
                        <div class="p-4 text-center border-b border-dashed border-gray-200 dark:border-gray-700">
                            {{-- Receipt Header --}}
                            <div class="font-extrabold text-xl mb-1 text-gray-800 dark:text-gray-100">{{ $restaurantName ?? 'OctoPOS' }}</div>
                            <div class="font-bold mb-1 text-gray-800 dark:text-gray-100">{{ $restaurantAddressLine1 ?? 'Le Bistro Gourmand' }}</div>
                            <div class="text-xs text-gray-500 mb-1 dark:text-gray-400">{{ $restaurantAddressLine2 ?? '123 Rue de la Saveur, 75001 Paris' }}</div>
                            <div class="text-xs text-gray-500 mb-1 dark:text-gray-400">Tel: {{ $restaurantPhone ?? '01 98 76 54 32' }}</div>
                            <div class="text-xs text-gray-500 mb-1 dark:text-gray-400">Table: <span class="receipt-table-num">N/A</span> - Serveur: {{ $userName ?? 'Serveur' }}</div>
                            <div class="text-xs text-gray-500 receipt-datetime dark:text-gray-400">Loading date...</div>
                        </div>
                        <div class="p-4">
                             {{-- Receipt Items Area (JS populates this) --}}
                            <div class="mb-4" aria-label="Articles commandés">
                                <div class="text-center text-gray-500 py-4 italic">Aucun article pour le moment.</div>
                            </div>
                            {{-- Receipt Totals (JS populates values) --}}
                            <div class="pt-4 border-t border-dashed border-gray-200 dark:border-gray-700" aria-label="Totaux">
                                <div class="grid grid-cols-[1fr_auto] gap-2 text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">Sous-total HT:</div><div class="text-right font-medium text-gray-800 receipt-subtotal-val dark:text-gray-100">0,00€</div></div>
                                <div class="grid grid-cols-[1fr_auto] gap-2 text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">TVA ({{ ($taxRate ?? 0.1) * 100 }}%):</div><div class="text-right font-medium text-gray-800 receipt-tax-val dark:text-gray-100">0,00€</div></div>
                                <div class="grid grid-cols-[1fr_auto] gap-2 font-bold border-t border-gray-200 pt-2 mt-2 dark:border-gray-700"><div class="text-gray-800 dark:text-gray-100">TOTAL TTC:</div><div class="text-right text-gray-800 receipt-total-val dark:text-gray-100">0,00€</div></div>
                                <div class="grid grid-cols-[1fr_auto] gap-2 receipt-payment-details" style="display: none;"><div class="text-gray-500 dark:text-gray-400">Payé (...):</div><div class="text-right font-medium text-gray-800 receipt-paid-val dark:text-gray-100">0,00€</div></div>
                                <div class="grid grid-cols-[1fr_auto] gap-2 receipt-payment-details" style="display: none;"><div class="text-gray-500 dark:text-gray-400">Rendu:</div><div class="text-right font-medium text-gray-800 receipt-change-val dark:text-gray-100">0,00€</div></div>
                            </div>
                        </div>
                        {{-- Receipt Footer --}}
                        <div class="p-4 text-center border-t border-dashed border-gray-200 dark:border-gray-700">
                            <div class="text-xs text-gray-500 mb-3 dark:text-gray-400">{{ $receiptFooterMessage ?? 'Merci de votre visite et à bientôt !' }}</div>
                            <div class="text-xs text-gray-500 mb-3 dark:text-gray-400">TVA N° {{ $restaurantVatNumber ?? 'FR123456789' }}</div>
                            <div class="w-[100px] h-[100px] bg-gray-100 mx-auto mb-4 flex items-center justify-center border border-gray-200 rounded-sm dark:bg-gray-700 dark:border-gray-600" aria-label="QR Code pour laisser un avis">
                                <i class="fas fa-qrcode text-5xl text-gray-500 dark:text-gray-400"></i> {{-- Placeholder QR --}}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Scannez pour laisser votre avis</div>
                        </div>
                    </div>
                    {{-- Receipt Action Buttons --}}
                    <div class="flex justify-center gap-2 flex-wrap">
                        <button class="min-w-[100px] max-w-[150px] flex-1 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer bg-primary-500 border border-primary-500 text-white transition-colors hover:bg-primary-600 hover:border-primary-600 active:scale-[0.97]" aria-label="Imprimer le ticket">
                            <i class="fas fa-print" aria-hidden="true"></i> Imprimer
                        </button>
                        <button class="min-w-[100px] max-w-[150px] flex-1 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer border border-gray-200 bg-white text-gray-800 transition-colors hover:bg-gray-100 active:scale-[0.97] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700" aria-label="Envoyer le ticket par Email">
                            <i class="fas fa-envelope" aria-hidden="true"></i> Email
                        </button>
                        <button class="min-w-[100px] max-w-[150px] flex-1 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer border border-gray-200 bg-white text-gray-800 transition-colors hover:bg-gray-100 active:scale-[0.97] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700" aria-label="Envoyer le ticket par SMS">
                            <i class="fas fa-mobile-alt" aria-hidden="true"></i> SMS
                        </button>
                    </div>
                    <!-- Payment Success Panel (JS handles visibility) -->
                    <div class="bg-secondary-50 border border-secondary-500 rounded-md p-4 mt-6 dark:bg-secondary-900/30 dark:border-secondary-700" hidden>
                        <div class="text-secondary-700 font-bold text-lg flex items-center gap-2 mb-2 dark:text-secondary-300">
                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                            Paiement réussi!
                        </div>
                         {{-- JS updates table number --}}
                        <div class="text-sm text-gray-500 mb-4 dark:text-gray-400">
                            La table <span class="receipt-table-num">N/A</span> est maintenant marquée comme libre et prête pour les prochains clients.
                        </div>
                        <div class="flex gap-2 mt-4">
                            <button class="flex-1 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer border border-gray-200 bg-white text-gray-800 transition-colors hover:bg-gray-100 active:scale-[0.97] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700" id="clean-table-btn">
                                <i class="fas fa-broom" aria-hidden="true"></i> Marquer comme nettoyée
                            </button>
                            <button class="flex-1 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer bg-secondary-500 border border-secondary-500 text-white transition-colors hover:bg-secondary-600 hover:border-secondary-600 active:scale-[0.97]" id="back-to-tables-btn">
                                <i class="fas fa-th-large" aria-hidden="true"></i> Retour aux tables
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Tab Content -->
            <div id="stats-tab" class="h-full w-full absolute top-0 left-0 p-4 overflow-y-auto" role="tabpanel" aria-labelledby="tab-stats-desktop tab-stats-mobile" hidden>
                <div class="bg-white rounded-md p-4 shadow-sm mb-4 dark:bg-gray-800">
                    <div class="font-bold mb-4 text-lg text-gray-800 flex items-center gap-2 dark:text-gray-100"><i class="fas fa-calendar-day" aria-hidden="true"></i> Statistiques du Jour</div>
                    {{-- Stats Placeholders - Pass $stats array from controller --}}
                    <div class="flex justify-between text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">Tables servies</div><div class="font-medium text-gray-800 dark:text-gray-200">{{ $stats['tables_served'] ?? 'N/A' }}</div></div>
                    <div class="flex justify-between text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">Clients servis</div><div class="font-medium text-gray-800 dark:text-gray-200">{{ $stats['customers_served'] ?? 'N/A' }}</div></div>
                    <div class="flex justify-between text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">Chiffre d'affaires</div><div class="font-medium text-gray-800 dark:text-gray-200">{{ number_format($stats['revenue'] ?? 0, 2, ',', ' ') }}€</div>
                    <div class="flex justify-between text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">Ticket moyen</div><div class="font-medium text-gray-800 dark:text-gray-200">{{ number_format($stats['average_ticket'] ?? 0, 2, ',', ' ') }}€</div>
                    <div class="flex justify-between text-sm mb-2"><div class="text-gray-500 dark:text-gray-400">Pourboires estimés</div><div class="font-medium text-gray-800 dark:text-gray-200">{{ number_format($stats['estimated_tips'] ?? 0, 2, ',', ' ') }}€</div>
                </div>
                <div class="bg-white rounded-md p-4 shadow-sm dark:bg-gray-800">
                    <div class="font-bold mb-4 text-lg text-gray-800 flex items-center gap-2 dark:text-gray-100"><i class="fas fa-tachometer-alt" aria-hidden="true"></i> Performance Personnelle</div>
                     {{-- Performance Placeholders - Pass $performance array from controller --}}
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <div class="text-gray-500 dark:text-gray-400">Temps moyen prise de commande</div>
                            <div class="font-medium text-gray-800 dark:text-gray-200">{{ $performance['avg_order_time'] ?? 'N/A' }} min <span class="{{ ($performance['avg_order_time_rating'] ?? '') == 'Rapide' ? 'text-secondary-500 dark:text-secondary-400' : 'text-gray-500' }}">({{ $performance['avg_order_time_rating'] ?? '-' }})</span></div>
                        </div>
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700" aria-label="Performance Temps de commande, {{ $performance['avg_order_time_percent'] ?? 0 }}%">
                            <div class="h-full bg-secondary-500 rounded-full" style="width: {{ $performance['avg_order_time_percent'] ?? 0 }}%;"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <div class="text-gray-500 dark:text-gray-400">Satisfaction client (avis récents)</div>
                            <div class="font-medium text-gray-800 dark:text-gray-200">{{ $performance['satisfaction_score'] ?? 'N/A' }} / 5 <i class="fas fa-star text-warning-500"></i></div>
                        </div>
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700" aria-label="Satisfaction client, {{ $performance['satisfaction_percent'] ?? 0 }}%">
                            <div class="h-full bg-primary-500 rounded-full" style="width: {{ $performance['satisfaction_percent'] ?? 0 }}%;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <div class="text-gray-500 dark:text-gray-400">Ventes additionnelles (Menu / Suggestions)</div>
                            <div class="font-medium text-gray-800 dark:text-gray-200">{{ $performance['upsell_percent'] ?? 'N/A' }}% <span class="{{ ($performance['upsell_rating'] ?? '') == 'Bon' ? 'text-secondary-500 dark:text-secondary-400' : 'text-gray-500' }}">({{ $performance['upsell_rating'] ?? '-' }})</span></div>
                        </div>
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700" aria-label="Performance Ventes additionnelles, {{ $performance['upsell_bar_percent'] ?? 0 }}%">
                            <div class="h-full bg-secondary-500 rounded-full" style="width: {{ $performance['upsell_bar_percent'] ?? 0 }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Panel (JS handles visibility and content) -->
        <div class="fixed bottom-0 left-0 right-0 bg-white shadow-[0_-4px_15px_rgba(0,0,0,0.1)] rounded-t-lg z-20 transform translate-y-[calc(100%-60px)] transition-transform duration-300 border-t border-gray-200 flex flex-col max-h-[80vh] dark:bg-gray-800 dark:border-gray-700" id="cart-panel" aria-labelledby="cart-heading" style="display: none;">
            <div class="px-4 pt-2 cursor-pointer" role="button" aria-expanded="false" aria-controls="cart-details">
                <div class="w-10 h-[5px] bg-gray-300 rounded-[2.5px] mx-auto mb-2 dark:bg-gray-600"></div>
                <div class="flex justify-between items-center pb-3">
                    <div>
                        <span class="font-semibold text-base text-gray-800 dark:text-gray-100" id="cart-heading">Table <span class="cart-table-id">N/A</span></span>
                        <span class="text-gray-500 text-sm ml-1 cart-count dark:text-gray-400">(0 articles)</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-bold text-primary-500 text-base cart-total dark:text-primary-400">0,00€</span>
                        <button class="bg-transparent border-none text-primary-500 font-semibold cursor-pointer text-sm py-2 px-2 -mr-2 cart-toggle-btn dark:text-primary-400" aria-label="Afficher/Masquer le détail du panier">
                            <i class="fas fa-chevron-up ml-1 transition-transform" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="cart-details" hidden>
                <div class="overflow-y-auto flex-grow px-4 border-t border-gray-200 dark:border-gray-700 cart-content">
                    <div class="py-8 text-center text-gray-500 dark:text-gray-400 cart-empty-message">
                        <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                        <p>Le panier est vide.</p>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-200 bg-white shadow-[0_-2px_5px_rgba(0,0,0,0.05)] dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-between text-sm mb-2"><span class="text-gray-500 dark:text-gray-400">Sous-total</span><span class="font-medium text-gray-800 cart-subtotal-footer dark:text-gray-200">0,00€</span></div>
                    <div class="flex justify-between text-sm mb-2"><span class="text-gray-500 dark:text-gray-400">TVA (10%)</span><span class="font-medium text-gray-800 cart-tax-footer dark:text-gray-200">0,00€</span></div>
                    <div class="flex justify-between font-bold mt-3 pt-3 border-t border-gray-200 dark:border-gray-700"><span class="text-base text-gray-800 dark:text-gray-100">Total</span><span class="text-xl text-primary-500 cart-grand-total-footer dark:text-primary-400">0,00€</span></div>
                    <div class="grid grid-cols-3 gap-2 mt-4">
                        <button class="py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer border border-gray-200 bg-white text-gray-800 transition-colors hover:bg-gray-100 active:scale-[0.97] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 disabled:opacity-60 disabled:cursor-not-allowed" id="cancel-order-btn" disabled><i class="fas fa-trash-alt" aria-hidden="true"></i> Annuler</button>
                        <button class="col-span-2 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer bg-primary-500 border border-primary-500 text-white transition-colors hover:bg-primary-600 hover:border-primary-600 active:scale-[0.97] disabled:opacity-60 disabled:cursor-not-allowed" id="send-to-kitchen-btn" disabled><i class="fas fa-paper-plane" aria-hidden="true"></i> Envoyer</button>
                        <button class="col-span-3 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer bg-secondary-500 border border-secondary-500 text-white transition-colors hover:bg-secondary-600 hover:border-secondary-600 active:scale-[0.97] mt-2 disabled:opacity-60 disabled:cursor-not-allowed" id="go-to-payment-btn" disabled><i class="fas fa-credit-card" aria-hidden="true"></i> Aller au Paiement</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Customization Modal (JS handles visibility and content reset) -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[19] opacity-0 invisible transition-opacity duration-300" id="customization-overlay">
            <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 scale-95 w-[90%] max-w-[500px] max-h-[90vh] bg-white rounded-lg p-6 z-[20] opacity-0 invisible transition-all duration-300 flex flex-col dark:bg-gray-800" id="customization-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title-label">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200 flex-shrink-0 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100" id="modal-title-label">Personnaliser l'article</h3>
                    <button class="w-9 h-9 bg-transparent border-none rounded-full flex items-center justify-center text-gray-500 cursor-pointer text-xl transition-colors hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 dark:hover:text-gray-200 modal-close" aria-label="Fermer la fenêtre de personnalisation"><i class="fas fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="flex-grow overflow-y-auto mb-6 modal-body">
                    {{-- Static example options - these should ideally be dynamic or reset carefully by JS --}}
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3 text-gray-800 text-base dark:text-gray-100">Cuisson</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2" role="radiogroup" aria-labelledby="cooking-level-label">
                            <div id="cooking-level-label" class="visually-hidden">Choisir la cuisson</div>
                            <button class="py-3 bg-white border border-gray-200 rounded-md text-center cursor-pointer text-sm text-gray-800 transition-colors hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 option-item" role="radio" aria-checked="false" data-option="Bleu">Bleu</button>
                            {{-- Assume 'Saignant' is the default active option --}}
                            <button class="py-3 bg-primary-50 border border-primary-500 rounded-md text-center cursor-pointer text-sm text-primary-500 font-semibold dark:bg-primary-900/30 dark:border-primary-600 dark:text-primary-400 option-item active" role="radio" aria-checked="true" data-option="Saignant">Saignant</button>
                            <button class="py-3 bg-white border border-gray-200 rounded-md text-center cursor-pointer text-sm text-gray-800 transition-colors hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 option-item" role="radio" aria-checked="false" data-option="À point">À point</button>
                            <button class="py-3 bg-white border border-gray-200 rounded-md text-center cursor-pointer text-sm text-gray-800 transition-colors hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 option-item" role="radio" aria-checked="false" data-option="Bien cuit">Bien cuit</button>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3 text-gray-800 text-base dark:text-gray-100">Accompagnement</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2" role="radiogroup" aria-labelledby="side-dish-label">
                            <div id="side-dish-label" class="visually-hidden">Choisir l'accompagnement</div>
                            {{-- Assume 'Frites' is the default active option --}}
                            <button class="py-3 bg-primary-50 border border-primary-500 rounded-md text-center cursor-pointer text-sm text-primary-500 font-semibold dark:bg-primary-900/30 dark:border-primary-600 dark:text-primary-400 option-item active" role="radio" aria-checked="true" data-option="Frites">Frites</button>
                            <button class="py-3 bg-white border border-gray-200 rounded-md text-center cursor-pointer text-sm text-gray-800 transition-colors hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 option-item" role="radio" aria-checked="false" data-option="Légumes">Légumes</button>
                            <button class="py-3 bg-white border border-gray-200 rounded-md text-center cursor-pointer text-sm text-gray-800 transition-colors hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 option-item" role="radio" aria-checked="false" data-option="Purée">Purée</button>
                            <button class="py-3 bg-white border border-gray-200 rounded-md text-center cursor-pointer text-sm text-gray-800 transition-colors hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 option-item" role="radio" aria-checked="false" data-option="Gratin">Gratin</button>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3 text-gray-800 text-base dark:text-gray-100">Extras</h4>
                        <div class="flex flex-col gap-2" role="group" aria-labelledby="extras-label">
                            <div id="extras-label" class="visually-hidden">Choisir les extras</div>
                            <label class="flex justify-between items-center p-3 bg-gray-50 border border-gray-200 rounded-md cursor-pointer dark:bg-gray-700 dark:border-gray-600 extra-item" role="checkbox" aria-checked="false" tabindex="0">
                                <div class="flex items-center gap-3 text-sm text-gray-800 dark:text-gray-100"><div class="w-5 h-5 border-2 border-gray-200 rounded flex items-center justify-center flex-shrink-0 transition-colors dark:border-gray-600 checkbox" aria-hidden="true"></div><span>Sauce béarnaise</span></div><div class="font-semibold text-sm text-gray-500 dark:text-gray-400">+2,50€</div>
                            </label>
                            <label class="flex justify-between items-center p-3 bg-gray-50 border border-gray-200 rounded-md cursor-pointer dark:bg-gray-700 dark:border-gray-600 extra-item" role="checkbox" aria-checked="false" tabindex="0">
                                <div class="flex items-center gap-3 text-sm text-gray-800 dark:text-gray-100"><div class="w-5 h-5 border-2 border-gray-200 rounded flex items-center justify-center flex-shrink-0 transition-colors dark:border-gray-600 checkbox" aria-hidden="true"></div><span>Supplément frites</span></div><div class="font-semibold text-sm text-gray-500 dark:text-gray-400">+3,00€</div>
                            </label>
                            <label class="flex justify-between items-center p-3 bg-gray-50 border border-gray-200 rounded-md cursor-pointer dark:bg-gray-700 dark:border-gray-600 extra-item" role="checkbox" aria-checked="false" tabindex="0"> {{-- Assume 'Sans sel' is unchecked by default --}}
                                <div class="flex items-center gap-3 text-sm text-gray-800 dark:text-gray-100"><div class="w-5 h-5 border-2 border-gray-200 rounded flex items-center justify-center flex-shrink-0 transition-colors dark:border-gray-600 checkbox" aria-hidden="true"></div><span>Sans sel</span></div><div class="font-semibold text-sm text-gray-500 dark:text-gray-400"></div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3 text-gray-800 text-base dark:text-gray-100" id="notes-label">Notes spéciales</h4>
                        <textarea class="w-full p-3 border border-gray-200 rounded-md resize-vertical min-h-[80px] bg-white text-gray-800 text-sm transition-colors focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-primary-900 notes-field" placeholder="Allergies, instructions spéciales..." aria-labelledby="notes-label"></textarea>
                    </div>
                </div>
                <div class="flex gap-2 mt-auto flex-shrink-0 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button class="flex-1 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer border border-gray-200 bg-white text-gray-800 transition-colors hover:bg-gray-100 active:scale-[0.97] dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700 modal-cancel-btn">Annuler</button>
                    <button class="flex-1 py-3 px-4 rounded-md font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer bg-primary-500 border border-primary-500 text-white transition-colors hover:bg-primary-600 hover:border-primary-600 active:scale-[0.97] add-to-cart-btn"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter à la commande</button>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation (Mobile) -->
        <nav class="flex bg-white border-t border-gray-200 fixed bottom-0 left-0 right-0 z-10 transition-colors dark:bg-gray-800 dark:border-gray-700 md:hidden" role="navigation" aria-label="Navigation inférieure">
            {{-- Add unique IDs like "-mobile" --}}
            <a href="#" class="flex-1 flex flex-col items-center py-2 px-1 text-primary-500 border-t-[3px] border-primary-500 min-h-[56px] justify-center transition-colors dark:text-primary-400" data-tab="tables" role="tab" aria-selected="true" aria-controls="tables-tab" id="tab-tables-mobile">
                <i class="fas fa-th-large text-lg mb-0.5" aria-hidden="true"></i><span class="text-xs font-medium block">Tables</span>
            </a>
            <a href="#" class="flex-1 flex flex-col items-center py-2 px-1 text-gray-500 border-t-[3px] border-transparent min-h-[56px] justify-center hover:text-gray-800 transition-colors dark:text-gray-400 dark:hover:text-gray-200" data-tab="orders" role="tab" aria-selected="false" aria-controls="orders-tab" tabindex="-1" id="tab-orders-mobile">
                <i class="fas fa-utensils text-lg mb-0.5" aria-hidden="true"></i><span class="text-xs font-medium block">Commande</span>
            </a>
            <a href="#" class="flex-1 flex flex-col items-center py-2 px-1 text-gray-500 border-t-[3px] border-transparent min-h-[56px] justify-center hover:text-gray-800 transition-colors dark:text-gray-400 dark:hover:text-gray-200" data-tab="payment" role="tab" aria-selected="false" aria-controls="payment-tab" tabindex="-1" id="tab-payment-mobile">
                <i class="fas fa-cash-register text-lg mb-0.5" aria-hidden="true"></i><span class="text-xs font-medium block">Paiement</span>
            </a>
            <a href="#" class="flex-1 flex flex-col items-center py-2 px-1 text-gray-500 border-t-[3px] border-transparent min-h-[56px] justify-center hover:text-gray-800 transition-colors dark:text-gray-400 dark:hover:text-gray-200" data-tab="receipt" role="tab" aria-selected="false" aria-controls="receipt-tab" tabindex="-1" id="tab-receipt-mobile">
                <i class="fas fa-receipt text-lg mb-0.5" aria-hidden="true"></i><span class="text-xs font-medium block">Tickets</span>
            </a>
            <a href="#" class="flex-1 flex flex-col items-center py-2 px-1 text-gray-500 border-t-[3px] border-transparent min-h-[56px] justify-center hover:text-gray-800 transition-colors dark:text-gray-400 dark:hover:text-gray-200" data-tab="stats" role="tab" aria-selected="false" aria-controls="stats-tab" tabindex="-1" id="tab-stats-mobile">
                <div class="relative"><i class="fas fa-chart-line text-lg mb-0.5" aria-hidden="true"></i></div><span class="text-xs font-medium block">Stats</span>
            </a>
        </nav>

        
        <div class="fixed left-1/2 bottom-[70px] md:bottom-5 -translate-x-1/2 z-[100] flex flex-col items-center gap-2 toast-container" aria-live="assertive" aria-atomic="true">
        </div>
    </div> 
@endsection
>>>>>>> b78e058317fce2f187271eca71cd7f410c5ff94d
