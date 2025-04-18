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
     if (profileForm) {
         profileForm.addEventListener('submit', (e) => {
             e.preventDefault();
             const formData = new FormData(profileForm);
             const data = Object.fromEntries(formData.entries());
             // Handle checkbox values correctly (unchecked boxes aren't included in FormData)
             data.vegetarian = formData.has('vegetarian') ? 'on' : 'off';
             data.gluten_free = formData.has('gluten-free') ? 'on' : 'off';
             // ... add other checkboxes ...
             data.email_notifications = formData.has('email_notifications') ? 'on' : 'off';
             data.sms_notifications = formData.has('sms_notifications') ? 'on' : 'off';
             data.marketing_communications = formData.has('marketing_communications') ? 'on' : 'off';

             console.log("Profile update submitted:", data);
              // TODO: Send data to backend via fetch/axios
             alert("Profil mis à jour avec succès ! (Simulation)");
         });
     }

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