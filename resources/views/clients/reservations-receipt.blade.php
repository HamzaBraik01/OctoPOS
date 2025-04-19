<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture de Réservation - {{ $restaurant->name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem;
        }
        
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        
        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .max-w-3xl {
            max-width: 48rem;
        }
        
        .bg-white {
            background-color: #fff;
        }
        
        .rounded-lg {
            border-radius: 0.5rem;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .overflow-hidden {
            overflow: hidden;
        }
        
        .p-6 {
            padding: 1.5rem;
        }
        
        /* Header styles */
        .bg-gradient-to-r {
            background: linear-gradient(to right, #0288D1, #026da8);
        }
        
        .text-white {
            color: white;
        }
        
        .flex {
            display: flex;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .items-center {
            align-items: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-2xl {
            font-size: 1.5rem;
        }
        
        .text-lg {
            font-size: 1.125rem;
        }
        
        .text-sm {
            font-size: 0.875rem;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .font-semibold {
            font-weight: 600;
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        .opacity-80 {
            opacity: 0.8;
        }
        
        .mr-1, .mr-2 {
            margin-right: 0.5rem;
        }
        
        /* Body section styles */
        .mb-3 {
            margin-bottom: 0.75rem;
        }
        
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .text-gray-800 {
            color: #2d3748;
        }
        
        .text-gray-600 {
            color: #4a5568;
        }
        
        .text-gray-700 {
            color: #374151;
        }
        
        .pb-2 {
            padding-bottom: 0.5rem;
        }
        
        .border-b {
            border-bottom-width: 1px;
        }
        
        .border-gray-200 {
            border-color: #e2e8f0;
        }
        
        .border-t {
            border-top-width: 1px;
        }
        
        .text-[#0288D1] {
            color: #0288D1;
        }
        
        .grid {
            display: grid;
        }
        
        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .gap-4 {
            gap: 1rem;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        .p-3, .p-4 {
            padding: 1rem;
        }
        
        .bg-gray-50 {
            background-color: #f9fafb;
        }
        
        .rounded-lg {
            border-radius: 0.5rem;
        }
        
        /* Blue info box */
        .bg-blue-50 {
            background-color: #e6f6ff;
        }
        
        .list-disc {
            list-style-type: disc;
        }
        
        .list-inside {
            list-style-position: inside;
        }
        
        .space-y-1 > * + * {
            margin-top: 0.25rem;
        }
        
        /* Button styles */
        button {
            cursor: pointer;
            padding: 0.5rem 1rem;
            background-color: #0288D1;
            color: white;
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        button:hover {
            background-color: #026da8;
        }
        
        /* Special styling for customer information */
        .customer-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .info-item {
            background-color: #f9fafb;
            padding: 0.75rem;
            border-radius: 0.375rem;
            border-left: 3px solid #0288D1;
        }
        
        /* Animation for hover effects */
        .section-header {
            position: relative;
            padding-left: 1.5rem;
            transition: transform 0.2s ease;
        }
        
        .section-header i {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }
            #receipt-container, #receipt-container * {
                visibility: visible;
            }
            #receipt-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
                border: none !important;
            }
            button {
                display: none !important;
            }
            .bg-gradient-to-r {
                background: #0288D1 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .bg-blue-50, .bg-gray-50 {
                background-color: #f9fafb !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
            
            .flex {
                flex-direction: column;
            }
            
            .text-right {
                text-align: left;
                margin-top: 1rem;
            }
        }
        
        /* Fancy decorative elements */
        .fancy-corner {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(2, 136, 209, 0.1);
            z-index: 0;
        }
        
        .top-right {
            top: -20px;
            right: -20px;
        }
        
        .bottom-left {
            bottom: -20px;
            left: -20px;
        }
        
        /* Footer special styling */
        .footer-signature {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px dashed #e2e8f0;
        }
        
        .signature-text {
            font-style: italic;
            color: #4a5568;
            margin-top: 0.5rem;
        }
        
        /* Enhanced table styling */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .info-item {
            background-color: #f9fafb;
            padding: 0.75rem;
            border-radius: 0.375rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Section titles with line indicators */
        .section-title {
            position: relative;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #0288D1;
        }
        
        /* Logo placeholder */
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: #0288D1;
            font-weight: bold;
            font-size: 1.25rem;
        }
        
        /* Restaurant Banner */
        .restaurant-banner {
            background-color: rgba(2, 136, 209, 0.1);
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            border-left: 4px solid #0288D1;
        }
        
        .restaurant-logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
        }
        
        .restaurant-info {
            flex: 1;
        }
        
        .restaurant-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        
        .restaurant-id {
            font-size: 0.875rem;
            color: #718096;
        }
        
        /* Date/Time badge */
        .datetime-badge {
            background-color: rgba(2, 136, 209, 0.2);
            color: #026da8;
            font-weight: 500;
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .datetime-badge i {
            margin-right: 0.375rem;
        }
    </style>
</head>
<body>
    <div class="container mx-auto py-6 px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden" id="receipt-container">
            <!-- Receipt Header -->
            <div class="p-6 bg-gradient-to-r from-[#0288D1] to-[#026da8] text-white" style="position: relative;">
                <div class="fancy-corner top-right"></div>
                <div class="flex justify-between items-center">
                    <div class="logo-container">
                        <div class="logo">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">Facture de Réservation</h1>
                            <p class="text-sm opacity-80">Merci d'avoir choisi notre restaurant</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-semibold">N° {{ $reservation->id }}</div>
                        <div class="text-white text-sm datetime-badge">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $current_datetime }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipt Body -->
            <div class="p-6">
                <!-- Restaurant Information -->
                <div class="restaurant-banner">
                    <div class="restaurant-logo">
                        <i class="fas fa-store text-[#0288D1]" style="font-size: 1.5rem;"></i>
                    </div>
                    <div class="restaurant-info">
                        <div class="restaurant-name">{{ $restaurant->nom }}</div>
                        <div class="restaurant-id">ID Restaurant: {{ $table->numero }}</div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-3 text-gray-800 pb-2 border-b border-gray-200 section-title">
                        <i class="fas fa-user-circle mr-2 text-[#0288D1]"></i>Informations Client
                    </h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <p class="text-sm text-gray-600">Nom complet :</p>
                            <p class="font-medium text-gray-800">{{ $user->first_name }} {{ $user->last_name }}</p>
                        </div>
                        <div class="info-item">
                            <p class="text-sm text-gray-600">Email :</p>
                            <p class="font-medium text-gray-800">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Reservation Details -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-3 text-gray-800 pb-2 border-b border-gray-200 section-title">
                        <i class="fas fa-calendar-check mr-2 text-[#0288D1]"></i>Détails de la Réservation
                    </h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <p class="text-sm text-gray-600">Table :</p>
                            <p class="font-medium text-gray-800">{{ $table->name }}</p>
                        </div>
                        <div class="info-item">
                            <p class="text-sm text-gray-600">Nombre d'invités :</p>
                            <p class="font-medium text-gray-800">{{ $reservation->invite }} personne(s)</p>
                        </div>
                        <div class="info-item">
                            <p class="text-sm text-gray-600">Date :</p>
                            <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</p>
                        </div>
                        <div class="info-item">
                            <p class="text-sm text-gray-600">Heure de début :</p>
                            <p class="font-medium text-gray-800">{{ $reservation->heure_debut }}</p>
                        </div>
                        <div class="info-item">
                            <p class="text-sm text-gray-600">Durée :</p>
                            <p class="font-medium text-gray-800">{{ $reservation->duree }} minutes</p>
                        </div>
                        <div class="info-item">
                            <p class="text-sm text-gray-600">Heure de fin prévue :</p>
                            <p class="font-medium text-gray-800">{{ $end_time }}</p>
                        </div>
                    </div>
                    
                    @if($special_requests)
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Demandes spéciales :</p>
                        <p class="font-medium text-gray-800 p-3 bg-gray-50 rounded-lg" style="border-left: 3px solid #0288D1;">{{ $special_requests }}</p>
                    </div>
                    @endif
                </div>

                <!-- Important Information -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg" style="position: relative; border-left: 4px solid #0288D1;">
                    <h2 class="text-lg font-semibold mb-3 text-gray-800 section-header">
                        <i class="fas fa-info-circle mr-2 text-[#0288D1]"></i>Informations Importantes
                    </h2>
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Veuillez arriver à l'heure pour votre réservation</li>
                        <li>En cas d'annulation, merci de nous prévenir au moins 24h à l'avance</li>
                        <li>Votre table sera gardée pendant 15 minutes après l'heure de réservation</li>
                        <li>Pour toute question, contactez-nous au 01 23 45 67 89</li>
                    </ul>
                    <button onclick="window.print()" class="px-4 py-2 bg-[#0288D1] text-white rounded-lg shadow hover:bg-[#026da8] transition">
                        <i class="fas fa-print mr-2"></i>Imprimer
                    </button>
                </div>

            </div>
          
         
        </div>
    </div>

    <script>
        window.onload = function() {
            // Add hover effects
            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#e6f6ff';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '#f9fafb';
                });
            });
            
            // Delayed print
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</body>
</html>