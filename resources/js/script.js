// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }


    // Handle mobile menu link clicks
    const mobileLinks = mobileMenu?.querySelectorAll('a');
    mobileLinks?.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');
        });
    });

    // Fade In Animation
    // Initialize map with a slight delay to ensure container is ready
    setTimeout(() => {
        const mapElement = document.getElementById('map');
        if (mapElement && typeof L !== 'undefined') {
            const map = L.map('map').setView([48.8566, 2.3522], 15); // Paris coordinates

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Restaurant marker
            const restaurantMarker = L.marker([48.8566, 2.3522]).addTo(map);
            restaurantMarker.bindPopup("<strong>OctoPOS Restaurant</strong><br>123 Avenue de la Gastronomie<br>75001 Paris, France").openPopup();
        }
    }, 1000);

    // Initial animations - only animate elements in viewport
    const fadeElements = document.querySelectorAll('.fade-in');
    setTimeout(() => {
        fadeElements.forEach(element => {
            if (isElementInViewport(element)) {
                element.classList.add('active');
            }
        });
    }, 100);

    // Scroll animations - use IntersectionObserver when available
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(element => {
            if (!element.classList.contains('active')) {
                observer.observe(element);
            }
        });
    } else {
        // Fallback for browsers that don't support IntersectionObserver
        window.addEventListener('scroll', debounce(function() {
            const fadeElements = document.querySelectorAll('.fade-in:not(.active)');
            fadeElements.forEach(element => {
                if (isElementInViewport(element)) {
                    element.classList.add('active');
                }
            });
        }, 50));
    }

    // Menu filter
    const filterButtons = document.querySelectorAll('.menu-filter');
    const menuItems = document.querySelectorAll('.menu-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-[#0288D1]', 'to-[#026da8]', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
            });
            this.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100');
            this.classList.add('bg-gradient-to-r', 'from-[#0288D1]', 'to-[#026da8]', 'text-white');

            // Filter menu items with animation
            menuItems.forEach(item => {
                if (category === 'all' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.classList.add('active');
                    }, 10);
                } else {
                    item.classList.remove('active');
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Table selection
    const tableItems = document.querySelectorAll('.table-item:not([aria-disabled="true"])');
    const reservationPopup = document.getElementById('reservation-popup');
    const closeReservationBtn = document.getElementById('close-reservation');
    const confirmReservationBtn = document.getElementById('confirm-reservation');
    const selectedTableSpan = document.getElementById('selected-table');
    const reservationSuccess = document.getElementById('reservation-success');
    const successTable = document.getElementById('success-table');
    const successDate = document.getElementById('success-date');
    const successTime = document.getElementById('success-time');
    const successRef = document.getElementById('success-ref');

    // Current date for reference
    const today = new Date();
    const formattedDate = today.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });

    // Set up table selection
    tableItems.forEach(table => {
        table.addEventListener('click', function() {
            const tableId = this.getAttribute('data-table');
            if (selectedTableSpan) {
                selectedTableSpan.textContent = tableId;
                if (reservationPopup) {
                    reservationPopup.classList.remove('hidden');
                }
            }

            // Visual feedback for selection
            tableItems.forEach(t => t.classList.remove('ring-4', 'ring-yellow-300', 'ring-offset-2'));
            this.classList.add('ring-4', 'ring-yellow-300', 'ring-offset-2');

            // Update date in reservation form
            if (successDate) {
                successDate.textContent = formattedDate;
            }

            // Set focus to first form field
            setTimeout(() => {
                document.getElementById('name')?.focus();
            }, 100);
        });
    });

    // Close reservation popup
    if (closeReservationBtn) {
        closeReservationBtn.addEventListener('click', function() {
            if (reservationPopup) {
                reservationPopup.classList.add('hidden');
                tableItems.forEach(t => t.classList.remove('ring-4', 'ring-yellow-300', 'ring-offset-2'));
            }
        });
    }

    // Handle reservation form submission
    if (confirmReservationBtn) {
        confirmReservationBtn.addEventListener('click', function() {
            const form = document.getElementById('reservation-form');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const termsCheckbox = document.getElementById('terms');

            // Form validation
            let isValid = true;

            // Simple validation
            if (nameInput && !nameInput.value) {
                nameInput.classList.add('border-red-500');
                isValid = false;
            }

            if (emailInput && !emailInput.value) {
                emailInput.classList.add('border-red-500');
                isValid = false;
            }

            if (phoneInput && !phoneInput.value) {
                phoneInput.classList.add('border-red-500');
                isValid = false;
            }

            if (termsCheckbox && !termsCheckbox.checked) {
                document.querySelector('label[for="terms"]')?.classList.add('text-red-500');
                isValid = false;
            }

            if (isValid) {
                // Show success message
                if (reservationPopup) {
                    reservationPopup.classList.add('hidden');
                }
                if (reservationSuccess) {
                    reservationSuccess.classList.remove('hidden');
                }
                if (successTable && selectedTableSpan) {
                    successTable.textContent = `Table ${selectedTableSpan.textContent}`;
                }
                if (successTime) {
                    successTime.textContent = document.getElementById('time-select')?.value || '19:00';
                }

                // Generate random reference
                if (successRef) {
                    const randomRef = `OCT-${Math.floor(1000 + Math.random() * 9000)}${String.fromCharCode(65 + Math.floor(Math.random() * 26))}${Math.floor(1 + Math.random() * 9)}`;
                    successRef.textContent = randomRef;
                }

                // Reset form
                if (nameInput) nameInput.value = '';
                if (emailInput) emailInput.value = '';
                if (phoneInput) phoneInput.value = '';
                if (termsCheckbox) termsCheckbox.checked = false;

                const specialRequests = document.getElementById('special-requests');
                if (specialRequests) specialRequests.value = '';

                // Scroll to success message
                if (reservationSuccess) {
                    reservationSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                // Remove table selection
                tableItems.forEach(t => t.classList.remove('ring-4', 'ring-yellow-300', 'ring-offset-2'));
            } else if (form) {
                // Show validation error with shake animation
                form.classList.add('shake');
                setTimeout(() => {
                    form.classList.remove('shake');
                }, 600);
            }

            // Remove error styling on input when typing
            const inputs = [nameInput, emailInput, phoneInput].filter(Boolean);
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                });
            });

            if (termsCheckbox) {
                termsCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        document.querySelector('label[for="terms"]')?.classList.remove('text-red-500');
                    }
                });
            }
        });
    }

    // Close modal when clicking outside
    if (reservationPopup) {
        window.addEventListener('click', function(event) {
            if (event.target === reservationPopup) {
                reservationPopup.classList.add('hidden');
                tableItems.forEach(t => t.classList.remove('ring-4', 'ring-yellow-300', 'ring-offset-2'));
            }
        });
    }

    // Contact form
    const sendMessageButton = document.getElementById('send-message');
    const contactSuccess = document.getElementById('contact-success');

    if (sendMessageButton) {
        sendMessageButton.addEventListener('click', function() {
            const form = document.getElementById('contact-form');
            const nameInput = document.getElementById('contact-name');
            const emailInput = document.getElementById('contact-email');
            const subjectInput = document.getElementById('contact-subject');
            const messageInput = document.getElementById('contact-message');

            // Simple validation
            let isValid = true;

            if (nameInput && !nameInput.value) {
                nameInput.classList.add('border-red-500');
                isValid = false;
            }

            if (emailInput && !emailInput.value) {
                emailInput.classList.add('border-red-500');
                isValid = false;
            }

            if (subjectInput && !subjectInput.value) {
                subjectInput.classList.add('border-red-500');
                isValid = false;
            }

            if (messageInput && !messageInput.value) {
                messageInput.classList.add('border-red-500');
                isValid = false;
            }

            if (isValid) {
                if (contactSuccess) {
                    contactSuccess.classList.remove('hidden');
                }

                // Reset form
                if (nameInput) nameInput.value = '';
                if (emailInput) emailInput.value = '';
                if (subjectInput) subjectInput.value = '';
                if (messageInput) messageInput.value = '';

                // Scroll to success message
                if (contactSuccess) {
                    contactSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                // Hide success message after 5 seconds
                setTimeout(() => {
                    if (contactSuccess) {
                        contactSuccess.classList.add('hidden');
                    }
                }, 5000);
            } else if (form) {
                form.classList.add('shake');
                setTimeout(() => {
                    form.classList.remove('shake');
                }, 600);
            }

            // Remove error styling on input
            const inputs = [nameInput, emailInput, subjectInput, messageInput].filter(Boolean);
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                });
            });
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80, // Adjust for fixed navbar
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Helper function to check if element is in viewport
function isElementInViewport(el) {
    if (!el) return false;
    const rect = el.getBoundingClientRect();
    return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.9 &&
        rect.bottom >= 0 &&
        rect.left <= (window.innerWidth || document.documentElement.clientWidth) &&
        rect.right >= 0
    );
}

// Debounce function for scroll events
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}
// Add this script at the end of your HTML or in a separate JS file
document.addEventListener('DOMContentLoaded', function() {
    const personsSelect = document.getElementById('persons-select');
    const tableItems = document.querySelectorAll('.table-item');
    
    personsSelect.addEventListener('change', function() {
        const selectedPersons = parseInt(this.value) || 0;
        
        // Loop through all tables and show/hide based on capacity
        tableItems.forEach(table => {
            const capacityText = table.querySelector('.bg-white\\/20').textContent;
            const tableCapacity = parseInt(capacityText) || 0;
            
            // Show tables with capacity >= selected persons
            if (tableCapacity >= selectedPersons) {
                table.classList.remove('hidden');
            } else {
                table.classList.add('hidden');
            }
        });
            
        // Update the URL with the selected filter
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('persons', this.value);
        window.history.pushState({}, '', currentUrl);
    });
    
    // Initialize filter from URL parameters if they exist
    const urlParams = new URLSearchParams(window.location.search);
    const personsParam = urlParams.get('persons');
    if (personsParam) {
        personsSelect.value = personsParam;
        // Trigger the change event to apply the filter
        personsSelect.dispatchEvent(new Event('change'));
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const mainTablesAvailable = document.querySelector('.table-item[data-table] button[style*="background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%)"]');
    const mainTablesUnavailable = document.querySelector('.table-item[data-table] div[style*="background: linear-gradient(135deg, #F44336 0%, #C62828 100%)"]');
    if (!mainTablesAvailable && !mainTablesUnavailable) {
        const msg1 = document.querySelector('.msg1');
        if (msg1) msg1.classList.remove('hidden');
    }

    const vipTablesAvailable = document.querySelector('.table-item[data-table] button[style*="background: linear-gradient(135deg, #FFC107 0%, #FF9800 100%)"]');
    const vipTablesUnavailable = document.querySelector('.table-item[data-table] div[style*="background: linear-gradient(135deg, #FFC107 0%, #FF9800 100%)"]');
    if (!vipTablesAvailable && !vipTablesUnavailable) {
        const msg2 = document.querySelector('.msg2');
        if (msg2) msg2.classList.remove('hidden');
    }

    const terraceTablesAvailable = document.querySelector('.table-item[data-table] button:has(.text-white/80.text-xs:contains("Terrasse"))');
    const terraceTablesUnavailable = document.querySelector('.table-item[data-table] div:has(.text-white/80.text-xs:contains("Terrasse"))');
    if (!terraceTablesAvailable && !terraceTablesUnavailable) {
        const msg3 = document.querySelector('.msg3');
        if (msg3) msg3.classList.remove('hidden');
    }
});