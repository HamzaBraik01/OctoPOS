{{-- resources/views/gerants/sections/caisse.blade.php --}}
<div id="section-caisse" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Caisse & Paiements</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Transactions Récentes --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex justify-between items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                    <i class="fas fa-receipt text-blue-500 mr-2"></i> 
                    Transactions Récentes
                </h3>
                
                <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline" id="refresh-transactions">Actualiser</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[400px]">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Date</th>
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Heure</th>
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Table</th>
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400 text-right">Montant</th> {{-- Align right --}}
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Paiement</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50" id="transactions-list">
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="inline-block animate-spin rounded-full h-5 w-5 border-b-2 border-blue-500 mr-2"></div>
                                Chargement des transactions...
                            </td>
                        </tr>
                    </tbody>
                </table>
                 
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 flex flex-col"> {{-- flex-col pour que le chart prenne la place restante --}}
            <div class="flex justify-between items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0"> {{-- flex-shrink-0 --}}
                <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                    <i class="fas fa-chart-line text-green-500 mr-2"></i>
                    Résumé des ventes
                </h3>
                 <select class="text-xs p-1 border rounded dark:bg-gray-700 dark:border-gray-600">
                     <option>Aujourd'hui</option>
                     <option>Hier</option>
                     <option>Cette semaine</option>
                 </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4 flex-shrink-0">
                <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">1 250,80 DH</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase mt-1">Aujourd'hui</div>
                </div>
                <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">8 745,25 DH</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase mt-1">Cette semaine</div>
                </div>
            </div>

            <div class="mt-auto flex-grow min-h-[200px]"> 
                <canvas id="sales-chart"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to load recent transactions
        function loadRecentTransactions() {
            const restaurantId = document.getElementById('header-restaurant-selector').value;
            
            if (!restaurantId) {
                const transactionsList = document.getElementById('transactions-list');
                transactionsList.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            <p>Sélectionnez un restaurant pour voir les transactions récentes.</p>
                        </td>
                    </tr>
                `;
                return;
            }
            
            // Show loading
            const transactionsList = document.getElementById('transactions-list');
            transactionsList.innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="inline-block animate-spin rounded-full h-5 w-5 border-b-2 border-blue-500 mr-2"></div>
                        Chargement des transactions...
                    </td>
                </tr>
            `;
            
            // Fetch transactions from API
            fetch(`/gerant/get-recent-transactions?restaurant_id=${restaurantId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.transactions && data.transactions.length > 0) {
                        let html = '';
                        
                        data.transactions.forEach(transaction => {
                            // Generate payment method badge based on the method
                            let paymentBadge = '';
                            switch(transaction.methode_paiement.toLowerCase()) {
                                case 'espèces':
                                case 'especes':
                                    paymentBadge = '<span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300">Espèces</span>';
                                    break;
                                case 'cb':
                                case 'carte bancaire':
                                case 'carte':
                                    paymentBadge = '<span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">CB</span>';
                                    break;
                                case 'ticket restaurant':
                                case 'tr':
                                    paymentBadge = '<span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300">TR</span>';
                                    break;
                                default:
                                    paymentBadge = '<span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">' + transaction.methode_paiement + '</span>';
                            }
                            
                            // Format amount with proper separators and currency symbol
                            const formattedAmount = parseFloat(transaction.montant).toLocaleString('fr-FR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' DH';
                            
                            html += `
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${transaction.date}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${transaction.heure}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${transaction.table}</td>
                                    <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100 text-right">${formattedAmount}</td>
                                    <td class="px-4 py-3">
                                        ${paymentBadge}
                                    </td>
                                </tr>
                            `;
                        });
                        
                        transactionsList.innerHTML = html;
                    } else {
                        transactionsList.innerHTML = `
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <p>Aucune transaction récente trouvée pour ce restaurant.</p>
                                </td>
                            </tr>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des transactions:', error);
                    transactionsList.innerHTML = `
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <p>Erreur lors du chargement des transactions.</p>
                            </td>
                        </tr>
                    `;
                });
        }
        
        // Load transactions when the section becomes visible
        const sectionCaisse = document.getElementById('section-caisse');
        if (sectionCaisse) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class' && !sectionCaisse.classList.contains('hidden')) {
                        loadRecentTransactions();
                    }
                });
            });
            
            observer.observe(sectionCaisse, { attributes: true });
        }
        
        // Load transactions when restaurant changes
        const restaurantSelector = document.getElementById('header-restaurant-selector');
        if (restaurantSelector) {
            restaurantSelector.addEventListener('change', function() {
                // If the caisse section is visible, reload transactions
                if (sectionCaisse && !sectionCaisse.classList.contains('hidden')) {
                    loadRecentTransactions();
                }
            });
        }
        
        // Manually refresh transactions
        const refreshButton = document.getElementById('refresh-transactions');
        if (refreshButton) {
            refreshButton.addEventListener('click', function() {
                loadRecentTransactions();
            });
        }
        
        // Initial load if section is visible
        if (sectionCaisse && !sectionCaisse.classList.contains('hidden')) {
            loadRecentTransactions();
        }
    });
</script>