{{-- resources/views/cuisiniers/sections/historique.blade.php --}}
<div id="section-historique" class="dashboard-section">
    <div class="section-header">
        <h2>Historique des commandes</h2>
        <div class="section-controls">
            <div class="date-filter">
                <label>Filtrer par date:</label>
                <input type="date" class="form-control date-picker">
            </div>
            <button class="btn btn-primary refresh-historique"><i class="fas fa-sync-alt"></i> Actualiser</button>
        </div>
    </div>

    <div class="historique-container">
        <div class="historique-list" id="commandes-historique">
            <!-- L'historique sera chargé dynamiquement ici -->
            <div class="empty-state">
                <i class="fas fa-history empty-icon"></i>
                <p>Aucune commande dans l'historique pour cette période</p>
            </div>
            
            <!-- Exemple de carte d'historique (sera générée dynamiquement) -->
            <div class="historique-card" style="display: none;">
                <div class="historique-header">
                    <span class="badge badge-info">Table 8</span>
                    <span class="historique-time">13:45 - 14:20</span>
                    <span class="badge badge-success">Complété</span>
                </div>
                <div class="historique-body">
                    <ul class="plat-list">
                        <li class="plat-item">
                            <span class="plat-quantity">3x</span>
                            <span class="plat-name">Burger maison</span>
                            <span class="plat-prep-time">Préparé en 12 min</span>
                        </li>
                        <li class="plat-item">
                            <span class="plat-quantity">2x</span>
                            <span class="plat-name">Frites maison</span>
                            <span class="plat-prep-time">Préparé en 8 min</span>
                        </li>
                    </ul>
                </div>
                <div class="historique-footer">
                    <span class="prep-rating">
                        <i class="fas fa-stopwatch"></i> Temps moyen: 10 min
                    </span>
                    <span class="quality-rating">
                        <i class="fas fa-star"></i> Note: 4.8/5
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>