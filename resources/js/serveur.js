document.addEventListener('DOMContentLoaded', function() {

    const body = document.body;
    const datetimeElement = document.querySelector('.datetime');
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');
    const bottomNavItems = document.querySelectorAll('.bottom-nav-item');
    const tableItems = document.querySelectorAll('.table-item');
    const backToTablesBtn = document.getElementById('back-to-tables');
    const menuItems = document.querySelectorAll('.menu-item');
    const customizationOverlay = document.getElementById('customization-overlay');
    const customizationModal = document.getElementById('customization-modal');
    const modalCloseBtn = customizationModal.querySelector('.modal-close');
    const modalCancelBtn = customizationModal.querySelector('.modal-cancel-btn');
    const modalAddToCartBtn = customizationModal.querySelector('.add-to-cart-btn');
    const modalTitle = customizationModal.querySelector('.modal-title');
    const modalBody = customizationModal.querySelector('.modal-body');
    const cartPanel = document.getElementById('cart-panel');
    const cartHeader = cartPanel.querySelector('.cart-header');
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
    const searchInput = document.querySelector('.search-input');
    const voiceBtn = document.querySelector('.voice-btn');
    const categoryTabs = document.querySelectorAll('.categories .category');
    const paymentMethods = document.querySelectorAll('.payment-method');
    const cashPaymentDetails = document.querySelector('.cash-payment-details');
    const amountInput = document.querySelector('.amount-input');
    const numpadKeys = document.querySelectorAll('.numpad .numkey');
    const changeAmountSpan = document.querySelector('.change-amount');
    const billsDisplay = document.querySelector('.bills-display');
    const tipCheckbox = document.getElementById('round-tip');
    const tipAmountSpan = document.querySelector('.tip-amount');
    const completePaymentBtn = document.getElementById('complete-payment');
    const backToTablesReceiptBtn = document.getElementById('back-to-tables-btn');
    const cleanTableBtn = document.getElementById('clean-table-btn');
    
    // Ajouter le sélecteur de restaurant
    const restaurantSelect = document.getElementById('restaurant-select');


    let currentTable = null;
    let currentOrder = [];
    let currentTab = 'tables';
    const TAX_RATE = 0.10;

    // Gestion de la sélection de restaurant
    if (restaurantSelect) {
        restaurantSelect.addEventListener('change', function() {
            // Créer un formulaire pour soumettre le restaurant sélectionné
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/serveur/select-restaurant'; // Route pour traiter la sélection
            form.style.display = 'none';
            
            // Ajouter le CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            // Ajouter l'ID du restaurant
            const restaurantInput = document.createElement('input');
            restaurantInput.type = 'hidden';
            restaurantInput.name = 'restaurant_id';
            restaurantInput.value = this.value;
            form.appendChild(restaurantInput);
            
            // Ajouter le formulaire au document et le soumettre
            document.body.appendChild(form);
            form.submit();
        });
    }

    const formatCurrency = (value) => {

        const numberValue = Number(value);
         if (isNaN(numberValue)) {
             console.error("Invalid value passed to formatCurrency:", value);
             return "0,00 €";
         }
        return numberValue.toLocaleString('fr-FR', { style: 'currency', currency: 'EUR' });
    };

    const showToast = (message, type = 'info', duration = 3000) => {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.setAttribute('role', 'status');
        let iconClass = 'fa-info-circle';
        if (type === 'success') iconClass = 'fa-check-circle';
        if (type === 'error') iconClass = 'fa-exclamation-triangle';

        toast.innerHTML = `<i class="fas ${iconClass}" aria-hidden="true"></i> ${message}`;
        toastContainer.appendChild(toast);


        setTimeout(() => {
            toast.classList.add('show');
        }, 10);


        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                 if (toast.parentNode === toastContainer) {
                     toast.remove();
                 }
            }, 300);
        }, duration);
    };

     const vibrate = (pattern) => {
        if ('vibrate' in navigator) {
            try {
                navigator.vibrate(pattern);
            } catch (e) {
                console.warn("Haptic feedback failed:", e);
            }
        }
    };




    function updateDateTime() {
        if (datetimeElement) {
            const now = new Date();

            const pad = (n) => n.toString().padStart(2, '0');
            const formattedDate = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
            datetimeElement.textContent = formattedDate;


             const receiptTime = document.querySelector('.receipt-datetime');
             const receiptTab = document.getElementById('receipt-tab');
             if(receiptTime && receiptTab && !receiptTab.hidden) {
                 receiptTime.textContent = formattedDate;
             }
        }
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);



    function activateTab(tabId) {
        currentTab = tabId;

        tabs.forEach(tab => {
            const isSelected = tab.getAttribute('data-tab') === tabId;
            tab.setAttribute('aria-selected', isSelected);
            tab.setAttribute('tabindex', isSelected ? '0' : '-1');
            tab.classList.toggle('active', isSelected);
        });

        bottomNavItems.forEach(item => {
            const isSelected = item.getAttribute('data-tab') === tabId;
            item.setAttribute('aria-selected', isSelected);
            item.setAttribute('tabindex', isSelected ? '0' : '-1');
             item.classList.toggle('active', isSelected);
        });

        tabContents.forEach(content => {
            const contentId = content.id.replace('-tab', '');
            const isHidden = contentId !== tabId;
            content.hidden = isHidden;

        });


         const cartVisible = (tabId === 'orders' || tabId === 'payment') && currentTable !== null;
         cartPanel.style.display = cartVisible ? 'flex' : 'none';


         const newTabContent = document.getElementById(`${tabId}-tab`);
         if(newTabContent && !newTabContent.hidden) {
             const firstFocusable = newTabContent.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
             if(firstFocusable) {

             }
         }
    }

    tabs.forEach(tab => tab.addEventListener('click', () => activateTab(tab.getAttribute('data-tab'))));
    bottomNavItems.forEach(item => item.addEventListener('click', (e) => {
        e.preventDefault();
        activateTab(item.getAttribute('data-tab'));
    }));



    tableItems.forEach(table => {
        table.addEventListener('click', () => {

            currentTable = table.getAttribute('data-table');


            currentOrder = [];
            updateOrderHeader();
            updateCart();
            activateTab('orders');
            showToast(`Table ${currentTable} sélectionnée`);
            vibrate(50);
        });

         table.addEventListener('keydown', (e) => {
             if (e.key === 'Enter' || e.key === ' ') {
                 e.preventDefault();
                 table.click();
             }
         });
    });

     function updateOrderHeader() {
        const orderHeaderNum = document.querySelector('.table-number-info');
        const orderHeaderMeta = document.querySelector('.table-meta');
        if (currentTable !== null) {
            const tableElement = document.querySelector(`.table-item[data-table="${currentTable}"]`);
            const capacityElement = tableElement?.querySelector('.table-capacity');
            const timeElement = tableElement?.querySelector('.table-time');
            const capacity = capacityElement?.textContent.replace('<i class="fas fa-users" aria-hidden="true"></i>','').trim() || '?';
            const time = timeElement?.textContent.replace(/<i.*?><\/i>\s*/, '').trim() || '';
            const status = tableElement?.classList.contains('table-free') ? 'Libre' :
                           tableElement?.classList.contains('table-occupied') ? 'Occupée' :
                           tableElement?.classList.contains('table-reserved') ? 'Réservée' : '';
            const timeIconClass = status === 'Réservée' ? 'fas fa-calendar-alt' : 'fas fa-clock';


            orderHeaderNum.textContent = `Table ${currentTable}`;
            let metaHTML = `<span><i class="fas fa-users" aria-hidden="true"></i> ${capacity} pers.</span>`;
            if (time) metaHTML += `<span><i class="${timeIconClass}" aria-hidden="true"></i> ${time}</span>`;
            metaHTML += `<span class="history-link"><i class="fas fa-history" aria-hidden="true"></i> Historique</span>`;
            orderHeaderMeta.innerHTML = metaHTML;
        } else {
            orderHeaderNum.textContent = 'Sélectionner une table';
            orderHeaderMeta.innerHTML = '';
        }
    }

    backToTablesBtn.addEventListener('click', () => activateTab('tables'));



    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            if (currentTable === null) {
                showToast('Veuillez d\'abord sélectionner une table.', 'info', 'custom-background');
                return;
            }
            const itemId = item.dataset.id;
            const itemName = item.dataset.name;
            const itemPrice = parseFloat(item.dataset.price);


            modalTitle.textContent = itemName;


             customizationModal.querySelectorAll('.option-item.active').forEach(el => el.classList.remove('active'));
             customizationModal.querySelectorAll('.extra-item[aria-checked="true"]').forEach(el => {
                el.setAttribute('aria-checked', 'false');
                el.querySelector('.checkbox').classList.remove('checked');
             });
            customizationModal.querySelector('.notes-field').value = '';



            modalAddToCartBtn.dataset.itemId = itemId;
            modalAddToCartBtn.dataset.itemName = itemName;
            modalAddToCartBtn.dataset.itemPrice = itemPrice;

            customizationOverlay.classList.add('active');
            customizationModal.classList.add('active');
            customizationModal.querySelector('button, input, textarea, select, [role="radio"], [role="checkbox"]')?.focus();
            vibrate(50);
        });

         item.addEventListener('keydown', (e) => {
             if (e.key === 'Enter' || e.key === ' ') {
                 e.preventDefault();
                 item.click();
             }
         });
    });


    const closeModal = () => {
        customizationOverlay.classList.remove('active');
        customizationModal.classList.remove('active');

    };
    modalCloseBtn.addEventListener('click', closeModal);
    modalCancelBtn.addEventListener('click', closeModal);
    customizationOverlay.addEventListener('click', (e) => {
        if (e.target === customizationOverlay) {
            closeModal();
        }
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && customizationOverlay.classList.contains('active')) {
            closeModal();
        }
    });


    customizationModal.addEventListener('click', (e) => {

        const radioTarget = e.target.closest('.option-item[role="radio"]');
        if (radioTarget) {
            const group = radioTarget.closest('.option-grid');
            group.querySelectorAll('.option-item[role="radio"]').forEach(radio => {
                const isSelected = radio === radioTarget;
                radio.classList.toggle('active', isSelected);
                radio.setAttribute('aria-checked', isSelected);
            });
             vibrate(30);
             return;
        }

        const checkboxLabel = e.target.closest('.extra-item[role="checkbox"]');
        if (checkboxLabel) {
            const checkboxInput = checkboxLabel.querySelector('.checkbox');
            const isChecked = checkboxLabel.getAttribute('aria-checked') === 'true';
            checkboxLabel.setAttribute('aria-checked', !isChecked);
            checkboxInput.classList.toggle('checked', !isChecked);
            vibrate(30);
        }
    });

     customizationModal.addEventListener('keydown', (e) => {
         if (e.key === 'Enter' || e.key === ' ') {
              const radioTarget = e.target.closest('.option-item[role="radio"]');
               const checkboxLabel = e.target.closest('.extra-item[role="checkbox"]');
               if(radioTarget || checkboxLabel) {
                    e.preventDefault();
                    e.target.click();
               }
         }
     });



    modalAddToCartBtn.addEventListener('click', () => {
        const itemId = modalAddToCartBtn.dataset.itemId;
        const itemName = modalAddToCartBtn.dataset.itemName;
        const itemPrice = parseFloat(modalAddToCartBtn.dataset.itemPrice);


        const selectedOptions = [];
        customizationModal.querySelectorAll('.option-item.active[role="radio"]').forEach(opt => selectedOptions.push(opt.dataset.option));
        customizationModal.querySelectorAll('.extra-item[aria-checked="true"]').forEach(opt => {
            const label = opt.querySelector('.extra-label span').textContent;
            const priceText = opt.querySelector('.extra-price').textContent;
            selectedOptions.push(label + (priceText ? ` (${priceText})` : ''));

        });
        const notes = customizationModal.querySelector('.notes-field').value.trim();


         const generateItemKey = (item) => `${item.id}-${JSON.stringify(item.options.sort())}-${item.notes}`;
         const newItemKey = generateItemKey({ id: itemId, options: selectedOptions, notes: notes });

        const existingItemIndex = currentOrder.findIndex(item => generateItemKey(item) === newItemKey);

        if (existingItemIndex > -1) {
            currentOrder[existingItemIndex].qty++;
        } else {
             currentOrder.push({
                id: itemId,
                name: itemName,
                price: itemPrice,
                qty: 1,
                options: selectedOptions,
                notes: notes
            });
        }

        updateCart();
        closeModal();
        showToast(`${itemName} ajouté`, 'success');
         if (!cartPanel.classList.contains('expanded')) {
             cartHeader.click();
         }
        vibrate([30, 50, 30]);
    });


    function updateCart() {
        if (currentTable === null) {
            cartPanel.style.display = 'none';
            return;
        }
        cartPanel.style.display = 'flex';

        const totalItems = currentOrder.reduce((sum, item) => sum + item.qty, 0);
        cartTableIdSpan.textContent = currentTable || 'N/A';
        cartItemCountSpan.textContent = `(${totalItems} article${totalItems !== 1 ? 's' : ''})`;

        cartContent.innerHTML = '';

        if (currentOrder.length === 0) {
             if (!cartContent.contains(cartEmptyMessage)) {
                cartContent.appendChild(cartEmptyMessage);
             }
        } else {
             if(cartContent.contains(cartEmptyMessage)) {
                 cartEmptyMessage.remove();
             }
             currentOrder.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'cart-item';
                itemElement.innerHTML = `
                    <div class="cart-item-details">
                        <div class="cart-item-title">${item.name}</div>
                        ${item.options.length > 0 ? `<div class="cart-item-options">${item.options.map(o => o.replace(/ \([^)]*\)/, '')).join(', ')}</div>` : ''}
                        ${item.notes ? `<div class="cart-item-options" style="font-style: italic;">Note: ${item.notes}</div>` : ''}
                        <div class="cart-item-price">${formatCurrency(item.price)}</div>
                    </div>
                    <div class="cart-item-actions">
                        <button class="qty-btn qty-decrease" data-index="${index}" aria-label="Diminuer quantité de ${item.name}">-</button>
                        <span class="qty-value" aria-live="polite" aria-atomic="true" aria-label="Quantité: ${item.qty}">${item.qty}</span>
                        <button class="qty-btn qty-increase" data-index="${index}" aria-label="Augmenter quantité de ${item.name}">+</button>
                    </div>
                `;
                cartContent.appendChild(itemElement);
            });
        }


        const subtotal = currentOrder.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const tax = subtotal * TAX_RATE;
        const total = subtotal + tax;

        cartTotalSpan.textContent = formatCurrency(total);
        cartSubtotalFooterSpan.textContent = formatCurrency(subtotal);
        cartTaxFooterSpan.textContent = formatCurrency(tax);
        cartGrandTotalFooterSpan.textContent = formatCurrency(total);


         const paymentTab = document.getElementById('payment-tab');
         if (paymentTab && !paymentTab.hidden) {
            document.querySelector('.cart-item-count').textContent = totalItems;
            document.querySelector('.cart-subtotal').textContent = formatCurrency(subtotal);
            document.querySelector('.cart-tax').textContent = formatCurrency(tax);
            document.querySelector('.cart-grand-total').textContent = formatCurrency(total);
            document.querySelector('.table-number-payment').textContent = `(Table ${currentTable})`;
         }


         const hasItems = currentOrder.length > 0;
         sendToKitchenBtn.disabled = !hasItems;
         cancelOrderBtn.disabled = !hasItems;
         goToPaymentBtn.disabled = !hasItems;
    }


    cartContent.addEventListener('click', (e) => {
        const targetButton = e.target.closest('.qty-btn');
        if (!targetButton) return;

        const index = targetButton.dataset.index;
        if (index === undefined) return;

        const itemIndex = parseInt(index);
         if(isNaN(itemIndex) || !currentOrder[itemIndex]) return;

        if (targetButton.classList.contains('qty-increase')) {
            currentOrder[itemIndex].qty++;
             vibrate(30);
        } else if (targetButton.classList.contains('qty-decrease')) {
            currentOrder[itemIndex].qty--;
            if (currentOrder[itemIndex].qty <= 0) {
                const removedItemName = currentOrder[itemIndex].name;
                currentOrder.splice(itemIndex, 1);
                showToast(`${removedItemName} supprimé`);
            }
             vibrate(30);
        }
        updateCart();
    });


    cartHeader.addEventListener('click', () => {
        const isExpanded = cartPanel.classList.toggle('expanded');
        cartHeader.setAttribute('aria-expanded', isExpanded);
         cartDetails.hidden = !isExpanded;
         cartHeader.querySelector('.fa-chevron-up').style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
    });



    cancelOrderBtn.addEventListener('click', () => {
        if (currentOrder.length > 0 && confirm(`Voulez-vous vraiment vider le panier pour la table ${currentTable} ?`)) {
            currentOrder = [];
            updateCart();
            showToast('Panier vidé', 'warning');
             vibrate(50);
        }
    });

    sendToKitchenBtn.addEventListener('click', (e) => {
        if (currentOrder.length === 0) return;
        
        // The form will be submitted, which triggers our event handler above
        orderForm.dispatchEvent(new Event('submit'));
    });

     goToPaymentBtn.addEventListener('click', () => {
         if (currentOrder.length === 0) {
             showToast('Le panier est vide.', 'warning');
             return;
         }
        activateTab('payment');
        updateCart();
        document.getElementById('cart-panel').style.display = 'none';

    });



    themeToggleBtn.addEventListener('click', () => {
        const isDark = body.classList.toggle('dark-mode');
        themeToggleBtn.classList.toggle('active', isDark);
        themeToggleBtn.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        themeToggleBtn.setAttribute('aria-label', isDark ? 'Basculer le thème clair' : 'Basculer le thème sombre');
        localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
         vibrate(30);
    });
    if (localStorage.getItem('dark-mode') === 'true') {
        body.classList.add('dark-mode');
        themeToggleBtn.classList.add('active');
        themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
        themeToggleBtn.setAttribute('aria-label', 'Basculer le thème clair');
    }


    document.addEventListener('DOMContentLoaded', () => {
        const contrastToggleBtn = document.querySelector('#contrast-toggle'); // or '.contrast-toggle'
        const body = document.body;
    
        if (contrastToggleBtn) {
            contrastToggleBtn.addEventListener('click', () => {
                const isHighContrast = body.classList.toggle('high-contrast');
                contrastToggleBtn.classList.toggle('active', isHighContrast);
                contrastToggleBtn.setAttribute('aria-pressed', isHighContrast);
                localStorage.setItem('high-contrast', isHighContrast ? 'true' : 'false');
                vibrate(30);
            });
    
            const storedContrast = localStorage.getItem('high-contrast') === 'true';
            if (storedContrast) {
                body.classList.add('high-contrast');
                contrastToggleBtn.classList.add('active');
                contrastToggleBtn.setAttribute('aria-pressed', 'true');
            }
        } else {
            console.warn('contrastToggleBtn element not found');
        }
    });
    
     if (localStorage.getItem('high-contrast') === 'true') {
        body.classList.add('high-contrast');
        contrastToggleBtn.classList.add('active');
         contrastToggleBtn.setAttribute('aria-pressed', 'true');
    }



    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            paymentMethods.forEach(m => {
                const isSelected = m === method;
                m.classList.toggle('active', isSelected);
                m.setAttribute('aria-checked', isSelected);
                m.setAttribute('tabindex', isSelected ? '0' : '-1');
            });

            const showCash = method.dataset.method === 'cash';
            cashPaymentDetails.style.display = showCash ? 'block' : 'none';
             if(showCash) {

                currentAmountString = "0";
                amountInput.value = "0,00";
                changeAmountSpan.textContent = "0,00 €";
                billsDisplay.innerHTML = '';
                tipCheckbox.checked = false;
                amountInput.focus();
             }

            vibrate(30);
        });
         method.addEventListener('keydown', (e) => {
             if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); method.click(); }

             if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                 const current = paymentMethods.findIndex(m => m === e.target);
                 const nextIndex = e.key === 'ArrowRight' ? (current + 1) % paymentMethods.length : (current - 1 + paymentMethods.length) % paymentMethods.length;
                 paymentMethods[nextIndex].focus();
                 paymentMethods[nextIndex].click();
             }
         });
    });


    let currentAmountString = "0";
    numpadKeys.forEach(key => {
        key.addEventListener('click', () => {
            const value = key.dataset.key;
             const totalDueText = cartGrandTotalFooterSpan.textContent;
             const totalDue = parseFloat(totalDueText.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;

            if (value === 'C') {
                currentAmountString = "0";
            } else if (value === '00') {
                if (currentAmountString !== "0" && currentAmountString.length < 10) {
                    currentAmountString += "00";
                }
            } else {
                 if (currentAmountString === "0") {
                    currentAmountString = value;
                 } else if (currentAmountString.length < 10) {
                    currentAmountString += value;
                }
            }


            let amountInCents = parseInt(currentAmountString);
            if(isNaN(amountInCents)) amountInCents = 0;

            const formattedAmount = (amountInCents / 100).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            amountInput.value = formattedAmount;


            const change = (amountInCents / 100) - totalDue;
            if (change >= 0) {
                changeAmountSpan.textContent = formatCurrency(change);
                tipAmountSpan.textContent = formatCurrency(change);
                updateBillsDisplay(change);
            } else {
                 changeAmountSpan.textContent = formatCurrency(0);
                 tipAmountSpan.textContent = formatCurrency(0);
                 billsDisplay.innerHTML = '';
            }
            vibrate(30);
        });
    });


    function updateBillsDisplay(changeAmount) {
        billsDisplay.innerHTML = '';
        if (changeAmount <= 0.001) return;

        const denominations = [50, 20, 10, 5, 2, 1, 0.5, 0.2, 0.1, 0.05, 0.02, 0.01];
        let remaining = changeAmount;

        denominations.forEach(denom => {

            if (remaining >= denom - 0.001) {
                const count = Math.floor(remaining / denom + 0.001);
                for(let i = 0; i < count; i++) {
                    const billElement = document.createElement('div');
                    billElement.className = denom >= 1 ? 'bill' : 'coin';
                    billElement.textContent = denom >= 0.05 ? formatCurrency(denom).replace(/\s/g,'') : `${Math.round(denom*100)}c`;
                     billElement.setAttribute('aria-label', formatCurrency(denom));
                    billsDisplay.appendChild(billElement);
                }
                remaining = parseFloat((remaining - count * denom).toFixed(2));
            }
        });
    }


    completePaymentBtn.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent any default behavior
        
        const totalDueText = cartGrandTotalFooterSpan.textContent;
        const totalDue = parseFloat(totalDueText.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;
        const amountPaidText = amountInput.value;
        const amountPaid = parseFloat(amountPaidText.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;
        const selectedMethodElement = document.querySelector('.payment-method.active');
        const paymentMethod = selectedMethodElement ? selectedMethodElement.dataset.method : 'unknown';
        let changeGiven = 0;
    
        // Payment method validation
        if (paymentMethod === 'cash') {
            if (amountPaid < totalDue) {
                showToast('Montant payé insuffisant!', 'error');
                vibrate([100, 50, 100]);
                amountInput.focus();
                return;
            }
            changeGiven = amountPaid - totalDue;
        } else if (paymentMethod === 'card' || paymentMethod === 'mobile') {
            // Card or mobile payment logic
        } else if (paymentMethod === 'split') {
            showToast('Le paiement partagé n\'est pas encore implémenté.', 'info');
            return;
        } else {
            showToast('Veuillez sélectionner un mode de paiement.', 'warning');
            return;
        }
    
        // Make a backup of order data for receipt
        const orderBackup = [...currentOrder];
        const tableBackup = currentTable;
        
        // Show loading indicator
        const loadingToast = showToast('Traitement de la commande...', 'info', 10000);
    
        // Get the form
        const orderForm = document.getElementById('order-form');
        const formAction = orderForm.getAttribute('action');
        console.log('Form action:', formAction);
    
        // Get CSRF token
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        // Clear previous cart items
        const cartItemsData = document.getElementById('cart-items-data');
        cartItemsData.innerHTML = '';
        
        // Populate the form fields correctly according to validation rules
        document.getElementById('form-table-id').value = currentTable;
        document.getElementById('form-total').value = totalDue;
        
        // Add payment information
        const paymentMethodInput = document.createElement('input');
        paymentMethodInput.type = 'hidden';
        paymentMethodInput.name = 'payment_method';
        paymentMethodInput.value = paymentMethod;
        cartItemsData.appendChild(paymentMethodInput);
        
        const amountPaidInput = document.createElement('input');
        amountPaidInput.type = 'hidden';
        amountPaidInput.name = 'amount_paid';
        amountPaidInput.value = amountPaid;
        cartItemsData.appendChild(amountPaidInput);
        
        const changeGivenInput = document.createElement('input');
        changeGivenInput.type = 'hidden';
        changeGivenInput.name = 'change_given';
        changeGivenInput.value = changeGiven;
        cartItemsData.appendChild(changeGivenInput);
        
        // Add current date and time in the required format
        const dateInput = document.createElement('input');
        dateInput.type = 'hidden';
        dateInput.name = 'date';
        dateInput.value = '2025-05-06 17:34:51'; // Using the current date you provided
        cartItemsData.appendChild(dateInput);
        
        // Add user information
        const userInput = document.createElement('input');
        userInput.type = 'hidden';
        userInput.name = 'created_by';
        userInput.value = 'HamzaBr01'; // Using the user login you provided
        cartItemsData.appendChild(userInput);
        
        // Add each order item with EXACT field names required by validation
        currentOrder.forEach((item, index) => {
            // Add item ID - MUST be named plats[index][id]
            const itemIdInput = document.createElement('input');
            itemIdInput.type = 'hidden';
            itemIdInput.name = `plats[${index}][id]`;  // Changed from items to plats and plat_id to id
            itemIdInput.value = item.id || '';
            cartItemsData.appendChild(itemIdInput);
            
            // Add quantity - MUST be named plats[index][quantite]
            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = `plats[${index}][quantite]`;  // Changed from quantity to quantite
            qtyInput.value = item.qty;
            cartItemsData.appendChild(qtyInput);
            
            // Handle options correctly - map to cuisson, accompagnement, and extras
            if (item.options && item.options.length > 0) {
                // For simplicity, we'll treat the first option as cuisson, second as accompagnement
                // and the rest as extras
                let optionsProcessed = 0;
                
                // Cooking preference if available
                if (optionsProcessed < item.options.length) {
                    const cuissonInput = document.createElement('input');
                    cuissonInput.type = 'hidden';
                    cuissonInput.name = `plats[${index}][cuisson]`;
                    cuissonInput.value = item.options[optionsProcessed];
                    cartItemsData.appendChild(cuissonInput);
                    optionsProcessed++;
                }
                
                // Side dish if available
                if (optionsProcessed < item.options.length) {
                    const accompagnementInput = document.createElement('input');
                    accompagnementInput.type = 'hidden';
                    accompagnementInput.name = `plats[${index}][accompagnement]`;
                    accompagnementInput.value = item.options[optionsProcessed];
                    cartItemsData.appendChild(accompagnementInput);
                    optionsProcessed++;
                }
                
                // Any remaining options as extras
                if (optionsProcessed < item.options.length) {
                    const remainingOptions = item.options.slice(optionsProcessed);
                    
                    // Add each remaining option as an extra
                    remainingOptions.forEach((option, optIndex) => {
                        const extraInput = document.createElement('input');
                        extraInput.type = 'hidden';
                        extraInput.name = `plats[${index}][extras][${optIndex}]`;
                        extraInput.value = option;
                        cartItemsData.appendChild(extraInput);
                    });
                }
            } else {
                // Ensure at least empty values for required fields
                const cuissonInput = document.createElement('input');
                cuissonInput.type = 'hidden';
                cuissonInput.name = `plats[${index}][cuisson]`;
                cuissonInput.value = '';
                cartItemsData.appendChild(cuissonInput);
                
                const accompagnementInput = document.createElement('input');
                accompagnementInput.type = 'hidden';
                accompagnementInput.name = `plats[${index}][accompagnement]`;
                accompagnementInput.value = '';
                cartItemsData.appendChild(accompagnementInput);
            }
            
            // Add notes if any
            if (item.notes) {
                const notesInput = document.createElement('input');
                notesInput.type = 'hidden';
                notesInput.name = `plats[${index}][notes]`;
                notesInput.value = item.notes;
                cartItemsData.appendChild(notesInput);
            } else {
                const notesInput = document.createElement('input');
                notesInput.type = 'hidden';
                notesInput.name = `plats[${index}][notes]`;
                notesInput.value = '';
                cartItemsData.appendChild(notesInput);
            }
        });
        
        // Use a hidden iframe for form submission
        const iframe = document.createElement('iframe');
        iframe.name = 'submit_frame';
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
        
        // Set the form's target to the iframe to avoid page refresh
        orderForm.target = 'submit_frame';
        
        // Set a timeout to ensure the user sees the receipt even if the form submission fails
        setTimeout(() => {
            if (loadingToast) {
                loadingToast.remove();
            }
            
            console.log('Displaying receipt interface');
            showToast('Votre commande a été traitée', 'success');
            processSuccessfulPayment(orderBackup, tableBackup, paymentMethod, amountPaid, changeGiven, selectedMethodElement);
            
            // Cleanup iframe after a delay
            setTimeout(() => {
                document.body.removeChild(iframe);
            }, 3000);
        }, 2500);
        
        // Add error handling for the iframe
        iframe.onerror = function() {
            console.error('Iframe loading error');
            if (loadingToast) {
                loadingToast.remove();
            }
            showToast('Erreur lors de la communication avec le serveur', 'error');
        };
        
        console.log('Submitting order form');
        
        // Submit the form to the iframe
        orderForm.submit();
      
    });
    
    // Separate function to handle UI updates after successful payment
 // Fix for the null element error in processSuccessfulPayment function
function processSuccessfulPayment(orderItems, tableNum, paymentMethod, amountPaid, changeGiven, selectedMethodElement) {
    const receiptTabElement = document.getElementById('receipt-tab');
    
    // Check if receipt tab exists before proceeding
    if (!receiptTabElement) {
        console.error('Receipt tab element not found');
        showToast('Erreur lors de l\'affichage du reçu', 'error');
        return; // Exit function early
    }

    const tableNumElement = receiptTabElement.querySelector('.receipt-table-num');
    if (tableNumElement) tableNumElement.textContent = tableNum;
    
    const datetimeElement = receiptTabElement.querySelector('.receipt-datetime');
    if (datetimeElement) datetimeElement.textContent = new Date().toLocaleString('fr-FR');

    const receiptItemsContainer = receiptTabElement.querySelector('.receipt-items');
    if (receiptItemsContainer) {
        receiptItemsContainer.innerHTML = '';
        orderItems.forEach(item => {
            const receiptItemEl = document.createElement('div');
            receiptItemEl.className = 'receipt-item';
            receiptItemEl.innerHTML = `
               <div class="item-qty">${item.qty}x</div>
               <div class="item-name">${item.name} ${item.options && item.options.length > 0 ? '<small>('+item.options.map(o => o.replace(/ \([^)]*\)/, '')).join(', ')+')</small>' : ''} ${item.notes ? '<small><i>Note: '+item.notes+'</i></small>' : ''}</div>
               <div class="item-price">${formatCurrency(item.price * item.qty)}</div>
            `;
            receiptItemsContainer.appendChild(receiptItemEl);
        });
    } else {
        console.error('Receipt items container not found');
    }

    // Calculate totals
    const subtotal = orderItems.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const tax = subtotal * TAX_RATE;
    const totalDue = subtotal + tax;
    
    // Update receipt values with null checks
    const subtotalElement = receiptTabElement.querySelector('.receipt-subtotal-val');
    if (subtotalElement) subtotalElement.textContent = formatCurrency(subtotal);
    
    const taxElement = receiptTabElement.querySelector('.receipt-tax-val');
    if (taxElement) taxElement.textContent = formatCurrency(tax);
    
    const totalElement = receiptTabElement.querySelector('.receipt-total-val');
    if (totalElement) totalElement.textContent = formatCurrency(totalDue);

    // Handle payment details with proper null checks
    const paymentDetailsElements = receiptTabElement.querySelectorAll('.receipt-payment-details');
    if (paymentDetailsElements && paymentDetailsElements.length >= 2) {
        const paymentNameElement = paymentDetailsElements[0].querySelector('.item-name');
        const paymentPriceElement = paymentDetailsElements[0].querySelector('.item-price');
        
        if (paymentNameElement && selectedMethodElement && selectedMethodElement.querySelector('.payment-name')) {
            paymentNameElement.textContent = `Payé (${selectedMethodElement.querySelector('.payment-name').textContent}):`;
        }
        
        if (paymentPriceElement) {
            paymentPriceElement.textContent = formatCurrency(amountPaid);
        }
        
        if (paymentMethod === 'cash' && changeGiven > 0.001) {
            const changeNameElement = paymentDetailsElements[1].querySelector('.item-name');
            const changePriceElement = paymentDetailsElements[1].querySelector('.item-price');
            
            if (changeNameElement) changeNameElement.textContent = 'Rendu:';
            if (changePriceElement) changePriceElement.textContent = formatCurrency(changeGiven);
            
            paymentDetailsElements[1].style.display = 'grid';
        } else if (paymentDetailsElements[1]) {
            paymentDetailsElements[1].style.display = 'none';
        }
    }

    // Update table display in success panel
    const successPanelTableNum = receiptTabElement.querySelector('.payment-success-panel .receipt-table-num');
    if (successPanelTableNum) successPanelTableNum.textContent = tableNum;

    // Rest of the function (with null checks as needed)
    activateTab('receipt');
    showToast(`Paiement pour Table ${tableNum} enregistré`, 'success');
    vibrate([50, 100, 50]);

    // Handle table element updates
    const tableElement = document.querySelector(`.table-item[data-table="${tableNum}"]`);
    if(tableElement) {
        tableElement.classList.remove('table-occupied', 'table-reserved', 'table-urgent');
        tableElement.classList.add('table-free');
        const timeDisplay = tableElement.querySelector('.table-time');
        if (timeDisplay) timeDisplay.remove();
        const capacityText = tableElement.querySelector('.table-capacity')?.textContent.replace('<i class="fas fa-users" aria-hidden="true"></i> ','').trim() || '? pers.';
        tableElement.setAttribute('aria-label', `Table ${tableNum}, ${capacityText}, Libre`);
    }

    // Reset application state
    currentTable = null;
    currentOrder = [];
    updateCart();
    updateOrderHeader();

    // Reset payment UI
    if (paymentMethods) {
        paymentMethods.forEach(m => m.classList.remove('active'));
        if (paymentMethods[0]) {
            paymentMethods[0].classList.add('active');
            paymentMethods[0].setAttribute('aria-checked', 'true');
            paymentMethods[0].setAttribute('tabindex', '0');
        }
    }
    
    if (cashPaymentDetails) cashPaymentDetails.style.display = 'block';
    if (amountInput) amountInput.value = '0,00';
    if (changeAmountSpan) changeAmountSpan.textContent = '0,00 €';
    if (billsDisplay) billsDisplay.innerHTML = '';
    if (tipCheckbox) tipCheckbox.checked = false;
}


     backToTablesReceiptBtn.addEventListener('click', () => {
         activateTab('tables');
     });
     cleanTableBtn.addEventListener('click', () => {

         showToast(`Table marquée comme nettoyée`, 'info');
         activateTab('tables');
     });



    activateTab('tables');
    updateCart();


     searchInput.addEventListener('input', (e) => {
         const searchTerm = e.target.value.toLowerCase().trim();
         const activeCategory = document.querySelector('.category.active')?.textContent || 'Tous';

         menuItems.forEach(item => {
             const name = item.dataset.name.toLowerCase();

             const categoryMatch = (activeCategory === 'Tous' );
             const searchMatch = name.includes(searchTerm);

             item.style.display = (categoryMatch && searchMatch) ? 'flex' : 'none';
         });
     });

     voiceBtn.addEventListener('click', () => {
         showToast('Fonction recherche vocale non implémentée');
         vibrate(100);

     });

     categoryTabs.forEach(catTab => {
         catTab.addEventListener('click', () => {
             categoryTabs.forEach(t => {
                const isSelected = t === catTab;
                t.classList.toggle('active', isSelected);
                t.setAttribute('aria-selected', isSelected);
             });
             const category = catTab.textContent;
             const categoryFilter = catTab.getAttribute('data-category');
             showToast(`Filtre: ${category}`);
             vibrate(30);

             // Filtre les plats en fonction de la catégorie
             menuItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                const matchesCategory = categoryFilter === 'Tous' || itemCategory === categoryFilter;
                const searchTerm = searchInput.value.toLowerCase().trim();
                const matchesSearch = item.getAttribute('data-name').toLowerCase().includes(searchTerm);
                
                item.style.display = (matchesCategory && matchesSearch) ? 'flex' : 'none';
             });
         });
         catTab.addEventListener('keydown', (e) => {
              if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); catTab.click(); }

              if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                   const current = Array.from(categoryTabs).findIndex(t => t === e.target);
                   const nextIndex = e.key === 'ArrowRight' ? (current + 1) % categoryTabs.length : (current - 1 + categoryTabs.length) % categoryTabs.length;
                   categoryTabs[nextIndex].focus();
                   categoryTabs[nextIndex].click();
              }
         });
     });

});

const sendButton = document.getElementById('send-to-kitchen-btn');
const tableIdInput = document.getElementById('form-table-id');
const cartItemsContainer = document.getElementById('cart-items-container');

if (tableIdInput.value && cartItemsContainer.children.length > 0) {
    sendButton.disabled = false;
} else {
    sendButton.disabled = true;
}

document.querySelectorAll('.table-select-button').forEach(button => {
    button.addEventListener('click', function () {
        const selectedTableId = this.dataset.tableId; // Assuming buttons have a data-table-id attribute
        document.getElementById('form-table-id').value = selectedTableId;
        document.querySelector('.cart-table-id').innerText = `Table ${selectedTableId}`;
    });
});



function updateCartData() {
    const plats = [];
    document.querySelectorAll('#cart-items-list .cart-item').forEach(item => {
        const plat = {
            quantite: parseInt(item.querySelector('.item-quantity').value, 10),
            options: JSON.parse(item.querySelector('.item-options').value || '[]'),
            notes: item.querySelector('.item-notes').value || null,
        };
        plats.push(plat);
    });

    // Update the hidden input with the serialized plats data
    const platsInput = document.getElementById('cart-items-data');
    platsInput.innerHTML = ''; // Clear previous data
    const platsField = document.createElement('input');
    platsField.type = 'hidden';
    platsField.name = 'plats';
    platsField.value = JSON.stringify(plats);
    platsInput.appendChild(platsField);
}

// Call this function whenever cart items are updated
document.getElementById('send-to-kitchen-btn').addEventListener('click', updateCartData);


function updateSendButtonState() {
    const tableId = document.getElementById('form-table-id').value;
    const cartItems = document.querySelectorAll('#cart-items-list .cart-item').length;
    const sendButton = document.getElementById('send-to-kitchen-btn');
    sendButton.disabled = !(tableId && cartItems > 0);
}

// Call this function whenever table or cart data changes
document.querySelectorAll('.table-select-button').forEach(button => {
    button.addEventListener('click', updateSendButtonState);
});
document.querySelectorAll('#cart-items-list .cart-item').forEach(item => {
    item.addEventListener('change', updateSendButtonState);
});


function selectTable(tableId) {
    document.querySelector('.cart-table-id').textContent = tableId;
    
    document.getElementById('form-table-id').value = tableId;
    
    document.getElementById('cart-panel').style.display = 'block';
    
    updateButtonState();
}
// When adding items to cart
function addToCart(platId, platName, price, quantity) {
    // Add to visual cart display
    let cartItemsList = document.getElementById('cart-items-list');
    // Create visual representation of the item in cart
    // ...
    
    // Create hidden inputs for form submission
    let cartItemsData = document.getElementById('cart-items-data');
    
    let platIdInput = document.createElement('input');
    platIdInput.type = 'hidden';
    platIdInput.name = 'plats[' + platId + '][id]';
    platIdInput.value = platId;
    cartItemsData.appendChild(platIdInput);
    
    let quantityInput = document.createElement('input');
    quantityInput.type = 'hidden';
    quantityInput.name = 'plats[' + platId + '][quantity]';
    quantityInput.value = quantity;
    cartItemsData.appendChild(quantityInput);
    
   
    updateButtonState();
}

function updateButtonState() {
    const hasItems = document.getElementById('cart-items-list').children.length > 0;
    const hasTableId = document.getElementById('form-table-id').value !== '';
    
}   

    document.addEventListener('DOMContentLoaded', function() {
        // Get the form and important elements
        const orderForm = document.getElementById('order-form');
        const formTableId = document.getElementById('form-table-id');
        const cartItemsData = document.getElementById('cart-items-data');
        const cartItemsList = document.getElementById('cart-items-list');
        const sendToKitchenBtn = document.getElementById('send-to-kitchen-btn');
        
        // Store cart items
        let cartItems = [];
        
        // Handle table selection
        document.querySelectorAll('.table-item').forEach(table => {
            table.addEventListener('click', function() {
                const tableId = this.getAttribute('data-table');
                
                // Update the form table ID field - ensure it's correctly set
                formTableId.value = tableId;
                console.log("Table ID set to:", tableId); // Debug
                
                // Update cart UI with selected table
                document.querySelector('.cart-table-id').textContent = this.querySelector('.table-number').textContent;
                
                // Show cart panel
                document.getElementById('cart-panel').style.display = 'block';
                
                // Switch to orders tab
                document.getElementById('tab-orders').click();
            });
        });
        
        // Handle menu item selection and add to cart (simplified for testing)
        document.querySelectorAll('.menu-item').forEach(menuItem => {
            menuItem.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                const itemName = this.getAttribute('data-name');
                const itemPrice = parseFloat(this.getAttribute('data-price'));
                
                // Create a simple cart item (without customization for testing)
                const cartItem = {
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    quantity: 1
                };
                
                // Add to cart items array
                cartItems.push(cartItem);
                updateCartUI();
                
                // Enable send button
                sendToKitchenBtn.disabled = false;
                
                console.log("Item added to cart:", cartItem); // Debug
            });
        });
        
        // Handle form submission - FIXED VERSION
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous cart data inputs
            cartItemsData.innerHTML = '';
            
            // Check if table is selected
            if (!formTableId.value) {
                alert('Veuillez sélectionner une table.');
                return;
            }
            
            // Check if cart has items
            if (cartItems.length === 0) {
                alert('Veuillez ajouter des articles à la commande.');
                return;
            }
            
            
            // Create hidden inputs for each cart item
            cartItems.forEach((item, index) => {
                const platIdInput = document.createElement('input');
                platIdInput.type = 'hidden';
                platIdInput.name = `plats[${index}][id]`;
                platIdInput.value = item.id;
                
                const platQuantityInput = document.createElement('input');
                platQuantityInput.type = 'hidden';
                platQuantityInput.name = `plats[${index}][quantite]`;
                platQuantityInput.value = item.quantity;
                
                // Add inputs to the form
                orderForm.appendChild(platIdInput);
                orderForm.appendChild(platQuantityInput);
            });
            
            console.log("Form submission - Table ID:", formTableId.value);
            console.log("Form submission - Plats count:", cartItems.length);
            
            // Submit the form
            this.submit();
        });
        
        // Update cart UI function
        function updateCartUI() {
            // Update cart items list
            cartItemsList.innerHTML = '';
            cartItems.forEach((item, index) => {
                cartItemsList.innerHTML += `
                    <div class="cart-item">
                        <div class="item-quantity">${item.quantity}</div>
                        <div class="item-details">
                            <div class="item-name">${item.name}</div>
                        </div>
                        <div class="item-price">${(item.price * item.quantity).toFixed(2)}DH</div>
                        <button type="button" class="item-remove" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            });
            
            // Update cart summary
            const total = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.querySelector('.cart-count').textContent = `(${cartItems.length} article${cartItems.length > 1 ? 's' : ''})`;
            document.querySelector('.cart-total').textContent = `${total.toFixed(2)}DH`;
            
            // Show/hide the cart details
            const emptyMessage = document.querySelector('.cart-empty-message');
            if (cartItems.length > 0) {
                emptyMessage.style.display = 'none';
                document.getElementById('cart-details').hidden = false;
            }
        }
    });
    document.getElementById('go-to-payment-btn').addEventListener('click', function() {
        document.getElementById('cart-panel').style.display = 'none';
    });






    document.addEventListener('DOMContentLoaded', function () {
        const printButton = document.querySelector('.receipt-actions .btn-primary');
        if (printButton) {
            printButton.addEventListener('click', handlePrintReceipt);
        }
    });
    
    function handlePrintReceipt() {
        const commandId = getCurrentCommandId();
        const receiptElement = document.querySelector('.receipt');
        
        if (receiptElement) {
            // Clone the receipt content to avoid modifying the original page
            const receiptContent = receiptElement.cloneNode(true);
            openPrintWindowWithQrCode(receiptContent.outerHTML, commandId);
        }
    }
    
    function getCurrentCommandId() {
        return 'CMD-' + new Date().getTime().toString();
    }
    
    function openPrintWindowWithQrCode(contentHTML, commandId) {
        const printWindow = window.open('', '_blank');
        if (!printWindow) {
            alert("Popup blocked. Please allow popups for this site.");
            return;
        }
    
        // Use the provided date and user information
        const currentDate = '2025-05-07 00:17:01';
        const currentUser = 'HamzaBr01';
    
        // Write the basic document structure with enhanced styling
        printWindow.document.write(`
            <html>
            <head>
                <title>Facture</title>
                <style>
                    @media print {
                        @page {
                            size: 80mm auto;
                            margin: 0;
                        }
                        body {
                            font-family: 'Courier New', monospace;
                            width: 80mm;
                            margin: 0;
                            padding: 5mm;
                            color: #333;
                            font-size: 12px;
                        }
                        .receipt {
                            width: 100%;
                            border: none;
                            background-color: white;
                        }
                        .receipt-header {
                            text-align: center;
                            margin-bottom: 15px;
                            padding-bottom: 10px;
                            border-bottom: 1px dashed #ccc;
                        }
                        .receipt-logo {
                            font-size: 20px;
                            font-weight: bold;
                            margin-bottom: 5px;
                        }
                        .receipt-restaurant {
                            font-size: 16px;
                            font-weight: bold;
                            margin-bottom: 8px;
                        }
                        .receipt-info {
                            font-size: 10px;
                            margin: 8px 0;
                        }
                        .receipt-datetime {
                            font-style: italic;
                            margin: 5px 0;
                            font-size: 10px;
                        }
                        .receipt-operator {
                            margin: 5px 0;
                            font-size: 10px;
                        }
                        .receipt-item {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 5px;
                            padding: 3px 0;
                        }
                        .receipt-item:nth-child(even) {
                            background-color: #f9f9f9;
                        }
                        .receipt-item-name {
                            flex: 2;
                        }
                        .receipt-item-price {
                            flex: 1;
                            text-align: right;
                            font-weight: bold;
                        }
                        .receipt-subtotal {
                            margin-top: 10px;
                            padding-top: 5px;
                            border-top: 1px dashed #ccc;
                            font-weight: bold;
                            text-align: right;
                        }
                        .receipt-total {
                            margin-top: 5px;
                            font-size: 16px;
                            font-weight: bold;
                            text-align: right;
                        }
                        .receipt-actions, .payment-success-panel {
                            display: none !important;
                        }
                        .receipt-qr {
                            text-align: center;
                            margin: 15px auto;
                            padding: 10px;
                            border-top: 1px dashed #ccc;
                            border-bottom: 1px dashed #ccc;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            width: 80%;
                        }
                        .receipt-qr img {
                            max-width: 100px;
                            height: auto;
                            margin: 0 auto;
                        }
                        #receipt-qr-code {
                            margin: 0 auto;
                            display: block;
                        }
                        .receipt-qr-id {
                            font-family: monospace;
                            text-align: center;
                            font-size: 10px;
                            margin-top: 5px;
                            width: 100%;
                        }
                        .receipt-footer {
                            text-align: center;
                            margin-top: 15px;
                            padding-top: 5px;
                            font-size: 10px;
                            font-style: italic;
                        }
                        .receipt-id {
                            font-family: monospace;
                            text-align: center;
                            font-size: 10px;
                            margin-top: 5px;
                        }
                        .receipt-thanks {
                            font-size: 12px;
                            font-weight: bold;
                            text-align: center;
                            margin: 10px 0;
                        }
                    }
                </style>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
            </head>
            <body>${contentHTML}</body>
            </html>
        `);
    
        printWindow.document.close();
    
        // Generate QR code in the new window
        printWindow.onload = function() {
            // Find or create QR container in the print window
            let qrCodeContainer = printWindow.document.querySelector('.receipt-qr');
            if (!qrCodeContainer) {
                qrCodeContainer = printWindow.document.createElement('div');
                qrCodeContainer.className = 'receipt-qr';
                printWindow.document.querySelector('.receipt').appendChild(qrCodeContainer);
            } else {
                // Clear the container without using innerHTML
                while (qrCodeContainer.firstChild) {
                    qrCodeContainer.removeChild(qrCodeContainer.firstChild);
                }
            }
    
            // Create QR code element
            const qrCodeElement = printWindow.document.createElement('div');
            qrCodeElement.id = 'receipt-qr-code';
            qrCodeContainer.appendChild(qrCodeElement);
    
            // Generate QR code in the new window
            new printWindow.QRCode(qrCodeElement, {
                text: commandId,
                width: 128,
                height: 128,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: printWindow.QRCode.CorrectLevel.H
            });
    
            // Add command ID text
            const commandIdText = printWindow.document.createElement('div');
            commandIdText.className = 'receipt-qr-id';
            commandIdText.textContent = 'ID Commande: ' + commandId;
            commandIdText.style.fontSize = '10px';
            commandIdText.style.marginTop = '5px';
            qrCodeContainer.appendChild(commandIdText);
    
            // Add date/time and operator info
            const receiptElement = printWindow.document.querySelector('.receipt');
            
            const dateTimeInfo = printWindow.document.createElement('div');
            dateTimeInfo.className = 'receipt-datetime';
            dateTimeInfo.textContent = 'Date: ' + currentDate;
            
            const operatorInfo = printWindow.document.createElement('div');
            operatorInfo.className = 'receipt-operator';
            operatorInfo.textContent = 'Opérateur: ' + currentUser;
            
            const thanksMsg = printWindow.document.createElement('div');
            thanksMsg.className = 'receipt-thanks';
            thanksMsg.textContent = 'Merci pour votre visite!';
            
            const receiptHeader = printWindow.document.querySelector('.receipt-header');
            if (receiptHeader) {
                receiptHeader.appendChild(dateTimeInfo);
                receiptHeader.appendChild(operatorInfo);
            } else {
                if (receiptElement.firstChild) {
                    receiptElement.insertBefore(operatorInfo, receiptElement.firstChild);
                    receiptElement.insertBefore(dateTimeInfo, receiptElement.firstChild);
                } else {
                    receiptElement.appendChild(dateTimeInfo);
                    receiptElement.appendChild(operatorInfo);
                }
            }
            
            const footer = printWindow.document.querySelector('.receipt-footer');
            if (footer) {
                footer.prepend(thanksMsg);
            } else {
                receiptElement.appendChild(thanksMsg);
            }
    
            setTimeout(() => {
                printWindow.focus();
                printWindow.print();
                printWindow.onafterprint = () => {
                    printWindow.close();
                };
            }, 500);
        };
    }
    
    const select = document.getElementById('restaurant-select');
    const selectedText = select.options[select.selectedIndex].text;
    const selectedValue = select.value;
    
    document.querySelector('.receipt-restaurant').textContent = selectedText;