@extends('layouts.client_app') 
@section('title', 'OctoPOS | Tableau de Bord Client') 

@section('content') {{-- Define the content section --}}

<div class="p-6">

    <div id="dashboard-section">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Tableau de bord Client</h1>
    
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            {{-- Card 1: Total Reservations --}}
            <div class="dashboard-card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm" style="color: var(--text-secondary);">Réservations Totales</h3>
                        <p class="text-2xl font-bold mt-1">{{ $totalReservationsCount }}</p>
                    </div>
                    <div class="p-3 rounded-lg" style="background-color: rgba(var(--info-rgb), 0.1);">
                        <i class="fas fa-calendar-check text-xl" style="color: var(--info);"></i>
                    </div>
                </div>
                <div class="flex items-center mt-4 text-sm">
                    <span class="flex items-center mr-1 font-medium" style="color: var(--success);">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i> {{ $reservationGrowth }}%
                    </span>
                    <span style="color: var(--text-secondary);"> vs mois dernier</span>
                </div>
            </div>
    
            {{-- Card 2: Upcoming Reservations --}}
            <div class="dashboard-card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm" style="color: var(--text-secondary);">Réservations à venir</h3>
                        <p class="text-2xl font-bold mt-1">{{ $upcomingReservationsCount }}</p>
                    </div>
                    <div class="p-3 rounded-lg" style="background-color: rgba(var(--success-rgb), 0.1);">
                        <i class="fas fa-clock text-xl" style="color: var(--success);"></i>
                    </div>
                </div>
                <div class="flex items-center mt-4 text-sm">
                    <span class="flex items-center mr-1 font-medium" style="color: var(--success);">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i> {{ $weeklyGrowth }}%
                    </span>
                    <span style="color: var(--text-secondary);"> vs semaine dernière</span>
                </div>
            </div>
    
            {{-- Card 3: Favorite Table --}}
            <div class="dashboard-card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm" style="color: var(--text-secondary);">Table Favorite</h3>
                        <p class="text-2xl font-bold mt-1">{{ $favoriteTable }}</p>
                    </div>
                    <div class="p-3 rounded-lg" style="background-color: rgba(var(--warning-rgb), 0.1);">
                        <i class="fas fa-star text-xl" style="color: var(--warning);"></i>
                    </div>
                </div>
                <div class="flex items-center mt-4 text-sm">
                    <span class="flex items-center" style="color: var(--text-secondary);">
                        <i class="fas fa-info-circle mr-1 text-xs"></i> Réservée {{ $favoriteTableCount }} fois
                    </span>
                </div>
            </div>
    
            {{-- Card 4: Total Spent --}}
            <div class="dashboard-card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm" style="color: var(--text-secondary);">Dépenses Totales</h3>
                        <p class="text-2xl font-bold mt-1">€{{ number_format($totalSpent, 2) }}</p>
                    </div>
                    <div class="p-3 rounded-lg" style="background-color: rgba(var(--accent-rgb), 0.1);">
                        <i class="fas fa-wallet text-xl" style="color: var(--accent);"></i>
                    </div>
                </div>
                <div class="flex items-center mt-4 text-sm">
                    <span class="flex items-center mr-1 font-medium" style="color: var(--success);">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i> {{ $spendingGrowth }}%
                    </span>
                    <span style="color: var(--text-secondary);"> vs mois dernier</span>
                </div>
            </div>
        </div>
    
        <!-- Upcoming Reservations Table -->
        <div class="dashboard-card p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Réservations à venir</h2>
                <a href="#reservations" class="btn btn-sm btn-outline nav-link">Voir tout</a>
            </div>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID Réservation</th>
                            <th>Date & Heure</th>
                            <th>Table</th>
                            <th>Invités</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingReservations as $reservation)
                            <tr>
                                <td class="font-medium">#{{ $reservation->reservation_number }}</td>
                                <td>{{ $reservation->formatted_date }} - {{ $reservation->formatted_time }}</td>
                                <td>{{ $reservation->table_name }}</td>
                                <td>{{ $reservation->invite }} </td>
                                <td>
                                    @if($reservation->status === 'confirmed')
                                        <span class="badge badge-green">Confirmée</span>
                                    @elseif($reservation->status === 'pending')
                                        <span class="badge badge-yellow">En attente</span>
                                    @else
                                        <span class="badge badge-gray">{{ ucfirst($reservation->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- IMPORTANT: Changed from onclick to data attributes -->
                                    <button class="btn btn-sm btn-icon btn-outline mr-1 edit-reservation" 
                                            data-id="{{ $reservation->id }}" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-outline-danger cancel-reservation"
                                    data-id="{{ $reservation->id }}" title="Annuler">
                                <i class="fas fa-trash"></i>
                            </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Aucune réservation à venir</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        function editReservation(id) {
           
        }
        
        function editReservation(id) {
    // Your edit reservation logic here
    console.log("Editing reservation: " + id);
}


 
    </script>

   
    
<div id="reservations-section" class="hidden">
    <h1 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Mes Réservations</h1>

    <!-- Reservations Controls -->
    <div class="dashboard-card p-6 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
            <div class="flex gap-2">
                {{-- Use JS to navigate or link to a dedicated booking page/modal --}}
                <button class="btn btn-primary btn-sm nav-link" data-href="#tables">
                    <i class="fas fa-plus"></i> Nouvelle Réservation
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
            </div>
            <div class="relative w-full sm:w-auto">
                <input type="text" placeholder="Rechercher..." class="form-input !py-1.5 pl-10 w-full sm:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-[var(--text-secondary)]"></i>
            </div>
        </div>

        <div class="flex flex-wrap gap-2 mt-4">
            <button class="btn btn-sm filter-btn active btn-primary" data-filter="all">Tout</button>
            <button class="btn btn-sm btn-outline filter-btn" data-filter="upcoming">À venir</button>
            <button class="btn btn-sm btn-outline filter-btn" data-filter="past">Passées</button>
            <button class="btn btn-sm btn-outline filter-btn" data-filter="canceled">Annulées</button>
        </div>
    </div>

    <!-- Reservations List -->
    <div class="space-y-4">
        @forelse($upcomingReservations as $reservation)
            @php
                // Define badge classes and labels based on status
                $badgeClasses = [
                    'confirmed' => 'badge-green',
                    'pending' => 'badge-yellow',
                    'completed' => 'badge-gray',
                    'canceled' => 'badge-red'
                ];
                
                $statusLabels = [
                    'confirmed' => 'Confirmée',
                    'pending' => 'En attente',
                    'completed' => 'Terminée',
                    'canceled' => 'Annulée'
                ];
                
                // Check if reservation is in the past
                $isPast = strtotime($reservation->date . ' ' . $reservation->start_time) < strtotime(now());
                
                // Determine reservation time (past or upcoming)
                $timeCategory = $isPast ? 'past' : 'upcoming';
                
                // Determine if reservation can be edited or canceled
                $isEditable = in_array($reservation->status, ['confirmed', 'pending']) && !$isPast;
                $isCancelable = in_array($reservation->status, ['confirmed', 'pending']) && !$isPast;
            @endphp

            <div 
                class="dashboard-card p-6 reservation-card {{ $isPast ? 'past' : '' }}" 
                data-status="{{ $reservation->status }}" 
                data-time="{{ $timeCategory }}"
            >
                <div class="flex flex-col md:flex-row justify-between">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center mb-2">
                            <span class="badge {{ $badgeClasses[$reservation->status] ?? 'badge-gray' }} mr-2">
                                {{ $statusLabels[$reservation->status] ?? 'Inconnu' }}
                            </span>
                            <span class="text-sm" style="color: var(--text-secondary);">#{{ $reservation->id }}</span>
                        </div>
                        <h3 class="text-lg font-bold mb-1 {{ $reservation->status === 'canceled' ? 'line-through' : '' }}">
                            {{ $reservation->title }}
                        </h3>
                        <div class="flex items-center text-sm mb-1" style="color: var(--text-secondary);">
                            <i class="fas fa-calendar-alt mr-2 w-4 text-center"></i>
                            <span>{{ \Carbon\Carbon::parse($reservation->date)->format('j F Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm mb-1" style="color: var(--text-secondary);">
                            <i class="fas fa-clock mr-2 w-4 text-center"></i>
                            <span>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</span>
                        </div>
                        <div class="flex items-center text-sm" style="color: var(--text-secondary);">
                            <i class="fas fa-user-friends mr-2 w-4 text-center"></i>
                            <span>{{ $reservation->invite }} Invités</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-start md:items-end">
                        <div class="text-sm mb-2" style="color: var(--text-secondary);">
                            <i class="fas fa-map-marker-alt mr-1"></i> Table #{{ $reservation->table_id }}
                        </div>
                        <div class="mt-4 space-y-2 md:space-y-0 md:space-x-2 flex flex-col md:flex-row w-full md:w-auto">
                            @if($isEditable)
                                <button class="btn btn-primary btn-sm w-full md:w-auto" 
                                        onclick="editReservation('{{ $reservation->id }}')">Modifier</button>
                            @endif
                            
                            @if($isCancelable)
                                <button class="btn btn-outline-danger btn-sm w-full md:w-auto" 
                                        onclick="cancelReservation('{{ $reservation->id }}')">Annuler</button>
                            @endif
                            
                            @if($isPast)
                                <button class="btn btn-secondary btn-sm w-full md:w-auto nav-link" data-href="#tables">
                                    Réserver à nouveau
                                </button>
                                
                                @if($reservation->has_invoice)
                                    <button class="btn btn-outline btn-sm w-full md:w-auto" 
                                            onclick="viewInvoice('{{ $reservation->invoice_id }}')">Voir Facture</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="dashboard-card p-6 text-center">
                <p class="text-lg" style="color: var(--text-secondary);">Vous n'avez pas encore de réservations.</p>
                <button class="btn btn-primary mt-4 nav-link" data-href="#tables">
                    <i class="fas fa-plus mr-2"></i>Créer ma première réservation
                </button>
            </div>
        @endforelse
    </div>
</div>

<script>
    // Current logged in user: {{ Auth::user()->username ?? 'HamzaBr01' }}
    // Current date/time: {{ now()->format('Y-m-d H:i:s') }}
    
    document.addEventListener('DOMContentLoaded', function() {
        // Filter buttons functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const reservationCards = document.querySelectorAll('.reservation-card');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => {
                    btn.classList.remove('active', 'btn-primary');
                    btn.classList.add('btn-outline');
                });
                
                // Add active class to clicked button
                this.classList.add('active', 'btn-primary');
                this.classList.remove('btn-outline');
                
                const filter = this.getAttribute('data-filter');
                
                // Show/hide reservation cards based on filter
                reservationCards.forEach(card => {
                    if (filter === 'all' || 
                        (filter === 'upcoming' && card.getAttribute('data-time') === 'upcoming') ||
                        (filter === 'past' && card.getAttribute('data-time') === 'past') ||
                        (filter === 'canceled' && card.getAttribute('data-status') === 'canceled')) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        
        // Search functionality
        const searchInput = document.querySelector('input[placeholder="Rechercher..."]');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            reservationCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const id = card.querySelector('span.text-sm').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || id.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    function editReservation(id) {
        // Implement reservation editing functionality
        console.log('Editing reservation', id);
        // Redirect to edit page or show modal
    }
    
    function cancelReservation(id) {
        // Implement reservation cancellation with confirmation
        if (confirm('Êtes-vous sûr de vouloir annuler cette réservation?')) {
            console.log('Cancelling reservation', id);
            // Send AJAX request to cancel reservation
        }
    }
    
    function viewInvoice(invoiceId) {
        // Implement invoice viewing functionality
        console.log('Viewing invoice', invoiceId);
        // Redirect to invoice page or show modal
    }
</script>
   
    <div id="tables-section" class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Réserver une Table</h1>
    
        <!-- Enhanced Filtering Options -->
        <form id="filter-form" method="GET" action="{{ url()->current() }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="relative">
                    <label for="dashboard-restaurant-select" class="block text-sm font-medium text-gray-700 mb-1">Restaurant</label>
                    <select id="dashboard-restaurant-select" name="restaurant" class="form-select w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50">
                        <option value="">Tous les restaurants</option>
                        @foreach($restaurantNames as $id => $name)
                            <option value="{{ $id }}" {{ $restaurantFilter == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="relative">
                    <label for="dashboard-date-select" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input 
                        type="date" 
                        id="dashboard-date-select" 
                        name="date" 
                        value="{{ $dateFilter ?? $today }}"
                        min="{{ $today }}" 
                        class="form-input w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50"
                    >
                </div>
                
                <div class="relative">
                    <label for="dashboard-persons-select" class="block text-sm font-medium text-gray-700 mb-1">Capacité</label>
                    <select id="dashboard-persons-select" name="persons" class="form-select w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50">
                        <option value="">Toutes capacités</option>
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ $personsFilter == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $i == 1 ? 'personne' : 'personnes' }}
                            </option>
                        @endfor
                        <option value="9+" {{ $personsFilter == '9+' ? 'selected' : '' }}>9+ personnes</option>
                    </select>
                </div>
            </div>
        </form>
    
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Table Layout with Dynamic Data -->
            <div id="tables" class="bg-gray-50 p-6 rounded-xl shadow-sm lg:col-span-2">
                <h2 class="text-lg font-semibold mb-2">Plan des tables</h2>
                <p class="mb-4 text-gray-600">Sélectionnez une table disponible.</p>
    
                <!-- Table Type Tabs -->
                <div class="flex border-b border-gray-200 mb-6">
                    <button type="button" data-table-filter="all" class="table-filter-btn py-2 px-4 border-b-2 border-[#0288D1] text-[#0288D1] font-medium">Toutes les tables</button>
                    <button type="button" data-table-filter="SallePrincipale" class="table-filter-btn py-2 px-4 text-gray-500 hover:text-[#0288D1] transition">Salle Principale</button>
                    <button type="button" data-table-filter="Vip" class="table-filter-btn py-2 px-4 text-gray-500 hover:text-[#0288D1] transition">Espace VIP</button>
                    <button type="button" data-table-filter="Terrasse" class="table-filter-btn py-2 px-4 text-gray-500 hover:text-[#0288D1] transition">Terrasse</button>
                </div>
    
                <div class="flex flex-wrap gap-3 mb-6">
                    <!-- Main Dining Tables -->
                    @foreach($tablesByType['SallePrincipale']['available'] as $table)
                        <button class="table-select-btn bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-3 transition-all hover:shadow-md" 
                                data-table-id="{{ $table->id }}" 
                                data-table-name="Table {{ $table->numero }}" 
                                data-table-capacity="{{ $table->capacite }}"
                                data-table-type="SallePrincipale">
                            <div class="relative">
                                <i class="fas fa-utensils text-xl mb-1 text-[#0288D1]"></i>
                                <p class="font-medium">Table {{ $table->numero }}</p>
                                <span class="text-xs block text-gray-600">{{ $table->capacite }} {{ $table->capacite == 1 ? 'place' : 'places' }}</span>
                                <span class="absolute top-1 right-1 w-3 h-3 rounded-full bg-gradient-to-r from-[#4CAF50] to-[#2E7D32]"></span>
                            </div>
                        </button>
                    @endforeach
    
                    @foreach($tablesByType['SallePrincipale']['unavailable'] as $table)
                        <button class="table-select-btn bg-white opacity-60 border border-gray-200 rounded-lg p-3 cursor-not-allowed" 
                                disabled
                                data-table-type="SallePrincipale">
                            <div class="relative">
                                <i class="fas fa-utensils text-xl mb-1 text-gray-400"></i>
                                <p class="font-medium">Table {{ $table->numero }}</p>
                                <span class="text-xs block text-gray-600">{{ $table->capacite }} {{ $table->capacite == 1 ? 'place' : 'places' }}</span>
                                <span class="absolute top-1 right-1 w-3 h-3 rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828]"></span>
                            </div>
                        </button>
                    @endforeach
    
                    <!-- VIP Tables -->
                    @foreach($tablesByType['Vip']['available'] as $table)
                        <button class="table-select-btn bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-3 transition-all hover:shadow-md" 
                                data-table-id="{{ $table->id }}" 
                                data-table-name="VIP {{ $table->numero }}" 
                                data-table-capacity="{{ $table->capacite }}"
                                data-table-type="Vip">
                            <div class="relative">
                                <i class="fas fa-crown text-xl mb-1 text-[#FFC107]"></i>
                                <p class="font-medium">VIP {{ $table->numero }}</p>
                                <span class="text-xs block text-gray-600">{{ $table->capacite }} {{ $table->capacite == 1 ? 'place' : 'places' }}</span>
                                <span class="absolute top-1 right-1 w-3 h-3 rounded-full bg-gradient-to-r from-[#4CAF50] to-[#2E7D32]"></span>
                            </div>
                        </button>
                    @endforeach
    
                    @foreach($tablesByType['Vip']['unavailable'] as $table)
                        <button class="table-select-btn bg-white opacity-60 border border-gray-200 rounded-lg p-3 cursor-not-allowed" 
                                disabled
                                data-table-type="Vip">
                            <div class="relative">
                                <i class="fas fa-crown text-xl mb-1 text-gray-400"></i>
                                <p class="font-medium">VIP {{ $table->numero }}</p>
                                <span class="text-xs block text-gray-600">{{ $table->capacite }} {{ $table->capacite == 1 ? 'place' : 'places' }}</span>
                                <span class="absolute top-1 right-1 w-3 h-3 rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828]"></span>
                            </div>
                        </button>
                    @endforeach
    
                    <!-- Terrace Tables -->
                    @foreach($tablesByType['Terrasse']['available'] as $table)
                        <button class="table-select-btn bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-3 transition-all hover:shadow-md" 
                                data-table-id="{{ $table->id }}" 
                                data-table-name="Terrasse {{ $table->numero }}" 
                                data-table-capacity="{{ $table->capacite }}"
                                data-table-type="Terrasse">
                            <div class="relative">
                                <i class="fas fa-umbrella-beach text-xl mb-1 text-[#03A9F4]"></i>
                                <p class="font-medium">Terrasse {{ $table->numero }}</p>
                                <span class="text-xs block text-gray-600">{{ $table->capacite }} {{ $table->capacite == 1 ? 'place' : 'places' }}</span>
                                <span class="absolute top-1 right-1 w-3 h-3 rounded-full bg-gradient-to-r from-[#4CAF50] to-[#2E7D32]"></span>
                            </div>
                        </button>
                    @endforeach
    
                    @foreach($tablesByType['Terrasse']['unavailable'] as $table)
                        <button class="table-select-btn bg-white opacity-60 border border-gray-200 rounded-lg p-3 cursor-not-allowed" 
                                disabled
                                data-table-type="Terrasse">
                            <div class="relative">
                                <i class="fas fa-umbrella-beach text-xl mb-1 text-gray-400"></i>
                                <p class="font-medium">Terrasse {{ $table->numero }}</p>
                                <span class="text-xs block text-gray-600">{{ $table->capacite }} {{ $table->capacite == 1 ? 'place' : 'places' }}</span>
                                <span class="absolute top-1 right-1 w-3 h-3 rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828]"></span>
                            </div>
                        </button>
                    @endforeach
                </div>
    
                <div class="flex gap-4 text-sm text-gray-600">
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-gradient-to-r from-[#4CAF50] to-[#2E7D32] mr-2"></span> Disponible</div>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-gradient-to-r from-[#F44336] to-[#C62828] mr-2"></span> Occupée</div>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#0288D1] mr-2"></span> Sélectionnée</div>
                </div>
            </div>
    
            <!-- Reservation Form -->
            <div class="bg-white p-6 rounded-xl shadow-md lg:sticky lg:top-[86px]">
                <!-- En-tête avec info utilisateur -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Compléter la réservation</h2>
                    
                </div>
                
                <!-- Date et heure actuelles -->
                <div class="mb-4 p-2 bg-gray-50 rounded text-xs text-gray-500 flex items-center">
                    <i class="fas fa-clock mr-1"></i> 
                    2025-04-18 16:55:13
                </div>
            
                <!-- Formulaire de réservation -->
                <form id="reservation-form" method="POST" action="/reservations">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Session::get('user_id', 1) }}">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Table sélectionnée -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="selected-table">Table Sélectionnée</label>
                            <input type="hidden" name="table_id" id="selected-table-id">
                            <div class="relative">
                                <input type="text" id="selected-table" class="form-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50" value="Aucune table sélectionnée" readonly>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-table text-gray-400"></i>
                                </div>
                            </div>
                        </div>
            
                        <!-- Nombre d'invités -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="guest-count">Nombre d'invités</label>
                            <div class="relative">
                                <select id="guest-count" name="number_of_guests" class="form-select block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50" required>
                                    <option value="">Sélectionnez une table d'abord</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-user-friends text-gray-400"></i>
                                </div>
                            </div>
                        </div>
            
                        <!-- Date de réservation -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="reservation-date">Date</label>
                            <div class="relative">
                                <input type="date" id="reservation-date" name="date" value="{{ $dateFilter ?? '2025-04-18' }}" min="{{ $today ?? '2025-04-18' }}" class="form-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                            </div>
                        </div>
            
                        <!-- Heure de réservation -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="reservation-time">Heure</label>
                            <div class="relative">
                                <select id="reservation-time" name="time" class="form-select block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50" required>
                                    <option value="">Sélectionnez une table et une date d'abord</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-clock text-gray-400"></i>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Horaires d'ouverture: 10h - 22h</p>
                        </div>
            
                        <!-- Durée de réservation -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="reservation-duration">Durée</label>
                            <div class="relative">
                                <select id="reservation-duration" name="duree" class="form-select block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50" required>
                                    <option value="">Sélectionnez date et heure d'abord</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-hourglass-half text-gray-400"></i>
                                </div>
                            </div>
                            <div id="closing-time-warning" class="mt-1 text-xs text-amber-600 hidden">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                La durée est limitée par l'heure de fermeture (22h)
                            </div>
                        </div>
            
                        <!-- Demandes spéciales -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="special-requests">Demandes Spéciales (optionnel)</label>
                            <textarea id="special-requests" name="special_requests" class="form-textarea block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0288D1] focus:ring focus:ring-[#0288D1] focus:ring-opacity-50" rows="3" placeholder="Allergies, préférences, etc."></textarea>
                        </div>
                    </div>
            
                    <!-- Récapitulatif de la réservation -->
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg text-sm hidden" id="reservation-summary">
                        <h3 class="font-medium text-gray-700 mb-2">Récapitulatif</h3>
                        <ul class="space-y-1 text-gray-600">
                            <li><span class="font-medium">Table:</span> <span id="summary-table">-</span></li>
                            <li><span class="font-medium">Date:</span> <span id="summary-date">-</span></li>
                            <li><span class="font-medium">Heure:</span> <span id="summary-time">-</span></li>
                            <li><span class="font-medium">Durée:</span> <span id="summary-duration">-</span></li>
                            <li><span class="font-medium">Fin prévue:</span> <span id="summary-end-time">-</span></li>
                            <li><span class="font-medium">Personnes:</span> <span id="summary-guests">-</span></li>
                        </ul>
                    </div>
            
                    <!-- Bouton de confirmation -->
                    <div class="mt-6">
                        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-[#0288D1] to-[#026da8] text-white font-medium rounded-lg shadow-md hover:shadow-lg transition focus:outline-none focus:ring-2 focus:ring-[#0288D1] focus:ring-opacity-50">
                            <i class="fas fa-calendar-check mr-2"></i>Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    {{-- Invoices Section (Hidden by default) --}}
    <div id="invoices-section" class="hidden">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Mes Factures</h1>

        <!-- Invoices Controls -->
        <div class="dashboard-card p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex gap-2">
                    <button class="btn btn-outline btn-sm"><i class="fas fa-filter"></i> Filtrer</button>
                    <button class="btn btn-outline btn-sm"><i class="fas fa-sort"></i> Trier</button>
                </div>
                <div class="relative w-full sm:w-auto">
                    <input type="text" placeholder="Rechercher..." class="form-input !py-1.5 pl-10 w-full sm:w-64">
                     <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-[var(--text-secondary)]"></i>
                </div>
            </div>
        </div>

        <!-- Invoices List -->
        <div class="dashboard-card overflow-hidden">
             <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Facture</th>
                            <th>Date</th>
                            <th>Réservation</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                         {{-- Example Row: Loop through $invoices in real app --}}
                        <tr>
                            <td>
                                 <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9 flex items-center justify-center rounded-md" style="background-color: rgba(var(--primary-rgb), 0.05);">
                                        <i class="fas fa-file-invoice-dollar" style="color: var(--text-secondary);"></i>
                                    </div>
                                    <div class="ml-3"><div class="text-sm font-medium">#INV-0025</div></div>
                                </div>
                            </td>
                            <td>10 Avril 2025</td><td>#RS12342</td><td>€85.40</td>
                            <td><span class="badge badge-green">Payée</span></td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-outline mr-1" onclick="viewInvoice('INV-0025')" title="Voir"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-icon btn-outline" title="Télécharger"><i class="fas fa-download"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9 flex items-center justify-center rounded-md" style="background-color: rgba(var(--primary-rgb), 0.05);">
                                        <i class="fas fa-file-invoice-dollar" style="color: var(--text-secondary);"></i>
                                    </div>
                                    <div class="ml-3"><div class="text-sm font-medium">#INV-0024</div></div>
                                </div>
                            </td>
                            <td>28 Mars 2025</td><td>#RS12339</td><td>€124.60</td>
                            <td><span class="badge badge-green">Payée</span></td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-outline mr-1" onclick="viewInvoice('INV-0024')" title="Voir"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-icon btn-outline" title="Télécharger"><i class="fas fa-download"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9 flex items-center justify-center rounded-md" style="background-color: rgba(var(--primary-rgb), 0.05);">
                                        <i class="fas fa-file-invoice-dollar" style="color: var(--text-secondary);"></i>
                                    </div>
                                    <div class="ml-3"><div class="text-sm font-medium">#INV-0023</div></div>
                                </div>
                            </td>
                            <td>15 Mars 2025</td><td>#RS12335</td><td>€95.80</td>
                            <td><span class="badge badge-green">Payée</span></td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-outline mr-1" onclick="viewInvoice('INV-0023')" title="Voir"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-icon btn-outline" title="Télécharger"><i class="fas fa-download"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9 flex items-center justify-center rounded-md" style="background-color: rgba(var(--primary-rgb), 0.05);">
                                        <i class="fas fa-file-invoice-dollar" style="color: var(--text-secondary);"></i>
                                    </div>
                                    <div class="ml-3"><div class="text-sm font-medium">#INV-0022</div></div>
                                </div>
                            </td>
                            <td>5 Mars 2025</td><td>#RS12330</td><td>€81.40</td>
                            <td><span class="badge badge-green">Payée</span></td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-outline mr-1" onclick="viewInvoice('INV-0022')" title="Voir"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-icon btn-outline" title="Télécharger"><i class="fas fa-download"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{-- Use Laravel Paginator links: {{ $invoices->links() }} --}}
             <div class="px-4 py-3 flex items-center justify-between border-t sm:px-6" style="border-color: var(--border-color);">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" class="btn btn-sm btn-outline">Précédent</a>
                    <a href="#" class="btn btn-sm btn-outline">Suivant</a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm" style="color: var(--text-secondary);">
                            Affichage <span class="font-medium" style="color: var(--text-primary);">1</span> à <span class="font-medium" style="color: var(--text-primary);">4</span> sur <span class="font-medium" style="color: var(--text-primary);">12</span> résultats
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                             <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border text-sm font-medium hover:bg-[rgba(var(--primary-rgb),0.05)]" style="border-color: var(--border-color); color: var(--text-secondary); background-color: var(--card-bg);"><span class="sr-only">Précédent</span><i class="fas fa-chevron-left text-xs h-5 w-5" aria-hidden="true"></i></a>
                             <a href="#" aria-current="page" class="relative z-10 inline-flex items-center px-4 py-2 border text-sm font-medium" style="border-color: var(--primary); background-color: rgba(var(--primary-rgb), 0.1); color: var(--primary);"> 1 </a>
                             <a href="#" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium hover:bg-[rgba(var(--primary-rgb),0.05)]" style="border-color: var(--border-color); color: var(--text-secondary); background-color: var(--card-bg);"> 2 </a>
                             <a href="#" class="relative hidden md:inline-flex items-center px-4 py-2 border text-sm font-medium hover:bg-[rgba(var(--primary-rgb),0.05)]" style="border-color: var(--border-color); color: var(--text-secondary); background-color: var(--card-bg);"> 3 </a>
                             <span class="relative inline-flex items-center px-4 py-2 border text-sm font-medium" style="border-color: var(--border-color); color: var(--text-secondary); background-color: var(--card-bg);"> ... </span>
                             <a href="#" class="relative hidden md:inline-flex items-center px-4 py-2 border text-sm font-medium hover:bg-[rgba(var(--primary-rgb),0.05)]" style="border-color: var(--border-color); color: var(--text-secondary); background-color: var(--card-bg);"> 8 </a>
                             <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border text-sm font-medium hover:bg-[rgba(var(--primary-rgb),0.05)]" style="border-color: var(--border-color); color: var(--text-secondary); background-color: var(--card-bg);"><span class="sr-only">Suivant</span><i class="fas fa-chevron-right text-xs h-5 w-5" aria-hidden="true"></i></a>
                        </nav>
                    </div>
                </div>
             </div>
        </div>
    </div>

    {{-- Invoice Detail Modal --}}
    <div id="invoice-modal" class="modal-backdrop">
        <div class="modal-content !max-w-4xl">
            <div class="modal-header">
                <h3 class="modal-title">Détails de la Facture</h3>
                <button id="close-invoice-modal" class="modal-close-btn"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <!-- Invoice Header -->
                <div class="flex flex-col md:flex-row justify-between mb-8">
                    <div>
                        <h4 class="text-2xl font-bold">FACTURE</h4>
                        <p class="mt-1" style="color: var(--text-secondary);" id="invoice-id-modal">#INV-0000</p>
                        <p class="mt-1" style="color: var(--text-secondary);" id="invoice-date-modal">Date: </p>
                    </div>
                     <div class="mt-6 md:mt-0 text-right">
                        <div class="flex items-center justify-end mb-2">
                            <i class="fas fa-utensils text-secondary text-2xl mr-2"></i>
                            <span class="text-2xl font-bold bg-gradient-to-r from-[#0288D1] to-[#4CAF50] bg-clip-text text-transparent">OctoPOS</span>
                        </div>
                        <p style="color: var(--text-secondary);">123 Rue du Restaurant</p>
                        <p style="color: var(--text-secondary);">Ville, Pays, 12345</p>
                        <p style="color: var(--text-secondary);">+123 456 789</p>
                    </div>
                </div>
                <!-- Customer Info -->
                <div class="border-t border-b py-4 mb-6" style="border-color: var(--border-color);">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div>
                            <h5 class="font-bold mb-2" style="color: var(--text-primary);">Facturé à :</h5>
                            <p style="color: var(--text-secondary);" id="customer-name-modal"></p>
                            <p style="color: var(--text-secondary);" id="customer-email-modal"></p>
                            <p style="color: var(--text-secondary);" id="customer-phone-modal"></p>
                        </div>
                         <div class="mt-4 md:mt-0 md:text-right">
                            <h5 class="font-bold mb-2" style="color: var(--text-primary);">Détails Réservation :</h5>
                            <p style="color: var(--text-secondary);" id="reservation-id-modal"></p>
                            <p style="color: var(--text-secondary);" id="reservation-date-modal"></p>
                            <p style="color: var(--text-secondary);" id="reservation-guests-modal"></p>
                            <p style="color: var(--text-secondary);" id="reservation-table-modal"></p>
                        </div>
                    </div>
                </div>
                <!-- Invoice Items Table -->
                <div class="mb-8">
                    <h5 class="font-bold mb-3" style="color: var(--text-primary);">Articles :</h5>
                    <div class="table-container">
                        <table class="custom-table">
                            <thead>
                                <tr style="background-color: rgba(var(--primary-rgb), 0.05);">
                                    <th>Article</th><th class="text-center">Quantité</th>
                                    <th class="text-right">Prix Unitaire</th><th class="text-right">Montant</th>
                                </tr>
                            </thead>
                            <tbody id="invoice-items-modal"></tbody>
                            <tfoot> {{-- Totals will be added by JS --}} </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Payment Info -->
                {{-- Add payment info display here if needed --}}
                <!-- Notes -->
                <div class="border-t pt-4 mt-6" style="border-color: var(--border-color);">
                    <p class="text-sm mb-2" style="color: var(--text-secondary);">Merci d'avoir dîné chez nous !</p>
                    <p class="text-sm" style="color: var(--text-secondary);">Note : Ceci est une facture simplifiée.</p>
                </div>
            </div>
             <div class="modal-footer">
                 <button id="print-invoice" class="btn btn-outline"><i class="fas fa-print"></i>Imprimer</button>
                 <button id="download-invoice" class="btn btn-primary"><i class="fas fa-download"></i>Télécharger PDF</button>
             </div>
        </div>
    </div>

    {{-- Profile Section (Hidden by default) --}}
    <div id="profile-section" class="hidden">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Mon Profil</h1>
    
        <div class="dashboard-card overflow-hidden">
            <div class="md:flex">
                <!-- Profile Sidebar -->
                <div class="p-6 md:w-1/3 flex flex-col items-center border-b md:border-b-0 md:border-r" style="border-color: var(--border-color);">
                    <div class="relative mb-4">
                        <img src="{{ Auth::user()->profile_photo_url ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="{{ Auth::user()->name ?? 'User' }}" class="h-28 w-28 rounded-full border-4 object-cover" style="border-color: var(--primary);">
                        <button onclick="triggerPhotoUpload()" class="absolute bottom-0 right-0 bg-[var(--primary)] text-white rounded-full p-1.5 leading-none hover:bg-[var(--primary-dark)] focus:outline-none border-2 border-white dark:border-gray-800" title="Changer la photo">
                            <i class="fas fa-camera text-xs"></i>
                        </button>
                    </div>
                    <h2 class="text-xl font-bold">{{ Auth::user()->first_name ." " . Auth::user()->last_name  ?? 'John Doe' }}</h2>
                    <p class="mb-4" style="color: var(--text-secondary);">Client fidèle depuis 2023</p>
                </div>
    
                <!-- Profile Form -->
                <div class="p-6 md:w-2/3">
                    <form id="profile-form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Only include the existing fields that are in the database -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                            <div>
                                <label class="form-label" for="profile-first-name">Prénom</label>
                                <input type="text" id="profile-first-name" name="first_name" value="{{ old('first_name', Auth::user()->first_name ?? '') }}" class="form-input">
                                @error('first_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="profile-last-name">Nom</label>
                                <input type="text" id="profile-last-name" name="last_name" value="{{ old('last_name', Auth::user()->last_name ?? '') }}" class="form-input">
                                @error('last_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="profile-email">Adresse E-mail</label>
                                <input type="email" id="profile-email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" class="form-input">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="profile-phone">Téléphone</label>
                                <input type="tel" id="profile-phone" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" class="form-input">
                                @error('phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <!-- Include other fields as client-side preferences (stored in session) -->
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2" style="border-color: var(--border-color);">Préférences</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                            <div>
                                <label class="form-label" for="profile-fav-cuisine">Cuisine Favorite</label>
                                <select id="profile-fav-cuisine" name="favorite_cuisine" class="form-select">
                                    <option value="italian" {{ (old('favorite_cuisine', session('favorite_cuisine')) == 'italian') ? 'selected' : '' }}>Italienne</option>
                                    <option value="french" {{ (old('favorite_cuisine', session('favorite_cuisine')) == 'french') ? 'selected' : '' }}>Française</option>
                                    <option value="mediterranean" {{ (old('favorite_cuisine', session('favorite_cuisine')) == 'mediterranean') ? 'selected' : '' }}>Méditerranéenne</option>
                                    <option value="asian" {{ (old('favorite_cuisine', session('favorite_cuisine')) == 'asian') ? 'selected' : '' }}>Asiatique</option>
                                    <option value="american" {{ (old('favorite_cuisine', session('favorite_cuisine')) == 'american') ? 'selected' : '' }}>Américaine</option>
                                </select>
                            </div>
                            <!-- Other preference fields -->
                        </div>
                        
                        <div class="flex justify-between mt-6 pt-6 border-t" style="border-color: var(--border-color);">
                            <button type="submit" class="btn btn-primary">
                                Enregistrer les Modifications
                            </button>
                            
                            <div class="flex gap-3">
                                <button type="button" class="btn btn-outline" onclick="openPasswordModal()">Changer Mot de Passe</button>
                                <button type="button" class="btn btn-outline-danger" onclick="openDeleteModal()">Supprimer Mon Compte</button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Profile Photo Update Form -->
                    <form id="photo-form" method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="file" id="profile-photo-input" name="photo" onchange="this.form.submit()">
                    </form>
                    
                    <!-- Modal Overlay -->
                    <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" onclick="closeAllModals()"></div>
                    
                    <!-- Password Change Modal -->
                    <!-- Password Change Modal -->
<div id="password-modal" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md z-50 hidden">
    <div class="flex justify-between items-center mb-4 pb-3 border-b" style="border-color: var(--border-color);">
        <h3 class="text-lg font-semibold">Changer de Mot de Passe</h3>
        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closePasswordModal()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <!-- Display validation errors if any -->
    @if ($errors->updatePassword->any())
        <div class="bg-red-50 text-red-600 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->updatePassword->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('profile.password.update') }}" id="password-change-form">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="form-label" for="current_password">Mot de passe actuel</label>
            <input type="password" id="current_password" name="current_password" class="form-input w-full" required>
        </div>
        
        <div class="mb-4">
            <label class="form-label" for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password" class="form-input w-full" required minlength="8">
            <p class="text-xs mt-1" style="color: var(--text-secondary);">Minimum 8 caractères</p>
        </div>
        
        <div class="mb-6">
            <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input w-full" required>
        </div>
        
        <div class="flex justify-end pt-4 border-t gap-3" style="border-color: var(--border-color);">
            <button type="button" class="btn btn-outline" onclick="closePasswordModal()">Annuler</button>
            <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
        </div>
    </form>
</div>
                    
                    <!-- Delete Account Modal -->
                    <div id="delete-modal" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md z-50 hidden">
                        <div class="flex justify-between items-center mb-4 pb-3 border-b" style="border-color: var(--border-color);">
                            <h3 class="text-lg font-semibold text-red-600">Supprimer Mon Compte</h3>
                            <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeDeleteModal()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="bg-red-50 p-4 rounded mb-4">
                            <p class="text-red-600 font-semibold mb-2">Attention! Cette action est irréversible.</p>
                            <p class="text-red-600 text-sm">Toutes vos données personnelles, historique et préférences seront définitivement supprimés.</p>
                        </div>
                        
                        <form method="POST" action="{{ route('profile.delete') }}">
                            @csrf
                            @method('DELETE')
                            
                            <div class="mb-4">
                                <label class="form-label" for="delete_confirmation">Pour confirmer, tapez "SUPPRIMER"</label>
                                <input type="text" id="delete_confirmation" class="form-input w-full" required pattern="SUPPRIMER" title="Vous devez taper exactement 'SUPPRIMER'">
                                <p class="text-xs mt-1" style="color: var(--text-secondary);">Sensible à la casse</p>
                            </div>
                            
                            <div class="mb-6">
                                <label class="form-label" for="delete_password">Mot de passe actuel</label>
                                <input type="password" id="delete_password" name="password" class="form-input w-full" required>
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t gap-3" style="border-color: var(--border-color);">
                                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">Annuler</button>
                                <button type="submit" class="btn btn-danger" id="delete-account-button" disabled>Supprimer définitivement mon compte</button>
                            </div>
                        </form>
                    </div>
                    
                    <script>
                        // Functions to handle modal interactions
                        function openPasswordModal() {
                            document.getElementById('password-modal').classList.remove('hidden');
                            document.getElementById('modal-overlay').classList.remove('hidden');
                            document.body.classList.add('overflow-hidden');
                        }
                        
                        function closePasswordModal() {
                            document.getElementById('password-modal').classList.add('hidden');
                            document.getElementById('modal-overlay').classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        }
                        
                        function openDeleteModal() {
                            document.getElementById('delete-modal').classList.remove('hidden');
                            document.getElementById('modal-overlay').classList.remove('hidden');
                            document.body.classList.add('overflow-hidden');
                        }
                        
                        function closeDeleteModal() {
                            document.getElementById('delete-modal').classList.add('hidden');
                            document.getElementById('modal-overlay').classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        }
                        
                        function closeAllModals() {
                            closePasswordModal();
                            closeDeleteModal();
                        }
                        
                        // Function to trigger photo upload
                        function triggerPhotoUpload() {
                            document.getElementById('profile-photo-input').click();
                        }
                        
                        // Enable delete button only when confirmation is correct
                        document.addEventListener('DOMContentLoaded', function() {
                            const deleteConfirmationInput = document.getElementById('delete_confirmation');
                            const deleteButton = document.getElementById('delete-account-button');
                            
                            deleteConfirmationInput.addEventListener('input', function() {
                                if (this.value === 'SUPPRIMER') {
                                    deleteButton.disabled = false;
                                } else {
                                    deleteButton.disabled = true;
                                }
                            });
                        });
                        // Add this to your existing script section
document.addEventListener('DOMContentLoaded', function() {
    // Handle password change form submission
    const passwordForm = document.getElementById('password-change-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            // Show loading state if desired
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement...';
                submitBtn.disabled = true;
            }
            
            // Let the form submit normally from here
            // The modal will close when the page reloads after submission
        });
    }
    
    // If there are password errors, show the password modal
    @if ($errors->updatePassword && $errors->updatePassword->any())
        openPasswordModal();
    @endif
});
                    </script>
                </div>
            </div>
        </div>
    </div>

    {{-- Add other hidden sections similarly --}}

</div>

@endsection