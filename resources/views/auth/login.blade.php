<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connexion à votre compte OctoPOS - Système de Point de Vente pour Restaurants">
    <title>Connexion - OctoPOS</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/login.css'])
</head>
<body class="bg-gray-800">
    <!-- Animated Particles Background -->
    <div class="particles"></div>

    <!-- Bouton Retour - Position fixe en haut à gauche -->
    <a href="{{ url('/') }}" class="back-link">
        <i class="fas fa-chevron-left mr-2"></i> Retour
    </a>

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 relative z-10">
        <!-- Logo Centré -->
        <div class="w-full max-w-md flex justify-center items-center mb-8">
            <a href="{{ url('/') }}" class="logo-container flex items-center" aria-label="OctoPOS Home">
                <div class="relative mr-2">
                    <i class="fas fa-utensils text-[#4CAF50] text-3xl sm:text-4xl absolute -top-1 -left-1 opacity-30"></i>
                    <i class="fas fa-utensils text-[#0288D1] text-3xl sm:text-4xl"></i>
                </div>
                <span class="logo-text text-3xl sm:text-4xl">OctoPOS</span>
            </a>
        </div>

        <!-- Login Form Card -->
        <div class="w-full max-w-md login-card bg-white rounded-2xl overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-[#0288D1] to-[#026da8] px-6 sm:px-8 py-5 sm:py-6 text-white">
                <h1 class="text-xl sm:text-2xl font-bold mb-1">Connexion</h1>
                <p class="text-white/80 text-sm sm:text-base">Accédez à votre compte OctoPOS</p>
            </div>

            <!-- Card Body -->
            <div class="px-6 sm:px-8 py-6 sm:py-8">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-5 sm:space-y-6">
                    @csrf
                    <!-- Email Field -->
                    <div class="fade-in-up">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-[#0288D1]"></i>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full pl-10 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 transition input-focus-effect" placeholder="votre@email.com" required>
                        </div>
                        <p id="email-error" class="hidden mt-1 text-sm text-red-500">Veuillez entrer une adresse email valide.</p>
                    </div>

                    <!-- Password Field -->
                    <div class="fade-in-up">
                        <div class="flex flex-wrap justify-between items-center mb-2">
                            <label for="password" class="block text-gray-700 text-sm font-medium">Mot de passe</label>
                            <a href="#" class="text-sm text-[#0288D1] hover:underline transition duration-300">Mot de passe oublié?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-[#0288D1]"></i>
                            </div>
                            <input id="password" name="password" type="password" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 transition input-focus-effect" placeholder="Votre mot de passe" required>
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500 hover:text-[#0288D1] transition">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p id="password-error" class="hidden mt-1 text-sm text-red-500">Votre mot de passe doit contenir au moins 6 caractères.</p>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center fade-in-up">
                        <label class="custom-checkbox">
                            <input type="checkbox" id="remember-me" name="remember_me">
                            <span class="checkmark"></span>
                        </label>
                        <span class="text-gray-700 text-sm">Se souvenir de moi</span>
                    </div>

                    <!-- Login Button -->
                    <div class="pt-2 fade-in-up">
                        <button type="submit" id="login-button" class="w-full bg-gradient-to-r from-[#0288D1] to-[#4CAF50] hover:from-[#026da8] hover:to-[#3d8b40] text-white py-3 px-4 rounded-lg transition-all duration-300 flex items-center justify-center font-semibold shadow-lg hover:shadow-xl" style="min-height: 50px;">
                            <i class="fas fa-sign-in-alt mr-2"></i> Se Connecter
                        </button>
                    </div>

                    <!-- Signup Link -->
                    <div class="text-center pt-4 fade-in-up">
                        <p class="text-gray-600">Vous n'avez pas de compte? <a href="{{ url('/register') }}" class="text-[#0288D1] font-semibold hover:underline transition duration-300">S'inscrire</a></p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Social Login Options -->
        <div class="w-full max-w-md mt-6 sm:mt-8 text-center fade-in-up">
            <p class="text-white/80 mb-4">Ou connectez-vous avec</p>
            <div class="flex justify-center gap-4">
                <a href="#" class="social-icon w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition duration-300" aria-label="Se connecter avec Google">
                    <i class="fab fa-google text-white text-lg"></i>
                </a>
                <a href="#" class="social-icon w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition duration-300" aria-label="Se connecter avec Facebook">
                    <i class="fab fa-facebook-f text-white text-lg"></i>
                </a>
                <a href="#" class="social-icon w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition duration-300" aria-label="Se connecter avec Apple">
                    <i class="fab fa-apple text-white text-lg"></i>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 sm:mt-12 text-center text-sm text-white/60 w-full px-4">
            <p>&copy; 2025 OctoPOS. Tous droits réservés.</p>
            <div class="mt-2 flex flex-wrap justify-center gap-2 sm:gap-4">
                <a href="#" class="text-white/60 hover:text-white transition duration-300">Conditions d'utilisation</a>
                <a href="#" class="text-white/60 hover:text-white transition duration-300">Politique de confidentialité</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/login.js'])
</body>
</html>