{{-- resources/views/cuisiniers/sections/preparation.blade.php --}}
<div id="section-preparation" class="dashboard-section">
    <div class="section-header">
        <h2>En préparation</h2>
        <div class="section-controls">
            <button class="btn btn-primary refresh-preparation"><i class="fas fa-sync-alt"></i> Actualiser</button>
        </div>
    </div>

    <div class="preparation-container">
        <div class="preparation-list" id="commandes-en-preparation">
            <!-- Les commandes en préparation seront chargées dynamiquement ici -->
            <div class="empty-state">
                <i class="fas fa-blender empty-icon"></i>
                <p>Aucun plat en préparation pour le moment</p>
            </div>
            
            <!-- Exemple de carte de commande en préparation (sera générée dynamiquement) -->
            <div class="preparation-card" style="display: none;">
                <div class="preparation-header">
                    <span class="badge badge-primary">Table 5</span>
                    <span class="preparation-time">En cours depuis 10 min</span>
                    <div class="preparation-timer">
                        <i class="fas fa-clock"></i> 10:23
                    </div>
                </div>
                <div class="preparation-body">
                    <ul class="plat-list">
                        <li class="plat-item">
                            <span class="plat-quantity">1x</span>
                            <span class="plat-name">Filet de poisson</span>
                            <span class="plat-spec badge badge-info">Extra sauce</span>
                        </li>
                        <li class="plat-item">
                            <span class="plat-quantity">2x</span>
                            <span class="plat-name">Risotto aux champignons</span>
                        </li>
                    </ul>
                </div>
                <div class="preparation-footer">
                    <button class="btn btn-success btn-sm mark-ready">Prêt à servir</button>
                    <button class="btn btn-warning btn-sm report-issue">Signaler un problème</button>
                </div>
            </div>
        </div>
    </div>
</div>