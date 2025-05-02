// resources/js/gerant.js

document.addEventListener('DOMContentLoaded', function() {

    // ----- Utilitaires Globaux -----

    function showNotification(message, type = 'info') { // types: 'info', 'success', 'error', 'warning'
        const existingNotifications = document.querySelectorAll('.dashboard-notification');
        existingNotifications.forEach(notif => notif.remove());

        const notification = document.createElement('div');
        let bgColor = 'bg-blue-500'; // Défaut = info
        if (type === 'success') bgColor = 'bg-green-500';
        else if (type === 'error') bgColor = 'bg-red-500';
        else if (type === 'warning') bgColor = 'bg-yellow-500 text-black'; // Warning avec texte noir pour lisibilité

        // Ajout de classes Tailwind pour positionnement, style et transition
        notification.className = `dashboard-notification fixed bottom-4 right-4 ${bgColor} text-white px-4 py-3 rounded-lg shadow-xl z-[100] transition-all duration-500 ease-out opacity-0 transform translate-y-2`;
        notification.textContent = message;
        document.body.appendChild(notification);

        // Animation d'apparition
        setTimeout(() => {
            notification.classList.remove('opacity-0', 'translate-y-2');
        }, 50);

        // Disparition après délai
        setTimeout(() => {
             notification.classList.add('opacity-0', 'translate-y-2');
             // Suppression du DOM après la fin de la transition
             setTimeout(() => {
                if (notification.parentNode) {
                     notification.parentNode.removeChild(notification);
                }
            }, 550); // Légèrement plus long que la durée de transition
        }, 3500); // Durée d'affichage
    }
    // Rendre accessible globalement si nécessaire (moins idéal que la délégation)
    window.showNotification = showNotification;

    function showModal(modalElement) {
        if (modalElement) {
            modalElement.classList.remove('hidden');
            modalElement.classList.add('flex'); // Utiliser flex pour centrer via Tailwind
             // Empêche le scroll de l'arrière-plan
             document.body.style.overflow = 'hidden';
        } else {
            console.warn("Tentative d'affichage d'une modal inexistante");
        }
    }

    function hideModal(modalElement) {
        if (modalElement) {
            modalElement.classList.add('hidden');
            modalElement.classList.remove('flex');
             // Rétablit le scroll de l'arrière-plan
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

    // ----- Initialisation Globale UI -----

    // Mise à jour Date/Heure
    const dateTimeEl = document.getElementById('current-date-time');
    if (dateTimeEl) {
        const updateClock = () => { dateTimeEl.textContent = getFormattedDateTime(); };
        updateClock();
        setInterval(updateClock, 1000);
    } else {
        console.warn("Élément 'current-date-time' non trouvé.");
    }

    // Toggle Sidebar
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const header = document.getElementById('header');

    if (sidebarToggle && sidebar && mainContent && header) {
        sidebarToggle.addEventListener('click', () => {
            const isCollapsed = sidebar.classList.toggle('w-[70px]'); // Bascule et vérifie si elle est maintenant réduite
            sidebar.classList.toggle('w-64', !isCollapsed); // Ajoute w-64 si PAS réduite

            mainContent.classList.toggle('ml-[70px]', isCollapsed);
            mainContent.classList.toggle('ml-64', !isCollapsed);

            header.classList.toggle('w-[calc(100%-70px)]', isCollapsed);
            header.classList.toggle('w-[calc(100%-16rem)]', !isCollapsed); // 16rem = 256px = w-64

            // Cache/Affiche les textes du menu et l'icône chevron
            document.querySelectorAll('.menu-text').forEach(el => el.classList.toggle('hidden', isCollapsed));
            const icon = sidebarToggle.querySelector('i');
            icon.classList.toggle('fa-chevron-left', !isCollapsed);
            icon.classList.toggle('fa-chevron-right', isCollapsed);

             // Cache le titre 'Opérations' / 'Gestion' si réduit
            document.querySelectorAll('.sidebar p.menu-text').forEach(p => p.classList.toggle('hidden', isCollapsed));
             // Cache le badge de notification si réduit
             document.querySelectorAll('.sidebar .sidebar-link span.rounded-full').forEach(badge => badge.classList.toggle('hidden', isCollapsed));

             // Ajuste le padding/margin si nécessaire quand réduit
             document.querySelectorAll('.sidebar-link').forEach(link => {
                 link.classList.toggle('justify-center', isCollapsed); // Centre l'icône
             });
        });
    } else {
        console.warn("Éléments de la sidebar (toggle, sidebar, main, header) non trouvés.");
    }

    // Toggle Menu Mobile
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    if (mobileMenuToggle && sidebar) {
         const toggleMobileMenu = () => {
             sidebar.classList.toggle('translate-x-0');
             sidebar.classList.toggle('-translate-x-full');
         };

        mobileMenuToggle.addEventListener('click', toggleMobileMenu);

        // Ferme le menu mobile quand on clique sur un lien de section
        sidebar.querySelectorAll('.sidebar-link[data-section]').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024 && sidebar.classList.contains('translate-x-0')) { // lg breakpoint for Tailwind
                    toggleMobileMenu();
                }
            });
        });

         // Gère l'affichage initial et le redimensionnement
        const handleResize = () => {
            if (window.innerWidth < 1024) { // lg breakpoint
                mobileMenuToggle.classList.remove('lg:hidden'); // Assure visibilité sur mobile/tablette
                sidebar.classList.add('-translate-x-full'); // Caché par défaut
                sidebar.classList.remove('translate-x-0');
            } else {
                mobileMenuToggle.classList.add('lg:hidden'); // Cache sur grand écran
                sidebar.classList.remove('-translate-x-full'); // Visible par défaut sur grand écran
                sidebar.classList.add('translate-x-0');
                 // Assure que la sidebar n'est pas en mode réduit si on agrandit l'écran
                 // (Comportement optionnel, on pourrait vouloir garder l'état réduit)
                 /*
                 if (sidebar.classList.contains('w-[70px]')) {
                     sidebarToggle.click(); // Simule un clic pour l'agrandir
                 }
                 */
            }
        };
        window.addEventListener('resize', handleResize);
        handleResize(); // Appel initial

    } else {
         console.warn("Bouton de menu mobile ou sidebar non trouvés.");
    }

    // Toggle Thème Sombre/Clair
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        const applyTheme = (theme) => {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
             // Redessine les charts visibles après changement de thème
             // Trouve la section actuellement visible
             const visibleSection = document.querySelector('.section-content:not(.hidden)');
             if (visibleSection) {
                 const sectionId = visibleSection.id.replace('section-', '');
                 if (sectionId === 'caisse') initSalesChart();
                 else if (sectionId === 'rapports') {
                     initSalesPerformanceChart();
                     initTrendsChart();
                 } else if (sectionId === 'tables') {
                    // Le rendu des tables utilise des classes Tailwind qui s'adaptent au dark mode
                    // mais si des couleurs CSS spécifiques sont utilisées, il faut forcer le re-rendu
                    renderTables(); // Re-render les tables pour appliquer les bonnes couleurs dark:bg-...
                 }
             }
        };

        // Applique le thème sauvegardé ou préféré au chargement
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(savedTheme || (prefersDark ? 'dark' : 'light'));

        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            const newTheme = isDark ? 'dark' : 'light';
            localStorage.setItem('theme', newTheme);
            applyTheme(newTheme); // Assure que les charts se mettent à jour
        });
    } else {
        console.warn("Bouton de changement de thème non trouvé.");
    }

    // Toggle Mode Crise
    const crisisToggle = document.getElementById('crisis-toggle-button');
    const crisisBanner = document.getElementById('crisis-banner');
    const headerElement = document.getElementById('header'); // Renommé pour clarté
    const alertSpeakButton = document.getElementById('alert-speak-button');

    if (crisisToggle && crisisBanner && headerElement) {
        crisisToggle.addEventListener('click', () => {
            const isActive = crisisToggle.classList.toggle('active');
            crisisBanner.classList.toggle('hidden', !isActive);

            // Gère les styles du header avec précaution pour éviter conflits
            // Il est peut-être préférable d'ajouter/retirer UNE classe spécifique 'crisis-active-header'
            headerElement.classList.toggle('border-red-500', isActive);
            headerElement.classList.toggle('bg-red-50', isActive && !document.documentElement.classList.contains('dark'));
            headerElement.classList.toggle('dark:bg-red-900/20', isActive && document.documentElement.classList.contains('dark'));
            // Supprime les classes de base pour éviter les conflits si on ne toggle pas bg-white/dark:bg-gray-800
            if (!isActive) {
                 headerElement.classList.remove('border-red-500', 'bg-red-50', 'dark:bg-red-900/20');
            }

            if (isActive && 'speechSynthesis' in window) {
                speakAlert();
            }
        });
    } else {
        console.warn("Éléments du mode crise (toggle, bannière, header) non trouvés.");
    }

    if (alertSpeakButton && 'speechSynthesis' in window) {
        alertSpeakButton.addEventListener('click', speakAlert);
    } else if (!alertSpeakButton) {
         console.warn("Bouton 'alert-speak-button' non trouvé.");
    }

    function speakAlert() {
        if (!('speechSynthesis' in window)) {
             showNotification("La synthèse vocale n'est pas supportée par votre navigateur.", "warning");
             return;
         }
        // Annule toute parole précédente
        window.speechSynthesis.cancel();

        const alertMessage = "Attention. Mode crise activé. Gestion prioritaire des ressources et du personnel requise.";
        const utterance = new SpeechSynthesisUtterance(alertMessage);
        utterance.lang = 'fr-FR';
        utterance.volume = 1; // Max volume
        utterance.rate = 0.9; // Un peu plus lent pour clarté
        utterance.pitch = 1;

        // Essaye de trouver une voix française
         let voices = window.speechSynthesis.getVoices();
         if (voices.length > 0) {
             const frenchVoice = voices.find(voice => voice.lang === 'fr-FR');
             if (frenchVoice) {
                 utterance.voice = frenchVoice;
             }
         } else {
             // Si les voix ne sont pas chargées, attendre l'événement
             window.speechSynthesis.onvoiceschanged = () => {
                 voices = window.speechSynthesis.getVoices();
                 const frenchVoice = voices.find(voice => voice.lang === 'fr-FR');
                 if (frenchVoice) {
                     utterance.voice = frenchVoice;
                 }
                  // Ne parle qu'après avoir potentiellement défini la voix
                  window.speechSynthesis.speak(utterance);
             };
             // Parle avec la voix par défaut si onvoiceschanged ne se déclenche pas rapidement
             setTimeout(() => {
                 if (!utterance.voice && !window.speechSynthesis.speaking) {
                      window.speechSynthesis.speak(utterance);
                  }
              }, 500); // Attend 500ms pour le chargement des voix
              return; // Sort pour éviter de parler deux fois
         }

        window.speechSynthesis.speak(utterance);
    }


    // ----- Navigation des Sections -----
    const sidebarLinks = document.querySelectorAll('.sidebar-link[data-section]');
    const sections = document.querySelectorAll('.section-content');
    let currentActiveSection = null; // Pour savoir quelle section est active

    function showSection(sectionId) {
        let sectionFound = false;
        sections.forEach(section => {
            if (section.id === `section-${sectionId}`) {
                section.classList.remove('hidden');
                sectionFound = true;
                currentActiveSection = sectionId;

                // Initialise les composants spécifiques à la section SI elle devient visible
                switch(sectionId) {
                    case 'caisse':
                        initSalesChart();
                        break;
                    case 'tables':
                        if (typeof initTableManager === 'function') initTableManager();
                        else console.error("initTableManager non défini");
                        break;
                    case 'personnel':
                         if (typeof initPersonnelManager === 'function') initPersonnelManager();
                         else console.error("initPersonnelManager non défini");
                        break;
                    case 'rapports':
                        initSalesPerformanceChart();
                        initTrendsChart();
                        break;
                    // Ajoutez d'autres cas si nécessaire
                }
            } else {
                section.classList.add('hidden');
            }
        });

        if (!sectionFound) {
            console.warn(`Section avec ID 'section-${sectionId}' non trouvée.`);
            // Optionnel: afficher une section par défaut ou une erreur visuelle
             const defaultSection = document.getElementById('section-reservations'); // Section par défaut
             if (defaultSection) {
                  defaultSection.classList.remove('hidden');
                  currentActiveSection = 'reservations';
                   // Mettre à jour le lien actif dans la sidebar
                   setActiveSidebarLink(currentActiveSection);
              }
        } else {
             // Mettre à jour le lien actif dans la sidebar
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
            // Empêche le comportement par défaut SEULEMENT si c'est un lien de section interne
            const sectionId = this.getAttribute('data-section');
            if (sectionId) {
                 e.preventDefault();
                 showSection(sectionId);
                 // Ferme le menu mobile si ouvert et si on est sur petit écran
                 if (window.innerWidth < 1024 && sidebar && sidebar.classList.contains('translate-x-0')) {
                     sidebar.classList.remove('translate-x-0');
                     sidebar.classList.add('-translate-x-full');
                 }
            }
            // Laisse les autres liens (comme Déconnexion ou liens externes) fonctionner normalement
        });
    });

    // Affiche la section initiale au chargement (défaut: reservations)
    // Pourrait être modifié pour lire l'URL (ex: #tables)
    const initialSection = window.location.hash.substring(1) || 'reservations';
    showSection(initialSection);


    // ----- Logique des Graphiques (Chart.js) -----
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
        // Utilisation des couleurs définies dans la config Tailwind via JS (si possible)
        // ou des valeurs codées en dur comme fallback.
        // Note: Accéder à tailwind.config n'est pas direct ici, il faut soit passer les couleurs
        // soit utiliser les valeurs hex/rgba.
        return {
            primary: isDarkMode ? '#3B82F6' : '#0288D1', // Ajustez si vos couleurs dark sont différentes
            primaryLight: isDarkMode ? 'rgba(59, 130, 246, 0.3)' : 'rgba(2, 136, 209, 0.1)',
            green: isDarkMode ? '#22C55E' : '#4CAF50',
            yellow: isDarkMode ? '#FACC15' : '#FFC107',
            grid: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
            text: isDarkMode ? '#E5E7EB' : '#374151'
        };
    }

    function initSalesChart() {
        const ctx = document.getElementById('sales-chart')?.getContext('2d');
        if (!ctx) { /*console.warn("Canvas 'sales-chart' non trouvé.");*/ return; } // Moins de bruit en console
        salesChartInstance = destroyChart(salesChartInstance);
        const colors = getChartColors();

        salesChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['14h', '16h', '18h', '20h', '22h', 'Actuel'],
                datasets: [{
                    label: 'Ventes (DH)',
                    data: [250.50, 520.00, 800.20, 950.75, 1100.00, 1250.80], // Données exemple
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
                    y: { grid: { color: colors.grid }, ticks: { color: colors.text, callback: value => value + ' DH' }, beginAtZero: true }
                },
                plugins: { legend: { display: false } },
                 interaction: { intersect: false, mode: 'index' }, // Améliore le tooltip
                 tooltip: { callbacks: { label: (context) => `${context.dataset.label}: ${context.parsed.y.toFixed(2)} DH` } }
            }
        });
    }

    function initSalesPerformanceChart() {
        const ctx = document.getElementById('sales-performance-chart')?.getContext('2d');
        if (!ctx) { /*console.warn("Canvas 'sales-performance-chart' non trouvé.");*/ return; }
        salesPerformanceChartInstance = destroyChart(salesPerformanceChartInstance);
        const colors = getChartColors();

        salesPerformanceChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Cette semaine',
                    data: [1200, 1500, 1300, 1700, 2100, 2500, 1800], // Données exemple
                    backgroundColor: colors.primary,
                    borderColor: colors.primary, // Ajout bordure pour cohérence
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 40 // Limite la largeur des barres
                }, {
                    label: 'Semaine précédente',
                    data: [1100, 1400, 1250, 1600, 1900, 2300, 1700], // Données exemple
                    backgroundColor: colors.primaryLight,
                    borderColor: colors.primaryLight, // Ajout bordure
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
                 interaction: { mode: 'index' }, // Tooltip pour les deux barres en même temps
                 tooltip: { callbacks: { label: (context) => `${context.dataset.label}: ${context.parsed.y.toFixed(2)} DH` } }
            }
        });
    }

    function initTrendsChart() {
        const ctx = document.getElementById('trends-chart')?.getContext('2d');
        if (!ctx) { /*console.warn("Canvas 'trends-chart' non trouvé.");*/ return; }
        trendsChartInstance = destroyChart(trendsChartInstance);
        const colors = getChartColors();

        trendsChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'], // Données exemple
                datasets: [{
                    label: 'Clients',
                    data: [1500, 1700, 1600, 1800, 1900, 2000], // Données exemple
                    borderColor: colors.green,
                    backgroundColor: colors.green + '1A', // Légère couleur de fond
                    tension: 0.3, yAxisID: 'yClients',
                    pointBackgroundColor: colors.green, pointBorderColor: '#fff', pointRadius: 4,
                    pointHoverBackgroundColor: '#fff', pointHoverBorderColor: colors.green, pointHoverRadius: 6
                }, {
                    label: 'Ticket moyen (DH)',
                    data: [48.5, 52.1, 51.0, 54.3, 56.8, 58.2], // Données exemple
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
                         grid: { drawOnChartArea: false }, // Ne pas dessiner la grille pour cet axe
                         ticks: { color: colors.text, callback: value => value.toFixed(2) + ' DH' },
                         beginAtZero: false // Le ticket moyen ne commence pas forcément à 0
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

    // ----- Logique Section Tables -----
    // Données exemple (à remplacer par des données dynamiques via Blade/AJAX)
    let tablesData = [
        { id: 1, number: 1, capacity: 4, zone: 'ground', type: 'round', status: 'available', x: 100, y: 150, since: null, server: null },
        { id: 2, number: 2, capacity: 4, zone: 'ground', type: 'round', status: 'occupied', x: 200, y: 150, since: '11:45', server: 'Thomas D.' },
        { id: 3, number: 3, capacity: 4, zone: 'ground', type: 'round', status: 'ordered', x: 300, y: 150, since: '12:15', server: 'Marie S.' },
        { id: 4, number: 4, capacity: 4, zone: 'ground', type: 'round', status: 'payment', x: 400, y: 150, since: '13:05', server: 'Thomas D.' },
        { id: 5, number: 5, capacity: 2, zone: 'ground', type: 'round', status: 'available', x: 100, y: 250, since: null, server: null },
        { id: 6, number: 6, capacity: 2, zone: 'ground', type: 'round', status: 'reserved', x: 200, y: 250, since: '13:30', server: 'Marie S.' },
        { id: 7, number: 7, capacity: 6, zone: 'ground', type: 'rect', status: 'available', x: 350, y: 250, since: null, server: null },
        { id: 8, number: 8, capacity: 8, zone: 'ground', type: 'rect', status: 'occupied', x: 150, y: 350, since: '12:30', server: 'Pierre L.' },
        { id: 9, number: 9, capacity: 2, zone: 'terrace', type: 'round', status: 'available', x: 500, y: 150, since: null, server: null },
        { id: 10, number: 10, capacity: 4, zone: 'terrace', type: 'round', status: 'available', x: 600, y: 150, since: null, server: null },
        { id: 11, number: 11, capacity: 4, zone: 'terrace', type: 'round', status: 'occupied', x: 500, y: 250, since: '12:00', server: 'Sophie R.' },
        { id: 12, number: 12, capacity: 8, zone: 'private', type: 'rect', status: 'reserved', x: 600, y: 350, since: '19:30', server: 'Thomas D.' }
    ];
    let selectedTableId = null;
    let sortableMapInstance = null;
    let isTableManagerInitialized = false; // Pour éviter ré-initialisations multiples

    function initTableManager() {
        if (isTableManagerInitialized) {
            renderTables(); // Re-render suffit si déjà initialisé
            renderTablesList();
            return;
        }

        const tablesContainer = document.getElementById('tables-container');
        const tablesListContainer = document.getElementById('tables-list');
        if (!tablesContainer || !tablesListContainer) {
            console.warn("Conteneurs de tables non trouvés. Initialisation de Table Manager annulée.");
            return;
        }

        console.log("Initialisation Table Manager...");
        renderTables();
        renderTablesList();
        setupTableEventListeners();
        initializeSortableMap();
        isTableManagerInitialized = true;
    }

    function renderTables() {
        const container = document.getElementById('tables-container');
        if (!container) return;
        container.innerHTML = ''; // Vide le conteneur
        const filterElement = document.getElementById('floor-selector');
        const filter = filterElement ? filterElement.value : 'all';
        const isDarkMode = document.documentElement.classList.contains('dark');

        tablesData.forEach(table => {
            if (filter === 'all' || filter === table.zone) {
                const tableElement = createTableElement(table, isDarkMode);
                container.appendChild(tableElement);
            }
        });
        // Réinitialise SortableJS si nécessaire après le rendu
        initializeSortableMap();
    }

     function createTableElement(table, isDarkMode) {
        const tableElement = document.createElement('div');
        tableElement.id = `map-table-${table.id}`; // ID unique pour la carte
        tableElement.className = `table-item absolute cursor-grab active:cursor-grabbing transition-all duration-150 transform hover:scale-105 group`; // group pour hover effets internes
        tableElement.style.left = `${table.x}px`;
        tableElement.style.top = `${table.y}px`;
        tableElement.dataset.id = table.id; // Pour SortableJS et clics

        // Forme et Taille
        let shape, size;
        if (table.type === 'round') { shape = 'rounded-full'; size = table.capacity <= 2 ? 'w-16 h-16' : 'w-20 h-20'; }
        else if (table.type === 'rect') { shape = 'rounded-lg'; size = table.capacity <= 4 ? 'w-24 h-16' : 'w-32 h-20'; }
        else if (table.type === 'booth') { shape = 'rounded-t-lg rounded-b-3xl'; size = 'w-24 h-20'; }
        else { shape = 'rounded-lg'; size = 'w-20 h-20'; } // Fallback

        // Couleurs basées sur le statut et le thème
        let bgColor, borderColor, textColor;
        switch(table.status) {
            case 'available':
                bgColor = 'bg-green-100 dark:bg-green-800 dark:bg-opacity-40'; borderColor = 'border-green-500 dark:border-green-600'; textColor = 'text-green-800 dark:text-green-200'; break;
            case 'occupied':
                bgColor = 'bg-blue-100 dark:bg-blue-800 dark:bg-opacity-40'; borderColor = 'border-blue-500 dark:border-blue-600'; textColor = 'text-blue-800 dark:text-blue-200'; break;
            case 'ordered':
                bgColor = 'bg-amber-100 dark:bg-amber-800 dark:bg-opacity-40'; borderColor = 'border-amber-500 dark:border-amber-600'; textColor = 'text-amber-800 dark:text-amber-200'; break;
            case 'payment':
                bgColor = 'bg-red-100 dark:bg-red-800 dark:bg-opacity-40'; borderColor = 'border-red-500 dark:border-red-600'; textColor = 'text-red-800 dark:text-red-200'; break;
            case 'reserved':
                bgColor = 'bg-purple-100 dark:bg-purple-800 dark:bg-opacity-40'; borderColor = 'border-purple-500 dark:border-purple-600'; textColor = 'text-purple-800 dark:text-purple-200'; break;
            default:
                bgColor = 'bg-gray-200 dark:bg-gray-700'; borderColor = 'border-gray-400 dark:border-gray-500'; textColor = 'text-gray-800 dark:text-gray-200';
        }

        tableElement.className += ` ${size} ${shape} ${bgColor} border-2 ${borderColor} ${textColor} flex flex-col items-center justify-center shadow-md hover:shadow-lg`;

        tableElement.innerHTML = `
            <div class="font-bold text-lg pointer-events-none">T${table.number}</div>
            <div class="text-xs pointer-events-none">${table.capacity} pers.</div>
            ${table.server ? `<div class="text-[10px] mt-0.5 pointer-events-none truncate max-w-[80%]">${table.server}</div>` : ''}
        `;

        // Utilise la délégation d'événements sur le conteneur au lieu d'ajouter un listener à chaque table
        // tableElement.addEventListener('click', handleClickOnTable);

        return tableElement;
    }

    function renderTablesList() {
        const container = document.getElementById('tables-list');
        const searchInput = document.getElementById('table-search');
        const statusFilterSelect = document.getElementById('status-filter');
        if (!container || !searchInput || !statusFilterSelect) return;

        container.innerHTML = ''; // Vide la liste
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilter = statusFilterSelect.value;

        const filteredAndSortedTables = tablesData
            .filter(table =>
                (searchTerm === '' || table.number.toString().includes(searchTerm) || (table.server && table.server.toLowerCase().includes(searchTerm))) &&
                (statusFilter === 'all' || statusFilter === table.status)
            )
            .sort((a, b) => a.number - b.number);

        if (filteredAndSortedTables.length === 0) {
             container.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-gray-500">Aucune table trouvée.</td></tr>`;
             return;
         }

        filteredAndSortedTables.forEach(table => {
            const row = document.createElement('tr');
            // Ajoute un data-id à la ligne pour faciliter la récupération
            row.dataset.id = table.id;
            row.className = 'border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150';

            let statusBadge, zoneText;
             switch(table.status) {
                 case 'available': statusBadge = '<span class="status-badge bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300">Disponible</span>'; break;
                 case 'occupied': statusBadge = '<span class="status-badge bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">Occupée</span>'; break;
                 case 'ordered': statusBadge = '<span class="status-badge bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300">Commande</span>'; break;
                 case 'payment': statusBadge = '<span class="status-badge bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">Paiement</span>'; break;
                 case 'reserved': statusBadge = '<span class="status-badge bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300">Réservée</span>'; break;
                 default: statusBadge = '<span class="status-badge bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">Inconnu</span>';
             }
              // Style commun pour les badges
              statusBadge = statusBadge.replace('class="status-badge', 'class="status-badge inline-block px-2 py-0.5 text-xs font-semibold rounded-full"');

             switch(table.zone) {
                 case 'ground': zoneText = 'RdC'; break; // Abrégé pour la liste
                 case 'terrace': zoneText = 'Terrasse'; break;
                 case 'private': zoneText = 'Privé'; break;
                 default: zoneText = table.zone;
             }

            row.innerHTML = `
                <td class="px-4 py-3 font-medium">T ${table.number}</td>
                <td class="px-4 py-3 text-sm">${table.capacity}</td>
                <td class="px-4 py-3 text-sm">${zoneText}</td>
                <td class="px-4 py-3">${statusBadge}</td>
                <td class="px-4 py-3 text-sm">${table.since || '-'}</td>
                <td class="px-4 py-3 text-sm truncate max-w-[100px]">${table.server || '-'}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-1">
                        <button class="action-button bg-blue-500 hover:bg-blue-600 text-white" title="Modifier" data-action="edit">
                            <i class="fas fa-edit"></i>
                        </button>
                         <button class="action-button bg-yellow-500 hover:bg-yellow-600 text-white ${table.status === 'available' ? 'opacity-50 cursor-not-allowed' : ''}" title="Changer Statut" data-action="status" ${table.status === 'available' ? 'disabled' : ''}>
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button class="action-button bg-green-500 hover:bg-green-600 text-white ${table.status !== 'available' && table.status !== 'reserved' ? 'opacity-50 cursor-not-allowed' : ''}" title="Occuper/Arrivée" data-action="occupy" ${table.status !== 'available' && table.status !== 'reserved' ? 'disabled' : ''}>
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="action-button bg-red-500 hover:bg-red-600 text-white" title="Supprimer" data-action="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
             // Ajout d'une classe commune aux boutons pour le style et la délégation
             row.querySelectorAll('.action-button').forEach(btn => {
                 btn.classList.add('p-1.5', 'text-xs', 'rounded', 'transition-colors', 'duration-150');
                 btn.querySelector('i')?.classList.add('pointer-events-none'); // Empêche l'icône de recevoir le clic
             });
            container.appendChild(row);
        });
    }

    function setupTableEventListeners() {
        // Écouteurs pour les filtres et boutons globaux de la section
        const floorSelector = document.getElementById('floor-selector');
        const tableSearch = document.getElementById('table-search');
        const statusFilter = document.getElementById('status-filter');
        const btnAddTable = document.getElementById('btn-add-table');

        if (floorSelector) floorSelector.addEventListener('change', renderTables);
        if (tableSearch) tableSearch.addEventListener('input', renderTablesList);
        if (statusFilter) statusFilter.addEventListener('change', renderTablesList);
        if (btnAddTable) btnAddTable.addEventListener('click', () => showTableModal());

        // Écouteurs pour les modales (ajout/modif et suppression)
        const tableModal = document.getElementById('table-modal');
        const cancelTableModal = document.getElementById('cancel-table-modal');
        const saveTableBtn = document.getElementById('save-table');
        const deleteTableModal = document.getElementById('delete-table-modal');
        const cancelDeleteTable = document.getElementById('cancel-delete-table');
        const confirmDeleteTableBtn = document.getElementById('confirm-delete-table');

        if (tableModal && cancelTableModal && saveTableBtn) {
            cancelTableModal.addEventListener('click', () => hideModal(tableModal));
            saveTableBtn.addEventListener('click', saveTable);
             // Ferme la modal si on clique en dehors du contenu
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

         // Délégation d'événements pour les actions sur la liste des tables
         const tablesListContainer = document.getElementById('tables-list');
         if (tablesListContainer) {
             tablesListContainer.addEventListener('click', handleTableListAction);
         }

          // Délégation d'événements pour les clics sur les tables du plan
          const tablesMapContainer = document.getElementById('tables-container');
          if (tablesMapContainer) {
              tablesMapContainer.addEventListener('click', handleClickOnTable);
          }
    }

     // Gère les clics sur les boutons de la LISTE des tables
     function handleTableListAction(event) {
        const button = event.target.closest('button.action-button[data-action]');
        if (!button || button.disabled) return;

        const action = button.dataset.action;
        // Trouve l'ID depuis la ligne parente <tr>
        const tableRow = button.closest('tr');
        const id = tableRow ? parseInt(tableRow.dataset.id) : null;

        if (id === null) return;

        switch(action) {
            case 'edit':
                editTable(id);
                break;
            case 'status': // Bouton "Changer Statut"
                 cycleTableStatus(id);
                 break;
            case 'occupy': // Bouton "Occuper/Arrivée" (check vert)
                 occupyTable(id);
                 break;
            case 'delete':
                confirmDeleteTable(id);
                break;
        }
    }

     // Gère les clics sur les tables du PLAN de salle
     function handleClickOnTable(event) {
         const tableElement = event.target.closest('.table-item[data-id]');
         // Ignore les clics pendant un drag (géré par SortableJS) ou si pas sur une table
         if (!tableElement || tableElement.classList.contains('sortable-ghost') || tableElement.classList.contains('sortable-chosen')) return;

         const id = parseInt(tableElement.dataset.id);
         if (isNaN(id)) return;

         // Action simple au clic sur le plan: cycle le statut (ouvre une modal d'actions plus tard)
         // showTableActionsModal(id); // Idéalement, ouvrir une petite modal/menu contextuel
         cycleTableStatus(id); // Pour l'instant, cycle le statut comme sur la liste
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

     // Gère le clic sur le bouton "Occuper/Arrivée" (check vert)
     function occupyTable(id) {
         const tableIndex = findTableIndexById(id);
         if (tableIndex === -1) return;

         const currentStatus = tablesData[tableIndex].status;

         if (currentStatus === 'available' || currentStatus === 'reserved') {
             tablesData[tableIndex].status = 'occupied';
             tablesData[tableIndex].since = getCurrentTime();
             // Potentiellement demander le serveur ici via une petite modal ou assigner par défaut
             if (!tablesData[tableIndex].server) tablesData[tableIndex].server = 'Assigné';
             renderAndUpdate(`Table ${tablesData[tableIndex].number} marquée comme occupée.`);
         } else {
             showNotification(`Cette action n'est possible que pour les tables disponibles ou réservées.`, 'warning');
         }
     }

     // Cycle à travers les statuts possibles (sauf 'available')
     function cycleTableStatus(id) {
         const tableIndex = findTableIndexById(id);
         if (tableIndex === -1) return;

         const currentStatus = tablesData[tableIndex].status;
         if (currentStatus === 'available') {
             showNotification("Utilisez le bouton vert 'Occuper' pour passer une table à 'Occupée'.", "info");
             return;
         }

         const statusOrder = ['occupied', 'ordered', 'payment', 'available']; // Ordre de cycle (revient à 'available' à la fin)
         let currentIndex = statusOrder.indexOf(currentStatus);
         let nextIndex = (currentIndex + 1) % statusOrder.length;
         let nextStatus = statusOrder[nextIndex];

         tablesData[tableIndex].status = nextStatus;
         tablesData[tableIndex].since = getCurrentTime(); // Met à jour l'heure du changement

         let notificationMessage = `Statut de la Table ${tablesData[tableIndex].number} mis à jour : ${nextStatus}.`;

         if (nextStatus === 'available') {
             tablesData[tableIndex].server = null; // Libère le serveur
             tablesData[tableIndex].since = null;
             notificationMessage = `Table ${tablesData[tableIndex].number} libérée.`;
         } else if (!tablesData[tableIndex].server) {
             // Assign un serveur si la table devient occupée et n'en a pas
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
        } else {
             console.error("Impossible d'ouvrir la modal de suppression pour la table ID:", id);
        }
    }

     function handleDeleteTable() {
         if (selectedTableId === null) return;
         const tableIndex = findTableIndexById(selectedTableId);
         if (tableIndex !== -1) {
             const deletedNumber = tablesData[tableIndex].number;
             tablesData.splice(tableIndex, 1); // Supprime du tableau local
             renderAndUpdate(`Table ${deletedNumber} supprimée.`);
             hideModal(document.getElementById('delete-table-modal'));
         } else {
             showNotification(`Erreur lors de la suppression de la table ID ${selectedTableId}.`, 'error');
         }
         selectedTableId = null; // Réinitialise l'ID sélectionné
     }

     // Met à jour l'affichage et affiche une notification
     function renderAndUpdate(notificationMessage = null, notificationType = 'info') {
          renderTables();
          renderTablesList();
          if (notificationMessage) {
               showNotification(notificationMessage, notificationType);
           }
      }

    function showTableModal(table = null) {
        const modal = document.getElementById('table-modal');
        if (!modal) return;

        // Références aux éléments du formulaire
        const title = document.getElementById('table-modal-title');
        const numberInput = document.getElementById('table-number');
        const capacityInput = document.getElementById('table-capacity');
        const zoneSelect = document.getElementById('table-zone');
        const typeSelect = document.getElementById('table-type');
        const xInput = document.getElementById('table-x');
        const yInput = document.getElementById('table-y');

        // Vérifie que tous les éléments existent
        if (!title || !numberInput || !capacityInput || !zoneSelect || !typeSelect || !xInput || !yInput) {
             console.error("Éléments de la modal table manquants.");
             return;
         }

        // Reset form elements
        numberInput.value = ''; capacityInput.value = ''; zoneSelect.value = 'ground';
        typeSelect.value = 'round'; xInput.value = ''; yInput.value = '';

        if (table) { // Mode édition
            title.textContent = `Modifier la table ${table.number}`;
            numberInput.value = table.number;
            capacityInput.value = table.capacity;
            zoneSelect.value = table.zone;
            typeSelect.value = table.type;
            xInput.value = table.x;
            yInput.value = table.y;
            selectedTableId = table.id; // Stocke l'ID pour la sauvegarde
        } else { // Mode ajout
            title.textContent = 'Ajouter une table';
            const maxNumber = tablesData.length > 0 ? Math.max(0, ...tablesData.map(t => t.number)) : 0;
            numberInput.value = maxNumber + 1;
            capacityInput.value = 4; // Capacité par défaut
            selectedTableId = null; // Pas d'ID sélectionné pour l'ajout
        }
        showModal(modal);
    }

    function saveTable() {
        // Récupère les éléments de la modal
        const numberInput = document.getElementById('table-number');
        const capacityInput = document.getElementById('table-capacity');
        const zoneSelect = document.getElementById('table-zone');
        const typeSelect = document.getElementById('table-type');
        const xInput = document.getElementById('table-x');
        const yInput = document.getElementById('table-y');
        const modal = document.getElementById('table-modal');

        // Validation simple
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

        // Vérifie l'unicité du numéro (sauf si on édite la même table)
        const existingTable = tablesData.find(t => t.number === tableNumber && t.id !== selectedTableId);
        if (existingTable) {
            showNotification(`Une table avec le numéro ${tableNumber} existe déjà.`, 'error');
            return;
        }

        // Détermine la position (utilise les inputs ou génère aléatoirement)
         const mapElement = document.getElementById('restaurant-map');
         // Dimensions fallback si mapElement non trouvé ou non rendu
         const mapWidth = mapElement ? mapElement.clientWidth - 100 : 700; // Ajuste pour taille table max
         const mapHeight = mapElement ? mapElement.clientHeight - 100 : 400;
         let x = xInput.value ? parseInt(xInput.value) : Math.max(20, Math.floor(Math.random() * mapWidth));
         let y = yInput.value ? parseInt(yInput.value) : Math.max(20, Math.floor(Math.random() * mapHeight));
         // S'assure que x et y sont des nombres valides
         x = isNaN(x) ? 50 : x;
         y = isNaN(y) ? 50 : y;


        const tableData = {
            number: tableNumber,
            capacity: capacity,
            zone: zoneSelect.value,
            type: typeSelect.value,
            x: x,
            y: y
        };

        if (selectedTableId !== null) { // Mode Modification
            const tableIndex = findTableIndexById(selectedTableId);
            if (tableIndex !== -1) {
                // Fusionne les nouvelles données avec les anciennes (conserve statut, etc.)
                tablesData[tableIndex] = { ...tablesData[tableIndex], ...tableData };
                renderAndUpdate(`Table ${tableNumber} modifiée.`, 'success');
            } else {
                 showNotification(`Erreur: Table ID ${selectedTableId} non trouvée pour modification.`, 'error');
            }
        } else { // Mode Ajout
            const newId = tablesData.length > 0 ? Math.max(0, ...tablesData.map(t => t.id)) + 1 : 1;
            const newTable = {
                ...tableData,
                id: newId,
                status: 'available', // Statut par défaut pour une nouvelle table
                 since: null,
                 server: null
            };
            tablesData.push(newTable);
            renderAndUpdate(`Table ${tableNumber} ajoutée.`, 'success');
        }

        hideModal(modal);
        selectedTableId = null; // Reset après sauvegarde/ajout
    }

     // --- Initialisation SortableJS ---
     function initializeSortableMap() {
         const mapContainer = document.getElementById('tables-container');
         if (mapContainer && typeof Sortable !== 'undefined') {
             // Détruit l'instance précédente pour éviter les doublons
             if (sortableMapInstance) {
                 try { sortableMapInstance.destroy(); } catch(e) {}
             }
             sortableMapInstance = new Sortable(mapContainer, {
                 animation: 150,
                 ghostClass: 'opacity-50',
                 chosenClass: "border-blue-500", // Classe quand on sélectionne
                 dragClass: "opacity-75", // Classe pendant le drag
                 // handle: '.table-item', // Permet de drag depuis toute la table
                 filter: '.pointer-events-none', // Ne pas démarrer le drag sur le texte interne
                 preventOnFilter: false, // Permet au clic de passer même sur éléments filtrés
                 onEnd: function (evt) {
                     const itemEl = evt.item; // L'élément DOM déplacé
                     const tableId = parseInt(itemEl.dataset.id);
                     const tableIndex = findTableIndexById(tableId);

                     if (tableIndex !== -1) {
                         // Lecture de la nouvelle position absolue et calcul relative au conteneur
                         const mapContainer = document.getElementById('tables-container');
                         const mapRect = mapContainer.getBoundingClientRect();
                         const itemRect = itemEl.getBoundingClientRect();

                         // Position relative au coin supérieur gauche du conteneur mapContainer
                         const newX = Math.round(itemRect.left - mapRect.left + mapContainer.scrollLeft);
                         const newY = Math.round(itemRect.top - mapRect.top + mapContainer.scrollTop);


                         if (!isNaN(newX) && !isNaN(newY)) {
                             tablesData[tableIndex].x = newX;
                             tablesData[tableIndex].y = newY;

                             // Mise à jour visuelle (SortableJS le fait, mais on peut forcer si besoin)
                             // itemEl.style.left = `${newX}px`;
                             // itemEl.style.top = `${newY}px`;

                             // Optionnel: Sauvegarder la nouvelle position via AJAX ici
                             console.log(`Table ${tablesData[tableIndex].number} déplacée vers (${newX}, ${newY})`);
                             // Pas besoin de re-render complet ici, juste la liste si elle affiche X/Y
                             showNotification(`Position T${tablesData[tableIndex].number} sauvée (simulation)`, 'info');
                         } else {
                             console.warn("Positions invalides après drag&drop");
                             // Remettre l'élément à sa position initiale si calcul échoue ?
                             itemEl.style.left = `${tablesData[tableIndex].x}px`;
                             itemEl.style.top = `${tablesData[tableIndex].y}px`;
                         }
                     }
                 },
             });
         } else if (mapContainer && typeof Sortable === 'undefined') {
             console.warn("Librairie SortableJS non chargée.");
         }
     }
     // --- Fin Logique Section Tables ---


    // ----- Logique Section Personnel -----
    let isPersonnelManagerInitialized = false;

    function initPersonnelManager() {
        if (isPersonnelManagerInitialized) return; // Évite ré-attachements
        console.log("Initialisation Personnel Manager...");
        setupPersonnelEventListeners();
        isPersonnelManagerInitialized = true;
    }

    function setupPersonnelEventListeners() {
        const sectionPersonnel = document.getElementById('section-personnel');
        if (!sectionPersonnel) return;

        // Références aux Modals spécifiques (si elles ont des ID uniques)
        const deleteEmployeeModal = document.getElementById('delete-modal'); // Assumant ID générique pour l'instant
        const scheduleModal = document.getElementById('schedule-modal');

        // Délégation d'événements pour les actions dans la section
        sectionPersonnel.addEventListener('click', function(event) {
            const target = event.target;
            const deleteButton = target.closest('button[title="Supprimer"]');
            const addShiftButton = target.closest('button.add-shift-button'); // Donner cette classe aux boutons +
             const addEmployeeButton = target.closest('button.add-employee-button'); // Donner cette classe au bouton principal

            if (deleteButton && deleteEmployeeModal) {
                const employeeRow = deleteButton.closest('tr');
                // Récupérer l'ID de l'employé depuis data-id="xxx" sur <tr> ou bouton
                // const employeeId = employeeRow ? employeeRow.dataset.employeeId : null;
                // const employeeName = employeeRow?.querySelector('.font-medium')?.textContent || 'cet employé';
                // deleteEmployeeModal.querySelector('.employee-name-placeholder').textContent = employeeName; // Pour personnaliser modal
                showModal(deleteEmployeeModal);
            } else if (addShiftButton && scheduleModal) {
                // Peut-être pré-remplir la date/heure/employé basé sur où on a cliqué
                showModal(scheduleModal);
            } else if (addEmployeeButton) {
                 // Logique pour ouvrir une modal d'ajout d'employé (à créer)
                 showNotification("Fonctionnalité 'Ajouter Employé' non implémentée.", "info");
             }
        });

        // Gestion des modals (fermeture et confirmation)
        const cancelDelete = document.getElementById('cancel-delete'); // Pour la modal générique
        const confirmDelete = document.getElementById('confirm-delete'); // Pour la modal générique
        const cancelSchedule = document.getElementById('cancel-schedule');
        const saveSchedule = document.getElementById('save-schedule');

        if (deleteEmployeeModal && cancelDelete && confirmDelete) {
            cancelDelete.addEventListener('click', () => hideModal(deleteEmployeeModal));
            confirmDelete.addEventListener('click', () => {
                // *** AJOUTER LOGIQUE DE SUPPRESSION REELLE (AJAX) ***
                showNotification("Employé supprimé (simulation).", 'success');
                hideModal(deleteEmployeeModal);
                // Mettre à jour la liste du personnel ici après suppression
            });
            // Fermeture en cliquant en dehors
            deleteEmployeeModal.addEventListener('click', (e) => { if (e.target === deleteEmployeeModal) hideModal(deleteEmployeeModal); });
        }

        if (scheduleModal && cancelSchedule && saveSchedule) {
            cancelSchedule.addEventListener('click', () => hideModal(scheduleModal));
            saveSchedule.addEventListener('click', () => {
                // *** AJOUTER LOGIQUE DE SAUVEGARDE REELLE (AJAX) ***
                showNotification("Créneau horaire ajouté (simulation).", 'success');
                hideModal(scheduleModal);
                // Mettre à jour le tableau de planning ici
            });
            // Fermeture en cliquant en dehors
            scheduleModal.addEventListener('click', (e) => { if (e.target === scheduleModal) hideModal(scheduleModal); });
        }

        // Gestion des changements de rôle (Select dans la liste)
        // Ajouter class="employee-role-select" aux <select> de la liste des employés
        sectionPersonnel.querySelectorAll('select.employee-role-select').forEach(select => {
            select.addEventListener('change', function() {
                const selectedRole = this.options[this.selectedIndex].text;
                const employeeRow = this.closest('tr');
                // const employeeId = employeeRow ? employeeRow.dataset.employeeId : null;
                // *** AJOUTER LOGIQUE DE MISE A JOUR REELLE (AJAX) ***
                showNotification(`Rôle mis à jour vers ${selectedRole} (simulation).`, 'info');
            });
        });

         // Gestion des filtres (recherche, rôle) - si présents
         const searchInput = sectionPersonnel.querySelector('input[type="text"][placeholder="Rechercher..."]');
         const roleFilterSelect = sectionPersonnel.querySelector('select:not(.employee-role-select)'); // Le select de filtre global
         if (searchInput) searchInput.addEventListener('input', () => { /* Logique de filtrage */ console.log("Recherche:", searchInput.value); });
         if (roleFilterSelect) roleFilterSelect.addEventListener('change', () => { /* Logique de filtrage */ console.log("Filtre rôle:", roleFilterSelect.value); });

    }
    // --- Fin Logique Section Personnel ---

    // Gestion des réservations
    const restaurantSelector = document.getElementById('header-restaurant-selector');
    const reservationsTableBody = document.getElementById('reservations-table-body');
    const loadingIndicator = document.getElementById('loading-indicator');
    const dateFilter = document.getElementById('reservation-date-filter');
    
    let selectedRestaurantId = null;
    let currentReservations = [];
    
    // Fonction pour charger les réservations
    function loadReservations() {
        if (!selectedRestaurantId) return;
        
        // Afficher l'indicateur de chargement
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        
        // Vider le tableau
        if (reservationsTableBody) {
            reservationsTableBody.innerHTML = '';
        }
        
        // Récupérer les réservations via AJAX
        fetch(`/gerant/get-reservations?restaurant_id=${selectedRestaurantId}`)
            .then(response => response.json())
            .then(data => {
                if (loadingIndicator) loadingIndicator.classList.add('hidden');
                
                currentReservations = data.reservations || [];
                
                // Filtrer les réservations selon la date
                const filteredReservations = filterReservationsByDate(currentReservations);
                
                // Afficher les réservations
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
    
    // Fonction pour filtrer les réservations selon la date
    function filterReservationsByDate(reservations) {
        const filterValue = dateFilter ? dateFilter.value : 'all';
        const today = new Date().toISOString().split('T')[0];
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const tomorrowStr = tomorrow.toISOString().split('T')[0];
        
        // Calculer la date de fin de semaine
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
                    return true; // 'all' - afficher toutes les réservations
            }
        });
    }
    
    // Fonction pour afficher les réservations dans le tableau
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
            // Déterminer la classe CSS pour le statut
            let statusClass = '';
            switch (reservation.statut) {
                case 'Confirmé':
                    statusClass = 'bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300';
                    break;
                case 'Refusé':
                    statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300';
                    break;
                default: // 'En attente'
                    statusClass = 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-300';
                    break;
            }
            
            // Formater la date pour l'affichage (DD/MM/YYYY)
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
        
        // Ajouter les événements pour les boutons d'action
        attachActionButtonEvents();
    }
    
    // Fonction pour attacher les événements aux boutons d'action
    function attachActionButtonEvents() {
        // Boutons de confirmation
        document.querySelectorAll('.confirm-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const reservationId = row.dataset.id;
                updateReservationStatus(reservationId, 'Confirmé');
            });
        });
        
        // Boutons de refus
        document.querySelectorAll('.refuse-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const reservationId = row.dataset.id;
                updateReservationStatus(reservationId, 'Refusé');
            });
        });
        
        // Boutons d'arrivée
        document.querySelectorAll('.arrived-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const reservationId = row.dataset.id;
                // Ici, on pourrait implémenter une logique pour marquer le client comme arrivé
                // Pour l'instant, on affiche juste une alerte
                alert('Le client est arrivé pour sa réservation.');
                
                // Vous pourriez ajouter un nouvel endpoint et une fonction pour gérer cela
                // updateReservationArrival(reservationId);
            });
        });
    }
    
    // Fonction pour mettre à jour le statut d'une réservation
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
                // Mettre à jour la réservation dans le tableau currentReservations
                const index = currentReservations.findIndex(r => r.id == id);
                if (index !== -1) {
                    currentReservations[index] = data.reservation;
                    
                    // Réafficher les réservations avec le filtre actuel
                    const filteredReservations = filterReservationsByDate(currentReservations);
                    displayReservations(filteredReservations);
                }
                
                // Afficher un message de succès
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
    
    // Fonction pour afficher une notification
    function showNotification(message, type = 'info') {
        const notificationDiv = document.createElement('div');
        notificationDiv.className = `fixed top-4 right-4 p-4 rounded shadow-lg transition-opacity z-50 ${
            type === 'success' ? 'bg-green-100 text-green-700 border-l-4 border-green-500' :
            type === 'error' ? 'bg-red-100 text-red-700 border-l-4 border-red-500' :
            'bg-blue-100 text-blue-700 border-l-4 border-blue-500'
        }`;
        
        notificationDiv.innerHTML = message;
        document.body.appendChild(notificationDiv);
        
        // Faire disparaître la notification après 3 secondes
        setTimeout(() => {
            notificationDiv.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notificationDiv);
            }, 300);
        }, 3000);
    }
    
    // Gestionnaire d'événement pour le sélecteur de restaurant
    if (restaurantSelector) {
        restaurantSelector.addEventListener('change', function() {
            selectedRestaurantId = this.value;
            if (selectedRestaurantId) {
                loadReservations();
            } else {
                // Réinitialiser le tableau si aucun restaurant n'est sélectionné
                if (reservationsTableBody) {
                    reservationsTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <p>Sélectionnez un restaurant pour voir les réservations.</p>
                            </td>
                        </tr>
                    `;
                }
            }
        });
    }
    
    // Gestionnaire d'événement pour le filtre de date
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            const filteredReservations = filterReservationsByDate(currentReservations);
            displayReservations(filteredReservations);
        });
    }
    
    // Charger les réservations au chargement de la page si un restaurant est déjà sélectionné
    if (restaurantSelector && restaurantSelector.value) {
        selectedRestaurantId = restaurantSelector.value;
        loadReservations();
    }
});