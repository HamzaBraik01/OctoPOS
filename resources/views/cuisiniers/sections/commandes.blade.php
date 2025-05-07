{{-- resources/views/cuisiniers/sections/commandes.blade.php --}}
<div id="section-commandes" class="dashboard-section active">
    <div class="section-header">
        <h2>Commandes en attente</h2>
        <div class="section-controls">
            <button class="btn btn-primary refresh-commandes"><i class="fas fa-sync-alt"></i> Actualiser</button>
        </div>
    </div>

    <div class="commandes-container">
        <div class="commandes-list" id="commandes-en-attente">
            <!-- Les commandes seront chargées dynamiquement ici -->
            <div class="empty-state">
                <i class="fas fa-utensils empty-icon"></i>
                <p>Aucune commande en attente pour le moment</p>
            </div>
            
            <!-- Exemple de carte de commande (sera générée dynamiquement) -->
            <div class="commande-card priority-high" style="display: none;">
                <div class="commande-header">
                    <span class="badge badge-warning">Table 12</span>
                    <span class="commande-time">Il y a 5 min</span>
                    <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Priorité haute</span>
                </div>
                <div class="commande-body">
                    <ul class="plat-list">
                        <li class="plat-item">
                            <span class="plat-quantity">2x</span>
                            <span class="plat-name">Steak frites</span>
                            <span class="plat-spec badge badge-danger">Allergie: Gluten</span>
                            <span class="plat-note">Cuisson saignante</span>
                        </li>
                        <li class="plat-item">
                            <span class="plat-quantity">1x</span>
                            <span class="plat-name">Salade César</span>
                            <span class="plat-spec badge badge-warning">Sans anchois</span>
                        </li>
                    </ul>
                </div>
                <div class="commande-footer">
                    <button class="btn btn-success btn-sm start-preparation">Commencer préparation</button>
                    <button class="btn btn-info btn-sm view-details">Détails</button>
                </div>
            </div>
        </div>
    </div>
</div>