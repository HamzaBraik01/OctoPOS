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
                
                <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Voir tout</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[400px]">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Heure</th>
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Table</th>
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400 text-right">Montant</th> {{-- Align right --}}
                            <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Paiement</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">22:15</td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Table 4</td>
                            <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100 text-right">128,50 €</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">CB</span> {{-- Abrégé --}}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">21:45</td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Table 9</td>
                            <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100 text-right">85,20 €</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300">Espèces</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">21:30</td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Table 2</td>
                            <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100 text-right">64,00 €</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300">TR</span> {{-- Ticket Resto --}}
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
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">1 250,80 €</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase mt-1">Aujourd'hui</div>
                </div>
                <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">8 745,25 €</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase mt-1">Cette semaine</div>
                </div>
            </div>

            <div class="mt-auto flex-grow min-h-[200px]"> 
                <canvas id="sales-chart"></canvas>
            </div>
        </div>
    </div>


</div>