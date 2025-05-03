document.addEventListener('DOMContentLoaded', () => {

    // Constants
    const currentUser = 'John Doe'; // Example user name - Should come from backend in real app

    // DOM Elements Cache
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const header = document.getElementById('header');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const themeToggle = document.getElementById('theme-toggle');
    const navLinks = document.querySelectorAll('.sidebar-link');
    const sections = {
        dashboard: document.getElementById('dashboard-section'),
        reservations: document.getElementById('reservations-section'),
        tables: document.getElementById('tables-section'),
        invoices: document.getElementById('invoices-section'),
        profile: document.getElementById('profile-section')
    };
    const invoiceModal = document.getElementById('invoice-modal');
    const closeInvoiceModal = document.getElementById('close-invoice-modal');
    const printInvoice = document.getElementById('print-invoice');
    const downloadInvoice = document.getElementById('download-invoice');
    const tableButtons = document.querySelectorAll('.table-select-btn:not([disabled])');
    const selectedTableInput = document.getElementById('selected-table');
    const guestCountSelect = document.getElementById('guest-count');
    const reservationForm = document.getElementById('reservation-form');
    const profileForm = document.getElementById('profile-form');
    const filterButtons = document.querySelectorAll('#reservations-section .filter-btn');
    const reservationCards = document.querySelectorAll('#reservations-section .reservation-card');


    // --- Theme Toggle Functionality ---
    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.removeAttribute('data-theme');
        }
        try {
            localStorage.setItem('theme', theme);
        } catch (e) {
            console.error("Could not save theme to localStorage", e);
        }
    }

    if (themeToggle) {
        let savedTheme = null;
        try {
            savedTheme = localStorage.getItem('theme');
        } catch (e) {
            console.error("Could not read theme from localStorage", e);
        }
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(savedTheme || (prefersDark ? 'dark' : 'light'));

        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.hasAttribute('data-theme') ? 'dark' : 'light';
            applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });
    }

    // --- Sidebar Toggle Functionality ---
    function updateSidebarState() {
        // Check required elements exist
        if (!sidebar || !mainContent || !header) {
            console.error("Sidebar, main content, or header element not found.");
            return;
        }

        const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
        sidebar.classList.toggle('collapsed', !isCurrentlyCollapsed);
        mainContent.classList.toggle('sidebar-collapsed', !isCurrentlyCollapsed);
        header.classList.toggle('sidebar-collapsed', !isCurrentlyCollapsed);

        const icon = sidebarToggle?.querySelector('i');
        if (icon) {
            icon.className = `fas ${!isCurrentlyCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'}`;
        }
    }

    if (sidebarToggle) { // Desktop toggle
        sidebarToggle.addEventListener('click', updateSidebarState);
    }

    if (mobileMenuToggle && sidebar) { // Mobile toggle
        mobileMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent closing immediately if clicking toggle itself
            sidebar.classList.toggle('mobile-open');
        });
        // Close sidebar if clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && sidebar.classList.contains('mobile-open') && !sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    }

    // --- Section Navigation ---
    function navigateToSection(targetId) {
        // Check required elements
        if (!mainContent) {
             console.error("Main content area not found for navigation.");
             return;
         }

        let sectionFound = false;
        navLinks.forEach(navLink => {
            const isActive = navLink.getAttribute('href') === targetId;
            navLink.classList.toggle('active', isActive);
        });

        Object.entries(sections).forEach(([key, section]) => {
            const shouldShow = `#${key}` === targetId;
            section?.classList.toggle('hidden', !shouldShow);
            if (shouldShow && section) {
                sectionFound = true;
            }
        });

        if (sectionFound) {
             mainContent.scrollTop = 0; // Scroll to top of content area
             // Update URL hash
             if (history.pushState) {
                 history.pushState(null, null, targetId);
             } else {
                 window.location.hash = targetId;
             }
        } else {
             console.warn(`Section "${targetId}" not found.`);
             sections.dashboard?.classList.remove('hidden'); // Fallback
             document.querySelector('.sidebar-link[href="#dashboard"]')?.classList.add('active');
             if (history.pushState) {
                 history.pushState(null, null, '#dashboard');
             } else {
                 window.location.hash = '#dashboard';
             }
        }

        // Close mobile menu if open
        if (window.innerWidth < 768 && sidebar?.classList.contains('mobile-open')) {
            sidebar.classList.remove('mobile-open');
        }
    }

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                navigateToSection(href);
            }
            // Allow default behavior for non-hash links (like logout)
        });
    });

    // Function to handle navigation from other buttons/links
    function handleNavigationClick(event) {
         const targetId = event.currentTarget.getAttribute('href') || event.currentTarget.dataset.href; // Allow data-href too
         if (targetId && targetId.startsWith('#')) {
              event.preventDefault();
              navigateToSection(targetId);
         }
     }
     // Attach this handler to elements that should navigate sections
     document.querySelectorAll('.nav-link').forEach(el => el.addEventListener('click', handleNavigationClick));


    // --- Invoice Modal ---
    function viewInvoice(invoiceId) {
         if (!invoiceModal) return; // Ensure modal exists

        // TODO: Fetch actual invoice data based on invoiceId from backend
        // Example static data for now:
        const modalData = {
             id: invoiceId,
             date: "10 Avril 2025",
             customer: { name: "John Doe", email: "john.doe@example.com", phone: "+1 234 567 890"},
             reservation: { id: "#RS12342", date: "10 Avril 2025", guests: 4, table: "#3"},
             items: [
                 { name: "Pâtes Carbonara", qty: 2, price: 14.50 }, { name: "Pizza Margherita", qty: 1, price: 12.90 },
                 { name: "Tiramisu", qty: 2, price: 6.50 }, { name: "Vin Maison (Verre)", qty: 4, price: 5.50 },
                 { name: "Eau Minérale", qty: 2, price: 3.00 },
             ],
             taxRate: 0.03,
             payment: { method: "Carte de Crédit (VISA **** 1234)", date: "10 Avril 2025", status: "Payée" }
         };

         // Populate Modal (using helper function for safety)
         const setText = (id, text) => { const el = document.getElementById(id); if (el) el.textContent = text; };
         const setHtml = (id, html) => { const el = document.getElementById(id); if (el) el.innerHTML = html; };

         setText('invoice-id-modal', modalData.id);
         setText('invoice-date-modal', `Date d'émission: ${modalData.date}`);
         setText('customer-name-modal', modalData.customer.name);
         setText('customer-email-modal', modalData.customer.email);
         setText('customer-phone-modal', modalData.customer.phone);
         setText('reservation-id-modal', `Réservation ${modalData.reservation.id}`);
         setText('reservation-date-modal', `Date: ${modalData.reservation.date}`);
         setText('reservation-guests-modal', `Invités: ${modalData.reservation.guests}`);
         setText('reservation-table-modal', `Table: ${modalData.reservation.table}`);

         const itemsTbody = document.getElementById('invoice-items-modal');
         if (itemsTbody) {
             itemsTbody.innerHTML = ''; // Clear previous items
             let subtotal = 0;
             modalData.items.forEach(item => {
                 const amount = item.qty * item.price;
                 subtotal += amount;
                 const row = document.createElement('tr');
                 row.innerHTML = `
                     <td>${item.name}</td>
                     <td class="text-center">${item.qty}</td>
                     <td class="text-right">€${item.price.toFixed(2)}</td>
                     <td class="text-right">€${amount.toFixed(2)}</td>
                 `;
                 itemsTbody.appendChild(row);
             });

             const tax = subtotal * modalData.taxRate;
             const total = subtotal + tax;

             const tfoot = itemsTbody.nextElementSibling;
             if (tfoot) {
                 tfoot.innerHTML = `
                     <tr>
                         <td colspan="3" class="py-2 px-4 text-right font-medium border-t" style="border-color: var(--border-color);">Sous-total :</td>
                         <td class="py-2 px-4 text-right font-medium border-t" style="border-color: var(--border-color);">€${subtotal.toFixed(2)}</td>
                     </tr>
                     <tr>
                         <td colspan="3" class="py-2 px-4 text-right font-medium">Taxe (${(modalData.taxRate * 100).toFixed(0)}%) :</td>
                         <td class="py-2 px-4 text-right font-medium">€${tax.toFixed(2)}</td>
                     </tr>
                     <tr style="background-color: rgba(var(--primary-rgb), 0.05);">
                         <td colspan="3" class="py-2 px-4 text-right font-bold">Total :</td>
                         <td class="py-2 px-4 text-right font-bold text-lg">€${total.toFixed(2)}</td>
                     </tr>
                 `;
             }
         }
         // TODO: Populate payment info section similarly

         invoiceModal.classList.add('active');
    }
    // Make viewInvoice globally accessible if called from inline HTML onclick
    window.viewInvoice = viewInvoice;


    if (closeInvoiceModal) {
        closeInvoiceModal.addEventListener('click', () => invoiceModal?.classList.remove('active'));
    }
    if (invoiceModal) {
        invoiceModal.addEventListener('click', (e) => { if (e.target === invoiceModal) invoiceModal.classList.remove('active'); });
    }
    if (printInvoice) {
        printInvoice.addEventListener('click', () => window.print());
    }
    if (downloadInvoice) {
        downloadInvoice.addEventListener('click', () => alert('Le téléchargement PDF commencerait ici.'));
    }

    // --- Table Reservation Logic ---
    function updateGuestOptions(capacity) {
         if (!guestCountSelect) return;
        guestCountSelect.innerHTML = ''; // Clear existing options
        if (capacity > 0) {
            for (let i = 1; i <= capacity; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `${i} Invité${i > 1 ? 's' : ''}`;
                guestCountSelect.appendChild(option);
            }
            guestCountSelect.value = '1'; // Default to 1 guest
            guestCountSelect.disabled = false;
        } else {
             guestCountSelect.disabled = true;
             const option = document.createElement('option');
             option.textContent = "-";
             guestCountSelect.appendChild(option);
        }
    }

    tableButtons.forEach(button => {
        button.addEventListener('click', function() {
            tableButtons.forEach(btn => btn.classList.remove('selected')); // Deselect others
            button.classList.add('selected'); // Select current

            const tableName = button.dataset.tableName;
            const tableCapacity = parseInt(button.dataset.tableCapacity || '0', 10);

            if (selectedTableInput) selectedTableInput.value = tableName || "Erreur";
            updateGuestOptions(tableCapacity);
        });
    });

    if (reservationForm) {
        reservationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!selectedTableInput || selectedTableInput.value === "Aucune table sélectionnée") {
                alert('Veuillez sélectionner une table.');
                return;
            }
            // Simulate submission
            const formData = new FormData(reservationForm);
             const data = {
                 table: selectedTableInput.value,
                 guests: formData.get('guest-count') || guestCountSelect.value, // Get from form data or select directly
                 date: formData.get('reservation-date'),
                 time: formData.get('reservation-time'),
                 requests: formData.get('special-requests')
             };
             console.log('Reservation submitted:', data);
             // TODO: Send data to backend via fetch/axios

            alert('Réservation confirmée avec succès ! (Simulation)');

            // Optionally clear form and selection
            // reservationForm.reset();
            // if (selectedTableInput) selectedTableInput.value = "Aucune table sélectionnée";
            // tableButtons.forEach(btn => btn.classList.remove('selected'));
            // updateGuestOptions(0);
            // navigateToSection('#reservations'); // Navigate to reservations list
        });
    }

    // --- Profile Form ---
    

     // --- Reservation Filtering ---
     filterButtons.forEach(button => {
         button.addEventListener('click', function() {
             filterButtons.forEach(btn => {
                 btn.classList.remove('active', 'btn-primary'); // Use specific classes
                 btn.classList.add('btn-outline');
             });
             button.classList.add('active', 'btn-primary'); // Use specific classes
             button.classList.remove('btn-outline');

             const filter = button.dataset.filter;
             filterReservations(filter);
         });
     });

     function filterReservations(filter) {
          if (!reservationCards) return;
          reservationCards.forEach(card => {
              const time = card.dataset.time; // 'upcoming' or 'past'
              const status = card.dataset.status; // 'confirmed', 'pending', 'completed', 'canceled'

              let show = false;
              if (filter === 'all') {
                  show = true;
              } else if (filter === 'upcoming' && time === 'upcoming') {
                  show = true;
              } else if (filter === 'past' && time === 'past' && status !== 'canceled') { // Show completed
                  show = true;
              } else if (filter === 'canceled' && status === 'canceled') {
                  show = true;
              }
              // Hide or show based on the filter logic
              card.style.display = show ? '' : 'none';
         });
     }


    // --- Initialization ---
    function init() {
        // Set default active section based on URL hash or default to dashboard
        const hash = window.location.hash;
        const initialSection = (hash && sections[hash.slice(1)]) ? hash : '#dashboard';
        navigateToSection(initialSection);

        // Update User Info in Header
         const userNameSpan = document.querySelector('#header .font-medium');
         if (userNameSpan) userNameSpan.textContent = currentUser; // Use dynamic data when available

        // Set min date for reservation date picker
        const dateInput = document.getElementById('reservation-date');
        if (dateInput) {
             const today = new Date();
             const offset = today.getTimezoneOffset() * 60000; // Offset in milliseconds
             const localISOTime = (new Date(today - offset)).toISOString().split('T')[0];
             dateInput.setAttribute('min', localISOTime);
             dateInput.value = localISOTime; // Set default to today
        }

         // Initial reservation filter
         filterReservations('all'); // Show all initially

         // Update guest options for initially selected table (if any)
         const initiallySelectedTable = document.querySelector('.table-select-btn.selected');
         if (initiallySelectedTable && guestCountSelect) {
             updateGuestOptions(parseInt(initiallySelectedTable.dataset.tableCapacity || '0', 10));
         } else if (guestCountSelect) {
             updateGuestOptions(0); // Default if no table selected
         }
         if(selectedTableInput && !initiallySelectedTable) {
              selectedTableInput.value = "Aucune table sélectionnée";
              if (guestCountSelect) guestCountSelect.disabled = true; // Disable if no table selected initially
         }

         // Add event listener to update disabled state based on input value change (e.g., if cleared by script)
         if (selectedTableInput && guestCountSelect) {
            const observer = new MutationObserver(() => {
                guestCountSelect.disabled = (selectedTableInput.value === "Aucune table sélectionnée");
            });
            observer.observe(selectedTableInput, { attributes: true, attributeFilter: ['value'] });
         }
    }

    // Run Initialization
    init();

});
document.addEventListener('DOMContentLoaded', function() {
    // Table selection functionality
    const tableButtons = document.querySelectorAll('.table-select-btn:not([disabled])');
    const selectedTableInput = document.getElementById('selected-table');
    const selectedTableIdInput = document.getElementById('selected-table-id');
    const guestCountSelect = document.getElementById('guest-count');
    
    // Filter form submission handling
    const restaurantSelect = document.getElementById('dashboard-restaurant-select');
    const dateSelect = document.getElementById('dashboard-date-select');
    const personsSelect = document.getElementById('dashboard-persons-select');
    
    // Add event listeners to all filter controls
    [restaurantSelect, dateSelect, personsSelect].forEach(element => {
        if (element) {
            element.addEventListener('change', function() {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = window.location.pathname + '#tables-section';
                
                // Append restaurant filter if set
                if (restaurantSelect.value) {
                    const restaurantInput = document.createElement('input');
                    restaurantInput.type = 'hidden';
                    restaurantInput.name = 'restaurant';
                    restaurantInput.value = restaurantSelect.value;
                    form.appendChild(restaurantInput);
                }
                
                // Append date filter
                const dateInput = document.createElement('input');
                dateInput.type = 'hidden';
                dateInput.name = 'date';
                dateInput.value = dateSelect.value;
                form.appendChild(dateInput);
                
                // Append persons filter if set
                if (personsSelect.value) {
                    const personsInput = document.createElement('input');
                    personsInput.type = 'hidden';
                    personsInput.name = 'persons';
                    personsInput.value = personsSelect.value;
                    form.appendChild(personsInput);
                }
                
                document.body.appendChild(form);
                form.submit();
            });
        }
    });
    
    // Table selection handling
    tableButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove selected class from all buttons
            tableButtons.forEach(btn => {
                btn.classList.remove('ring-2', 'ring-[#0288D1]', 'ring-offset-2');
                btn.querySelector('.relative > span:last-child').classList.remove('bg-[#0288D1]');
                btn.querySelector('.relative > span:last-child').classList.add('bg-gradient-to-r', 'from-[#4CAF50]', 'to-[#2E7D32]');
            });
            
            // Add selected class to clicked button
            this.classList.add('ring-2', 'ring-[#0288D1]', 'ring-offset-2');
            this.querySelector('.relative > span:last-child').classList.remove('bg-gradient-to-r', 'from-[#4CAF50]', 'to-[#2E7D32]');
            this.querySelector('.relative > span:last-child').classList.add('bg-[#0288D1]');
            
            // Get table data
            const tableId = this.dataset.tableId;
            const tableName = this.dataset.tableName;
            const tableCapacity = parseInt(this.dataset.tableCapacity);
            const tableType = this.dataset.tableType;
            
            // Update form fields
            selectedTableInput.value = tableName + (tableType ? ` (${tableType})` : '');
            selectedTableIdInput.value = tableId;
            
            // Populate guest count dropdown based on table capacity
            guestCountSelect.innerHTML = '';
            for (let i = 1; i <= tableCapacity; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i + (i === 1 ? ' personne' : ' personnes');
                guestCountSelect.appendChild(option);
            }
            
            // Set default value to max capacity
            guestCountSelect.value = tableCapacity;
        });
    });
    
    // Sync the date between filter and form
    const reservationDateInput = document.getElementById('reservation-date');
    if (dateSelect && reservationDateInput) {
        dateSelect.addEventListener('change', function() {
            reservationDateInput.value = this.value;
        });
    }
    
    // Form validation
    const reservationForm = document.getElementById('reservation-form');
    if (reservationForm) {
        reservationForm.addEventListener('submit', function(e) {
            if (!selectedTableIdInput.value) {
                e.preventDefault();
                alert('Veuillez sélectionner une table avant de confirmer la réservation.');
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Get all table filter buttons
    const filterButtons = document.querySelectorAll('.table-filter-btn');
    
    // Get all table buttons
    const tableButtons = document.querySelectorAll('.table-select-btn');
    
    // Add click event to each filter button
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => {
                btn.classList.remove('border-b-2', 'border-[#0288D1]', 'text-[#0288D1]');
                btn.classList.add('text-gray-500');
            });
            
            // Add active class to clicked button
            this.classList.remove('text-gray-500');
            this.classList.add('border-b-2', 'border-[#0288D1]', 'text-[#0288D1]');
            
            // Get the filter value
            const filterValue = this.getAttribute('data-table-filter');
            
            // Filter tables
            tableButtons.forEach(table => {
                // Check if the table has a data-table-type attribute
                if (table.hasAttribute('data-table-type')) {
                    const tableType = table.getAttribute('data-table-type');
                    
                    if (filterValue === 'all' || tableType === filterValue) {
                        table.style.display = '';
                    } else {
                        table.style.display = 'none';
                    }
                }
            });
            
            // Scroll to tables section
            document.getElementById('tables').scrollIntoView({ behavior: 'smooth' });
        });
    });
    
    // Make URL filtering work by checking for hash
    if (window.location.hash === '#tables') {
        document.getElementById('tables').scrollIntoView({ behavior: 'smooth' });
    }
    
    // Add event listeners to filter form elements
    document.getElementById('dashboard-restaurant-select').addEventListener('change', function() {
        // Add #tables to the URL when submitting
        document.getElementById('filter-form').action = document.getElementById('filter-form').action + '#tables';
        document.getElementById('filter-form').submit();
    });
    
    document.getElementById('dashboard-date-select').addEventListener('change', function() {
        // Add #tables to the URL when submitting
        document.getElementById('filter-form').action = document.getElementById('filter-form').action + '#tables';
        document.getElementById('filter-form').submit();
    });
    
    document.getElementById('dashboard-persons-select').addEventListener('change', function() {
        // Add #tables to the URL when submitting
        document.getElementById('filter-form').action = document.getElementById('filter-form').action + '#tables';
        document.getElementById('filter-form').submit();
    });
    
    const tableSelectButtons = document.querySelectorAll('.table-select-btn:not([disabled])');
    const selectedTableInput = document.getElementById('selected-table');
    const selectedTableIdInput = document.getElementById('selected-table-id');
    const guestCountSelect = document.getElementById('guest-count');
    
    tableSelectButtons.forEach(button => {
        button.addEventListener('click', function() {
            tableSelectButtons.forEach(btn => {
                btn.classList.remove('ring-2', 'ring-[#0288D1]');
            });
            
            this.classList.add('ring-2', 'ring-[#0288D1]');
            
            const tableId = this.getAttribute('data-table-id');
            const tableName = this.getAttribute('data-table-name');
            const tableCapacity = parseInt(this.getAttribute('data-table-capacity'));
            
            selectedTableIdInput.value = tableId;
            selectedTableInput.value = tableName;
            
            guestCountSelect.innerHTML = '';
            for (let i = 1; i <= tableCapacity; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i + (i === 1 ? ' personne' : ' personnes');
                guestCountSelect.appendChild(option);
            }
        });
    });
    
    const reservationForm = document.getElementById('reservation-form');
    reservationForm.addEventListener('submit', function(event) {
        if (!selectedTableIdInput.value) {
            event.preventDefault();
            alert('Veuillez sélectionner une table avant de confirmer la réservation.');
        }
    });
});
// Ajouter après le code JavaScript existant
document.addEventListener('DOMContentLoaded', function() {
    // Références aux éléments du formulaire
    const dateInput = document.getElementById('reservation-date');
    const timeSelect = document.getElementById('reservation-time');
    const durationSelect = document.getElementById('reservation-duration');
    
    // Fonction pour mettre à jour les options de durée
    function updateDurationOptions() {
        // Effacer les options actuelles
        durationSelect.innerHTML = '';
        
        // Vérifier si une date et une heure sont sélectionnées
        if (!dateInput.value || !timeSelect.value) {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Sélectionnez date et heure d\'abord';
            durationSelect.appendChild(option);
            return;
        }
        
        // Convertir la date en objet Date
        const selectedDate = new Date(dateInput.value);
        const dayOfWeek = selectedDate.getDay(); // 0 = dimanche, 6 = samedi
        const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
        
        // Déterminer s'il s'agit du déjeuner ou du dîner
        const selectedTime = timeSelect.value;
        const hour = parseInt(selectedTime.split(':')[0]);
        const isLunch = (hour < 15); // Avant 15h = déjeuner
        
        // Déterminer les durées disponibles en fonction des règles
        let durations = [];
        
        if (isLunch && !isWeekend) {
            // Déjeuner en semaine: 1 heure
            durations.push({ value: 60, label: '1 heure' });
        } else if (!isLunch && !isWeekend) {
            // Dîner en semaine: 2 heures
            durations.push({ value: 120, label: '2 heures' });
        } else if (!isLunch && isWeekend) {
            // Dîner le weekend: 3 heures
            durations.push({ value: 180, label: '3 heures' });
        } else {
            // Déjeuner le weekend: proposons 1h30
            durations.push({ value: 90, label: '1 heure 30' });
        }
        
        // Ajouter des options supplémentaires selon le contexte
        if (isWeekend && !isLunch) {
            // Option pour réduire à 2h le weekend
            durations.push({ value: 120, label: '2 heures' });
        }
        
        if (!isLunch) {
            // Option pour une durée courte en soirée
            durations.push({ value: 90, label: '1 heure 30' });
        }
        
        // Ajouter les options au sélecteur
        durations.forEach(duration => {
            const option = document.createElement('option');
            option.value = duration.value;
            option.textContent = duration.label;
            durationSelect.appendChild(option);
        });
        
        // Sélectionner la première option
        if (durations.length > 0) {
            durationSelect.value = durations[0].value;
        }
    }
    
    // Écouter les changements de date ou d'heure
    dateInput.addEventListener('change', updateDurationOptions);
    timeSelect.addEventListener('change', updateDurationOptions);
    
    // Initialiser les options de durée
    updateDurationOptions();
});





document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const form = document.getElementById('reservation-form');
    const tableIdInput = document.getElementById('selected-table-id');
    const tableNameInput = document.getElementById('selected-table');
    const guestCountSelect = document.getElementById('guest-count');
    const dateInput = document.getElementById('reservation-date');
    const timeSelect = document.getElementById('reservation-time');
    const durationSelect = document.getElementById('reservation-duration');
    const specialRequests = document.getElementById('special-requests');
    const summary = document.getElementById('reservation-summary');
    const closingTimeWarning = document.getElementById('closing-time-warning');
    
    // Summary elements
    const summaryTable = document.getElementById('summary-table');
    const summaryDate = document.getElementById('summary-date');
    const summaryTime = document.getElementById('summary-time');
    const summaryDuration = document.getElementById('summary-duration');
    const summaryEndTime = document.getElementById('summary-end-time');
    const summaryGuests = document.getElementById('summary-guests');
    
    // Update summary when inputs change
    function updateSummary() {
        if (tableNameInput.value !== 'Aucune table sélectionnée' && 
            dateInput.value && 
            timeSelect.value && 
            durationSelect.value && 
            guestCountSelect.value) {
            
            // Format date for display
            const formattedDate = new Date(dateInput.value).toLocaleDateString('fr-FR', {
                day: '2-digit', 
                month: '2-digit', 
                year: 'numeric'
            });
            
            // Calculate end time
            const startTime = timeSelect.value;
            const duration = parseInt(durationSelect.value);
            const [hours, minutes] = startTime.split(':').map(Number);
            
            let endHours = hours + Math.floor((minutes + duration) / 60);
            let endMinutes = (minutes + duration) % 60;
            
            const endTime = `${endHours.toString().padStart(2, '0')}:${endMinutes.toString().padStart(2, '0')}`;
            
            // Update summary fields
            summaryTable.textContent = tableNameInput.value;
            summaryDate.textContent = formattedDate;
            summaryTime.textContent = startTime;
            summaryDuration.textContent = `${duration} minutes`;
            summaryEndTime.textContent = endTime;
            summaryGuests.textContent = `${guestCountSelect.value} personne(s)`;
            
            // Show summary
            summary.classList.remove('hidden');
        }
    }
    
    // Handle time selection
    dateInput.addEventListener('change', function() {
        // Update available times based on date
        timeSelect.innerHTML = '<option value="">Choisissez une heure</option>';
        
        for (let hour = 10; hour < 22; hour++) {
            for (let minute of ['00', '30']) {
                const timeValue = `${hour.toString().padStart(2, '0')}:${minute}`;
                const option = new Option(timeValue, timeValue);
                timeSelect.add(option);
            }
        }
        
        timeSelect.disabled = false;
    });
    
    // Handle duration selection
    timeSelect.addEventListener('change', function() {
        if (!timeSelect.value) return;
        
        durationSelect.innerHTML = '<option value="">Choisissez une durée</option>';
        
        // Get selected time
        const [hours, minutes] = timeSelect.value.split(':').map(Number);
        
        // Calculate minutes until closing (22:00)
        const minutesUntilClosing = (22 - hours) * 60 - minutes;
        
        // Add duration options
        const durations = [30, 60, 90, 120, 150, 180];
        
        for (const duration of durations) {
            if (duration <= minutesUntilClosing) {
                const option = new Option(`${duration} minutes`, duration);
                durationSelect.add(option);
            }
        }
        
        durationSelect.disabled = false;
        
        // Show warning if close to closing time
        if (minutesUntilClosing < 180) {
            closingTimeWarning.classList.remove('hidden');
        } else {
            closingTimeWarning.classList.add('hidden');
        }
        
        updateSummary();
    });
    
    // Update summary when any relevant input changes
    [tableNameInput, guestCountSelect, dateInput, timeSelect, durationSelect].forEach(element => {
        element.addEventListener('change', updateSummary);
    });
    
    // Form submission handler
    form.addEventListener('submit', function(event) {
        // Prevent default browser submission
        event.preventDefault();
        
        // Validate form
        if (!tableIdInput.value || !guestCountSelect.value || !dateInput.value || !timeSelect.value || !durationSelect.value) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return false;
        }
        
        // Show confirmation dialog
        if (confirm('Confirmez-vous cette réservation ?')) {
            // Manually submit the form
            const formData = new FormData(form);
            
            fetch('/reservations', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'text/html,application/xhtml+xml,application/xml',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text();
                }
            })
            .then(html => {
                if (html) {
                    document.open();
                    document.write(html);
                    document.close();
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);
                alert('Une erreur est survenue lors de la création de votre réservation. Veuillez réessayer.');
            });
        }
    });
});
document.querySelectorAll('.table-select-btn').forEach(button => {
    button.addEventListener('click', event => {
        const tableId = button.getAttribute('data-table-id');
        const tableName = button.getAttribute('data-table-name');
        const tableCapacity = button.getAttribute('data-table-capacity');

        // Update selected table input
        document.getElementById('selected-table-id').value = tableId;
        document.getElementById('selected-table').value = tableName;

        // Populate guest count dropdown
        const guestCountDropdown = document.getElementById('guest-count');
        guestCountDropdown.innerHTML = '';
        for (let i = 1; i <= tableCapacity; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = `${i} ${i === 1 ? 'personne' : 'personnes'}`;
            guestCountDropdown.appendChild(option);
        }
    });
});
// Improved modal handling
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.getElementById('modal-overlay').classList.remove('hidden');
    document.body.classList.add('overflow-hidden'); // Prevent scrolling
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById('modal-overlay').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Use these functions for specific modals
function openPasswordModal() {
    openModal('password-modal');
}

function openDeleteModal() {
    openModal('delete-modal');
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modal-overlay').addEventListener('click', function() {
        closeModal('password-modal');
        closeModal('delete-modal');
    });
});


document.querySelectorAll('.cancel-reservation').forEach(button => {
    button.addEventListener('click', function () {
        const reservationId = this.getAttribute('data-id');
        fetch(`/reservations/${reservationId}/cancel`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Reload the page or remove the row from the table
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });
});
// JavaScript to handle the "Annuler" button click
function cancelReservation(reservationId) {
    if (!confirm("Êtes-vous sûr de vouloir annuler cette réservation ?")) {
        return;
    }

    fetch(`/reservations/${reservationId}/cancel`, {
        method: 'POST', // Use POST for simplicity
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // CSRF Token
        },
        body: JSON.stringify({
            status: 'canceled'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Optionally reload the page or update the UI dynamically
            document.querySelector(`#reservation-${reservationId} .badge`).textContent = 'Annuler';
            document.querySelector(`#reservation-${reservationId} .badge`).classList.replace('badge-green', 'badge-gray');
        } else {
            alert("Échec de l'annulation de la réservation.");
        }
    })
    .catch(error => {
        console.error("Erreur :", error);
        alert("Une erreur s'est produite. Veuillez réessayer.");
    });
}



document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('reservation-search');
    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.reservation-card').forEach(card => {
            // Tu peux filtrer sur plusieurs champs, par exemple le titre, la date, le numéro de table, etc.
            const text = card.innerText.toLowerCase();
            if (text.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        // Optionnel : Masquer le message "Vous n'avez pas encore de réservations" si filtre actif
        const emptyMsg = document.querySelector('.dashboard-card.text-center');
        if (emptyMsg) {
            emptyMsg.style.display = document.querySelectorAll('.reservation-card:not([style*="display: none"])').length === 0 ? '' : 'none';
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('invoice-search');
    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.invoice-row').forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        const visibleRows = Array.from(document.querySelectorAll('.invoice-row')).some(row => row.style.display !== 'none');
    });
});