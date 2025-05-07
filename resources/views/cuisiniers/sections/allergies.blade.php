{{-- resources/views/cuisiniers/sections/allergies.blade.php --}}
<div id="section-allergies" class="dashboard-section">
    <div class="section-header">
        <h2>Allergies et restrictions</h2>
        <div class="section-controls">
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Rechercher une allergie...">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <div class="allergies-container">
        <div class="allergies-list">
            <div class="row">
                <div class="col-md-6">
                    <div class="allergie-card">
                        <div class="allergie-header">
                            <h3><i class="fas fa-exclamation-circle text-danger"></i> Allergènes courants</h3>
                        </div>
                        <div class="allergie-body">
                            <ul class="allergie-items">
                                <li><span class="badge badge-danger">Gluten</span> - Éviter farine, pâtes, panure, sauce soja</li>
                                <li><span class="badge badge-danger">Fruits de mer</span> - Éviter tous crustacés, poissons</li>
                                <li><span class="badge badge-danger">Arachides</span> - Vérifier huiles de cuisson, sauces</li>
                                <li><span class="badge badge-danger">Lactose</span> - Éviter lait, beurre, crème, fromage</li>
                                <li><span class="badge badge-danger">Œufs</span> - Vérifier sauces, pâtisseries, crèmes</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="allergie-card">
                        <div class="allergie-header">
                            <h3><i class="fas fa-leaf text-success"></i> Restrictions alimentaires</h3>
                        </div>
                        <div class="allergie-body">
                            <ul class="allergie-items">
                                <li><span class="badge badge-success">Végétarien</span> - Pas de viande, poisson accepté</li>
                                <li><span class="badge badge-success">Végétalien</span> - Aucun produit animal</li>
                                <li><span class="badge badge-success">Sans porc</span> - Vérifier les graisses de cuisson</li>
                                <li><span class="badge badge-success">Sans alcool</span> - Attention aux sauces, marinades</li>
                                <li><span class="badge badge-success">Halal/Casher</span> - Procédures spécifiques</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="allergie-card mt-4">
                <div class="allergie-header">
                    <h3><i class="fas fa-clipboard-list text-primary"></i> Procédures spéciales</h3>
                </div>
                <div class="allergie-body">
                    <p>Pour toute commande avec allergie signalée :</p>
                    <ol>
                        <li>Utiliser des ustensiles et surfaces nettoyés spécifiquement</li>
                        <li>Porter des gants propres avant la préparation</li>
                        <li>Vérifier tous les ingrédients, y compris les condiments</li>
                        <li>Signaler la commande spéciale avec l'étiquette rouge</li>
                        <li>Faire valider par le chef avant le service</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>