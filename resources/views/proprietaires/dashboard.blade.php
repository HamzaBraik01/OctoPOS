<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Propriétaires</title>
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
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <h1>Bienvenue dans votre tableau de bord Propriétaires</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>

        <div class="content">
            <p>Ici, vous pouvez gérer vos établissements et accéder à toutes les fonctionnalités réservées aux propriétaires.</p>

            <!-- Ajoutez ici le contenu du tableau de bord -->
            <div class="dashboard-modules">
                <h2>Fonctionnalités disponibles</h2>
                <ul>
                    <li>Gestion des établissements</li>
                    <li>Rapports financiers</li>
                    <li>Gestion des gérants</li>
                    <li>Paramètres généraux</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>