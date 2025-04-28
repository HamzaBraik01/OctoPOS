document.addEventListener('DOMContentLoaded', function() {
    const currentDateTime = "2025-04-10 08:33:51";
    const currentUser = "HamzaBr01";
    const dateTimeEl = document.getElementById('current-date-time');
    if (dateTimeEl) {
        updateTime();
        setInterval(updateTime, 1000);
    }
    
    // Restaurant selector functionality
    const restaurantSelector = document.getElementById('restaurant-selector');
    if (restaurantSelector) {
        // Check if there's a saved restaurant selection in localStorage
        const savedRestaurantId = localStorage.getItem('selectedRestaurantId');
        if (savedRestaurantId) {
            restaurantSelector.value = savedRestaurantId;
        }
        
        // Add event listener for restaurant change
        restaurantSelector.addEventListener('change', function() {
            // Save selection to localStorage
            localStorage.setItem('selectedRestaurantId', this.value);
            
            // You could reload data or make an AJAX call here to update the dashboard
            showNotification(`Restaurant sélectionné: ${this.options[this.selectedIndex].text}`);
            
            // Optional: Reload the page to refresh data for the selected restaurant
            // window.location.reload();
        });
    }
    
    function updateTime() {
        const date = new Date();
        const formattedTime = date.toISOString().replace('T', ' ').substring(0, 19);
        dateTimeEl.textContent = formattedTime;
    }
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const header = document.getElementById('header');
    
    if (sidebarToggle && sidebar && mainContent && header) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('sidebar-collapsed');
            header.classList.toggle('sidebar-collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
            }
        });
    }

    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    
    if (mobileMenuToggle && sidebar) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
        });
    }

    const themeToggle = document.getElementById('theme-toggle');
    
    if (themeToggle) {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
        
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
    
    const crisisToggle = document.getElementById('crisis-toggle-button');
    const crisisBanner = document.getElementById('crisis-banner');
    const header_el = document.getElementById('header');
    const alertSpeakButton = document.getElementById('alert-speak-button');
    
    if (crisisToggle && crisisBanner && header_el) {
        crisisToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            crisisBanner.classList.toggle('hidden');
            header_el.classList.toggle('crisis-mode');
            
            if (this.classList.contains('active') && 'speechSynthesis' in window) {
                speakAlert();
            }
        });
    }

    if (alertSpeakButton && 'speechSynthesis' in window) {
        alertSpeakButton.addEventListener('click', function() {
            speakAlert();
        });
    }
    
    function speakAlert() {
        const alertMessage = "Attention. Mode crise activé. Cinq alertes urgentes en attente. Gestion prioritaire des ressources et du personnel requise.";
        const utterance = new SpeechSynthesisUtterance(alertMessage);
        utterance.lang = 'fr-FR';
        utterance.volume = 1;
        utterance.rate = 1;
        utterance.pitch = 1;
        
        window.speechSynthesis.speak(utterance);
    }
  
    const calendarEl = document.getElementById('hr-calendar');
    
    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            locale: 'fr',
            height: 'auto',
            events: [
                {
                    title: 'Congé - Thomas',
                    start: '2025-04-15',
                    end: '2025-04-22',
                    backgroundColor: '#3B82F6'
                },
                {
                    title: 'Formation - Pierre',
                    start: '2025-04-10',
                    end: '2025-04-12',
                    backgroundColor: '#10B981'
                },
                {
                    title: 'Congé - Marie',
                    start: '2025-04-25',
                    end: '2025-04-28',
                    backgroundColor: '#8B5CF6'
                },
                {
                    title: 'Maladie - Sophie',
                    start: '2025-04-10',
                    backgroundColor: '#EF4444'
                }
            ]
        });
        
        calendar.render();
    }
 
    const morningShift = document.getElementById('morning-shift');
    const afternoonShift = document.getElementById('afternoon-shift');
    const eveningShift = document.getElementById('evening-shift');
    
    if (morningShift && afternoonShift && eveningShift) {
        [morningShift, afternoonShift, eveningShift].forEach(el => {
            new Sortable(el, {
                group: 'staff',
                animation: 150,
                onEnd: function(evt) {
                    updateStaffSchedule(evt);
                }
            });
        });
    }
    
    function updateStaffSchedule(evt) {
        const staffItem = evt.item;
        const newShift = evt.to.id;
        const oldShift = evt.from.id;
        
        if (newShift !== oldShift) {
            staffItem.classList.remove('shift-morning', 'shift-afternoon', 'shift-evening');
      
            switch(newShift) {
                case 'morning-shift':
                    staffItem.classList.add('shift-morning');
                    break;
                case 'afternoon-shift':
                    staffItem.classList.add('shift-afternoon');
                    break;
                case 'evening-shift':
                    staffItem.classList.add('shift-evening');
                    break;
            }
  
            const timeLabel = staffItem.querySelector('div.text-xs');
            if (timeLabel) {
                switch(newShift) {
                    case 'morning-shift':
                        timeLabel.textContent = '7h-14h';
                        timeLabel.className = 'text-xs bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 px-2 py-1 rounded';
                        break;
                    case 'afternoon-shift':
                        timeLabel.textContent = '14h-19h';
                        timeLabel.className = 'text-xs bg-amber-100 dark:bg-amber-800 text-amber-700 dark:text-amber-300 px-2 py-1 rounded';
                        break;
                    case 'evening-shift':
                        timeLabel.textContent = '19h-00h';
                        timeLabel.className = 'text-xs bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 px-2 py-1 rounded';
                        break;
                }
            }
            
  
            showNotification(`Horaire modifié - ${staffItem.querySelector('p.font-medium').textContent} déplacé vers ${getShiftName(newShift)}`);
        }
    }
    
    function getShiftName(shiftId) {
        switch(shiftId) {
            case 'morning-shift': return 'Service Matin';
            case 'afternoon-shift': return 'Service Après-midi';
            case 'evening-shift': return 'Service Soir';
            default: return 'Service';
        }
    }
    
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-4 right-4 bg-primary text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('opacity-0');
            notification.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        }, 3000);
    }
});