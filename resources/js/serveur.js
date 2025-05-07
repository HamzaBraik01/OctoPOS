document.addEventListener('DOMContentLoaded', function() {

    const body = document.body;
    const datetimeElement = document.querySelector('.datetime');
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');
    const bottomNavItems = document.querySelectorAll('.bottom-nav-item');
    const tableItems = document.querySelectorAll('.table-item');
    const backToTablesBtn = document.getElementById('back-to-tables');
    const menuItems = document.querySelectorAll('.menu-item');
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
    
    const restaurantSelect = document.getElementById('restaurant-select');

    let currentTable = null;
    let currentOrder = [];
    let currentTab = 'tables';
    const TAX_RATE = 0.10;

    if (restaurantSelect) {
        restaurantSelect.addEventListener('change', function() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/serveur/select-restaurant';
            form.style.display = 'none';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            const restaurantInput = document.createElement('input');
            restaurantInput.type = 'hidden';
            restaurantInput.name = 'restaurant_id';
            restaurantInput.value = this.value;
            form.appendChild(restaurantInput);
            
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
        return null;
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
                firstFocusable.focus();
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
                return;
            }
            const itemId = item.dataset.id;
            const itemName = item.dataset.name;
            const itemPrice = parseFloat(item.dataset.price);

            const existingItemIndex = currentOrder.findIndex(orderItem => orderItem.id === itemId);

            if (existingItemIndex > -1) {
                currentOrder[existingItemIndex].qty++;
            } else {
                currentOrder.push({
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    qty: 1,
                    options: [],
                    notes: ''
                });
            }

            updateCart();
            if (!cartPanel.classList.contains('expanded')) {
                cartHeader.click();
            }
            vibrate([30, 50, 30]);
        });

        item.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                item.click();
            }
        });
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
            vibrate(50);
        }
    });

    sendToKitchenBtn.addEventListener('click', (e) => {
        if (currentOrder.length === 0) return;
        
        orderForm.dispatchEvent(new Event('submit'));
    });

    goToPaymentBtn.addEventListener('click', () => {
        if (currentOrder.length === 0) {
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
        const contrastToggleBtn = document.querySelector('#contrast-toggle');
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
        e.preventDefault();
        
        const totalDueText = cartGrandTotalFooterSpan.textContent;
        const totalDue = parseFloat(totalDueText.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;
        const amountPaidText = amountInput.value;
        const amountPaid = parseFloat(amountPaidText.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;
        let changeGiven = 0;
    
        if (amountPaid < totalDue) {
            vibrate([100, 50, 100]);
            amountInput.focus();
            return;
        }
        
        changeGiven = amountPaid - totalDue;
    
        const orderBackup = [...currentOrder];
        const tableBackup = currentTable;
        
        const orderForm = document.getElementById('order-form');
        const formAction = orderForm.getAttribute('action');
        console.log('Form action:', formAction);
    
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        const cartItemsData = document.getElementById('cart-items-data');
        cartItemsData.innerHTML = '';
        
        document.getElementById('form-table-id').value = currentTable;
        document.getElementById('form-total').value = totalDue;
        
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
        
        currentOrder.forEach((item, index) => {
            const itemIdInput = document.createElement('input');
            itemIdInput.type = 'hidden';
            itemIdInput.name = `plats[${index}][id]`;
            itemIdInput.value = item.id || '';
            cartItemsData.appendChild(itemIdInput);
            
            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = `plats[${index}][quantite]`;
            qtyInput.value = item.qty;
            cartItemsData.appendChild(qtyInput);
            
            if (item.options && item.options.length > 0) {
                let optionsProcessed = 0;
                
                if (optionsProcessed < item.options.length) {
                    const optionText = item.options[optionsProcessed];
                    if (optionText.toLowerCase().includes('cuisson') || 
                        optionText.toLowerCase().includes('saignant') || 
                        optionText.toLowerCase().includes('a point') || 
                        optionText.toLowerCase().includes('bien cuit')) {
                        
                        const cuissonInput = document.createElement('input');
                        cuissonInput.type = 'hidden';
                        cuissonInput.name = `plats[${index}][cuisson]`;
                        cuissonInput.value = optionText;
                        cartItemsData.appendChild(cuissonInput);
                        optionsProcessed++;
                    }
                }
                
                if (optionsProcessed < item.options.length) {
                    const optionText = item.options[optionsProcessed];
                    if (optionText.toLowerCase().includes('frite') || 
                        optionText.toLowerCase().includes('riz') || 
                        optionText.toLowerCase().includes('légume') || 
                        optionText.toLowerCase().includes('salade')) {
                        
                        const accompagnementInput = document.createElement('input');
                        accompagnementInput.type = 'hidden';
                        accompagnementInput.name = `plats[${index}][accompagnement]`;
                        accompagnementInput.value = optionText;
                        cartItemsData.appendChild(accompagnementInput);
                        optionsProcessed++;
                    }
                }
            } else {
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
        
        const iframe = document.createElement('iframe');
        iframe.name = 'submit_frame';
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
        
        orderForm.target = 'submit_frame';
        
        setTimeout(() => {
            console.log('Displaying receipt interface');
            processSuccessfulPayment(orderBackup, tableBackup, 'Espèces', amountPaid, changeGiven);
            
            setTimeout(() => {
                if (iframe && iframe.parentNode) {
                    iframe.parentNode.removeChild(iframe);
                }
            }, 3000);
        }, 2500);
        
        iframe.onerror = function() {
            console.error('Iframe loading error');
        };
        
        console.log('Submitting payment form with data:', {
            table_id: currentTable,
            total: totalDue,
            payment_method: 'Espèces',
            amount_paid: amountPaid,
            change_given: changeGiven,
            items_count: currentOrder.length
        });
        
        orderForm.submit();
    });

function processSuccessfulPayment(orderItems, tableNum, paymentMethod, amountPaid, changeGiven) {
    const receiptTabElement = document.getElementById('receipt-tab');
    
    if (!receiptTabElement) {
        console.error('Receipt tab element not found');
        return;
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

    const subtotal = orderItems.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const tax = subtotal * TAX_RATE;
    const totalDue = subtotal + tax;
    
    const subtotalElement = receiptTabElement.querySelector('.receipt-subtotal-val');
    if (subtotalElement) subtotalElement.textContent = formatCurrency(subtotal);
    
    const taxElement = receiptTabElement.querySelector('.receipt-tax-val');
    if (taxElement) taxElement.textContent = formatCurrency(tax);
    
    const totalElement = receiptTabElement.querySelector('.receipt-total-val');
    if (totalElement) totalElement.textContent = formatCurrency(totalDue);

    const paymentDetailsElements = receiptTabElement.querySelectorAll('.receipt-payment-details');
    if (paymentDetailsElements && paymentDetailsElements.length >= 2) {
        const paymentNameElement = paymentDetailsElements[0].querySelector('.item-name');
        const paymentPriceElement = paymentDetailsElements[0].querySelector('.item-price');
        
        if (paymentNameElement) {
            paymentNameElement.textContent = `Payé (Espèces):`;
        }
        
        if (paymentPriceElement) {
            paymentPriceElement.textContent = formatCurrency(amountPaid);
        }
        
        if (changeGiven > 0.001) {
            const changeNameElement = paymentDetailsElements[1].querySelector('.item-name');
            const changePriceElement = paymentDetailsElements[1].querySelector('.item-price');
            
            if (changeNameElement) changeNameElement.textContent = 'Rendu:';
            if (changePriceElement) changePriceElement.textContent = formatCurrency(changeGiven);
            
            paymentDetailsElements[1].style.display = 'grid';
        } else if (paymentDetailsElements[1]) {
            paymentDetailsElements[1].style.display = 'none';
        }
    }

    const successPanelTableNum = receiptTabElement.querySelector('.payment-success-panel .receipt-table-num');
    if (successPanelTableNum) successPanelTableNum.textContent = tableNum;

    activateTab('receipt');
    vibrate([50, 100, 50]);

    const tableElement = document.querySelector(`.table-item[data-table="${tableNum}"]`);
    if(tableElement) {
        tableElement.classList.remove('table-occupied', 'table-reserved', 'table-urgent');
        tableElement.classList.add('table-free');
        const timeDisplay = tableElement.querySelector('.table-time');
        if (timeDisplay) timeDisplay.remove();
        const capacityText = tableElement.querySelector('.table-capacity')?.textContent.replace('<i class="fas fa-users" aria-hidden="true"> ','').trim() || '? pers.';
        tableElement.setAttribute('aria-label', `Table ${tableNum}, ${capacityText}, Libre`);
    }

    currentTable = null;
    currentOrder = [];
    updateCart();
    updateOrderHeader();

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
            vibrate(30);

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

document.addEventListener('DOMContentLoaded', function () {
    const printButton = document.querySelector('.receipt-actions .btn-primary');
    if (printButton) {
        printButton.addEventListener('click', handlePrintReceipt);
    }
});

function handlePrintReceipt(event) {
    if (event) {
        event.preventDefault();
    }
    
    const commandId = getCurrentCommandId();
    const receiptElement = document.querySelector('.receipt');
    
    if (receiptElement) {
        const receiptContent = receiptElement.cloneNode(true);
        openPrintWindowWithQrCode(receiptContent.outerHTML, commandId);
        
        setTimeout(() => {
            window.location.reload();
        }, 1500);
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

    const currentDate = '2025-05-07 00:17:01';
    const currentUser = 'HamzaBr01';

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

    printWindow.onload = function() {
        let qrCodeContainer = printWindow.document.querySelector('.receipt-qr');
        if (!qrCodeContainer) {
            qrCodeContainer = printWindow.document.createElement('div');
            qrCodeContainer.className = 'receipt-qr';
            printWindow.document.querySelector('.receipt').appendChild(qrCodeContainer);
        } else {
            while (qrCodeContainer.firstChild) {
                qrCodeContainer.removeChild(qrCodeContainer.firstChild);
            }
        }

        const qrCodeElement = printWindow.document.createElement('div');
        qrCodeElement.id = 'receipt-qr-code';
        qrCodeContainer.appendChild(qrCodeElement);

        new printWindow.QRCode(qrCodeElement, {
            text: commandId,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: printWindow.QRCode.CorrectLevel.H
        });

        const commandIdText = printWindow.document.createElement('div');
        commandIdText.className = 'receipt-qr-id';
        commandIdText.textContent = 'ID Commande: ' + commandId;
        commandIdText.style.fontSize = '10px';
        commandIdText.style.marginTop = '5px';
        qrCodeContainer.appendChild(commandIdText);

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