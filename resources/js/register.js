document.addEventListener('DOMContentLoaded', () => {

    const registrationSuccess = typeof window.registrationSuccess !== 'undefined' ? window.registrationSuccess : false;
    const registeredEmail = typeof window.registeredEmail !== 'undefined' ? window.registeredEmail : '';

    initMultiStepForm();
    initPasswordStrengthMeter();
    initPasswordToggle();
    initFormValidation();
    createParticles();

    if (registrationSuccess) {
        const successEmailEl = document.getElementById('success-email');
        if (successEmailEl && registeredEmail) {
            successEmailEl.textContent = registeredEmail;
        }

        if (typeof window.goToStepGlobal === 'function') {
            window.goToStepGlobal(4);
            if (typeof createConfetti === 'function') {
                createConfetti();
            }
        } else {
            console.warn('goToStepGlobal function not found. Cannot show success step automatically.');
            document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
            const step4 = document.querySelector('.form-step[data-step="4"]');
            if (step4) step4.classList.add('active');
            document.querySelectorAll('.step').forEach(ind => {
                const stepNum = parseInt(ind.getAttribute('data-step') || 0);
                ind.classList.remove('active', 'completed');
                if (stepNum > 0 && stepNum < 4) ind.classList.add('completed');
                else if (stepNum === 4) ind.classList.add('active');
            });
            if (typeof createConfetti === 'function') createConfetti();
        }
    }

    function initMultiStepForm() {
        const steps = document.querySelectorAll('.form-step');
        const stepIndicators = document.querySelectorAll('.step');
        const progressBar = document.querySelector('.step-progress');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const form = document.getElementById('register-form');
        const submitButton = document.getElementById('submit-button');
        let currentStep = 1;

        let initialStep = 1;
        steps.forEach((stepElement, index) => {
            const stepNum = index + 1;
            if (stepElement.querySelector('.border-red-500')) {
                if (initialStep === 1) {
                    initialStep = stepNum;
                }
            }
        });
        currentStep = initialStep;

        if (currentStep > 1) {
            goToStep(currentStep, false);
        } else {
            const firstStepEl = document.querySelector('.form-step[data-step="1"]');
            const firstIndicator = document.querySelector('.step[data-step="1"]');
            if (firstStepEl) firstStepEl.classList.add('active');
            if (firstIndicator) firstIndicator.classList.add('active');
            updateProgressBar();
        }

        nextButtons.forEach(button => {
            button.addEventListener('click', () => {
                if (validateStep(currentStep)) {
                    if (currentStep < (steps.length - 1)) {
                        goToStep(currentStep + 1);
                    }
                } else {
                    const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                    if (currentStepElement) {
                        currentStepElement.classList.add('shake');
                        setTimeout(() => currentStepElement.classList.remove('shake'), 400);
                    }
                }
            });
        });

        prevButtons.forEach(button => {
            button.addEventListener('click', () => {
                if (currentStep > 1) {
                    if (currentStep <= (steps.length - 1)) {
                        goToStep(currentStep - 1);
                    }
                }
            });
        });

        if (form && submitButton) {
            form.addEventListener('submit', (event) => {
                if (!validateStep(3)) {
                    event.preventDefault();

                    const termsCheckbox = document.getElementById('terms-checkbox');
                    const termsError = document.getElementById('terms-error');
                    if (termsError && termsCheckbox && !termsCheckbox.checked) {
                        termsError.classList.remove('hidden');
                        termsCheckbox.addEventListener('change', function () {
                            if (this.checked) termsError.classList.add('hidden');
                        }, { once: true });
                    }

                    const step3Element = document.querySelector('.form-step[data-step="3"]');
                    if (step3Element) {
                        step3Element.classList.add('shake');
                        setTimeout(() => step3Element.classList.remove('shake'), 400);
                    }
                } else {
                    submitButton.disabled = true;
                    submitButton.innerHTML = 'Envoi en cours... <i class="fas fa-spinner fa-spin ml-2"></i>';
                }
            });
        }

        function goToStep(step, smoothScroll = true) {
            steps.forEach(s => s.classList.remove('active'));
            stepIndicators.forEach(s => {
                s.classList.remove('active', 'completed');
                const stepNum = parseInt(s.getAttribute('data-step') || 0);
                if (stepNum > 0 && stepNum < step) {
                    s.classList.add('completed');
                }
                else if (stepNum === step) {
                    s.classList.add('active');
                }
            });

            currentStep = step;

            const targetStepElement = document.querySelector(`.form-step[data-step="${currentStep}"]`);
            if (targetStepElement) {
                targetStepElement.classList.add('active');
            } else {
                console.error("Target form step element not found:", currentStep);
            }

            updateProgressBar();

            if (currentStep === 3) {
                updateSummary();
            }

            const cardElement = document.querySelector('.register-card');
            if (cardElement && smoothScroll) {
                const cardTop = cardElement.getBoundingClientRect().top + window.scrollY;
                window.scrollTo({ top: cardTop - 80, behavior: 'smooth' });
            } else if (cardElement) {
                const cardTop = cardElement.getBoundingClientRect().top + window.scrollY;
                window.scrollTo({ top: cardTop - 80, behavior: 'auto' });
            }
        }
        window.goToStepGlobal = goToStep;

        function updateProgressBar() {
            const totalVisibleSteps = steps.length - 1;
            let progressPercentage = 0;
            if (totalVisibleSteps > 0) {
                progressPercentage = ((currentStep - 1) / totalVisibleSteps) * 100;

                if (currentStep >= steps.length) {
                    progressPercentage = 100;
                }
            }
            progressPercentage = Math.max(0, Math.min(progressPercentage, 100));
            if (progressBar) {
                progressBar.style.width = `${progressPercentage}%`;
            }
        }

        function updateSummary() {
            const firstName = document.getElementById('first-name')?.value || 'N/A';
            const lastName = document.getElementById('last-name')?.value || 'N/A';
            const email = document.getElementById('email')?.value || 'N/A';
            const phone = document.getElementById('phone')?.value || 'N/A';
            const restaurantSelect = document.getElementById('restaurant-name');
            let selectedRestaurant = 'N/A';
            if (restaurantSelect && restaurantSelect.selectedIndex > 0) {
                selectedRestaurant = restaurantSelect.options[restaurantSelect.selectedIndex].text;
            }

            document.getElementById('summary-name').textContent = `${firstName} ${lastName}`;
            document.getElementById('summary-email').textContent = email;
            document.getElementById('summary-phone').textContent = phone;
            document.getElementById('summary-restaurant').textContent = selectedRestaurant;
        }

        function validateStep(step) {
            let isValid = true;
            const currentStepElement = document.querySelector(`.form-step[data-step="${step}"]`);
            if (!currentStepElement) return false;

            if (step === 1 || step === 2) {
                const inputsToValidate = currentStepElement.querySelectorAll('input[required], select[required]');

                inputsToValidate.forEach(input => {
                    const validationType = input.getAttribute('data-validate');
                    if (!validateField(input, validationType)) {
                        isValid = false;
                    }
                });
            }
            else if (step === 3) {
                const termsCheckbox = document.getElementById('terms-checkbox');
                const termsError = document.getElementById('terms-error');

                if (!termsCheckbox || !termsCheckbox.checked) {
                    isValid = false;
                    if (termsError) termsError.classList.remove('hidden');
                } else {
                    if (termsError) termsError.classList.add('hidden');
                }
            }

            return isValid;
        }

    }

    function initFormValidation() {
        const inputs = document.querySelectorAll('input[data-validate], select[data-validate]');
        inputs.forEach(input => {
            const validationType = input.getAttribute('data-validate');

            input.addEventListener('input', () => {
                validateField(input, validationType);
                if (input.id === 'password') {
                    const confirmInput = document.getElementById('password_confirmation');
                    if (confirmInput) {
                        validateField(confirmInput, confirmInput.getAttribute('data-validate'));
                    }
                }
            });

            input.addEventListener('blur', () => {
                validateField(input, validationType);
            });
        });
    }

    function validateField(input, type) {
        if (!input) return false;

        const value = input.value.trim();
        const parentDiv = input.closest('div.relative');
        const validIcon = parentDiv ? parentDiv.querySelector('.validation-icon.valid') : null;
        const invalidIcon = parentDiv ? parentDiv.querySelector('.validation-icon.invalid') : null;

        const fieldContainer = input.closest('div:not(.relative)');
        const errorMessage = fieldContainer ? fieldContainer.querySelector('p.validation-message, p.text-red-500:not(.validation-message)') : null;

        let isValid = false;
        let specificErrorMessage = "";

        switch (type) {
            case 'name':
                isValid = value.length >= 2 && /^[a-zA-ZÀ-ÿ\s'-]+$/.test(value);
                specificErrorMessage = "Doit contenir au moins 2 lettres.";
                break;
            case 'email':
                isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                specificErrorMessage = "Format d'email invalide.";
                break;
            case 'phone':
                isValid = /^(\+\d{1,3}\s?)?(\(?\d{1,4}\)?\s?)?[\d\s-]{7,}$/.test(value);
                specificErrorMessage = "Numéro de téléphone invalide.";
                break;
            case 'password':
                isValid = validatePassword(value);
                break;
            case 'confirm-password':
                const passwordInput = document.getElementById('password');
                const passwordValue = passwordInput ? passwordInput.value : '';
                isValid = value === passwordValue && value.length > 0;
                specificErrorMessage = "Les mots de passe ne correspondent pas.";
                break;
            case 'required':
                if (input.tagName === 'SELECT') {
                    isValid = input.selectedIndex > 0;
                    specificErrorMessage = "Veuillez faire une sélection.";
                } else {
                    isValid = value.length > 0;
                    specificErrorMessage = "Ce champ est requis.";
                }
                break;
            default:
                isValid = true;
        }

        input.classList.remove('border-red-500', 'border-green-500', 'focus:border-red-500', 'focus:border-green-500');
        if (validIcon) validIcon.style.display = 'none';
        if (invalidIcon) invalidIcon.style.display = 'none';
        const serverError = errorMessage && !errorMessage.classList.contains('validation-message');
        if (errorMessage && errorMessage.classList.contains('validation-message') && !serverError) {
            errorMessage.classList.add('hidden');
            errorMessage.textContent = specificErrorMessage;
        }

        if (isValid) {
            input.classList.add('border-green-500', 'focus:border-green-500');
            if (validIcon) validIcon.style.display = 'block';
        } else {
            if (value.length > 0 || input.required) {
                input.classList.add('border-red-500', 'focus:border-red-500');
                if (invalidIcon) invalidIcon.style.display = 'block';
                if (errorMessage && errorMessage.classList.contains('validation-message') && !serverError) {
                    errorMessage.classList.remove('hidden');
                }
            } else {
                input.classList.remove('border-red-500', 'border-green-500', 'focus:border-red-500', 'focus:border-green-500');
            }
        }

        return isValid;
    }

    function initPasswordToggle() {
        const toggles = document.querySelectorAll('.toggle-password');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function () {
                const passwordInput = this.previousElementSibling;

                if (passwordInput && (passwordInput.tagName === 'INPUT')) {
                    const currentType = passwordInput.getAttribute('type');
                    const newType = currentType === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', newType);

                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    }
                } else {
                    console.warn("Could not find password input for toggle:", this);
                }
            });
        });
    }

    function initPasswordStrengthMeter() {
        const passwordInput = document.getElementById('password');
        const strengthMeter = document.querySelector('.password-strength-value');
        const strengthText = document.getElementById('strength-text');

        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const numberCheck = document.getElementById('number-check');
        const specialCheck = document.getElementById('special-check');

        const checkElements = {
            length: lengthCheck,
            uppercase: uppercaseCheck,
            lowercase: lowercaseCheck,
            number: numberCheck,
            special: specialCheck
        };

        if (passwordInput && strengthMeter && strengthText) {
            passwordInput.addEventListener('input', () => {
                const passwordValue = passwordInput.value;
                const strengthPercentage = calculatePasswordStrength(passwordValue);
                const requirementsMet = checkPasswordRequirements(passwordValue);

                strengthMeter.style.width = `${strengthPercentage}%`;
                if (strengthPercentage < 20) {
                    strengthMeter.style.backgroundColor = 'var(--error-color)';
                    strengthText.textContent = 'Trop court';
                } else if (strengthPercentage < 40) {
                    strengthMeter.style.backgroundColor = 'var(--error-color)';
                    strengthText.textContent = 'Faible';
                } else if (strengthPercentage < 60) {
                    strengthMeter.style.backgroundColor = 'var(--warning-color)';
                    strengthText.textContent = 'Moyen';
                } else if (strengthPercentage < 80) {
                    strengthMeter.style.backgroundColor = 'var(--success-color)';
                    strengthText.textContent = 'Fort';
                } else {
                    strengthMeter.style.backgroundColor = 'var(--success-color)';
                    strengthText.textContent = 'Très fort';
                }

                updateRequirementIndicators(requirementsMet, checkElements);
            });
        } else {
            console.warn("Password strength meter elements not found.");
        }
    }

    function checkPasswordRequirements(password) {
        return {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(password)
        };
    }

    function updateRequirementIndicators(requirementsMet, checkElements) {
        for (const requirement in requirementsMet) {
            const element = checkElements[requirement];
            if (element) {
                const isMet = requirementsMet[requirement];
                element.classList.toggle('text-green-500', isMet);
                element.classList.toggle('text-gray-300', !isMet);
                element.classList.toggle('fa-check-circle', isMet);
                element.classList.toggle('fa-circle', !isMet);
            }
        }
    }

    function calculatePasswordStrength(password) {
        let strength = 0;
        const requirements = checkPasswordRequirements(password);

        if (password.length === 0) return 0;

        if (requirements.length) strength += 25;

        if (requirements.uppercase) strength += 15;
        if (requirements.lowercase) strength += 15;
        if (requirements.number) strength += 15;
        if (requirements.special) strength += 15;

        if (password.length >= 12) strength += 10;
        if (password.length >= 16) strength += 5;

        return Math.min(strength, 100);
    }

    function validatePassword(password) {
        const requirements = checkPasswordRequirements(password);
        return Object.values(requirements).every(met => met === true);
    }

    function createParticles() {
        const particlesContainer = document.querySelector('.particles');
        if (!particlesContainer) return;

        let particleCount = window.innerWidth < 768 ? 25 : 50;

        const fragment = document.createDocumentFragment();
        const styleFragment = document.createDocumentFragment();

        const colors = ['var(--primary-color)', 'var(--secondary-color)', '#26c6da', 'rgba(255, 255, 255, 0.2)'];

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');

            const size = Math.random() * (window.innerWidth < 768 ? 10 : 15) + 5;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;

            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;

            particle.style.opacity = Math.random() * 0.3 + 0.05;

            particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];

            const animDuration = Math.random() * 20 + 15;
            const animDelay = Math.random() * -30;

            const animName = `float-${i}`;
            particle.style.animation = `${animName} ${animDuration}s linear infinite`;
            particle.style.animationDelay = `${animDelay}s`;

            const xEnd = (Math.random() - 0.5) * 150;
            const yEnd = (Math.random() - 0.5) * 150;
            const rotateEnd = (Math.random() - 0.5) * 90;

            const keyframes = `
                 @keyframes ${animName} {
                     0% {
                         transform: translate(0, 0) rotate(0deg);
                     }
                     100% {
                          transform: translate(${xEnd}px, ${yEnd}px) rotate(${rotateEnd}deg);
                     }
                 }
             `;

            const style = document.createElement('style');
            style.textContent = keyframes;
            styleFragment.appendChild(style);

            fragment.appendChild(particle);
        }

        document.head.appendChild(styleFragment);
        particlesContainer.appendChild(fragment);
    }

    function createConfetti() {
        const confettiContainer = document.body;
        const colors = ['#0288D1', '#4CAF50', '#26c6da', '#FFC107', '#FF9800', '#f44336', '#9c27b0'];
        const confettiCount = 100;

        if (!document.getElementById('confetti-styles')) {
            const confettiKeyframes = `
                @keyframes confetti-fall {
                    0% {
                        transform: translateY(-10vh) rotate(0deg);
                        opacity: 1;
                    }
                    100% {
                        transform: translateY(110vh) rotate(720deg);
                        opacity: 0;
                    }
                }
            `;
            const styleSheet = document.createElement("style");
            styleSheet.id = 'confetti-styles';
            styleSheet.textContent = confettiKeyframes;
            document.head.appendChild(styleSheet);
        }

        for (let i = 0; i < confettiCount; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';

            confetti.style.left = `${Math.random() * 100}vw`;
            confetti.style.top = `${Math.random() * -20 - 5}vh`;

            const size = Math.random() * 8 + 4;
            confetti.style.width = `${size}px`;
            confetti.style.height = `${size}px`;

            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];

            confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
            if (Math.random() > 0.7) {
                confetti.style.borderRadius = '50%';
            }

            const animDuration = Math.random() * 3 + 2;
            const animDelay = Math.random() * 1;

            confetti.style.animation = `confetti-fall ${animDuration}s ease-in ${animDelay}s forwards`;

            confettiContainer.appendChild(confetti);

            setTimeout(() => {
                confetti.remove();
            }, (animDuration + animDelay + 0.5) * 1000);
        }
    }
});