<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Serveurs</title>
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
        .user-info {
            margin-right: 20px;
            color: #666;
        }
        .content {
            padding: 15px 0;
        }
        .tables-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .table-card {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .table-free {
            border-left: 4px solid #28a745;
        }
        .table-occupied {
            border-left: 4px solid #dc3545;
        }
        .table-reserved {
            border-left: 4px solid #ffc107;
        }
        .table-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .table-status {
            font-weight: bold;
        }
        .status-free {
            color: #28a745;
        }
        .status-occupied {
            color: #dc3545;
        }
        .status-reserved {
            color: #ffc107;
        }
        .orders-section {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .ready {
            color: #28a745;
            font-weight: bold;
        }
        .current-time {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
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
            <div>
                <h1>Tableau de bord Serveurs</h1>
                <div class="current-time">{{ date('Y-m-d H:i:s') }} | Connecté: {{ auth('api')->user()->name ?? 'HamzaBr01' }}</div>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>

        <div class="content">
            <p>Gérez les tables et les commandes depuis cette interface.</p>

            <h2>Statut des tables</h2>
            <div class="tables-grid">
                <div class="table-card table-occupied">
                    <h3>Table 1</h3>
                    <p class="table-status status-occupied">Occupée</p>
                    <p>4 personnes - 20:30</p>
                </div>
                <div class="table-card table-free">
                    <h3>Table 2</h3>
                    <p class="table-status status-free">Libre</p>
                    <p>2 personnes</p>
                </div>
                <div class="table-card table-occupied">
                    <h3>Table 3</h3>
                    <p class="table-status status-occupied">Occupée</p>
                    <p>6 personnes - 20:15</p>
                </div>
                <div class="table-card table-reserved">
                    <h3>Table 4</h3>
                    <p class="table-status status-reserved">Réservée</p>
                    <p>Pour 21:00</p>
                </div>
                <div class="table-card table-free">
                    <h3>Table 5</h3>
                    <p class="table-status status-free">Libre</p>
                    <p>4 personnes</p>
                </div>
                <div class="table-card table-occupied">
                    <h3>Table 6</h3>
                    <p class="table-status status-occupied">Occupée</p>
                    <p>2 personnes - 19:45</p>
                </div>
            </div>

            <div class="orders-section">
                <h2>Commandes à servir</h2>
                <div class="order-item">
                    <p><span class="ready">PRÊT</span> - Table 3 - Plat: Entrecôte sauce poivre (x2), Risotto aux champignons (x1)</p>
                    <p>Notes: Apporter du pain supplémentaire</p>
                </div>
                <div class="order-item">
                    <p>Table 6 - Dessert: Tiramisu (x1), Fondant au chocolat (x1)</p>
                    <p>Notes: -</p>
                </div>
                <div class="order-item">
                    <p><span class="ready">PRÊT</span> - Table 1 - Entrée: Salade César (x2)</p>
                    <p>Notes: Sans sauce pour une portion</p>
                </div>
            </div>

            <div class="dashboard-modules">
                <h2>Fonctionnalités disponibles</h2>
                <ul>
                    <li>Prise de commande</li>
                    <li>Gestion des tables</li>
                    <li>Suivi des commandes en cuisine</li>
                    <li>Addition et paiements</li>
                    <li>Réservations</li>
                    <li>Communication avec la cuisine</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>