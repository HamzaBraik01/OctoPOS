<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Gérants</title>
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
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-card {
            flex: 1;
            min-width: 200px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .stat-card h3 {
            margin-top: 0;
            color: #555;
        }
        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 0;
        }
        .tasks-section {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .task-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
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
            <h1>Bienvenue dans votre tableau de bord Gérants</h1>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>

        <div class="content">
            <p>Gérez votre établissement et suivez les performances en temps réel.</p>

            <div class="stats-container">
                <div class="stat-card">
                    <h3>Chiffre d'affaires (aujourd'hui)</h3>
                    <p>1,245.00 €</p>
                </div>
                <div class="stat-card">
                    <h3>Commandes</h3>
                    <p>48</p>
                </div>
                <div class="stat-card">
                    <h3>Clients servis</h3>
                    <p>126</p>
                </div>
                <div class="stat-card">
                    <h3>Réservations (ce soir)</h3>
                    <p>18</p>
                </div>
            </div>

            <div class="tasks-section">
                <h2>Tâches à accomplir</h2>
                <div class="task-item">
                    <span>Valider les horaires du personnel pour la semaine prochaine</span>
                    <span>Échéance: Demain</span>
                </div>
                <div class="task-item">
                    <span>Commander des fournitures de bar</span>
                    <span>Échéance: 16/04/2025</span>
                </div>
                <div class="task-item">
                    <span>Réviser le menu saisonnier</span>
                    <span>Échéance: 20/04/2025</span>
                </div>
            </div>

            <div class="dashboard-modules">
                <h2>Fonctionnalités disponibles</h2>
                <ul>
                    <li>Gestion du personnel et des plannings</li>
                    <li>Suivi des stocks et approvisionnements</li>
                    <li>Rapports de vente et statistiques</li>
                    <li>Gestion des réservations</li>
                    <li>Configuration des tables et du plan de salle</li>
                    <li>Communication avec l'équipe</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>