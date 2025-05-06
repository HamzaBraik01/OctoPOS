<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport de Ventes Mensuelles - {{ $moisActuel }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #3182ce;
            margin-bottom: 5px;
        }
        .header p {
            color: #718096;
            margin-top: 0;
        }
        .restaurant-name {
            font-weight: bold;
            color: #2c5282;
            font-size: 1.1em;
            margin-top: 5px;
        }
        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .summary-item {
            text-align: center;
        }
        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #3182ce;
            margin: 5px 0;
        }
        .summary-label {
            font-size: 14px;
            color: #718096;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f8fafc;
            font-weight: bold;
        }
        .section-title {
            margin-top: 30px;
            color: #3182ce;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .weekend {
            background-color: #f3f4f6;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #e5e7eb;
        }
        .no-commandes {
            color: #9ca3af;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport de Ventes Mensuelles</h1>
        <p>{{ $moisActuel }}</p>
        <p class="restaurant-name">{{ $nomRestaurant }}</p>
    </div>

    <div class="summary-box">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ number_format($totalVentes, 2) }} DH</div>
                <div class="summary-label">Chiffre d'affaires</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $nombreCommandes }}</div>
                <div class="summary-label">Commandes</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($ticketMoyen, 2) }} DH</div>
                <div class="summary-label">Ticket moyen</div>
            </div>
        </div>
    </div>

    <h2 class="section-title">Détail des ventes quotidiennes</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Jour</th>
                <th class="text-center">Nombre de commandes</th>
                <th class="text-right">Montant des ventes (DH)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($joursComplets as $jour)
            <tr class="{{ in_array($jour['jour_semaine'], ['Saturday', 'Sunday']) ? 'weekend' : '' }} {{ $jour['nombre_commandes'] == 0 ? 'no-commandes' : '' }}">
                <td>{{ \Carbon\Carbon::parse($jour['date'])->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($jour['date'])->translatedFormat('l') }}</td>
                <td class="text-center">{{ $jour['nombre_commandes'] }}</td>
                <td class="text-right">{{ number_format($jour['total_ventes'], 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2"><strong>TOTAL DU MOIS</strong></td>
                <td class="text-center"><strong>{{ $nombreCommandes }}</strong></td>
                <td class="text-right"><strong>{{ number_format($totalVentes, 2) }} DH</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Rapport généré le {{ $dateGeneration }} | OctoPOS - Système de gestion de restaurant</p>
    </div>
</body>
</html>