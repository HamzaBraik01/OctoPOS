<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Cuisiniers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .content {
            padding: 15px 0;
        }
        .order-section {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .urgent {
            color: #dc3545;
            font-weight: bold;
        }
        .dashboard-modules ul {
            padding-left: 20px;
        }
        .dashboard-modules li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <h1>Bienvenue dans votre tableau de bord Cuisiniers</h1>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>

        <div class="content">
            <p>Gérez les commandes à préparer et consultez les recettes des plats.</p>

            <div class="order-section">
                <h2>Commandes en attente</h2>
                <div class="order-item">
                    <p><span class="urgent">Urgent</span> - Table 3 - Plat: Entrecôte sauce poivre</p>
                    <p>Notes: Cuisson à point</p>
                </div>
                <div class="order-item">
                    <p>Table 5 - Plat: Saumon grillé</p>
                    <p>Notes: Sans ail</p>
                </div>
                <div class="order-item">
                    <p>Table 7 - Plat: Risotto aux champignons</p>
                    <p>Notes: -</p>
                </div>
            </div>

            <div class="dashboard-modules">
                <h2>Fonctionnalités disponibles</h2>
                <ul>
                    <li>Liste des commandes à préparer</li>
                    <li>Recettes et fiches techniques</li>
                    <li>Inventaire des ingrédients</li>
                    <li>Gestion des stocks</li>
                    <li>Communication avec les serveurs</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>