<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Clients</title>
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
        .dashboard-modules {
            margin-top: 20px;
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
            <h1>Bienvenue dans votre tableau de bord Client</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>

        <div class="content">
            <p>Gérez vos commandes et vos réservations depuis cette interface.</p>

            <div class="dashboard-modules">
                <h2>Options disponibles</h2>
                <ul>
                    <li>Historique des commandes</li>
                    <li>Réservations en cours</li>
                    <li>Programme de fidélité</li>
                    <li>Mes informations personnelles</li>
                    <li>Contacter le restaurant</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>