// resources/js/gerant.js

document.addEventListener('DOMContentLoaded', function() {
    let currentActiveSection = null;
    let selectedRestaurantId = null;

    function showNotification(message, type = 'info') {
        const existingNotifications = document.querySelectorAll('.dashboard-notification');
        existingNotifications.forEach(notif => notif.remove());

        const notification = document.createElement('div');
        let bgColor = 'bg-blue-500';
        if (type === 'success') bgColor = 'bg-green-500';
        else if (type === 'error') bgColor = 'bg-red-500';
        else if (type === 'warning') bgColor = 'bg-yellow-500 text-black';

        notification.className = `dashboard-notification fixed bottom-4 right-4 ${bgColor} text-white px-4 py-3 rounded-lg shadow-xl z-[100] transition-all duration-500 ease-out opacity-0 transform translate-y-2`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('opacity-0', 'translate-y-2');
        }, 50);

        setTimeout(() => {
             notification.classList.add('opacity-0', 'translate-y-2');
             setTimeout(() => {
                if (notification.parentNode) {
                     notification.parentNode.removeChild(notification);
                }
            }, 550);
        }, 3500);
    }
    window.showNotification = showNotification;

    function showModal(modalElement) {
        if (modalElement) {
            modalElement.classList.remove('hidden');
            modalElement.classList.add('flex');
             document.body.style.overflow = 'hidden';
        }
    }

    function hideModal(modalElement) {
        if (modalElement) {
            modalElement.classList.add('hidden');
            modalElement.classList.remove('flex');
             document.body.style.overflow = '';
        }
    }

    function getCurrentTime(includeSeconds = false) {
        const options = { hour: '2-digit', minute: '2-digit' };
        if (includeSeconds) {
            options.second = '2-digit';
        }
        return new Date().toLocaleTimeString('fr-FR', options);
    }

    function getFormattedDateTime() {
        return new Date().toLocaleString('fr-FR', {
              year: 'numeric', month: '2-digit', day: '2-digit',
              hour: '2-digit', minute: '2-digit', second: '2-digit'
         }).replace(',', '');
    }

    const dateTimeEl = document.getElementById('current-date-time');
    if (dateTimeEl) {
        const updateClock = () => { dateTimeEl.textContent = getFormattedDateTime(); };
        updateClock();
        setInterval(updateClock, 1000);
    }

    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const header = document.getElementById('header');

    if (sidebarToggle && sidebar && mainContent && header) {
        sidebarToggle.addEventListener('click', () => {
            const isCollapsed = sidebar.classList.toggle('w-[70px]');
            sidebar.classList.toggle('w-64', !isCollapsed);

            mainContent.classList.toggle('ml-[70px]', isCollapsed);
            mainContent.classList.toggle('ml-64', !isCollapsed);

            header.classList.toggle('w-[calc(100%-70px)]', isCollapsed);
            header.classList.toggle('w-[calc(100%-16rem)]', !isCollapsed);

            document.querySelectorAll('.menu-text').forEach(el => el.classList.toggle('hidden', isCollapsed));
            const icon = sidebarToggle.querySelector('i');
            icon.classList.toggle('fa-chevron-left', !isCollapsed);
            icon.classList.toggle('fa-chevron-right', isCollapsed);

            document.querySelectorAll('.sidebar p.menu-text').forEach(p => p.classList.toggle('hidden', isCollapsed));
            document.querySelectorAll('.sidebar .sidebar-link span.rounded-full').forEach(badge => badge.classList.toggle('hidden', isCollapsed));

            document.querySelectorAll('.sidebar-link').forEach(link => {
                 link.classList.toggle('justify-center', isCollapsed);
             });
        });
    }

    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    if (mobileMenuToggle && sidebar) {
         const toggleMobileMenu = () => {
             sidebar.classList.toggle('translate-x-0');
             sidebar.classList.toggle('-translate-x-full');
         };

        mobileMenuToggle.addEventListener('click', toggleMobileMenu);

        sidebar.querySelectorAll('.sidebar-link[data-section]').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024 && sidebar.classList.contains('translate-x-0')) {
                    toggleMobileMenu();
                }
            });
        });

        const handleResize = () => {
            if (window.innerWidth < 1024) {
                mobileMenuToggle.classList.remove('lg:hidden');
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            } else {
                mobileMenuToggle.classList.add('lg-hidden');
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            }
        };
        window.addEventListener('resize', handleResize);
        handleResize();

    }

    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        const applyTheme = (theme) => {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

             const visibleSection = document.querySelector('.section-content:not(.hidden)');
             if (visibleSection) {
                 const sectionId = visibleSection.id.replace('section-', '');
                 if (sectionId === 'caisse') initSalesChart();
                 else if (sectionId === 'rapports') {
                     initSalesPerformanceChart();
                     initTrendsChart();
                 } else if (sectionId === 'tables') {
                    renderTables();
                 }
             }
        };

        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(savedTheme || (prefersDark ? 'dark' : 'light'));

        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            const newTheme = isDark ? 'dark' : 'light';
            localStorage.setItem('theme', newTheme);
            applyTheme(newTheme);
        });
    }

    const crisisToggle = document.getElementById('crisis-toggle-button');
    const crisisBanner = document.getElementById('crisis-banner');
    const headerElement = document.getElementById('header');
    const alertSpeakButton = document.getElementById('alert-speak-button');

    if (crisisToggle && crisisBanner && headerElement) {
        crisisToggle.addEventListener('click', () => {
            const isActive = crisisToggle.classList.toggle('active');
            crisisBanner.classList.toggle('hidden', !isActive);

            headerElement.classList.toggle('border-red-500', isActive);
            headerElement.classList.toggle('bg-red-50', isActive && !document.documentElement.classList.contains('dark'));
            headerElement.classList.toggle('dark:bg-red-900/20', isActive && document.documentElement.classList.contains('dark'));
            if (!isActive) {
                 headerElement.classList.remove('border-red-500', 'bg-red-50', 'dark:bg-red-900/20');
            }

            if (isActive && 'speechSynthesis' in window) {
                speakAlert();
            }
        });
    }

    if (alertSpeakButton && 'speechSynthesis' in window) {
        alertSpeakButton.addEventListener('click', speakAlert);
    }

    function speakAlert() {
        if (!('speechSynthesis' in window)) {
             showNotification("La synthèse vocale n'est pas supportée par votre navigateur.", "warning");
             return;
         }
        window.speechSynthesis.cancel();

        const alertMessage = "Attention. Mode crise activé. Gestion prioritaire des ressources et du personnel requise.";
        const utterance = new SpeechSynthesisUtterance(alertMessage);
        utterance.lang = 'fr-FR';
        utterance.volume = 1;
        utterance.rate = 0.9;
        utterance.pitch = 1;

         let voices = window.speechSynthesis.getVoices();
         if (voices.length > 0) {
             const frenchVoice = voices.find(voice => voice.lang === 'fr-FR');
             if (frenchVoice) {
                 utterance.voice = frenchVoice;
             }
         } else {
             window.speechSynthesis.onvoiceschanged = () => {
                 voices = window.speechSynthesis.getVoices();
                 const frenchVoice = voices.find(voice => voice.lang === 'fr-FR');
                 if (frenchVoice) {
                     utterance.voice = frenchVoice;
                 }
                  window.speechSynthesis.speak(utterance);
             };
             setTimeout(() => {
                 if (!utterance.voice && !window.speechSynthesis.speaking) {
                      window.speechSynthesis.speak(utterance);
                  }
              }, 500);
              return;
         }

        window.speechSynthesis.speak(utterance);
    }

    function updateSalesSummary(todayTotal, weekTotal) {
        const todaySalesElement = document.getElementById('today-sales');
        const weekSalesElement = document.getElementById('week-sales');
        
        if (todaySalesElement) {
            todaySalesElement.textContent = (todayTotal || 0).toLocaleString('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + ' DH';
        }
        
        if (weekSalesElement) {
            weekSalesElement.textContent = (weekTotal || 0).toLocaleString('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + ' DH';
        }
    }

    function loadSalesSummary() {
        const restaurantSelector = document.getElementById('header-restaurant-selector');
        if (!restaurantSelector || !restaurantSelector.value) {
            updateSalesSummary(0, 0);
            return;
        }
        
        const todaySalesElement = document.getElementById('today-sales');
        const weekSalesElement = document.getElementById('week-sales');
        
        if (todaySalesElement) todaySalesElement.textContent = "...";
        if (weekSalesElement) weekSalesElement.textContent = "...";
        
        fetch(`/gerant/get-sales-summary?restaurant_id=${restaurantSelector.value}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau lors de la récupération des données');
                }
                return response.json();
            })
            .then(data => {
                updateSalesSummary(data.today_total, data.week_total);
            })
            .catch(error => {
                console.error('Erreur lors du chargement des données de ventes:', error);
                updateSalesSummary(0, 0);
            });
    }

    const restaurantSelector = document.getElementById('header-restaurant-selector');
    if (restaurantSelector) {
        restaurantSelector.addEventListener('change', function() {
            selectedRestaurantId = this.value;
            
            loadSalesSummary();
            
            if (currentActiveSection === 'caisse') {
                initSalesChart();
            }
            
            if (currentActiveSection === 'reservations') {
                loadReservations();
            }
            
            if (currentActiveSection === 'caisse') {
                const loadRecentTransactions = document.getElementById('refresh-transactions');
                if (loadRecentTransactions) {
                    loadRecentTransactions.click();
                } else {
                    const event = new Event('restaurantChanged');
                    document.dispatchEvent(event);
                }
            }
            
            if (currentActiveSection === 'tables') {
                fetchTables();
            }
        });
    }
    
    document.addEventListener('restaurantChanged', function() {
        if (currentActiveSection === 'caisse') {
            loadRecentTransactions();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (restaurantSelector && restaurantSelector.value) {
            selectedRestaurantId = restaurantSelector.value;
            loadSalesSummary();
            
            if (currentActiveSection === 'reservations') {
                loadReservations();
            }
        }
    });

    const sidebarLinks = document.querySelectorAll('.sidebar-link[data-section]');
    const sections = document.querySelectorAll('.section-content');

    function showSection(sectionId) {
        let sectionFound = false;
        sections.forEach(section => {
            if (section.id === `section-${sectionId}`) {
                section.classList.remove('hidden');
                sectionFound = true;
                currentActiveSection = sectionId;

                switch(sectionId) {
                    case 'caisse':
                        initSalesChart();
                        break;
                    case 'menu':
                        if (typeof initMenuManager === 'function') initMenuManager();
                        break;
                    case 'tables':
                        if (typeof initTableManager === 'function') initTableManager();
                        break;
                    case 'personnel':
                         if (typeof initPersonnelManager === 'function') initPersonnelManager();
                        break;
                    case 'rapports':
                        initSalesPerformanceChart();
                        initTrendsChart();
                        break;
                }
            } else {
                section.classList.add('hidden');
            }
        });

        if (!sectionFound) {
             const defaultSection = document.getElementById('section-reservations');
             if (defaultSection) {
                  defaultSection.classList.remove('hidden');
                  currentActiveSection = 'reservations';
              }
        } else {
             setActiveSidebarLink(sectionId);
        }
    }

     function setActiveSidebarLink(sectionId) {
         sidebarLinks.forEach(link => {
             if (link.getAttribute('data-section') === sectionId) {
                 link.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400');
             } else {
                 link.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400');
             }
         });
     }

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const sectionId = this.getAttribute('data-section');
            if (sectionId) {
                 e.preventDefault();
                 showSection(sectionId);
                 if (window.innerWidth < 1024 && sidebar && sidebar.classList.contains('translate-x-0')) {
                     sidebar.classList.remove('translate-x-0');
                     sidebar.classList.add('-translate-x-full');
                 }
            }
        });
    });

    const initialSection = window.location.hash.substring(1) || 'reservations';
    showSection(initialSection);

    let salesChartInstance = null;
    let salesPerformanceChartInstance = null;
    let trendsChartInstance = null;

    function destroyChart(instance) {
        if (instance) {
            try {
                 instance.destroy();
             } catch (e) {
                 console.error("Erreur lors de la destruction du chart:", e);
             }
        }
        return null;
    }

    function getChartColors() {
        const isDarkMode = document.documentElement.classList.contains('dark');
        return {
            primary: isDarkMode ? '#3B82F6' : '#0288D1',
            primaryLight: isDarkMode ? 'rgba(59, 130, 246, 0.3)' : 'rgba(2, 136, 209, 0.1)',
            green: isDarkMode ? '#22C55E' : '#4CAF50',
            yellow: isDarkMode ? '#FACC15' : '#FFC107',
            grid: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
            text: isDarkMode ? '#E5E7EB' : '#374151'
        };
    }

    function initSalesChart() {
        const ctx = document.getElementById('sales-chart')?.getContext('2d');
        if (!ctx) { return; }
        salesChartInstance = destroyChart(salesChartInstance);
        const colors = getChartColors();
        
        const restaurantSelector = document.getElementById('header-restaurant-selector');
        if (!restaurantSelector || !restaurantSelector.value) {
            const salesChartContainer = document.getElementById('sales-chart').parentNode;
            if (salesChartContainer) {
                salesChartContainer.innerHTML = `
                    <div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">
                        <p>Sélectionnez un restaurant pour voir les données de ventes.</p>
                    </div>
                `;
            }
            return;
        }
        
        const salesChartContainer = document.getElementById('sales-chart').parentNode;
        if (salesChartContainer) {
            salesChartContainer.innerHTML = `
                <div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mr-2"></div>
                    <p>Chargement des données...</p>
                </div>
            `;
        }
        
        fetch(`/gerant/get-sales-summary?restaurant_id=${restaurantSelector.value}`)
            .then(response => response.json())
            .then(data => {
                if (salesChartContainer) {
                    salesChartContainer.innerHTML = '<canvas id="sales-chart"></canvas>';
                }
                
                updateSalesSummary(data.today_total, data.week_total);
                
                const ctx = document.getElementById('sales-chart')?.getContext('2d');
                if (!ctx) return;
                
                const chartLabels = data.data.map(day => day.day);
                const chartData = data.data.map(day => day.sales);
                
                salesChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Ventes (DH)',
                            data: chartData,
                            borderColor: colors.primary,
                            backgroundColor: colors.primaryLight,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: colors.primary,
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: colors.primary,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { grid: { color: colors.grid }, ticks: { color: colors.text } },
                            y: { 
                                grid: { color: colors.grid }, 
                                ticks: { 
                                    color: colors.text, 
                                    callback: value => value.toLocaleString('fr-FR') + ' DH' 
                                }, 
                                beginAtZero: true 
                            }
                        },
                        plugins: { 
                            legend: { display: false },
                            tooltip: { 
                                callbacks: { 
                                    label: (context) => {
                                        const value = context.parsed.y;
                                        const formattedValue = value.toLocaleString('fr-FR', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                        return `Ventes: ${formattedValue} DH`;
                                    }
                                } 
                            }
                        },
                        interaction: { intersect: false, mode: 'index' }
                    }
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des données de ventes:', error);
                if (salesChartContainer) {
                    salesChartContainer.innerHTML = `
                        <div class="flex items-center justify-center h-full text-red-500">
                            <p>Erreur lors du chargement des données. Veuillez réessayer.</p>
                        </div>
                    `;
                }
            });
    }

    function initSalesPerformanceChart() {
        const ctx = document.getElementById('sales-performance-chart')?.getContext('2d');
        if (!ctx) { return; }
        salesPerformanceChartInstance = destroyChart(salesPerformanceChartInstance);
        const colors = getChartColors();

        salesPerformanceChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Cette semaine',
                    data: [1200, 1500, 1300, 1700, 2100, 2500, 1800],
                    backgroundColor: colors.primary,
                    borderColor: colors.primary,
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 40
                }, {
                    label: 'Semaine précédente',
                    data: [1100, 1400, 1250, 1600, 1900, 2300, 1700],
                    backgroundColor: colors.primaryLight,
                    borderColor: colors.primaryLight,
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { grid: { display: false }, ticks: { color: colors.text } },
                    y: { grid: { color: colors.grid }, ticks: { color: colors.text, callback: value => value + ' DH' }, beginAtZero: true }
                },
                plugins: { legend: { labels: { color: colors.text } } },
                 interaction: { mode: 'index' },
                 tooltip: { callbacks: { label: (context) => `${context.dataset.label}: ${context.parsed.y.toFixed(2)} DH` } }
            }
        });
    }

    function initTrendsChart() {
        const ctx = document.getElementById('trends-chart')?.getContext('2d');
        if (!ctx) { return; }
        trendsChartInstance = destroyChart(trendsChartInstance);
        const colors = getChartColors();

        trendsChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Clients',
                    data: [1500, 1700, 1600, 1800, 1900, 2000],
                    borderColor: colors.green,
                    backgroundColor: colors.green + '1A',
                    tension: 0.3, yAxisID: 'yClients',
                    pointBackgroundColor: colors.green, pointBorderColor: '#fff', pointRadius: 4,
                    pointHoverBackgroundColor: '#fff', pointHoverBorderColor: colors.green, pointHoverRadius: 6
                }, {
                    label: 'Ticket moyen (DH)',
                    data: [48.5, 52.1, 51.0, 54.3, 56.8, 58.2],
                    borderColor: colors.yellow,
                    backgroundColor: colors.yellow + '1A',
                    tension: 0.3, yAxisID: 'yTicket',
                    pointBackgroundColor: colors.yellow, pointBorderColor: '#fff', pointRadius: 4,
                    pointHoverBackgroundColor: '#fff', pointHoverBorderColor: colors.yellow, pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                 scales: {
                     x: { grid: { color: colors.grid }, ticks: { color: colors.text } },
                     yClients: {
                         position: 'left',
                         title: { display: true, text: 'Nombre de clients', color: colors.text },
                         grid: { color: colors.grid },
                         ticks: { color: colors.text }
                     },
                     yTicket: {
                         position: 'right',
                         title: { display: true, text: 'Ticket moyen (DH)', color: colors.text },
                         grid: { drawOnChartArea: false },
                         ticks: { color: colors.text, callback: value => value.toFixed(2) + ' DH' },
                         beginAtZero: false
                     }
                 },
                 plugins: { legend: { labels: { color: colors.text } } },
                 interaction: { intersect: false, mode: 'index' },
                 tooltip: {
                     callbacks: {
                         label: (context) => {
                              let label = context.dataset.label || '';
                              if (label) { label += ': '; }
                              if (context.parsed.y !== null) {
                                  label += context.parsed.y.toFixed(context.dataset.yAxisID === 'yTicket' ? 2 : 0);
                                  if (context.dataset.yAxisID === 'yTicket') label += ' DH';
                              }
                              return label;
                          }
                     }
                 }
            }
        });
    }

    let tablesData = [];
    let selectedTableId = null;
    let isTableManagerInitialized = false;

    function initTableManager() {
        if (isTableManagerInitialized) {
            renderTablesList();
            return;
        }

        const tablesListContainer = document.getElementById('tables-list');
        if (!tablesListContainer) {
            return;
        }

        renderTablesList();
        setupTableEventListeners();
        isTableManagerInitialized = true;
    }

    function renderTablesList() {
        const container = document.getElementById('tables-list');
        const searchInput = document.getElementById('table-search');
        const statusFilterSelect = document.getElementById('status-filter');
        if (!container || !searchInput || !statusFilterSelect) return;

        container.innerHTML = '';
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusFilter = statusFilterSelect.value;

        const filteredAndSortedTables = tablesData
            .filter(table => {
                const properties = Object.keys(table).join(", ");
                console.log(`Table ID ${table.id}: ${properties}`);
                
                const tableNumber = table.number || table.numero || "";
                const tableCapacity = table.capacity || table.capacite || "";
                const tableType = table.type || table.typeTable || "";
                
                const matchSearch = searchTerm === '' || 
                                   String(tableNumber).toLowerCase().includes(searchTerm) || 
                                   String(tableCapacity).toLowerCase().includes(searchTerm) ||
                                   String(tableType).toLowerCase().includes(searchTerm);
                
                const matchStatus = statusFilter === 'all' || statusFilter === table.status;
                return matchSearch && matchStatus;
            })
            .sort((a, b) => (a.number || a.numero) - (b.number || b.numero));

        if (filteredAndSortedTables.length === 0) {
             container.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-gray-500">Aucune table trouvée.</td></tr>`;
             return;
         }

        filteredAndSortedTables.forEach(table => {
            const row = document.createElement('tr');
            row.dataset.id = table.id;
            row.className = 'border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150';

            let statusBadge;
            switch(table.status) {
                case 'available': 
                    statusBadge = '<span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300">Disponible</span>'; 
                    break;
                case 'occupied': 
                    statusBadge = '<span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">Occupée</span>'; 
                    break;
                default: 
                    statusBadge = '<span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">Inconnu</span>';
            }

            let typeText;
            switch(table.type) {
                case 'round': typeText = 'Ronde'; break;
                case 'rect': typeText = 'Rectangulaire'; break;
                case 'booth': typeText = 'Booth'; break;
                default: typeText = table.type;
            }

            row.innerHTML = `
                <td class="px-4 py-3 font-medium">T ${table.number}</td>
                <td class="px-4 py-3 text-sm">${table.capacity}</td>
                <td class="px-4 py-3 text-sm">${typeText}</td>
                <td class="px-4 py-3">${statusBadge}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-1">
                        <button class="action-button bg-blue-500 hover:bg-blue-600 text-white" title="Modifier" data-action="edit">
                            <i class="fas fa-edit"></i>
                        </button>
                         <button class="action-button bg-yellow-500 hover:bg-yellow-600 text-white ${table.status === 'available' ? 'opacity-50 cursor-not-allowed' : ''}" title="Changer Statut" data-action="status" ${table.status === 'available' ? 'disabled' : ''}>
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button class="action-button bg-green-500 hover:bg-green-600 text-white ${table.status !== 'available' ? 'opacity-50 cursor-not-allowed' : ''}" title="Occuper/Arrivée" data-action="occupy" ${table.status !== 'available' ? 'disabled' : ''}>
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="action-button bg-red-500 hover:bg-red-600 text-white" title="Supprimer" data-action="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
             row.querySelectorAll('.action-button').forEach(btn => {
                 btn.classList.add('p-1.5', 'text-xs', 'rounded', 'transition-colors', 'duration-150');
                 btn.querySelector('i')?.classList.add('pointer-events-none');
             });
            container.appendChild(row);
        });
    }

    function setupTableEventListeners() {
        const floorSelector = document.getElementById('floor-selector');
        const tableSearch = document.getElementById('table-search');
        const statusFilter = document.getElementById('status-filter');
        const btnAddTable = document.getElementById('btn-add-table');

        if (floorSelector) floorSelector.addEventListener('change', renderTables);
        if (tableSearch) tableSearch.addEventListener('input', renderTablesList);
        if (statusFilter) statusFilter.addEventListener('change', renderTablesList);
        if (btnAddTable) btnAddTable.addEventListener('click', () => showTableModal());

        const tableModal = document.getElementById('table-modal');
        const cancelTableModal = document.getElementById('cancel-table-modal');
        const saveTableBtn = document.getElementById('save-table');
        const deleteTableModal = document.getElementById('delete-table-modal');
        const cancelDeleteTable = document.getElementById('cancel-delete-table');
        const confirmDeleteTableBtn = document.getElementById('confirm-delete-table');

        if (tableModal && cancelTableModal && saveTableBtn) {
            cancelTableModal.addEventListener('click', () => hideModal(tableModal));
            saveTableBtn.addEventListener('click', saveTable);
             tableModal.addEventListener('click', (event) => {
                 if (event.target === tableModal) hideModal(tableModal);
             });
        }
        if (deleteTableModal && cancelDeleteTable && confirmDeleteTableBtn) {
            cancelDeleteTable.addEventListener('click', () => hideModal(deleteTableModal));
            confirmDeleteTableBtn.addEventListener('click', handleDeleteTable);
             deleteTableModal.addEventListener('click', (event) => {
                 if (event.target === deleteTableModal) hideModal(deleteTableModal);
             });
        }

         const tablesListContainer = document.getElementById('tables-list');
         if (tablesListContainer) {
             tablesListContainer.addEventListener('click', handleTableListAction);
         }
    }

     function handleTableListAction(event) {
        const button = event.target.closest('button.action-button[data-action]');
        if (!button || button.disabled) return;

        const action = button.dataset.action;
        const tableRow = button.closest('tr');
        const id = tableRow ? parseInt(tableRow.dataset.id) : null;

        if (id === null) return;

        switch(action) {
            case 'edit':
                editTable(id);
                break;
            case 'status':
                 cycleTableStatus(id);
                 break;
            case 'occupy':
                 occupyTable(id);
                 break;
            case 'delete':
                confirmDeleteTable(id);
                break;
        }
    }

     function findTableById(id) {
         return tablesData.find(t => t.id === id);
     }
     function findTableIndexById(id) {
         return tablesData.findIndex(t => t.id === id);
     }

    function editTable(id) {
        const table = findTableById(id);
        if (table) {
            showTableModal(table);
        } else {
            showNotification(`Table ID ${id} non trouvée pour modification.`, 'error');
        }
    }

     function occupyTable(id) {
         const tableIndex = findTableIndexById(id);
         if (tableIndex === -1) return;

         const currentStatus = tablesData[tableIndex].status;

         if (currentStatus === 'available') {
             const tableData = {
                 statut: 'occupied'
             };

             fetch(`/gerant/tables/${id}/update-status`, {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                 },
                 body: JSON.stringify(tableData)
             })
             .then(response => response.json())
             .then(data => {
                 if (data.success) {
                     tablesData[tableIndex].status = 'occupied';
                     tablesData[tableIndex].since = getCurrentTime();
                     if (!tablesData[tableIndex].server) tablesData[tableIndex].server = 'Assigné';
                     
                     renderAndUpdate(`Table ${tablesData[tableIndex].number} marquée comme occupée.`, 'success');
                 } else {
                     showNotification(data.message || 'Erreur lors de la mise à jour du statut', 'error');
                 }
             })
             .catch(error => {
                 console.error('Erreur:', error);
                 showNotification('Erreur de communication avec le serveur', 'error');
             });
         } else {
             showNotification(`Cette action n'est possible que pour les tables disponibles.`, 'warning');
         }
     }

     function cycleTableStatus(id) {
         const tableIndex = findTableIndexById(id);
         if (tableIndex === -1) return;

         const currentStatus = tablesData[tableIndex].status;
         if (currentStatus === 'available') {
             showNotification("Utilisez le bouton vert 'Occuper' pour passer une table à 'Occupée'.", "info");
             return;
         }

         const statusOrder = ['occupied', 'available'];
         let currentIndex = statusOrder.indexOf(currentStatus);
         let nextIndex = (currentIndex + 1) % statusOrder.length;
         let nextStatus = statusOrder[nextIndex];

         tablesData[tableIndex].status = nextStatus;
         tablesData[tableIndex].since = getCurrentTime();

         let notificationMessage = `Statut de la Table ${tablesData[tableIndex].number} mis à jour : ${nextStatus}.`;

         if (nextStatus === 'available') {
             tablesData[tableIndex].server = null;
             tablesData[tableIndex].since = null;
             notificationMessage = `Table ${tablesData[tableIndex].number} libérée.`;
         } else if (!tablesData[tableIndex].server) {
             tablesData[tableIndex].server = 'Assigné';
         }

         renderAndUpdate(notificationMessage);
     }


    function confirmDeleteTable(id) {
        selectedTableId = id;
        const table = findTableById(id);
        const modal = document.getElementById('delete-table-modal');
        const numberSpan = document.getElementById('delete-table-number');
        if (table && modal && numberSpan) {
            numberSpan.textContent = `n°${table.number}`;
            showModal(modal);
        }
    }

     function handleDeleteTable() {
         if (selectedTableId === null) return;
         
         fetch(`/gerant/tables/${selectedTableId}`, {
             method: 'DELETE',
             headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
             }
         })
         .then(response => response.json())
         .then(data => {
             if (data.success) {
                 fetchTables();
                 hideModal(document.getElementById('delete-table-modal'));
                 showNotification(data.message, 'success');
             } else {
                 showNotification(data.message || 'Erreur lors de la suppression', 'error');
             }
         })
         .catch(error => {
             console.error('Erreur:', error);
             showNotification('Erreur de communication avec le serveur', 'error');
         });
         
         selectedTableId = null;
     }

     function renderAndUpdate(notificationMessage = null, notificationType = 'info') {
          renderTablesList();
          if (notificationMessage) {
               showNotification(notificationMessage, notificationType);
           }
      }

    function showTableModal(table = null) {
        const modal = document.getElementById('table-modal');
        if (!modal) return;

        const title = document.getElementById('table-modal-title');
        const numberInput = document.getElementById('table-number');
        const capacityInput = document.getElementById('table-capacity');
        const zoneSelect = document.getElementById('table-zone');

        if (!title || !numberInput || !capacityInput || !zoneSelect) {
             return;
         }

        numberInput.value = ''; 
        capacityInput.value = ''; 
        zoneSelect.value = 'SallePrincipale';

        if (table) {
            title.textContent = `Modifier la table ${table.number}`;
            numberInput.value = table.number;
            capacityInput.value = table.capacity;
            
            if (table.typeTable) {
                zoneSelect.value = table.typeTable;
            } else if (table.zone) {
                zoneSelect.value = table.zone;
            }
            
            const zoneExists = Array.from(zoneSelect.options).some(option => option.value === zoneSelect.value);
            if (!zoneExists) {
                zoneSelect.value = 'SallePrincipale';
            }
            
            selectedTableId = table.id;
        } else {
            title.textContent = 'Ajouter une table';
            const maxNumber = tablesData.length > 0 ? Math.max(0, ...tablesData.map(t => t.number || t.numero)) : 0;
            numberInput.value = maxNumber + 1;
            capacityInput.value = 4;
            selectedTableId = null;
        }
        showModal(modal);
    }

    function saveTable() {
        const numberInput = document.getElementById('table-number');
        const capacityInput = document.getElementById('table-capacity');
        const zoneSelect = document.getElementById('table-zone');
        const modal = document.getElementById('table-modal');
        const restaurantSelector = document.getElementById('header-restaurant-selector');

        if (!numberInput.value || !capacityInput.value) {
            showNotification('Le numéro et la capacité sont obligatoires.', 'warning');
            return;
        }
        const tableNumber = parseInt(numberInput.value);
        const capacity = parseInt(capacityInput.value);
        if (isNaN(tableNumber) || tableNumber <= 0 || isNaN(capacity) || capacity <= 0) {
             showNotification('Numéro ou capacité invalide.', 'warning');
             return;
         }
        
        if (!restaurantSelector || !restaurantSelector.value) {
            showNotification('Veuillez sélectionner un restaurant.', 'warning');
            return;
        }

        const tableData = {
            numero: tableNumber,
            capacite: capacity,
            typeTable: zoneSelect.value,
            restaurant_id: restaurantSelector.value
        };

        let url, method;
        if (selectedTableId !== null) {
            url = `/gerant/tables/${selectedTableId}`;
            method = 'PUT';
        } else {
            url = `/gerant/tables`;
            method = 'POST';
        }

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(tableData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchTables();
                hideModal(modal);
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || 'Erreur lors de l\'enregistrement', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur de communication avec le serveur', 'error');
        });

        selectedTableId = null;
    }

    function fetchTables() {
        const restaurantSelector = document.getElementById('header-restaurant-selector');
        const tablesListContainer = document.getElementById('tables-list');
        if (!restaurantSelector || !restaurantSelector.value) {
            showNotification("Veuillez sélectionner un restaurant", "warning");
            if (tablesListContainer) {
                tablesListContainer.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-gray-500">Veuillez sélectionner un restaurant</td></tr>`;
            }
            return;
        }
        
        if (tablesListContainer) {
            tablesListContainer.innerHTML = `<tr><td colspan="5" class="text-center py-4"><div class="inline-block animate-spin rounded-full h-5 w-5 border-b-2 border-blue-500 mr-2"></div> Chargement des tables...</td></tr>`;
        }
        
        fetch(`/gerant/get-tables?restaurant_id=${restaurantSelector.value}`)
            .then(response => response.json())
            .then(data => {
                tablesData = data.tables.map(table => ({
                    id: table.id,
                    number: table.numero,
                    capacity: table.capacite,
                    zone: table.zone,
                    type: table.typeTable,
                    status: table.statut
                }));
                
                renderTablesList();
            })
            .catch(error => {
                console.error('Erreur lors du chargement des tables:', error);
                showNotification("Erreur lors du chargement des tables", "error");
                if (tablesListContainer) {
                    tablesListContainer.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-red-500">Erreur lors du chargement des tables</td></tr>`;
                }
            });
    }

    let isPersonnelManagerInitialized = false;

    function initPersonnelManager() {
        if (isPersonnelManagerInitialized) return;
        setupPersonnelEventListeners();
        isPersonnelManagerInitialized = true;
    }

    function setupPersonnelEventListeners() {
        const sectionPersonnel = document.getElementById('section-personnel');
        if (!sectionPersonnel) return;

        const deleteEmployeeModal = document.getElementById('delete-modal');
        const scheduleModal = document.getElementById('schedule-modal');

        sectionPersonnel.addEventListener('click', function(event) {
            const target = event.target;
            const deleteButton = target.closest('button[title="Supprimer"]');
            const addShiftButton = target.closest('button.add-shift-button');
             const addEmployeeButton = target.closest('button.add-employee-button');

            if (deleteButton && deleteEmployeeModal) {
                const employeeRow = deleteButton.closest('tr');
                showModal(deleteEmployeeModal);
            } else if (addShiftButton && scheduleModal) {
                showModal(scheduleModal);
            } else if (addEmployeeButton) {
                 showNotification("Fonctionnalité 'Ajouter Employé' non implémentée.", "info");
             }
        });

        const cancelDelete = document.getElementById('cancel-delete');
        const confirmDelete = document.getElementById('confirm-delete');
        const cancelSchedule = document.getElementById('cancel-schedule');
        const saveSchedule = document.getElementById('save-schedule');

        if (deleteEmployeeModal && cancelDelete && confirmDelete) {
            cancelDelete.addEventListener('click', () => hideModal(deleteEmployeeModal));
            confirmDelete.addEventListener('click', () => {
                showNotification("Employé supprimé (simulation).", 'success');
                hideModal(deleteEmployeeModal);
            });
            deleteEmployeeModal.addEventListener('click', (e) => { if (e.target === deleteEmployeeModal) hideModal(deleteEmployeeModal); });
        }

        if (scheduleModal && cancelSchedule && saveSchedule) {
            cancelSchedule.addEventListener('click', () => hideModal(scheduleModal));
            saveSchedule.addEventListener('click', () => {
                showNotification("Créneau horaire ajouté (simulation).", 'success');
                hideModal(scheduleModal);
            });
            scheduleModal.addEventListener('click', (e) => { if (e.target === scheduleModal) hideModal(scheduleModal); });
        }

        sectionPersonnel.querySelectorAll('select.employee-role-select').forEach(select => {
            select.addEventListener('change', function() {
                const selectedRole = this.options[this.selectedIndex].text;
                const employeeRow = this.closest('tr');
                showNotification(`Rôle mis à jour vers ${selectedRole} (simulation).`, 'info');
            });
        });

         const searchInput = sectionPersonnel.querySelector('input[type="text"][placeholder="Rechercher..."]');
         const roleFilterSelect = sectionPersonnel.querySelector('select:not(.employee-role-select)');
         if (searchInput) searchInput.addEventListener('input', () => { console.log("Recherche:", searchInput.value); });
         if (roleFilterSelect) roleFilterSelect.addEventListener('change', () => { console.log("Filtre rôle:", roleFilterSelect.value); });

    }

    const reservationsTableBody = document.getElementById('reservations-table-body');
    const loadingIndicator = document.getElementById('loading-indicator');
    const dateFilter = document.getElementById('reservation-date-filter');
    
    let currentReservations = [];
    
    function loadReservations() {
        if (!selectedRestaurantId) return;
        
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        
        if (reservationsTableBody) {
            reservationsTableBody.innerHTML = '';
        }
        
        fetch(`/gerant/get-reservations?restaurant_id=${selectedRestaurantId}`)
            .then(response => response.json())
            .then(data => {
                if (loadingIndicator) loadingIndicator.classList.add('hidden');
                
                currentReservations = data.reservations || [];
                
                const filteredReservations = filterReservationsByDate(currentReservations);
                
                displayReservations(filteredReservations);
            })
            .catch(error => {
                console.error('Erreur lors du chargement des réservations:', error);
                if (loadingIndicator) loadingIndicator.classList.add('hidden');
                if (reservationsTableBody) {
                    reservationsTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-red-500">
                                <p>Erreur lors du chargement des réservations. Veuillez réessayer.</p>
                            </td>
                        </tr>
                    `;
                }
            });
    }
    
    function filterReservationsByDate(reservations) {
        const filterValue = dateFilter ? dateFilter.value : 'all';
        const today = new Date().toISOString().split('T')[0];
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const tomorrowStr = tomorrow.toISOString().split('T')[0];
        
        const endOfWeek = new Date();
        endOfWeek.setDate(endOfWeek.getDate() + (7 - endOfWeek.getDay()));
        const endOfWeekStr = endOfWeek.toISOString().split('T')[0];
        
        return reservations.filter(reservation => {
            switch (filterValue) {
                case 'today':
                    return reservation.date === today;
                case 'tomorrow':
                    return reservation.date === tomorrowStr;
                case 'week':
                    return reservation.date >= today && reservation.date <= endOfWeekStr;
                default:
                    return true;
            }
        });
    }
    
    function displayReservations(reservations) {
        if (!reservationsTableBody) return;
        
        if (reservations.length === 0) {
            reservationsTableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                        <p>Aucune réservation trouvée pour cette période.</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        
        reservations.forEach(reservation => {
            let statusClass = '';
            switch (reservation.statut) {
                case 'Confirmé':
                    statusClass = 'bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300';
                    break;
                case 'Refusé':
                    statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300';
                    break;
                default:
                    statusClass = 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-300';
                    break;
            }
            
            const dateParts = reservation.date.split('-');
            const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
            
            html += `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30" data-id="${reservation.id}">
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${formattedDate}</td>
                    <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100">${reservation.heure}</td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${reservation.client}</td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${reservation.telephone}</td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${reservation.table}</td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 text-center">${reservation.personnes}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full ${statusClass}">
                            ${reservation.statut}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-1">
                            <form method="POST" action="/gerant/reservations/update-status" class="inline-block">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="id" value="${reservation.id}">
                                
                                ${reservation.statut !== 'Confirmé' ? 
                                    `<button type="button" class="confirm-reservation p-1.5 text-xs bg-green-500 hover:bg-green-600 text-white rounded" title="Confirmer" data-reservation-id="${reservation.id}" data-status="Confirmé">
                                        <i class="fas fa-check"></i>
                                    </button>` : 
                                    `<button type="button" class="arrived-btn p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Marquer Arrivé">
                                        <i class="fas fa-user-check"></i>
                                    </button>`
                                }
                                
                                ${reservation.statut !== 'Refusé' ? 
                                    `<button type="button" class="refuse-reservation p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Refuser" data-reservation-id="${reservation.id}" data-status="Refusé">
                                        <i class="fas fa-times"></i>
                                    </button>` : ''
                                }
                            </form>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        reservationsTableBody.innerHTML = html;
        
        attachActionButtonEvents();
    }
    
    function attachActionButtonEvents() {
        document.querySelectorAll('.confirm-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const reservationId = row.dataset.id;
                updateReservationStatus(reservationId, 'Confirmé');
            });
        });
        
        document.querySelectorAll('.refuse-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const reservationId = row.dataset.id;
                updateReservationStatus(reservationId, 'Refusé');
            });
        });
        
        document.querySelectorAll('.arrived-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const reservationId = row.dataset.id;
                alert('Le client est arrivé pour sa réservation.');
            });
        });
    }
    
    function updateReservationStatus(id, status) {
        if (!id || !status) return;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/gerant/reservations/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                id: id,
                statut: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const index = currentReservations.findIndex(r => r.id == id);
                if (index !== -1) {
                    currentReservations[index] = data.reservation;
                    
                    const filteredReservations = filterReservationsByDate(currentReservations);
                    displayReservations(filteredReservations);
                }
                
                showNotification(data.message, 'success');
            } else {
                showNotification('Erreur lors de la mise à jour du statut.', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur de connexion.', 'error');
        });
    }
    
    function showNotification(message, type = 'info') {
        const notificationDiv = document.createElement('div');
        notificationDiv.className = `fixed top-4 right-4 p-4 rounded shadow-lg transition-opacity z-50 ${
            type === 'success' ? 'bg-green-100 text-green-700 border-l-4 border-green-500' :
            type === 'error' ? 'bg-red-100 text-red-700 border-l-4 border-red-500' :
            'bg-blue-100 text-blue-700 border-l-4 border-blue-500'
        }`;
        
        notificationDiv.innerHTML = message;
        document.body.appendChild(notificationDiv);
        
        setTimeout(() => {
            notificationDiv.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notificationDiv);
            }, 300);
        }, 3000);
    }
    
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            const filteredReservations = filterReservationsByDate(currentReservations);
            displayReservations(filteredReservations);
        });
    }
    
    if (restaurantSelector && restaurantSelector.value) {
        selectedRestaurantId = restaurantSelector.value;
        loadReservations();
    }
});