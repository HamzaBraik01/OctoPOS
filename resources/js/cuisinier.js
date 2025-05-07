// resources/js/cuisinier.js

document.addEventListener('DOMContentLoaded', function() {
    let currentActiveSection = null;
    const restaurantSelect = document.getElementById('restaurant-select');
    if (restaurantSelect) {
        restaurantSelect.addEventListener('change', function() {
            if (this.value) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/cuisinier/select-restaurant';
                form.style.display = 'none';

                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                // Add restaurant ID
                const restaurantInput = document.createElement('input');
                restaurantInput.type = 'hidden';
                restaurantInput.name = 'restaurant_id';
                restaurantInput.value = this.value;
                form.appendChild(restaurantInput);

                // Submit the form
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Fonction pour afficher des notifications
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

    // Gestion du basculement de la barre latérale
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.getElementById('main-content');

    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', () => {
            const isCollapsed = sidebar.classList.toggle('w-[70px]');
            sidebar.classList.toggle('w-64', !isCollapsed);

            mainContent.classList.toggle('ml-[70px]', isCollapsed);
            mainContent.classList.toggle('ml-64', !isCollapsed);

            document.querySelectorAll('.sidebar p, .sidebar span:not(.icon)').forEach(el => 
                el.classList.toggle('hidden', isCollapsed)
            );
        });
    }

    // Gestion du thème sombre/clair
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        // Définir le thème initial basé sur les préférences locales ou du système
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const initialTheme = savedTheme || (prefersDark ? 'dark' : 'light');
        
        if (initialTheme === 'dark') {
            document.documentElement.classList.add('dark');
            document.querySelector('.mode-light')?.classList.add('hidden');
            document.querySelector('.mode-dark')?.classList.remove('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            document.querySelector('.mode-light')?.classList.remove('hidden');
            document.querySelector('.mode-dark')?.classList.add('hidden');
        }

        // Écouteur d'événement pour le changement de thème
        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            // Mettre à jour les icônes
            if (isDark) {
                document.querySelector('.mode-light')?.classList.add('hidden');
                document.querySelector('.mode-dark')?.classList.remove('hidden');
            } else {
                document.querySelector('.mode-light')?.classList.remove('hidden');
                document.querySelector('.mode-dark')?.classList.add('hidden');
            }
        });
    }

    // Gestion du menu utilisateur
    const userMenuToggle = document.querySelector('.user-menu-toggle');
    const userMenu = document.querySelector('.user-menu');
    if (userMenuToggle && userMenu) {
        userMenuToggle.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Fermer le menu quand on clique ailleurs
        document.addEventListener('click', (e) => {
            if (!userMenuToggle.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }

    // Gestion des notifications
    const notificationBell = document.querySelector('.notification-bell');
    const notificationDropdown = document.querySelector('.notification-dropdown');
    if (notificationBell && notificationDropdown) {
        notificationBell.addEventListener('click', () => {
            notificationDropdown.classList.toggle('hidden');
        });

        // Fermer les notifications quand on clique ailleurs
        document.addEventListener('click', (e) => {
            if (!notificationBell.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });
    }

    // Navigation entre les sections
    const sectionLinks = document.querySelectorAll('[data-section]');
    const sections = document.querySelectorAll('.dashboard-section');

    function showSection(sectionId) {
        sections.forEach(section => {
            if (section.id === `section-${sectionId}`) {
                section.classList.add('active');
                currentActiveSection = sectionId;
            } else {
                section.classList.remove('active');
            }
        });

        // Mettre à jour la classe active dans la barre latérale
        sectionLinks.forEach(link => {
            if (link.dataset.section === sectionId) {
                link.classList.add('text-primary', 'bg-primary-light');
                link.classList.remove('text-gray-700', 'dark:text-gray-300');
            } else {
                link.classList.remove('text-primary', 'bg-primary-light');
                link.classList.add('text-gray-700', 'dark:text-gray-300');
            }
        });
    }

    sectionLinks.forEach(link => {
        link.addEventListener('click', () => {
            const sectionId = link.dataset.section;
            if (sectionId) {
                showSection(sectionId);
            }
        });
    });

    // Afficher la section initiale (commandes par défaut)
    const initialSection = window.location.hash.substring(1) || 'commandes';
    showSection(initialSection);

    // Simulation du rechargement des commandes
    const refreshButtons = document.querySelectorAll('.refresh-commandes, .refresh-preparation, .refresh-historique, .refresh-stock');
    refreshButtons.forEach(button => {
        button.addEventListener('click', function() {
            const section = this.classList.contains('refresh-commandes') ? 'commandes' : 
                            this.classList.contains('refresh-preparation') ? 'préparation' :
                            this.classList.contains('refresh-historique') ? 'historique' : 'stock';
            
            showNotification(`Actualisation des ${section} en cours...`, 'info');
            
            // Simuler un chargement
            setTimeout(() => {
                showNotification(`Les données des ${section} ont été actualisées`, 'success');
            }, 1000);
        });
    });

    // Gestion des boutons dans les commandes
    document.addEventListener('click', function(e) {
        // Commencer la préparation d'une commande
        if (e.target.classList.contains('start-preparation')) {
            const card = e.target.closest('.commande-card');
            if (card) {
                showNotification('Commande mise en préparation', 'success');
                card.style.display = 'none';
            }
        }
        
        // Marquer une commande comme prête
        if (e.target.classList.contains('mark-ready')) {
            const card = e.target.closest('.preparation-card');
            if (card) {
                showNotification('Plat marqué comme prêt à servir', 'success');
                card.style.display = 'none';
            }
        }
        
        // Signaler un problème
        if (e.target.classList.contains('report-issue')) {
            showNotification('Problème signalé au gérant', 'warning');
        }
        
        // Voir les détails
        if (e.target.classList.contains('view-details')) {
            showNotification('Fonctionnalité de détails en développement', 'info');
        }
    });

    // Gestion de la recherche dans les allergies
    const allergieSearch = document.querySelector('#section-allergies .search-box input');
    if (allergieSearch) {
        allergieSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const allergyItems = document.querySelectorAll('.allergie-items li');
            
            allergyItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm) || searchTerm === '') {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Gestion du filtre de date pour l'historique
    const datePicker = document.querySelector('.date-picker');
    if (datePicker) {
        datePicker.addEventListener('change', function() {
            showNotification(`Filtrage par date: ${this.value}`, 'info');
        });
    }

    // Gestion de la recherche des ingrédients
    const stockSearch = document.querySelector('#section-stock .search-box input');
    if (stockSearch) {
        stockSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const stockItems = document.querySelectorAll('.stock-item');
            
            stockItems.forEach(item => {
                const text = item.querySelector('.stock-name').textContent.toLowerCase();
                if (text.includes(searchTerm) || searchTerm === '') {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Gestion des boutons du stock
    const stockButtons = document.querySelectorAll('.stock-actions button');
    stockButtons.forEach(button => {
        button.addEventListener('click', function() {
            const text = this.textContent.trim();
            showNotification(`Action "${text}" en développement`, 'info');
        });
    });

    // Gestion des boutons de commande dans les alertes de stock
    const orderButtons = document.querySelectorAll('.alert-item button');
    orderButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemName = this.closest('.alert-item').querySelector('.alert-text').textContent.split('-')[0].trim();
            showNotification(`Commande de ${itemName} enregistrée`, 'success');
        });
    });
});