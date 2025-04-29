// resources/js/gerant.js

document.addEventListener('DOMContentLoaded', function() {
    // Date et heure actuelles du serveur (peut être passée dynamiquement par Blade si nécessaire)
    const currentDateTimeFromServer = "2025-04-29 07:07:34";
    const currentUserFromServer = "HamzaBr01"; // Exemple

    // Mise à jour de l'affichage du temps en temps réel
    const dateTimeEl = document.getElementById('current-date-time');
    if (dateTimeEl) {
        // Initial display with server time is good, but live update should use client time
        // Or better, get server time offset and calculate continuously
        dateTimeEl.textContent = currentDateTimeFromServer; // Initial display
        updateTime(); // Start client-side clock
        setInterval(updateTime, 1000);
    }

    function updateTime() {
        const date = new Date();
        // Formatage simple, ajustez selon vos besoins (ex: toLocaleString)
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const day = date.getDate().toString().padStart(2, '0');
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        const seconds = date.getSeconds().toString().padStart(2, '0');
        const formattedTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        if (dateTimeEl) { // Check again inside interval
            dateTimeEl.textContent = formattedTime;
        }
    }

    // Fonctionnalité de bascule de la barre latérale
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const header = document.getElementById('header');

    if (sidebarToggle && sidebar && mainContent && header) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('sidebar-collapsed');
            header.classList.toggle('sidebar-collapsed');

            // Changer l'icône de bascule
            const icon = sidebarToggle.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
                // Cacher le texte dans la sidebar réduite (CSS le fait déjà via media query, mais peut être forcé ici si besoin)
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
                // Afficher le texte
            }

            // Redessiner les graphiques si nécessaire après le redimensionnement
            window.dispatchEvent(new Event('resize'));
        });
    }

    // Bascule du menu mobile
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');

    if (mobileMenuToggle && sidebar) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
        });
        // Optionnel: fermer la sidebar si on clique en dehors
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target) && sidebar.classList.contains('mobile-open')) {
               sidebar.classList.remove('mobile-open');
            }
        });
    }


    // Bascule du thème
    const themeToggle = document.getElementById('theme-toggle');
    const docElement = document.documentElement; // Cible <html>

    function applyTheme(theme) {
        docElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
         // Informer Chart.js du changement de thème si nécessaire
        if (window.activeCharts) {
            Object.values(window.activeCharts).forEach(chart => {
                // Mettez à jour les options de couleur du graphique ici si elles dépendent du thème
                // Exemple simple : chart.options.scales.y.ticks.color = (theme === 'dark' ? 'white' : 'black');
                chart.update();
            });
        }
         // Informer FullCalendar
        if (window.globalCalendar) {
             // Vous pourriez avoir besoin de recharger les événements ou de mettre à jour les options
             // window.globalCalendar.setOption('...', ...);
        }
    }

    if (themeToggle) {
        // Définir le thème initial
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const initialTheme = savedTheme || (prefersDark ? 'dark' : 'light');
        applyTheme(initialTheme);

        themeToggle.addEventListener('click', function() {
            const currentTheme = docElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyTheme(newTheme);
        });
    }

    // Bascule du mode crise
    const crisisToggleButton = document.getElementById('crisis-toggle-button');
    // const crisisBanner = document.getElementById('crisis-banner'); // Assurez-vous que cet ID existe ou ajustez
    const headerEl = document.getElementById('header'); // Renommé pour éviter conflit
    // const alertSpeakButton = document.getElementById('alert-speak-button'); // Assurez-vous que cet ID existe ou ajustez

    if (crisisToggleButton && headerEl) { // Removed banner/speak checks as they weren't in original html
        crisisToggleButton.addEventListener('click', function() {
            const isActive = this.classList.toggle('active');
            headerEl.classList.toggle('crisis-mode', isActive); // Use second arg for toggle
            document.body.classList.toggle('crisis-active', isActive); // Peut-être utile pour styler d'autres éléments

            // Si le mode crise est activé, déclencher l'alerte vocale
            if (isActive && 'speechSynthesis' in window) {
                // speakAlert(); // Décommentez si la fonction speakAlert est définie et nécessaire
                 console.log("Mode crise activé");
            } else {
                 console.log("Mode crise désactivé");
            }
        });
    }

    // Synthèse vocale pour les alertes (Exemple, adaptez si nécessaire)
    /*
    function speakAlert() {
        if ('speechSynthesis' in window) {
            const alertMessage = "Attention. Mode crise activé. Vérifiez les alertes."; // Message simplifié
            const utterance = new SpeechSynthesisUtterance(alertMessage);
            utterance.lang = 'fr-FR';
            utterance.volume = 1;
            utterance.rate = 1;
            utterance.pitch = 1;
            window.speechSynthesis.speak(utterance);
        } else {
            console.warn("Speech Synthesis non supporté par ce navigateur.");
        }
    }

    // Décommentez si vous avez un bouton spécifique pour parler
    // if (alertSpeakButton && 'speechSynthesis' in window) {
    //     alertSpeakButton.addEventListener('click', function() {
    //         speakAlert();
    //     });
    // }
    */

    // Initialisation du calendrier RH
    const calendarEl = document.getElementById('hr-calendar');
    window.globalCalendar = null; // Pour référence globale si nécessaire (ex: thème)

    if (calendarEl && typeof FullCalendar !== 'undefined') {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek' // Gardé, mais pourrait être simplifié
            },
            locale: 'fr',
            height: 'auto', // ou une hauteur fixe si 'auto' pose problème
            // aspectRatio: 1.5, // Alternative à height
            events: [ // Données statiques, à remplacer par une source dynamique (AJAX)
                { title: 'Congé - Thomas', start: '2025-04-15', end: '2025-04-22', backgroundColor: '#3B82F6', borderColor: '#3B82F6' },
                { title: 'Formation - Pierre', start: '2025-04-10', end: '2025-04-12', backgroundColor: '#10B981', borderColor: '#10B981' },
                { title: 'Congé - Marie', start: '2025-04-25', end: '2025-04-28', backgroundColor: '#8B5CF6', borderColor: '#8B5CF6' },
                { title: 'Maladie - Sophie', start: '2025-04-29', backgroundColor: '#EF4444', borderColor: '#EF4444' }
            ],
            // eventColor: 'var(--primary)', // Utiliser les variables CSS si possible
            // eventTextColor: 'white',
            // Vous pouvez ajouter plus d'options ici (ex: dateClick, eventClick)
        });

        // Attendre un petit délai pour le rendu initial correct, surtout si dans un conteneur caché
        setTimeout(() => {
             calendar.render();
             window.globalCalendar = calendar; // Stocker la référence
        }, 100); // Ajustez si nécessaire

         // Si le calendrier est dans une section initialement cachée, le rendre lors de l'affichage
         const personnelSection = document.getElementById('section-personnel');
         if (personnelSection) {
             const observer = new MutationObserver(mutations => {
                 mutations.forEach(mutation => {
                     if (mutation.attributeName === 'class' && !personnelSection.classList.contains('hidden')) {
                         calendar.render(); // Ou calendar.updateSize(); si déjà rendu
                         observer.disconnect(); // Ne l'observer qu'une fois
                     }
                 });
             });
             observer.observe(personnelSection, { attributes: true });
         }


    } else if (calendarEl) {
        console.error("FullCalendar n'est pas chargé ou l'élément #hr-calendar est introuvable.");
    }


    // Gestion de la navigation entre les sections
    const sidebarLinks = document.querySelectorAll('.sidebar-link[data-section]');
    const sections = document.querySelectorAll('.section-content');
    window.activeCharts = {}; // Stocker les instances de graphiques actifs

    function showSection(sectionId) {
        let sectionFound = false;
        sections.forEach(section => {
            if (section.id === `section-${sectionId}`) {
                section.classList.remove('hidden');
                sectionFound = true;
                // Initialiser les composants spécifiques à la section si nécessaire et pas déjà fait
                 initializeSectionComponents(sectionId);
            } else {
                section.classList.add('hidden');
            }
        });

        if (!sectionFound) {
            console.warn(`Section non trouvée : ${sectionId}`);
            // Afficher une section par défaut si la cible n'existe pas ?
             // sections[0]?.classList.remove('hidden'); // Affiche la première section
             // initializeSectionComponents(sections[0]?.id.replace('section-',''));
        }

        // Mettre à jour le lien actif dans la sidebar
        sidebarLinks.forEach(link => {
            link.classList.toggle('active', link.getAttribute('data-section') === sectionId);
        });

         // Fermer la sidebar mobile si ouverte
        if (sidebar && sidebar.classList.contains('mobile-open')) {
            sidebar.classList.remove('mobile-open');
        }
    }

     function initializeSectionComponents(sectionId) {
        // Utiliser un drapeau pour éviter réinitialisations multiples
        const sectionElement = document.getElementById(`section-${sectionId}`);
        if (!sectionElement || sectionElement.dataset.initialized === 'true') {
            return;
        }

        console.log(`Initialisation des composants pour : ${sectionId}`);

        if (sectionId === 'caisse' && typeof Chart !== 'undefined') {
            const canvas = document.getElementById('sales-chart');
            if (canvas && !window.activeCharts['salesChart']) {
                initSalesChart(canvas);
            }
        } else if (sectionId === 'rapports' && typeof Chart !== 'undefined') {
            const perfCanvas = document.getElementById('sales-performance-chart');
            const trendsCanvas = document.getElementById('trends-chart');
            if (perfCanvas && !window.activeCharts['salesPerformanceChart']) {
                initSalesPerformanceChart(perfCanvas);
            }
            if (trendsCanvas && !window.activeCharts['trendsChart']) {
                initTrendsChart(trendsCanvas);
            }
        } else if (sectionId === 'personnel') {
            // Si le calendrier n'a pas été rendu car caché initialement
            if (window.globalCalendar) {
                // Tenter de redessiner/mettre à jour la taille
                 window.globalCalendar.updateSize();
            }
            // Initialiser SortableJS si besoin (non présent dans l'HTML fourni mais mentionné)
            // initSortableLists();
        }
        // Ajouter d'autres initialisations spécifiques ici (SortableJS, etc.)

        sectionElement.dataset.initialized = 'true'; // Marquer comme initialisé
    }


    // Afficher la section initiale (peut être déterminée par l'URL ou une valeur par défaut)
    // Lire depuis l'URL hash ou définir une valeur par défaut
    const initialSection = window.location.hash ? window.location.hash.substring(1) : 'reservations'; // Défaut: réservations
    showSection(initialSection);

    // Gérer les clics sur les liens de la sidebar
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            showSection(sectionId);
            // Mettre à jour l'URL hash pour la persistance et le partage de lien
            window.location.hash = sectionId;
        });
    });

    // Gérer le changement de hash (ex: boutons précédent/suivant du navigateur)
     window.addEventListener('hashchange', () => {
        const hashSection = window.location.hash.substring(1);
        if (hashSection) {
            showSection(hashSection);
        } else {
             // Si le hash est vide, revenir à la section par défaut
             showSection('reservations');
        }
    });


    // Initialisation des graphiques (fonctions appelées par initializeSectionComponents)
    function initSalesChart(canvas) {
        const ctx = canvas.getContext('2d');
        window.activeCharts['salesChart'] = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['14h', '16h', '18h', '20h', '22h', 'Actuel'],
                datasets: [{
                    label: 'Ventes (€)',
                    data: [250, 520, 800, 950, 1100, 1250.80], // Données statiques
                    borderColor: 'var(--primary)', // Utiliser var CSS
                    backgroundColor: 'rgba(var(--primary-rgb), 0.1)', // Utiliser var CSS
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                // Adaptez les couleurs des axes/légendes au thème si nécessaire
                 scales: {
                    y: { ticks: { color: 'var(--text-secondary)' }, grid: { color: 'var(--border-color)' } },
                    x: { ticks: { color: 'var(--text-secondary)' }, grid: { display: false } }
                },
                plugins: { legend: { labels: { color: 'var(--text-primary)' } } }
            }
        });
    }

    function initSalesPerformanceChart(canvas) {
        const ctx = canvas.getContext('2d');
        window.activeCharts['salesPerformanceChart'] = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Cette semaine',
                    data: [1200, 1500, 1300, 1700, 2100, 2500, 1800], // Données statiques
                    backgroundColor: 'var(--primary)'
                }, {
                    label: 'Semaine précédente',
                    data: [1100, 1400, 1250, 1600, 1900, 2300, 1700], // Données statiques
                    backgroundColor: 'rgba(var(--primary-rgb), 0.3)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                 scales: {
                    y: { ticks: { color: 'var(--text-secondary)' }, grid: { color: 'var(--border-color)' } },
                    x: { ticks: { color: 'var(--text-secondary)' }, grid: { display: false } }
                },
                plugins: { legend: { labels: { color: 'var(--text-primary)' } } }
            }
        });
    }

    function initTrendsChart(canvas) {
        const ctx = canvas.getContext('2d');
        window.activeCharts['trendsChart'] = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'], // Données statiques
                datasets: [{
                    label: 'Clients',
                    data: [1500, 1700, 1600, 1800, 1900, 2000], // Données statiques
                    borderColor: 'var(--success)',
                    tension: 0.3,
                    yAxisID: 'y'
                }, {
                    label: 'Ticket moyen (€)',
                    data: [48, 52, 51, 54, 56, 58], // Données statiques
                    borderColor: 'var(--warning)',
                    tension: 0.3,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        position: 'left',
                        title: { display: true, text: 'Nombre de clients', color: 'var(--text-primary)' },
                        ticks: { color: 'var(--text-secondary)' },
                        grid: { color: 'var(--border-color)' }
                    },
                    y1: {
                        position: 'right',
                        title: { display: true, text: 'Ticket moyen (€)', color: 'var(--text-primary)' },
                        ticks: { color: 'var(--text-secondary)' },
                        grid: { drawOnChartArea: false } // Ne pas dessiner la grille pour l'axe Y1
                    },
                     x: { ticks: { color: 'var(--text-secondary)' }, grid: { display: false } }
                },
                plugins: { legend: { labels: { color: 'var(--text-primary)' } } }
            }
        });
    }

    // Fonction utilitaire pour afficher une notification (peut être améliorée)
    function showNotification(message, type = 'info') { // type peut être 'info', 'success', 'warning', 'danger'
        const notification = document.createElement('div');
        // Utilisez les variables CSS pour les couleurs de fond selon le type
        let bgColorVar = '--info';
        if (type === 'success') bgColorVar = '--success';
        if (type === 'warning') bgColorVar = '--warning';
        if (type === 'danger') bgColorVar = '--danger';

        notification.style.position = 'fixed';
        notification.style.bottom = '1rem';
        notification.style.right = '1rem';
        notification.style.padding = '1rem 1.5rem';
        notification.style.borderRadius = '0.5rem';
        notification.style.backgroundColor = `var(${bgColorVar})`;
        notification.style.color = 'white'; // Assumer un texte blanc pour la plupart des fonds
        notification.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
        notification.style.zIndex = '1000';
        notification.style.opacity = '1';
        notification.style.transition = 'opacity 0.5s ease-out';
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500); // Laisser le temps à la transition de se terminer
        }, 3000); // Durée d'affichage de la notification
    }

    // Exemple d'utilisation (vous pouvez l'appeler depuis d'autres parties de votre code)
    // showNotification('Bienvenue sur le tableau de bord !');
    // showNotification('Opération réussie.', 'success');
    // showNotification('Attention, stock faible.', 'warning');
    // showNotification('Erreur critique.', 'danger');

});