<div id="section-reservations" class="section-content p-6"> {{-- Retrait de 'hidden' ici, le JS gère l'affichage initial --}}
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion des Réservations</h2>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 gap-2">
            <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                <i class="fas fa-calendar-check text-blue-500 mr-2"></i>
                Réservations à venir
            </h3>
            <div class="flex items-center">
                <select id="reservation-date-filter" class="text-sm px-3 py-1.5 pr-8 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">Toutes les dates</option>
                    <option value="today" selected>Aujourd'hui</option>
                    <option value="tomorrow">Demain</option>
                    <option value="week">Cette semaine</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]" id="reservations-table"> {{-- min-w pour éviter compression excessive --}}
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Date</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Heure</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Client</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Téléphone</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Table</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Pers.</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Statut</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50" id="reservations-table-body">
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            <p>Sélectionnez un restaurant pour voir les réservations.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="loading-indicator" class="py-4 text-center hidden">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Chargement des réservations...</p>
            </div>
        </div>
    </div>
    
    {{-- Notification de succès --}}
    <div id="status-notification" class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg transition-opacity duration-300 opacity-0 z-50 transform translate-y-2">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span id="notification-message"></span>
        </div>
    </div>
</div>

{{-- Script pour gérer les boutons de mise à jour de statut --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour mettre à jour le statut d'une réservation
    function updateReservationStatus(id, status) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/gerant/reservations/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                id: id,
                statut: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Afficher la notification
                showNotification(data.message, 'success');
                
                // Recharger les réservations (on pourrait optimiser en mettant à jour uniquement la ligne concernée)
                if (typeof loadReservations === 'function') {
                    loadReservations();
                } else {
                    // Fallback: recharger la page
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            } else {
                showNotification('Erreur lors de la mise à jour du statut.', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur de connexion.', 'error');
        });
    }
    
    // Fonction pour afficher une notification stylisée
    function showNotification(message, type = 'info') {
        const notification = document.getElementById('status-notification');
        const messageEl = document.getElementById('notification-message');
        
        if (!notification || !messageEl) return;
        
        // Définir les styles en fonction du type
        if (type === 'success') {
            notification.className = 'fixed bottom-4 right-4 p-4 rounded-lg shadow-lg transition-opacity duration-300 z-50 bg-green-100 text-green-700 border-l-4 border-green-500';
            notification.querySelector('i').className = 'fas fa-check-circle mr-2';
        } else if (type === 'error') {
            notification.className = 'fixed bottom-4 right-4 p-4 rounded-lg shadow-lg transition-opacity duration-300 z-50 bg-red-100 text-red-700 border-l-4 border-red-500';
            notification.querySelector('i').className = 'fas fa-exclamation-circle mr-2';
        } else {
            notification.className = 'fixed bottom-4 right-4 p-4 rounded-lg shadow-lg transition-opacity duration-300 z-50 bg-blue-100 text-blue-700 border-l-4 border-blue-500';
            notification.querySelector('i').className = 'fas fa-info-circle mr-2';
        }
        
        // Définir le message
        messageEl.textContent = message;
        
        // Afficher la notification avec animation
        notification.classList.remove('opacity-0', 'translate-y-2');
        notification.classList.add('opacity-100', 'translate-y-0');
        
        // Cacher la notification après 3 secondes
        setTimeout(() => {
            notification.classList.add('opacity-0', 'translate-y-2');
            notification.classList.remove('opacity-100', 'translate-y-0');
        }, 3000);
    }
    
    // Délégation d'événements pour les boutons de confirmation et refus
    document.addEventListener('click', function(event) {
        // Gestion du bouton de confirmation
        if (event.target.matches('.confirm-reservation') || event.target.closest('.confirm-reservation')) {
            const button = event.target.matches('.confirm-reservation') ? event.target : event.target.closest('.confirm-reservation');
            const reservationId = button.getAttribute('data-reservation-id');
            const status = button.getAttribute('data-status');
            
            event.preventDefault();
            updateReservationStatus(reservationId, status);
        }
        
        // Gestion du bouton de refus
        if (event.target.matches('.refuse-reservation') || event.target.closest('.refuse-reservation')) {
            const button = event.target.matches('.refuse-reservation') ? event.target : event.target.closest('.refuse-reservation');
            const reservationId = button.getAttribute('data-reservation-id');
            const status = button.getAttribute('data-status');
            
            event.preventDefault();
            updateReservationStatus(reservationId, status);
        }
        
        // Gestion du bouton "Marquer Arrivé"
        if (event.target.matches('.arrived-btn') || event.target.closest('.arrived-btn')) {
            const button = event.target.matches('.arrived-btn') ? event.target : event.target.closest('.arrived-btn');
            
            event.preventDefault();
            showNotification('Le client est arrivé pour sa réservation.', 'success');
            // Ici, vous pourriez implémenter une logique pour marquer le client comme arrivé
        }
    });
});
</script>