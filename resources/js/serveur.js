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
                showToast('Veuillez d\'abord sélectionner une table.', 'warning');
                vibrate([50,50]);
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

    sendToKitchenBtn.addEventListener('click', () => {
         if (currentOrder.length === 0) return;

         console.log(`Sending order for Table ${currentTable}:`, JSON.stringify(currentOrder));
         showToast(`Commande pour Table ${currentTable} envoyée !`, 'success');


         vibrate([50, 100, 50]);
    });

     goToPaymentBtn.addEventListener('click', () => {
         if (currentOrder.length === 0) {
             showToast('Le panier est vide.', 'warning');
             return;
         }
        activateTab('payment');
        updateCart();
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


    contrastToggleBtn.addEventListener('click', () => {
        const isHighContrast = body.classList.toggle('high-contrast');
        contrastToggleBtn.classList.toggle('active', isHighContrast);
         contrastToggleBtn.setAttribute('aria-pressed', isHighContrast);
        localStorage.setItem('high-contrast', isHighContrast ? 'true' : 'false');
         vibrate(30);
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


    completePaymentBtn.addEventListener('click', () => {
         const totalDueText = cartGrandTotalFooterSpan.textContent;
         const totalDue = parseFloat(totalDueText.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;
         const amountPaidText = amountInput.value;
         const amountPaid = parseFloat(amountPaidText.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;
         const selectedMethodElement = document.querySelector('.payment-method.active');
         const paymentMethod = selectedMethodElement ? selectedMethodElement.dataset.method : 'unknown';
         let changeGiven = 0;

         if (paymentMethod === 'cash') {
             if (amountPaid < totalDue) {
                 showToast('Montant payé insuffisant!', 'error');
                 vibrate([100, 50, 100]);
                 amountInput.focus();
                 return;
             }
             changeGiven = amountPaid - totalDue;
         } else if (paymentMethod === 'card' || paymentMethod === 'mobile') {


         } else if (paymentMethod === 'split') {

             showToast('Le paiement partagé n\'est pas encore implémenté.', 'info');
             return;
         } else {
             showToast('Veuillez sélectionner un mode de paiement.', 'warning');
             return;
         }



         console.log(`Payment Recorded: Table ${currentTable}, Method: ${paymentMethod}, Total: ${formatCurrency(totalDue)}, Paid: ${formatCurrency(amountPaid)}, Change: ${formatCurrency(changeGiven)}`);



         const receiptTabElement = document.getElementById('receipt-tab');

         receiptTabElement.querySelector('.receipt-table-num').textContent = currentTable;
         receiptTabElement.querySelector('.receipt-datetime').textContent = new Date().toLocaleString('fr-FR');

         const receiptItemsContainer = receiptTabElement.querySelector('.receipt-items');
         receiptItemsContainer.innerHTML = '';
         currentOrder.forEach(item => {
             const receiptItemEl = document.createElement('div');
             receiptItemEl.className = 'receipt-item';
             receiptItemEl.innerHTML = `
                <div class="item-qty">${item.qty}x</div>
                <div class="item-name">${item.name} ${item.options.length > 0 ? '<small>('+item.options.map(o => o.replace(/ \([^)]*\)/, '')).join(', ')+')</small>' : ''} ${item.notes ? '<small><i>Note: '+item.notes+'</i></small>' : ''}</div>
                <div class="item-price">${formatCurrency(item.price * item.qty)}</div>
             `;
             receiptItemsContainer.appendChild(receiptItemEl);
         });

         const subtotal = currentOrder.reduce((sum, item) => sum + (item.price * item.qty), 0);
         const tax = subtotal * TAX_RATE;
         receiptTabElement.querySelector('.receipt-subtotal-val').textContent = formatCurrency(subtotal);
         receiptTabElement.querySelector('.receipt-tax-val').textContent = formatCurrency(tax);
         receiptTabElement.querySelector('.receipt-total-val').textContent = formatCurrency(totalDue);

         const paymentDetailsElements = receiptTabElement.querySelectorAll('.receipt-payment-details');
         if (paymentDetailsElements.length >= 2) {
             paymentDetailsElements[0].querySelector('.item-name').textContent = `Payé (${selectedMethodElement.querySelector('.payment-name').textContent}):`;
             paymentDetailsElements[0].querySelector('.item-price').textContent = formatCurrency(amountPaid);
             if (paymentMethod === 'cash' && changeGiven > 0.001) {
                paymentDetailsElements[1].querySelector('.item-name').textContent = 'Rendu:';
                paymentDetailsElements[1].querySelector('.item-price').textContent = formatCurrency(changeGiven);
                paymentDetailsElements[1].style.display = 'grid';
             } else {
                 paymentDetailsElements[1].style.display = 'none';
             }
         }

         receiptTabElement.querySelector('.payment-success-panel .receipt-table-num').textContent = currentTable;



         activateTab('receipt');
         showToast(`Paiement pour Table ${currentTable} enregistré`, 'success');
         vibrate([50, 100, 50]);


         const tableElement = document.querySelector(`.table-item[data-table="${currentTable}"]`);
         if(tableElement) {
             tableElement.classList.remove('table-occupied', 'table-reserved', 'table-urgent');
             tableElement.classList.add('table-free');
             const timeDisplay = tableElement.querySelector('.table-time');
             if (timeDisplay) timeDisplay.remove();
             const capacityText = tableElement.querySelector('.table-capacity')?.textContent.replace('<i class="fas fa-users" aria-hidden="true"></i> ','').trim() || '? pers.';
             tableElement.setAttribute('aria-label', `Table ${currentTable}, ${capacityText}, Libre`);
         }

         const paidTableId = currentTable;
         currentTable = null;
         currentOrder = [];
         updateCart();
         updateOrderHeader();


         paymentMethods.forEach(m => m.classList.remove('active'));
         paymentMethods[0].classList.add('active');
         paymentMethods[0].setAttribute('aria-checked', 'true');
         paymentMethods[0].setAttribute('tabindex', '0');
         cashPaymentDetails.style.display = 'block';
         amountInput.value = '0,00';
         changeAmountSpan.textContent = '0,00 €';
         billsDisplay.innerHTML = '';
         tipCheckbox.checked = false;


    });


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
