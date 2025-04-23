document.addEventListener('DOMContentLoaded', function() {
    // --- DOM Elements ---
    const body = document.body;
    const datetimeElement = document.querySelector('.datetime');
    const tabs = document.querySelectorAll('div[role="tablist"][aria-label="Navigation principale"] button[role="tab"], nav[aria-label="Navigation inférieure"] a[role="tab"]'); // Select tabs from both locations
    const tabContents = document.querySelectorAll('div[role="tabpanel"]'); // Simpler selector for tab content
    const bottomNavItems = document.querySelectorAll('nav[aria-label="Navigation inférieure"] a[role="tab"]'); // Specific selector for bottom nav
    const tableItems = document.querySelectorAll('#tables-tab div[role="button"][data-table]'); // More specific selector for table items
    const backToTablesBtn = document.getElementById('back-to-tables');
    const menuItems = document.querySelectorAll('#orders-tab div[role="button"][data-id]'); // More specific selector for menu items
    const customizationOverlay = document.getElementById('customization-overlay');
    const customizationModal = document.getElementById('customization-modal');
    const modalCloseBtn = customizationModal.querySelector('.modal-close');
    const modalCancelBtn = customizationModal.querySelector('.modal-cancel-btn');
    const modalAddToCartBtn = customizationModal.querySelector('.add-to-cart-btn');
    const modalTitle = customizationModal.querySelector('#modal-title-label'); // Use ID for title
    const modalBody = customizationModal.querySelector('.modal-body');
    const cartPanel = document.getElementById('cart-panel');
    const cartHeader = cartPanel.querySelector('div[role="button"]'); // The clickable header part
    const cartDetails = document.getElementById('cart-details');
    const cartContent = cartPanel.querySelector('.cart-content');
    const cartEmptyMessage = cartPanel.querySelector('.cart-empty-message');
    const cartTableIdSpan = cartPanel.querySelector('.cart-table-id');
    const cartItemCountSpan = cartPanel.querySelector('.cart-count');
    const cartTotalSpan = cartPanel.querySelector('.cart-total');
    const cartSubtotalFooterSpan = cartPanel.querySelector('.cart-subtotal-footer');
    const cartTaxFooterSpan = cartPanel.querySelector('.cart-tax-footer');
    const cartGrandTotalFooterSpan = cartPanel.querySelector('.cart-grand-total-footer');
    const sendToKitchenBtn = document.getElementById('send-to-kitchen-btn');
    const cancelOrderBtn = document.getElementById('cancel-order-btn');
    const goToPaymentBtn = document.getElementById('go-to-payment-btn');
    const themeToggleBtn = document.getElementById('theme-toggle');
    const contrastToggleBtn = document.getElementById('contrast-toggle');
    const toastContainer = document.querySelector('.toast-container');
    const searchInput = document.querySelector('#orders-tab input[type="search"]'); // Specific search input
    const voiceBtn = document.querySelector('#orders-tab button[aria-label="Recherche vocale"]'); // Specific voice button
    const categoryTabs = document.querySelectorAll('#orders-tab div[role="tablist"][aria-label="Filtrer par catégorie"] button[role="tab"]'); // Specific category tabs
    const paymentMethods = document.querySelectorAll('#payment-tab div[role="radio"][data-method]'); // More specific payment method selector
    const cashPaymentDetails = document.querySelector('#payment-tab .cash-payment-details');
    const amountInput = document.querySelector('#payment-tab .amount-input');
    const numpadKeys = document.querySelectorAll('#payment-tab .numpad .numkey');
    const changeAmountSpan = document.querySelector('#payment-tab .change-amount');
    const billsDisplay = document.querySelector('#payment-tab .bills-display');
    const tipCheckbox = document.getElementById('round-tip');
    const tipAmountSpan = document.querySelector('#payment-tab .tip-amount');
    const completePaymentBtn = document.getElementById('complete-payment');
    const backToTablesReceiptBtn = document.getElementById('back-to-tables-btn');
    const cleanTableBtn = document.getElementById('clean-table-btn');
    const orderHeaderNum = document.querySelector('#orders-tab .text-2xl.font-bold'); // Selector for table number in order tab
    const orderHeaderMeta = document.querySelector('#orders-tab .table-meta'); // Selector for table meta in order tab
    const receiptItemsContainer = document.querySelector('#receipt-tab div[aria-label="Articles commandés"]'); // Selector for receipt items container
    const paymentSuccessPanel = document.querySelector('#receipt-tab .bg-secondary-50'); // Selector for success panel


    // --- State ---
    let currentTable = null;
    let currentOrder = []; // Array of {id, name, price, qty, options: [], notes: '', key: ''}
    let currentTab = 'tables';
    const TAX_RATE = 0.10; // 10%

    // --- Utility Functions ---
    const formatCurrency = (value) => {
        // Ensure value is a number before formatting
        const numberValue = Number(value);
         if (isNaN(numberValue)) {
             console.error("Invalid value passed to formatCurrency:", value);
             return "0,00\u00A0€"; // Use non-breaking space for Euro symbol consistency
         }
        // If the value is valid, format it
        return numberValue.toLocaleString('fr-FR', { style: 'currency', currency: 'EUR' });
    };

    const showToast = (message, type = 'info', duration = 3000) => {
        if (!toastContainer) return; // Safety check
        const toast = document.createElement('div');
        let bgColor = 'bg-gray-900/90';
        if (type === 'success') bgColor = 'bg-secondary-600/90';
        if (type === 'error') bgColor = 'bg-danger-600/90';
        if (type === 'warning') bgColor = 'bg-warning-600/90';

        toast.className = `${bgColor} text-white py-2.5 px-5 rounded-full text-sm shadow-lg opacity-0 transform translate-y-2.5 transition-all duration-300 flex items-center gap-2`;
        toast.setAttribute('role', 'status');
        let iconClass = 'fa-info-circle';
        if (type === 'success') iconClass = 'fa-check-circle';
        if (type === 'error') iconClass = 'fa-exclamation-triangle';
        if (type === 'warning') iconClass = 'fa-exclamation-circle';

        toast.innerHTML = `<i class="fas ${iconClass}" aria-hidden="true"></i> ${message}`;
        toastContainer.appendChild(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.remove('opacity-0', 'translate-y-2.5');
        }, 10);

        // Remove after duration
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2.5');
            setTimeout(() => {
                 if (toast.parentNode === toastContainer) { // Check if still attached
                     toast.remove();
                 }
            }, 300); // Wait for transition
        }, duration);
    };

     const vibrate = (pattern) => {
        if ('vibrate' in navigator && navigator.vibrate) { // Add check for vibrate function existence
            try {
                navigator.vibrate(pattern);
            } catch (e) {
                // console.warn("Haptic feedback failed:", e); // Optional: less console noise
            }
        }
    };


    // --- Core Logic ---

    // Date/Time Update
    function updateDateTime() {
        if (datetimeElement) {
            const now = new Date();
            // Format: YYYY-MM-DD HH:MM:SS
            const pad = (n) => n.toString().padStart(2, '0');
            const formattedDate = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
            datetimeElement.textContent = formattedDate;

             // Update receipt time if visible
             const receiptTime = document.querySelector('#receipt-tab .receipt-datetime'); // Specific selector
             const receiptTab = document.getElementById('receipt-tab');
             if(receiptTime && receiptTab && !receiptTab.hidden) { // Check if tab is not hidden
                 receiptTime.textContent = formattedDate;
             }
        }
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);


    // Tab Navigation
    function activateTab(tabId) {
        if (!tabId) return; // Safety check
        currentTab = tabId;

        // Update Top Tabs & Bottom Nav shared logic
        tabs.forEach(tab => {
            const isSelected = tab.getAttribute('data-tab') === tabId;
            tab.setAttribute('aria-selected', isSelected.toString());
            tab.setAttribute('tabindex', isSelected ? '0' : '-1');
            // Top tabs styling
            if (tab.closest('div[role="tablist"][aria-label="Navigation principale"]')) {
                if (isSelected) {
                    tab.classList.add('text-primary-500', 'border-primary-500');
                    tab.classList.remove('text-gray-500', 'border-transparent', 'hover:text-gray-800', 'dark:hover:text-gray-200');
                } else {
                    tab.classList.remove('text-primary-500', 'border-primary-500');
                    tab.classList.add('text-gray-500', 'border-transparent', 'hover:text-gray-800', 'dark:hover:text-gray-200');
                }
            }
            // Bottom nav styling
            if (tab.closest('nav[aria-label="Navigation inférieure"]')) {
                 if (isSelected) {
                     tab.classList.add('text-primary-500', 'border-primary-500', 'dark:text-primary-400');
                     tab.classList.remove('text-gray-500', 'border-transparent', 'hover:text-gray-800', 'dark:text-gray-400', 'dark:hover:text-gray-200');
                 } else {
                     tab.classList.remove('text-primary-500', 'border-primary-500', 'dark:text-primary-400');
                     tab.classList.add('text-gray-500', 'border-transparent', 'hover:text-gray-800', 'dark:text-gray-400', 'dark:hover:text-gray-200');
                 }
            }
        });

        // Update Content Panels
        let foundPanel = false;
        tabContents.forEach(content => {
             const contentId = content.id.replace('-tab', ''); // e.g., 'tables-tab' -> 'tables'
             const isHidden = contentId !== tabId;
             content.hidden = isHidden;
             if (!isHidden) foundPanel = true;
         });
         if (!foundPanel) console.error(`No tab content panel found for tabId: ${tabId}`);


         // Show/Hide Cart based on tab
         const cartVisible = (tabId === 'orders' || tabId === 'payment') && currentTable !== null;
         cartPanel.style.display = cartVisible ? 'flex' : 'none';

         // Focus the first focusable element in the new tab for accessibility (optional, can be jarring)
         /*
         const newTabContent = document.getElementById(`${tabId}-tab`);
         if(newTabContent && !newTabContent.hidden) {
             const firstFocusable = newTabContent.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
             if(firstFocusable) {
                 firstFocusable.focus({ preventScroll: true });
             }
         }
         */
         // Ensure cart visibility updates after tab change
         updateCartVisibility();
    }

     function updateCartVisibility() {
         const cartVisible = (currentTab === 'orders' || currentTab === 'payment') && currentTable !== null;
         cartPanel.style.display = cartVisible ? 'flex' : 'none';
     }

    tabs.forEach(tab => tab.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default link behavior for bottom nav
        const tabId = tab.getAttribute('data-tab');
        if (tabId) {
           activateTab(tabId);
        } else {
            console.error("Clicked tab has no data-tab attribute:", tab);
        }
    }));
    // Note: Bottom nav items are included in the 'tabs' querySelectorAll now


    // Table Selection
    tableItems.forEach(table => {
        table.addEventListener('click', () => {
            // Prevent selecting if already processing payment for this table? (optional)
            const tableId = table.getAttribute('data-table');
            if (!tableId) return;

            currentTable = tableId;
            // TODO: Load existing order for this table if applicable from a backend/localStorage
            // For demo, we reset the order each time
            currentOrder = [];
            updateOrderHeader();
            updateCart(); // This will calculate totals and items, but visibility is handled by activateTab/updateCartVisibility
            activateTab('orders'); // Switch to orders tab
            showToast(`Table ${currentTable} sélectionnée`);
            vibrate(50);
        });
         // Keyboard activation
         table.addEventListener('keydown', (e) => {
             if (e.key === 'Enter' || e.key === ' ') {
                 e.preventDefault();
                 table.click();
             }
         });
    });

     function updateOrderHeader() {
        if (!orderHeaderNum || !orderHeaderMeta) return; // Safety check

        if (currentTable !== null) {
            const tableElement = document.querySelector(`#tables-tab div[data-table="${currentTable}"]`);
            if (!tableElement) {
                console.error("Could not find table element for table:", currentTable);
                orderHeaderNum.textContent = 'Erreur Table';
                orderHeaderMeta.innerHTML = '';
                return;
            }
            const capacityElement = tableElement.querySelector('.text-xs.text-gray-500 i.fa-users');
            const timeElement = tableElement.querySelector('.text-xs.font-semibold');
            const capacity = capacityElement ? capacityElement.parentElement.textContent.replace(/.*?(\d+).*/, '$1') : '?'; // Extract number
            const timeText = timeElement?.textContent.replace(/<i.*?><\/i>\s*/, '').trim() || ''; // Remove potential icon tag
            const status = tableElement.classList.contains('border-secondary-500') ? 'Libre' :
                           tableElement.classList.contains('border-danger-500') ? 'Occupée' :
                           tableElement.classList.contains('border-warning-500') ? 'Réservée' : 'Inconnu';
            const timeIconClass = status === 'Réservée' ? 'fas fa-calendar-alt' : 'fas fa-clock';


            orderHeaderNum.textContent = `Table ${currentTable}`;
            let metaHTML = `<span><i class="fas fa-users mr-1" aria-hidden="true"></i> ${capacity} pers.</span>`; // Add 'pers.' and margin
            if (timeText) metaHTML += `<span class="ml-2"><i class="${timeIconClass} mr-1" aria-hidden="true"></i> ${timeText}</span>`; // Add margin
            metaHTML += `<span class="text-primary-500 cursor-pointer hover:underline ml-2"><i class="fas fa-history mr-1" aria-hidden="true"></i> Historique</span>`; // Add margin
            orderHeaderMeta.innerHTML = metaHTML;
        } else {
            orderHeaderNum.textContent = 'Sélectionner une table';
            orderHeaderMeta.innerHTML = '';
        }
    }

    if (backToTablesBtn) {
        backToTablesBtn.addEventListener('click', () => activateTab('tables'));
    }


    // Menu Item Interaction -> Open Modal
    menuItems.forEach(item => {
        item.addEventListener('click', () => {
             if (currentTable === null) {
                showToast('Veuillez d\'abord sélectionner une table.', 'warning');
                vibrate([50,50]);
                return;
             }

            const itemId = item.dataset.id;
            const itemName = item.dataset.name;
            const itemPrice = parseFloat(item.dataset.price);

            if (!itemId || !itemName || isNaN(itemPrice)) {
                console.error("Menu item missing data attributes:", item);
                showToast('Erreur de données pour cet article.', 'error');
                return;
            }

            // Load customization options based on itemId (Static example used from HTML)
            modalTitle.textContent = `Personnaliser : ${itemName}`; // Be more specific
            // Reset options (using the static HTML structure as template)
             customizationModal.querySelectorAll('.option-item[role="radio"]').forEach(el => {
                 const isDefault = el.classList.contains('active'); // Check if it was the default active one
                 el.classList.toggle('active', isDefault);
                 el.classList.toggle('bg-primary-50', isDefault);
                 el.classList.toggle('border-primary-500', isDefault);
                 el.classList.toggle('text-primary-500', isDefault);
                 el.classList.toggle('font-semibold', isDefault);
                 el.classList.toggle('bg-white', !isDefault);
                 el.classList.toggle('border-gray-200', !isDefault);
                 el.classList.toggle('text-gray-800', !isDefault);
                 el.classList.toggle('hover:bg-gray-100', !isDefault);
                 el.setAttribute('aria-checked', isDefault.toString());
             });
             customizationModal.querySelectorAll('.extra-item[role="checkbox"]').forEach(el => {
                 const isDefaultChecked = el.classList.contains('checked'); // Using a hypothetical 'checked' class for default
                 const checkbox = el.querySelector('.checkbox');
                 el.setAttribute('aria-checked', isDefaultChecked.toString());
                 checkbox.classList.toggle('bg-primary-500', isDefaultChecked);
                 checkbox.classList.toggle('border-primary-500', isDefaultChecked);
                 checkbox.classList.toggle('checked', isDefaultChecked); // Keep the class if needed
                 checkbox.classList.toggle('border-gray-200', !isDefaultChecked);
                 checkbox.innerHTML = isDefaultChecked ? '<i class="fas fa-check text-white text-xs" aria-hidden="true"></i>' : '';
             });
            customizationModal.querySelector('.notes-field').value = '';


            // Store item data for adding to cart
            modalAddToCartBtn.dataset.itemId = itemId;
            modalAddToCartBtn.dataset.itemName = itemName;
            modalAddToCartBtn.dataset.itemPrice = itemPrice.toString(); // Store as string

            customizationOverlay.classList.remove('invisible', 'opacity-0');
            customizationModal.classList.remove('invisible', 'opacity-0', 'scale-95');
            customizationModal.classList.add('scale-100'); // Ensure final state is scale 1
            const firstFocusable = customizationModal.querySelector('button, input, textarea, select, [role="radio"], [role="checkbox"]');
            if (firstFocusable) firstFocusable.focus(); // Focus first element in modal
            vibrate(50);
        });
         // Keyboard activation
         item.addEventListener('keydown', (e) => {
             if (e.key === 'Enter' || e.key === ' ') {
                 e.preventDefault();
                 item.click();
             }
         });
    });

    // Modal Closing
    const closeModal = () => {
        customizationOverlay.classList.add('invisible', 'opacity-0');
        customizationModal.classList.add('invisible', 'opacity-0', 'scale-95');
        customizationModal.classList.remove('scale-100');
        // TODO: Return focus to the element that opened the modal if possible
         const openedBy = document.querySelector(`[data-id="${modalAddToCartBtn.dataset.itemId}"]`);
         if (openedBy) openedBy.focus();
    };
    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
    if (modalCancelBtn) modalCancelBtn.addEventListener('click', closeModal);
    if (customizationOverlay) {
        customizationOverlay.addEventListener('click', (e) => {
            if (e.target === customizationOverlay) {
                closeModal();
            }
        });
    }
    document.addEventListener('keydown', (e) => {
         // Check if modal is visible (not just overlay)
        if (e.key === 'Escape' && !customizationModal.classList.contains('invisible')) {
            closeModal();
        }
    });

     // Modal Option Selection (Example for radio groups and checkboxes)
    if (customizationModal) {
        customizationModal.addEventListener('click', (e) => {
            // Radio buttons (like cooking level, side dish)
            const radioTarget = e.target.closest('.option-item[role="radio"]');
            if (radioTarget) {
                const group = radioTarget.closest('[role="radiogroup"]');
                if (!group) return; // Should have a group
                group.querySelectorAll('.option-item[role="radio"]').forEach(radio => {
                    const isSelected = radio === radioTarget;
                    radio.classList.toggle('active', isSelected);
                    radio.classList.toggle('bg-primary-50', isSelected);
                     radio.classList.toggle('dark:bg-primary-900/30', isSelected);
                    radio.classList.toggle('border-primary-500', isSelected);
                     radio.classList.toggle('dark:border-primary-600', isSelected);
                    radio.classList.toggle('text-primary-500', isSelected);
                     radio.classList.toggle('dark:text-primary-400', isSelected);
                    radio.classList.toggle('font-semibold', isSelected);

                    radio.classList.toggle('bg-white', !isSelected);
                     radio.classList.toggle('dark:bg-gray-800', !isSelected);
                    radio.classList.toggle('border-gray-200', !isSelected);
                     radio.classList.toggle('dark:border-gray-700', !isSelected);
                    radio.classList.toggle('text-gray-800', !isSelected);
                     radio.classList.toggle('dark:text-gray-100', !isSelected);
                    radio.classList.toggle('hover:bg-gray-100', !isSelected);
                     radio.classList.toggle('dark:hover:bg-gray-700', !isSelected);
                    radio.setAttribute('aria-checked', isSelected.toString());
                });
                vibrate(30);
                return; // Prevent checkbox logic from running
            }
            // Checkboxes (like extras)
            const checkboxLabel = e.target.closest('.extra-item[role="checkbox"]');
            if (checkboxLabel) {
                const checkboxInput = checkboxLabel.querySelector('.checkbox'); // The visual div
                if (!checkboxInput) return; // Need the visual checkbox
                const isChecked = checkboxLabel.getAttribute('aria-checked') === 'true';
                const newState = !isChecked;
                checkboxLabel.setAttribute('aria-checked', newState.toString());

                checkboxInput.classList.toggle('bg-primary-500', newState);
                checkboxInput.classList.toggle('border-primary-500', newState);
                checkboxInput.classList.toggle('checked', newState); // Keep track of state with class
                checkboxInput.classList.toggle('dark:border-primary-600', newState);

                checkboxInput.classList.toggle('border-gray-200', !newState);
                checkboxInput.classList.toggle('dark:border-gray-600', !newState);
                checkboxInput.innerHTML = newState ? '<i class="fas fa-check text-white text-xs" aria-hidden="true"></i>' : '';
                vibrate(30);
            }
        });

         // Keyboard activation for modal options
         customizationModal.addEventListener('keydown', (e) => {
             if (e.key === 'Enter' || e.key === ' ') {
                  const radioTarget = e.target.closest('.option-item[role="radio"]');
                   const checkboxLabel = e.target.closest('.extra-item[role="checkbox"]');
                   if(radioTarget || checkboxLabel) {
                        e.preventDefault(); // Prevent default space bar scroll
                        e.target.click(); // Simulate click
                   }
             }
         });
    }


    // Add to Cart from Modal
     if (modalAddToCartBtn) {
        modalAddToCartBtn.addEventListener('click', () => {
            const itemId = modalAddToCartBtn.dataset.itemId;
            const itemName = modalAddToCartBtn.dataset.itemName;
            const itemPrice = parseFloat(modalAddToCartBtn.dataset.itemPrice);

            if (!itemId || !itemName || isNaN(itemPrice)) {
                 console.error("Missing item data on Add to Cart button");
                 showToast("Erreur lors de l'ajout.", "error");
                 return;
             }

            // Gather selected options and notes from modal
            const selectedOptionsData = []; // Store { text: '', price: 0 }
            let extrasTotal = 0;

            customizationModal.querySelectorAll('.option-item.active[role="radio"]').forEach(opt => {
                selectedOptionsData.push({ text: opt.dataset.option || opt.textContent.trim(), price: 0 });
            });
            customizationModal.querySelectorAll('.extra-item[aria-checked="true"]').forEach(opt => {
                 const label = opt.querySelector('.flex span')?.textContent.trim();
                 const priceText = opt.querySelector('.font-semibold')?.textContent.trim();
                 let price = 0;
                 if (priceText && priceText.includes('+')) {
                     price = parseFloat(priceText.replace(/[^0-9,.]/g, '').replace(',', '.')) || 0;
                     extrasTotal += price;
                 }
                 if (label) {
                    selectedOptionsData.push({ text: label, price: price });
                 }
             });
            const notes = customizationModal.querySelector('.notes-field')?.value.trim() || '';

            // Create a unique key for the item based on ID, sorted options text, and notes
             const generateItemKey = (item) => {
                 const optionTexts = item.options.map(o => o.text).sort().join('|');
                 return `${item.id}-${optionTexts}-${item.notes}`;
             };

             const newItemData = {
                 id: itemId,
                 name: itemName,
                 price: itemPrice + extrasTotal, // Base price + extras
                 qty: 1,
                 options: selectedOptionsData, // Array of {text, price}
                 notes: notes,
                 key: '' // Key will be generated now
             };
             newItemData.key = generateItemKey(newItemData); // Generate the key


            const existingItemIndex = currentOrder.findIndex(item => item.key === newItemData.key);

            if (existingItemIndex > -1) {
                currentOrder[existingItemIndex].qty++;
            } else {
                 currentOrder.push(newItemData);
            }

            updateCart();
            closeModal();
            showToast(`${itemName} ajouté`, 'success');
             if (!cartPanel.classList.contains('translate-y-0')) { // Expand cart if collapsed
                 const chevron = cartHeader?.querySelector('.fa-chevron-up');
                 if (cartHeader && chevron) { // Check if elements exist
                    cartPanel.classList.add('translate-y-0');
                    cartPanel.classList.remove('translate-y-[calc(100%-60px)]');
                    cartHeader.setAttribute('aria-expanded', 'true');
                    cartDetails.hidden = false;
                    chevron.style.transform = 'rotate(180deg)';
                 }
             }
            vibrate([30, 50, 30]); // Haptic feedback for success
        });
     }

    // Cart Update & Rendering
    function updateCart() {
         // These elements might not exist if the cart panel is hidden initially or structure changes
         if (!cartTableIdSpan || !cartItemCountSpan || !cartContent || !cartTotalSpan || !cartSubtotalFooterSpan || !cartTaxFooterSpan || !cartGrandTotalFooterSpan || !sendToKitchenBtn || !cancelOrderBtn || !goToPaymentBtn) {
             // console.warn("Cart elements not found, skipping cart update."); // Optional warning
             return;
         }

         const isCartVisible = currentTable !== null && (currentTab === 'orders' || currentTab === 'payment');
         cartPanel.style.display = isCartVisible ? 'flex' : 'none'; // Control visibility here too

         if (!isCartVisible) {
              // Optionally clear spans when cart is hidden
              // cartTableIdSpan.textContent = 'N/A';
              // cartItemCountSpan.textContent = '(0 articles)';
              // cartTotalSpan.textContent = formatCurrency(0);
              // cartSubtotalFooterSpan.textContent = formatCurrency(0);
              // cartTaxFooterSpan.textContent = formatCurrency(0);
              // cartGrandTotalFooterSpan.textContent = formatCurrency(0);
              return; // Don't proceed if cart shouldn't be visible
         }

        const totalItems = currentOrder.reduce((sum, item) => sum + item.qty, 0);
        cartTableIdSpan.textContent = currentTable || 'N/A';
        cartItemCountSpan.textContent = `(${totalItems} article${totalItems !== 1 ? 's' : ''})`; // Pluralize

        cartContent.innerHTML = ''; // Clear previous items

        if (currentOrder.length === 0) {
             // Make sure the empty message exists before trying to append it
             if (cartEmptyMessage && !cartContent.contains(cartEmptyMessage)) {
                 cartContent.appendChild(cartEmptyMessage);
             }
        } else {
             // Make sure the empty message exists before trying to remove it
             if (cartEmptyMessage && cartContent.contains(cartEmptyMessage)) {
                 cartEmptyMessage.remove();
             }
             currentOrder.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex py-4 border-b border-gray-200 gap-2 dark:border-gray-700 cart-item-row'; // Add class for easier selection
                itemElement.dataset.index = index; // Add index to the row itself

                const optionsHtml = item.options.length > 0
                    ? `<div class="text-xs text-gray-500 mb-1 dark:text-gray-400">${item.options.map(o => `${o.text}${o.price > 0 ? ` (+${formatCurrency(o.price)})` : ''}`).join(', ')}</div>` // Show options with prices if any
                    : '';
                const notesHtml = item.notes
                    ? `<div class="text-xs text-gray-500 italic dark:text-gray-400">Note: ${item.notes}</div>`
                    : '';

                itemElement.innerHTML = `
                    <div class="flex-1">
                        <div class="font-semibold mb-0.5 text-gray-800 dark:text-gray-100">${item.name}</div>
                        ${optionsHtml}
                        ${notesHtml}
                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200">${formatCurrency(item.price)} / unité</div>
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="w-8 h-8 bg-gray-100 border-none rounded-full flex items-center justify-center cursor-pointer text-gray-500 text-base transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-gray-200 qty-btn qty-decrease" aria-label="Diminuer quantité de ${item.name}">-</button>
                        <span class="min-w-[30px] text-center font-semibold text-base text-gray-800 dark:text-gray-100 qty-value" aria-live="polite" aria-atomic="true" aria-label="Quantité: ${item.qty}">${item.qty}</span>
                        <button class="w-8 h-8 bg-gray-100 border-none rounded-full flex items-center justify-center cursor-pointer text-gray-500 text-base transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-gray-200 qty-btn qty-increase" aria-label="Augmenter quantité de ${item.name}">+</button>
                    </div>
                `;
                cartContent.appendChild(itemElement);
            });
        }

        // Calculate totals
        const subtotal = currentOrder.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const tax = subtotal * TAX_RATE;
        const total = subtotal + tax;

        cartTotalSpan.textContent = formatCurrency(total);
        cartSubtotalFooterSpan.textContent = formatCurrency(subtotal);
        cartTaxFooterSpan.textContent = formatCurrency(tax);
        cartGrandTotalFooterSpan.textContent = formatCurrency(total);

         // Update payment summary if payment tab is active and elements exist
         const paymentTab = document.getElementById('payment-tab');
         const paymentItemCount = document.querySelector('#payment-tab .cart-item-count');
         const paymentSubtotal = document.querySelector('#payment-tab .cart-subtotal');
         const paymentTax = document.querySelector('#payment-tab .cart-tax');
         const paymentGrandTotal = document.querySelector('#payment-tab .cart-grand-total');
         const paymentTableNum = document.querySelector('#payment-tab .table-number-payment');

         if (paymentTab && !paymentTab.hidden && paymentItemCount && paymentSubtotal && paymentTax && paymentGrandTotal && paymentTableNum) {
            paymentItemCount.textContent = totalItems;
            paymentSubtotal.textContent = formatCurrency(subtotal);
            paymentTax.textContent = formatCurrency(tax);
            paymentGrandTotal.textContent = formatCurrency(total);
            paymentTableNum.textContent = `(Table ${currentTable})`;
         }

         // Enable/disable cart buttons
         const hasItems = currentOrder.length > 0;
         sendToKitchenBtn.disabled = !hasItems;
         cancelOrderBtn.disabled = !hasItems;
         goToPaymentBtn.disabled = !hasItems; // Or based on if order was sent

         const toggleButtonState = (btn, enabled) => {
             if (!btn) return;
             btn.disabled = !enabled;
             btn.classList.toggle('opacity-60', !enabled);
             btn.classList.toggle('cursor-not-allowed', !enabled);
         };

         toggleButtonState(sendToKitchenBtn, hasItems);
         toggleButtonState(cancelOrderBtn, hasItems);
         toggleButtonState(goToPaymentBtn, hasItems);
    }

    // Cart Quantity Adjustment (Event Delegation on cartContent)
    if (cartContent) {
        cartContent.addEventListener('click', (e) => {
            const targetButton = e.target.closest('.qty-btn');
            if (!targetButton) return;

            const itemRow = targetButton.closest('.cart-item-row');
             if (!itemRow) return;

            const index = itemRow.dataset.index;
            if (index === undefined || index === null) return; // Check for null/undefined

            const itemIndex = parseInt(index);
             if(isNaN(itemIndex) || !currentOrder[itemIndex]) {
                 console.error("Invalid item index or item not found:", index);
                 return; // Safety check
             }

            if (targetButton.classList.contains('qty-increase')) {
                currentOrder[itemIndex].qty++;
                 vibrate(30);
            } else if (targetButton.classList.contains('qty-decrease')) {
                currentOrder[itemIndex].qty--;
                if (currentOrder[itemIndex].qty <= 0) {
                    const removedItemName = currentOrder[itemIndex].name;
                    currentOrder.splice(itemIndex, 1); // Remove item if qty is 0 or less
                    showToast(`${removedItemName} supprimé`);
                }
                 vibrate(30);
            }
            updateCart(); // Re-render the cart
        });
    }

    // Cart Expand/Collapse
    if (cartHeader) {
        cartHeader.addEventListener('click', () => {
            const isExpanded = cartPanel.classList.toggle('translate-y-0');
            cartPanel.classList.toggle('translate-y-[calc(100%-60px)]', !isExpanded);
            cartHeader.setAttribute('aria-expanded', isExpanded.toString());
            cartDetails.hidden = !isExpanded; // Toggle visibility of details
            const chevron = cartHeader.querySelector('.fa-chevron-up');
            if (chevron) { // Check if chevron exists
                 chevron.style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    }


     // Cart Actions
     if (cancelOrderBtn) {
        cancelOrderBtn.addEventListener('click', () => {
            if (currentOrder.length > 0 && confirm(`Voulez-vous vraiment vider le panier pour la table ${currentTable} ?`)) {
                currentOrder = [];
                updateCart();
                showToast('Panier vidé', 'warning');
                 vibrate(50);
            }
        });
     }

    if (sendToKitchenBtn) {
        sendToKitchenBtn.addEventListener('click', () => {
             if (currentOrder.length === 0) return;
             // TODO: Implement actual sending logic (API call)
             console.log(`Sending order for Table ${currentTable}:`, JSON.stringify(currentOrder));
             showToast(`Commande pour Table ${currentTable} envoyée !`, 'success');
             // Maybe disable items or show a "sent" status
             // Optionally clear order or mark as sent: currentOrder.forEach(item => item.sent = true); updateCart();
             vibrate([50, 100, 50]);
        });
    }

     if (goToPaymentBtn) {
        goToPaymentBtn.addEventListener('click', () => {
             if (currentOrder.length === 0) {
                 showToast('Le panier est vide.', 'warning');
                 vibrate([50,50]);
                 return;
             }
             // TODO: Add check if order has unsent items? Confirm before proceeding?
            activateTab('payment');
            updateCart(); // Ensure payment summary totals are up-to-date
        });
     }


    // Theme Toggle
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const isDark = body.classList.toggle('dark');
            themeToggleBtn.classList.toggle('active', isDark); // Optional active state styling
            themeToggleBtn.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
            themeToggleBtn.setAttribute('aria-label', isDark ? 'Basculer le thème clair' : 'Basculer le thème sombre');
            try {
                localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
            } catch (e) { console.warn("Could not save dark mode to localStorage", e); }
             vibrate(30);
        });
        // Apply saved theme on load
        try {
            if (localStorage.getItem('dark-mode') === 'true') {
                body.classList.add('dark');
                themeToggleBtn.classList.add('active');
                themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
                themeToggleBtn.setAttribute('aria-label', 'Basculer le thème clair');
            }
        } catch (e) { console.warn("Could not load dark mode from localStorage", e); }
    }

    // Contrast Toggle
    if (contrastToggleBtn) {
        contrastToggleBtn.addEventListener('click', () => {
            const isHighContrast = body.classList.toggle('high-contrast');
            contrastToggleBtn.classList.toggle('active', isHighContrast); // Optional active state styling
             contrastToggleBtn.setAttribute('aria-pressed', isHighContrast.toString());
            try {
                localStorage.setItem('high-contrast', isHighContrast ? 'true' : 'false');
            } catch(e) { console.warn("Could not save high contrast to localStorage", e); }
             vibrate(30);
        });
         // Apply saved contrast on load
         try {
             if (localStorage.getItem('high-contrast') === 'true') {
                body.classList.add('high-contrast');
                contrastToggleBtn.classList.add('active');
                 contrastToggleBtn.setAttribute('aria-pressed', 'true');
            }
         } catch(e) { console.warn("Could not load high contrast from localStorage", e); }
    }


    // --- Payment Logic ---
    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            paymentMethods.forEach(m => {
                const isSelected = m === method;
                 m.classList.toggle('bg-white', !isSelected);
                 m.classList.toggle('dark:bg-gray-800', !isSelected);
                 m.classList.toggle('border-gray-200', !isSelected);
                 m.classList.toggle('dark:border-gray-700', !isSelected);
                 m.classList.toggle('hover:bg-gray-50', !isSelected);
                 m.classList.toggle('dark:hover:bg-gray-700', !isSelected);

                 m.classList.toggle('bg-primary-50', isSelected);
                 m.classList.toggle('dark:bg-primary-900/30', isSelected);
                 m.classList.toggle('border-primary-500', isSelected);
                 m.classList.toggle('dark:border-primary-600', isSelected);

                 const icon = m.querySelector('.text-3xl i'); // Target the icon specifically
                 if (icon) {
                    icon.classList.toggle('text-gray-500', !isSelected);
                    icon.classList.toggle('dark:text-gray-400', !isSelected);
                    icon.classList.toggle('text-primary-500', isSelected);
                    icon.classList.toggle('dark:text-primary-400', isSelected);
                 }

                 const checkIconContainer = m.querySelector('.absolute.top-2.right-2');
                 if (isSelected && !checkIconContainer) {
                    const checkIcon = document.createElement('div');
                    checkIcon.className = 'absolute top-2 right-2 text-primary-500 text-base dark:text-primary-400';
                    checkIcon.innerHTML = '<i class="fas fa-check-circle" aria-hidden="true"></i>';
                    m.appendChild(checkIcon);
                 } else if (!isSelected && checkIconContainer) {
                     checkIconContainer.remove();
                 }

                m.setAttribute('aria-checked', isSelected.toString());
                m.setAttribute('tabindex', isSelected ? '0' : '-1');
            });
            // Show/hide specific payment details based on method.dataset.method
            const showCash = method.dataset.method === 'cash';
             if (cashPaymentDetails) {
                 cashPaymentDetails.style.display = showCash ? 'block' : 'none';
             }

             if(showCash && amountInput) {
                // Reset cash payment state
                currentAmountString = "0";
                amountInput.value = "0,00";
                if(changeAmountSpan) changeAmountSpan.textContent = formatCurrency(0);
                if(billsDisplay) billsDisplay.innerHTML = '';
                if(tipCheckbox) tipCheckbox.checked = false;
                 if(tipAmountSpan) tipAmountSpan.textContent = formatCurrency(0);
                amountInput.focus();
             }
            // Add logic for other payment methods here...
            vibrate(30);
        });
         method.addEventListener('keydown', (e) => {
             if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); method.click(); }
             // Arrow key navigation within the radio group
             if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                 e.preventDefault();
                 const current = Array.from(paymentMethods).findIndex(m => m === e.target);
                 const nextIndex = (current + 1) % paymentMethods.length;
                 paymentMethods[nextIndex].focus();
                 // paymentMethods[nextIndex].click(); // Optionally select on arrow nav
             } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                 e.preventDefault();
                 const current = Array.from(paymentMethods).findIndex(m => m === e.target);
                 const nextIndex = (current - 1 + paymentMethods.length) % paymentMethods.length;
                 paymentMethods[nextIndex].focus();
                  // paymentMethods[nextIndex].click(); // Optionally select on arrow nav
             }
         });
    });

    // Numpad Logic
    let currentAmountString = "0"; // Keep track of cents as string
    numpadKeys.forEach(key => {
        key.addEventListener('click', () => {
             if (!amountInput || !cartGrandTotalFooterSpan || !changeAmountSpan || !tipAmountSpan || !billsDisplay) return; // Safety checks

             const value = key.dataset.key;
             const totalDueText = cartGrandTotalFooterSpan.textContent; // Get total from cart footer
             const totalDue = parseFloat(totalDueText.replace(/[^0-9,.]+/g, "").replace(",", ".")) || 0;

             if (value === 'C') {
                 currentAmountString = "0";
             } else if (value === '00') {
                 if (currentAmountString !== "0" && currentAmountString.length < 10) { // Limit length
                     currentAmountString += "00";
                 }
             } else if (value >= '0' && value <= '9') { // Ensure it's a digit 0-9
                  if (currentAmountString === "0") {
                     currentAmountString = value;
                  } else if (currentAmountString.length < 10) { // Limit length
                     currentAmountString += value;
                 }
             }

             // Handle value as cents, then format
             let amountInCents = parseInt(currentAmountString);
             if(isNaN(amountInCents)) amountInCents = 0;

             const formattedAmount = (amountInCents / 100).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
             amountInput.value = formattedAmount;

              // Calculate and update change
             const change = (amountInCents / 100) - totalDue;
             if (change >= -0.001) { // Allow for tiny floating point errors
                 const positiveChange = Math.max(0, change); // Ensure change is not negative visually
                 changeAmountSpan.textContent = formatCurrency(positiveChange);
                 tipAmountSpan.textContent = formatCurrency(positiveChange); // Update potential tip amount
                 updateBillsDisplay(positiveChange);
             } else {
                  changeAmountSpan.textContent = formatCurrency(0);
                  tipAmountSpan.textContent = formatCurrency(0);
                  billsDisplay.innerHTML = ''; // No change
             }
             vibrate(30);
         });
     });

      // Function to display change breakdown (basic example)
     function updateBillsDisplay(changeAmount) {
         if (!billsDisplay) return; // Safety check
         billsDisplay.innerHTML = ''; // Clear existing
         if (changeAmount <= 0.001) return; // Account for floating point issues

         const denominations = [50, 20, 10, 5, 2, 1, 0.5, 0.2, 0.1, 0.05, 0.02, 0.01];
         let remaining = changeAmount;

         denominations.forEach(denom => {
              // Use a tolerance for floating point comparisons
             if (remaining >= denom - 0.001) {
                 const count = Math.floor((remaining + 0.001) / denom); // Add tolerance before dividing
                 for(let i = 0; i < count; i++) {
                     const billElement = document.createElement('div');
                     if (denom >= 1) {
                         billElement.className = 'py-1 px-2 bg-blue-50 border border-blue-200 rounded text-blue-800 font-semibold text-center min-w-[50px] text-xs sm:text-sm dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700'; // Adjusted padding/size
                     } else {
                         billElement.className = 'w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center font-semibold text-xs text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-700'; // Adjusted size
                     }
                     billElement.textContent = denom >= 0.05 ? formatCurrency(denom).replace(/\s/g,'') : `${Math.round(denom*100)}c`; // Use formatCurrency or cents
                     billElement.setAttribute('aria-label', formatCurrency(denom)); // Improve label
                     billsDisplay.appendChild(billElement);
                 }
                 remaining = parseFloat((remaining - count * denom).toFixed(2)); // Use toFixed for precision
             }
         });
     }

      // Complete Payment
     if (completePaymentBtn) {
        completePaymentBtn.addEventListener('click', () => {
              if (!cartGrandTotalFooterSpan || !amountInput || !receiptItemsContainer) {
                  showToast("Erreur: Éléments de paiement manquants.", "error");
                  return;
              }

              const totalDueText = cartGrandTotalFooterSpan.textContent;
              const totalDue = parseFloat(totalDueText.replace(/[^0-9,.]+/g, "").replace(",", ".")) || 0;
              const amountPaidText = amountInput.value;
              const amountPaid = parseFloat(amountPaidText.replace(/[^0-9,.]+/g, "").replace(",", ".")) || 0;
              const selectedMethodElement = document.querySelector('#payment-tab .payment-method[aria-checked="true"]');
              const paymentMethod = selectedMethodElement ? selectedMethodElement.dataset.method : 'unknown';
              const paymentMethodText = selectedMethodElement ? selectedMethodElement.querySelector('.font-semibold')?.textContent.trim() : 'Inconnu';
              let changeGiven = 0;

              if (paymentMethod === 'cash') {
                  if (amountPaid < totalDue - 0.001) { // Tolerance for float comparison
                      showToast('Montant payé insuffisant!', 'error');
                      vibrate([100, 50, 100]); // Error vibration
                      amountInput.focus();
                      return;
                  }
                  changeGiven = Math.max(0, amountPaid - totalDue); // Ensure change is not negative
              } else if (paymentMethod === 'card' || paymentMethod === 'mobile') {
                  // For card/mobile, assume exact amount is paid unless splitting
                  // Here, we assume the exact amount is processed externally if these methods are chosen.
                  if (amountPaid < totalDue - 0.001 && amountInput.value !== "0,00") {
                     // If user manually entered an insufficient amount for non-cash, warn them? Optional.
                     // showToast(`Le montant pour ${paymentMethodText} doit être ${formatCurrency(totalDue)}.`, 'warning');
                     // return;
                  }
                   // For simplicity, record totalDue as amountPaid for these methods
                   changeGiven = 0;
                   // You might want to clear or ignore amountInput for these methods.
              } else if (paymentMethod === 'split') {
                  // TODO: Implement split payment logic
                  showToast('Le paiement partagé n\'est pas encore implémenté.', 'info');
                  return;
              } else {
                  showToast('Veuillez sélectionner un mode de paiement.', 'warning');
                  return;
              }

              const finalAmountPaid = (paymentMethod === 'cash') ? amountPaid : totalDue; // Use totalDue for non-cash simple case


              // --- Record Payment ---
              // TODO: Send data to backend/localStorage
              console.log(`Payment Recorded: Table ${currentTable}, Method: ${paymentMethod}, Total: ${formatCurrency(totalDue)}, Paid: ${formatCurrency(finalAmountPaid)}, Change: ${formatCurrency(changeGiven)}`);
              const orderDetailsForReceipt = [...currentOrder]; // Copy order before clearing
              const paidTableId = currentTable; // Store before clearing


              // --- Update Receipt Tab Content ---
              const receiptTabElement = document.getElementById('receipt-tab');
              if (receiptTabElement) {
                  // Update Receipt Header
                  receiptTabElement.querySelectorAll('.receipt-table-num').forEach(el => el.textContent = paidTableId); // Update both instances
                  receiptTabElement.querySelector('.receipt-datetime').textContent = new Date().toLocaleString('fr-FR', { dateStyle: 'short', timeStyle: 'medium' }); // Current time, nicer format
                  // Update Receipt Items
                  receiptItemsContainer.innerHTML = ''; // Clear old items
                  orderDetailsForReceipt.forEach(item => {
                      const receiptItemEl = document.createElement('div');
                      receiptItemEl.className = 'grid grid-cols-[30px_1fr_auto] gap-x-2 gap-y-1 mb-1 items-start'; // Adjusted gaps

                      const optionsText = item.options.length > 0
                          ? ` <span class="text-xs text-gray-500 dark:text-gray-400">(${item.options.map(o => o.text).join(', ')})</span>` // Simpler options text
                          : '';
                      const notesText = item.notes
                          ? `<div class="col-start-2 text-xs text-gray-500 italic dark:text-gray-400">Note: ${item.notes}</div>` // Notes on new line, spanning cols
                          : '';

                      receiptItemEl.innerHTML = `
                          <div class="text-right text-gray-500 dark:text-gray-400">${item.qty}x</div>
                          <div class="text-gray-800 dark:text-gray-100">${item.name}${optionsText}</div>
                          <div class="text-right font-medium text-gray-800 dark:text-gray-100">${formatCurrency(item.price * item.qty)}</div>
                          ${notesText}
                      `;
                      receiptItemsContainer.appendChild(receiptItemEl);
                  });
                  // Update Receipt Totals
                  const subtotal = orderDetailsForReceipt.reduce((sum, item) => sum + (item.price * item.qty), 0);
                  const tax = subtotal * TAX_RATE;
                  receiptTabElement.querySelector('.receipt-subtotal-val').textContent = formatCurrency(subtotal);
                  receiptTabElement.querySelector('.receipt-tax-val').textContent = formatCurrency(tax);
                  receiptTabElement.querySelector('.receipt-total-val').textContent = formatCurrency(totalDue);
                  // Update Payment Details on Receipt
                  const paymentDetailsElements = receiptTabElement.querySelectorAll('.receipt-payment-details'); // Should target specific elements if structure is complex
                  const paidLine = receiptTabElement.querySelector('.receipt-paid-val')?.closest('.grid');
                  const changeLine = receiptTabElement.querySelector('.receipt-change-val')?.closest('.grid');

                  if(paidLine){
                      paidLine.querySelector('.text-gray-500').textContent = `Payé (${paymentMethodText}):`;
                      paidLine.querySelector('.receipt-paid-val').textContent = formatCurrency(finalAmountPaid);
                      paidLine.style.display = 'grid';
                  }
                  if(changeLine){
                      if (paymentMethod === 'cash' && changeGiven > 0.001) {
                         changeLine.querySelector('.text-gray-500').textContent = 'Rendu:';
                         changeLine.querySelector('.receipt-change-val').textContent = formatCurrency(changeGiven);
                         changeLine.style.display = 'grid';
                      } else {
                          changeLine.style.display = 'none'; // Hide change line if not cash or no change
                      }
                  }
                  // Ensure Success Panel is visible
                  if (paymentSuccessPanel) paymentSuccessPanel.hidden = false;

              } else {
                   console.error("Receipt tab element not found.");
              }
              // --- End Update Receipt Tab ---


              activateTab('receipt'); // Show the receipt
              showToast(`Paiement pour Table ${paidTableId} enregistré`, 'success');
              vibrate([50, 100, 50]);

              // Mark table as free (find based on paidTableId)
              const tableElement = document.querySelector(`#tables-tab div[data-table="${paidTableId}"]`);
              if(tableElement) {
                  tableElement.classList.remove('border-danger-500', 'border-warning-500', 'animate-pulse-danger');
                  tableElement.classList.add('border-secondary-500');
                  const timeDisplay = tableElement.querySelector('.text-xs.font-semibold');
                  if (timeDisplay) timeDisplay.remove(); // Remove time display
                  const capacityElement = tableElement.querySelector('.text-xs.text-gray-500 i.fa-users');
                  const capacity = capacityElement ? capacityElement.parentElement.textContent.replace(/.*?(\d+).*/, '$1') : '?';
                  tableElement.setAttribute('aria-label', `Table ${paidTableId}, ${capacity} personnes, Libre`);
              }

              // --- Clear State & Reset ---
              currentTable = null;
              currentOrder = [];
              updateCart(); // This will hide the cart panel as currentTable is null
              updateOrderHeader(); // Clear order header

              // Reset payment tab state to default (e.g., Cash selected)
              paymentMethods.forEach((m, index) => {
                  const isDefault = index === 0; // Assuming first is default
                  m.setAttribute('aria-checked', isDefault.toString());
                  m.setAttribute('tabindex', isDefault ? '0' : '-1');
                  // Reset visual state (could refactor with the selection logic)
                  m.classList.toggle('bg-white', !isDefault);
                  m.classList.toggle('dark:bg-gray-800', !isDefault);
                  m.classList.toggle('border-gray-200', !isDefault);
                  m.classList.toggle('dark:border-gray-700', !isDefault);
                  m.classList.toggle('hover:bg-gray-50', !isDefault);
                  m.classList.toggle('dark:hover:bg-gray-700', !isDefault);
                  m.classList.toggle('bg-primary-50', isDefault);
                  m.classList.toggle('dark:bg-primary-900/30', isDefault);
                  m.classList.toggle('border-primary-500', isDefault);
                  m.classList.toggle('dark:border-primary-600', isDefault);
                  const icon = m.querySelector('.text-3xl i');
                   if (icon) {
                      icon.classList.toggle('text-gray-500', !isDefault);
                      icon.classList.toggle('dark:text-gray-400', !isDefault);
                      icon.classList.toggle('text-primary-500', isDefault);
                      icon.classList.toggle('dark:text-primary-400', isDefault);
                   }
                  const checkIconContainer = m.querySelector('.absolute.top-2.right-2');
                   if (isDefault && !checkIconContainer) {
                      const checkIcon = document.createElement('div');
                      checkIcon.className = 'absolute top-2 right-2 text-primary-500 text-base dark:text-primary-400';
                      checkIcon.innerHTML = '<i class="fas fa-check-circle" aria-hidden="true"></i>';
                      m.appendChild(checkIcon);
                   } else if (!isDefault && checkIconContainer) {
                       checkIconContainer.remove();
                   }
              });

              if (cashPaymentDetails) cashPaymentDetails.style.display = 'block'; // Show cash by default
              if (amountInput) amountInput.value = '0,00';
              if (changeAmountSpan) changeAmountSpan.textContent = formatCurrency(0);
              if (billsDisplay) billsDisplay.innerHTML = '';
              if (tipCheckbox) tipCheckbox.checked = false;
               if (tipAmountSpan) tipAmountSpan.textContent = formatCurrency(0);

         });
     }

      // Back to tables from Receipt
      if (backToTablesReceiptBtn) {
         backToTablesReceiptBtn.addEventListener('click', () => {
             activateTab('tables');
             // Optionally hide success panel when leaving receipt tab
             if (paymentSuccessPanel) paymentSuccessPanel.hidden = true;
         });
      }
      if (cleanTableBtn) {
         cleanTableBtn.addEventListener('click', () => {
              // TODO: Logic to mark table as cleaned/ready in backend/state
             showToast(`Table marquée comme nettoyée`, 'info');
             // Optionally change table appearance further (e.g., remove border color temporarily)
             activateTab('tables');
              // Optionally hide success panel
              if (paymentSuccessPanel) paymentSuccessPanel.hidden = true;
         });
      }


     // --- Other Initializations ---
     activateTab('tables'); // Start on tables tab
     updateCart(); // Initialize cart state (will be hidden initially)
     updateCartVisibility(); // Ensure cart visibility is correct on load

      // Filter/Search (Basic examples - requires menu items to have category data)
      if (searchInput) {
         searchInput.addEventListener('input', () => {
             filterMenuItems();
         });
      }

     if (voiceBtn) {
         voiceBtn.addEventListener('click', () => {
             showToast('Fonction recherche vocale non implémentée');
             vibrate(100);
             // TODO: Implement Speech Recognition API if needed
         });
     }

     categoryTabs.forEach(catTab => {
         catTab.addEventListener('click', () => {
             categoryTabs.forEach(t => {
                 const isSelected = t === catTab;
                 // Reset styles
                 t.classList.remove('bg-primary-50', 'text-primary-500', 'border-primary-500', 'dark:bg-primary-900/30', 'dark:text-primary-400', 'dark:border-primary-600');
                 t.classList.add('bg-gray-100', 'text-gray-500', 'border-transparent', 'hover:bg-gray-200', 'hover:text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-400', 'dark:hover:bg-gray-700', 'dark:hover:text-gray-200');
                 // Apply selected styles
                 if (isSelected) {
                     t.classList.add('bg-primary-50', 'text-primary-500', 'border-primary-500', 'dark:bg-primary-900/30', 'dark:text-primary-400', 'dark:border-primary-600');
                     t.classList.remove('bg-gray-100', 'text-gray-500', 'border-transparent', 'hover:bg-gray-200', 'hover:text-gray-800', 'dark:bg-gray-800', 'dark:text-gray-400', 'dark:hover:bg-gray-700', 'dark:hover:text-gray-200');
                 }
                 t.setAttribute('aria-selected', isSelected.toString());
              });
              const category = catTab.textContent.trim();
              // showToast(`Filtre: ${category}`); // Optional feedback
              vibrate(30);
              filterMenuItems(); // Re-filter based on new category + existing search term
          });
          catTab.addEventListener('keydown', (e) => {
               if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); catTab.click(); }
               // Arrow key navigation
               if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    const current = Array.from(categoryTabs).findIndex(t => t === e.target);
                    const nextIndex = (current + 1) % categoryTabs.length;
                    categoryTabs[nextIndex].focus();
                    // categoryTabs[nextIndex].click(); // Optional select on arrow
               } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const current = Array.from(categoryTabs).findIndex(t => t === e.target);
                    const nextIndex = (current - 1 + categoryTabs.length) % categoryTabs.length;
                    categoryTabs[nextIndex].focus();
                     // categoryTabs[nextIndex].click(); // Optional select on arrow
               }
          });
      });

     function filterMenuItems() {
         const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
         const activeCategoryElement = document.querySelector('#orders-tab div[role="tablist"][aria-label="Filtrer par catégorie"] button[aria-selected="true"]');
         const activeCategory = activeCategoryElement ? activeCategoryElement.textContent.trim() : 'Tous';

         menuItems.forEach(item => {
              const name = (item.dataset.name || '').toLowerCase();
              // Placeholder: Assume items have a 'data-category' attribute
              const itemCategory = item.dataset.category || 'Inconnu';

              const categoryMatch = (activeCategory === 'Tous' || itemCategory === activeCategory);
              const searchMatch = name.includes(searchTerm);

              item.style.display = (categoryMatch && searchMatch) ? 'flex' : 'none';
          });
     }

}); 