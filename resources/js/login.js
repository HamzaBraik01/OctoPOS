document.addEventListener('DOMContentLoaded', () => {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Adapt UI based on device
    adaptUIToDevice();

    // Create particles for background effect
    createParticles();

    // Toggle password visibility
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');

    if (togglePassword && passwordField) {
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle eye icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    // Form validation
    const loginForm = document.getElementById('login-form');
    const emailField = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    if (emailField && passwordField) {
        // Client-side validation
        emailField.addEventListener('blur', function() {
            if (this.value && !isValidEmail(this.value)) {
                emailError.classList.remove('hidden');
                this.classList.add('border-red-500');
            } else {
                emailError.classList.add('hidden');
                this.classList.remove('border-red-500');
            }
        });

        passwordField.addEventListener('blur', function() {
            if (this.value && this.value.length < 6) {
                passwordError.classList.remove('hidden');
                this.classList.add('border-red-500');
            } else {
                passwordError.classList.add('hidden');
                this.classList.remove('border-red-500');
            }
        });

        // Remove validation errors on input
        emailField.addEventListener('input', function() {
            emailError.classList.add('hidden');
            this.classList.remove('border-red-500');
        });

        passwordField.addEventListener('input', function() {
            passwordError.classList.add('hidden');
            this.classList.remove('border-red-500');
        });
    }

    // Handle resize events for responsive adjustments
    window.addEventListener('resize', debounce(function() {
        adaptUIToDevice();
    }, 250));
});

// Detect touch devices and adapt UI
function adaptUIToDevice() {
    const isMobile = window.innerWidth < 640;

    // Adjust UI based on device type
    if (isMobile) {
        // Optimize for mobile
        document.querySelectorAll('.social-icon').forEach(icon => {
            icon.classList.remove('w-12', 'h-12');
            icon.classList.add('w-14', 'h-14');
        });
    } else {
        // Restore default size
        document.querySelectorAll('.social-icon').forEach(icon => {
            icon.classList.remove('w-14', 'h-14');
            icon.classList.add('w-12', 'h-12');
        });
    }
}

// Email validation helper
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Debounce helper function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Create particle animation
function createParticles() {
    const particlesContainer = document.querySelector('.particles');
    if (!particlesContainer) return;

    // Adjust particle count based on device capability
    let particleCount = window.innerWidth < 768 ? 20 : 50;

    // Create document fragment for better performance
    const fragment = document.createDocumentFragment();
    const styleFragment = document.createDocumentFragment();

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');

        // Random size
        const size = window.innerWidth < 768 ? Math.random() * 15 + 5 : Math.random() * 20 + 5;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;

        // Random position
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;

        // Random opacity
        const opacity = Math.random() * 0.08 + 0.02;
        particle.style.opacity = opacity;

        // Random color
        const colors = ['#0288D1', '#4CAF50', '#26c6da'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        particle.style.background = randomColor;

        // Animation
        const animDuration = Math.random() * 20 + 20;
        const animName = `float-${i}`;
        particle.style.animation = `${animName} ${animDuration}s ease-in-out infinite`;
        particle.style.animationDelay = `${Math.random() * -40}s`;

        // Add floating animation
        const keyframes = `
            @keyframes ${animName} {
                0%, 100% {
                    transform: translate(0, 0) rotate(0deg);
                }
                25% {
                    transform: translate(${Math.random() * 80 - 40}px, ${Math.random() * 40 - 20}px) rotate(${Math.random() * 15 - 7.5}deg);
                }
                50% {
                    transform: translate(${Math.random() * 80 - 40}px, ${Math.random() * 40 - 20}px) rotate(${Math.random() * 15 - 7.5}deg);
                }
                75% {
                    transform: translate(${Math.random() * 80 - 40}px, ${Math.random() * 40 - 20}px) rotate(${Math.random() * 15 - 7.5}deg);
                }
            }
        `;

        const style = document.createElement('style');
        style.appendChild(document.createTextNode(keyframes));
        styleFragment.appendChild(style);

        fragment.appendChild(particle);
    }

    // Batch DOM updates
    document.head.appendChild(styleFragment);
    particlesContainer.appendChild(fragment);
}