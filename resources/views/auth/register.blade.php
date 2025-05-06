@extends('layouts.guest') {{-- Or your main app layout --}}

@section('title', 'Inscription')
@section('description', 'Inscription à OctoPOS - Créez votre compte pour notre système de point de vente pour restaurants.')

@push('styles')
    @vite('resources/css/register.css')
@endpush

@section('content')
<div class="register-card bg-white rounded-2xl overflow-hidden mb-8">
    <!-- Card Header -->
    <div class="bg-gradient-to-r from-[#0288D1] to-[#026da8] px-6 sm:px-8 py-5 sm:py-6 text-white">
        <h1 class="text-xl sm:text-2xl font-bold mb-1">Créer votre compte</h1>
        <p class="text-white/80 text-sm sm:text-base">Rejoignez la communauté OctoPOS</p>
    </div>

    <!-- Multi-Step Progress Indicator -->
    <div class="px-6 sm:px-8 pt-8">
        <div class="step-indicator">
            <div class="step-line"></div>
            <div class="step-progress" style="width: 0%"></div>
            <div class="step active" data-step="1">1<span class="step-label">Informations</span></div>
            <div class="step" data-step="2">2<span class="step-label">Identifiants</span></div>
            <div class="step" data-step="3">3<span class="step-label">Confirmation</span></div>
            <div class="step" data-step="4"><i class="fas fa-check"></i><span class="step-label">Terminé</span></div>
        </div>
    </div>

    <!-- Card Body -->
    <div class="px-6 sm:px-8 pb-8">
        <form id="register-form" method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <!-- Step 1: Personal Information -->
            <div class="form-step active" data-step="1">
                <div class="space-y-4">
                    <!-- First Name -->
                    <div>
                        <label for="first-name" class="block text-gray-700 text-sm font-medium mb-2">Prénom <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-user text-[#0288D1]"></i></div>
                            <input id="first-name" name="first_name" type="text" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-50 border rounded-lg focus:outline-none transition input-focus-effect @error('first_name') border-red-500 @else border-gray-200 focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 @enderror" placeholder="Votre prénom" value="{{ old('first_name') }}" data-validate="name" required>
                            <div class="validation-icon valid"><i class="fas fa-check-circle"></i></div>
                            <div class="validation-icon invalid"><i class="fas fa-times-circle"></i></div>
                        </div>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @else
                            <p class="validation-message hidden mt-1 text-sm text-red-500">Veuillez entrer un prénom valide</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last-name" class="block text-gray-700 text-sm font-medium mb-2">Nom <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-user text-[#0288D1]"></i></div>
                            <input id="last-name" name="last_name" type="text" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-50 border rounded-lg focus:outline-none transition input-focus-effect @error('last_name') border-red-500 @else border-gray-200 focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 @enderror" placeholder="Votre nom" value="{{ old('last_name') }}" data-validate="name" required>
                            <div class="validation-icon valid"><i class="fas fa-check-circle"></i></div>
                            <div class="validation-icon invalid"><i class="fas fa-times-circle"></i></div>
                        </div>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @else
                            <p class="validation-message hidden mt-1 text-sm text-red-500">Veuillez entrer un nom valide</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Téléphone <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-phone text-[#0288D1]"></i></div>
                            <input id="phone" name="phone" type="tel" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-50 border rounded-lg focus:outline-none transition input-focus-effect @error('phone') border-red-500 @else border-gray-200 focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 @enderror" placeholder="+33 1 23 45 67 89" value="{{ old('phone') }}" data-validate="phone" required>
                            <div class="validation-icon valid"><i class="fas fa-check-circle"></i></div>
                            <div class="validation-icon invalid"><i class="fas fa-times-circle"></i></div>
                        </div>
                         @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @else
                            <p class="validation-message hidden mt-1 text-sm text-red-500">Veuillez entrer un numéro de téléphone valide</p>
                        @enderror
                    </div>

                    <!-- Restaurant Name Dropdown -->
                    <div>
                        <label for="restaurant-name" class="block text-gray-700 text-sm font-medium mb-2">Nom du restaurant <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-store text-[#0288D1]"></i></div>
                            <select id="restaurant-name" name="restaurant_id" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-50 border rounded-lg focus:outline-none transition input-focus-effect appearance-none @error('restaurant_id') border-red-500 @else border-gray-200 focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 @enderror" data-validate="required" required>
                                <option value="" disabled {{ old('restaurant_id') ? '' : 'selected' }}>Sélectionnez un restaurant</option>
                                @forelse($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}" {{ old('restaurant_id') == $restaurant->id ? 'selected' : '' }}>{{ $restaurant->nom }}</option>
                                @empty
                                    <option value="" disabled>Aucun restaurant disponible</option>
                                @endforelse
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"><i class="fas fa-chevron-down text-gray-400"></i></div>
                        </div>
                        @error('restaurant_id')
                             <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @else
                            <p class="validation-message hidden mt-1 text-sm text-red-500">Veuillez sélectionner un restaurant</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="button" class="next-step bg-gradient-to-r from-[#0288D1] to-[#4CAF50] hover:from-[#026da8] hover:to-[#3d8b40] text-white py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center font-semibold shadow-lg hover:shadow-xl">
                        Continuer <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Account Information -->
            <div class="form-step" data-step="2">
                <div class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-envelope text-[#0288D1]"></i></div>
                            <input id="email" name="email" type="email" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-50 border rounded-lg focus:outline-none transition input-focus-effect @error('email') border-red-500 @else border-gray-200 focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 @enderror" placeholder="votre@email.com" value="{{ old('email') }}" data-validate="email" required>
                             <div class="validation-icon valid"><i class="fas fa-check-circle"></i></div>
                             <div class="validation-icon invalid"><i class="fas fa-times-circle"></i></div>
                        </div>
                         @error('email')
                             <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @else
                            <p class="validation-message hidden mt-1 text-sm text-red-500">Veuillez entrer une adresse email valide</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Mot de passe <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-lock text-[#0288D1]"></i></div>
                            <input id="password" name="password" type="password" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-50 border rounded-lg focus:outline-none transition input-focus-effect @error('password') border-red-500 @else border-gray-200 focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 @enderror" placeholder="Votre mot de passe" data-validate="password" required>
                            <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500 hover:text-[#0288D1] transition">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength-meter mt-2">
                            <div class="password-strength-value" style="width: 0%;"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 flex justify-between">
                            <span>Force du mot de passe:</span>
                            <span id="strength-text">Trop court</span>
                        </div>
                         @error('password')
                             <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                         @enderror
                         <div class="mt-3 @error('password') hidden @enderror">
                            <div class="text-xs text-gray-700 font-semibold mb-1">Votre mot de passe doit contenir:</div>
                            <ul class="text-xs space-y-1">
                                <li class="flex items-start"><i class="fas fa-circle text-gray-300 text-[0.5rem] mt-1 mr-2" id="length-check"></i><span>Au moins 8 caractères</span></li>
                                <li class="flex items-start"><i class="fas fa-circle text-gray-300 text-[0.5rem] mt-1 mr-2" id="uppercase-check"></i><span>Au moins 1 majuscule</span></li>
                                <li class="flex items-start"><i class="fas fa-circle text-gray-300 text-[0.5rem] mt-1 mr-2" id="lowercase-check"></i><span>Au moins 1 minuscule</span></li>
                                <li class="flex items-start"><i class="fas fa-circle text-gray-300 text-[0.5rem] mt-1 mr-2" id="number-check"></i><span>Au moins 1 chiffre</span></li>
                                <li class="flex items-start"><i class="fas fa-circle text-gray-300 text-[0.5rem] mt-1 mr-2" id="special-check"></i><span>Au moins 1 caractère spécial (!@#$%^&*)</span></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                        <div class="relative">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-lock text-[#0288D1]"></i></div>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0288D1] focus:ring-2 focus:ring-[#0288D1]/20 transition input-focus-effect" placeholder="Confirmez votre mot de passe" data-validate="confirm-password" required>
                             <div class="validation-icon valid"><i class="fas fa-check-circle"></i></div>
                             <div class="validation-icon invalid"><i class="fas fa-times-circle"></i></div>
                        </div>
                         <p class="validation-message hidden mt-1 text-sm text-red-500">Les mots de passe ne correspondent pas</p>
                    </div>
                </div>
                <div class="mt-8 flex justify-between">
                    <button type="button" class="prev-step bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Retour
                    </button>
                    <button type="button" class="next-step bg-gradient-to-r from-[#0288D1] to-[#4CAF50] hover:from-[#026da8] hover:to-[#3d8b40] text-white py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center font-semibold shadow-lg hover:shadow-xl">
                        Continuer <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Terms & Conditions -->
            <div class="form-step" data-step="3">
                <div class="space-y-6">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <div class="flex items-start">
                            <div class="mt-0.5 text-blue-500"><i class="fas fa-info-circle text-lg"></i></div>
                            <div class="ml-3 text-sm text-blue-700">
                                <h4 class="font-semibold mb-1">Dernière étape avant de créer votre compte</h4>
                                <p>Veuillez vérifier vos informations et accepter les conditions d'utilisation pour continuer.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800 mb-2">Récapitulatif de vos informations</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div><span class="text-gray-500">Nom complet:</span><span class="text-gray-800 font-medium ml-1" id="summary-name"></span></div>
                                <div><span class="text-gray-500">Email:</span><span class="text-gray-800 font-medium ml-1" id="summary-email"></span></div>
                                <div><span class="text-gray-500">Téléphone:</span><span class="text-gray-800 font-medium ml-1" id="summary-phone"></span></div>
                                <div><span class="text-gray-500">Restaurant:</span><span class="text-gray-800 font-medium ml-1" id="summary-restaurant"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <label class="custom-checkbox mt-1">
                                <input type="checkbox" id="terms-checkbox" name="terms" required {{ old('terms') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <div class="text-sm text-gray-700">
                                J'accepte les <a href="#" class="text-[#0288D1] hover:underline">Conditions d'utilisation</a> et la <a href="#" class="text-[#0288D1] hover:underline">Politique de confidentialité</a> d'OctoPOS. <span class="text-red-500">*</span>
                            </div>
                        </div>
                        @error('terms')
                            <p class="mt-1 text-sm text-red-500 ml-6">{{ $message }}</p>
                        @else
                            <p id="terms-error" class="hidden mt-1 text-sm text-red-500 ml-6">Vous devez accepter les conditions pour continuer</p>
                        @enderror

                        <div class="flex items-start">
                            <label class="custom-checkbox mt-1">
                                <input type="checkbox" id="marketing-checkbox" name="marketing_opt_in" value="1" {{ old('marketing_opt_in') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <div class="text-sm text-gray-700">
                                J'accepte de recevoir des emails marketing et des newsletters d'OctoPOS. Je peux me désinscrire à tout moment.
                            </div>
                        </div>
                         @error('marketing_opt_in')
                            <p class="mt-1 text-sm text-red-500 ml-6">{{ $message }}</p>
                         @enderror
                    </div>
                </div>
                <div class="mt-8 flex justify-between">
                    <button type="button" class="prev-step bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Retour
                    </button>
                    <button type="submit" id="submit-button" class="bg-gradient-to-r from-[#0288D1] to-[#4CAF50] hover:from-[#026da8] hover:to-[#3d8b40] text-white py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center font-semibold shadow-lg hover:shadow-xl">
                        Créer mon compte <i class="fas fa-check ml-2"></i>
                    </button>
                </div>
            </div>

             <!-- Step 4: Success (Handled by JS after successful redirect/flash message) -->
             <div class="form-step" data-step="4">
                 <div class="text-center py-8">
                     <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                         <i class="fas fa-check text-green-500 text-3xl success-icon"></i>
                     </div>
                     <h3 class="text-2xl font-bold text-gray-800 mb-2">Compte Créé avec Succès!</h3>
                     <p class="text-gray-600 mb-8">Félicitations! Votre compte a été créé. Un email de vérification a été envoyé à votre adresse email.</p>
                      <div>
                         <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-6">
                             <div class="flex items-start">
                                 <div class="mt-0.5 text-blue-500"><i class="fas fa-envelope text-lg"></i></div>
                                 <div class="ml-3 text-sm text-blue-700">
                                     <h4 class="font-semibold mb-1">Vérification nécessaire</h4>
                                     <p>Pour activer votre compte, veuillez cliquer sur le lien de vérification envoyé à :</p>
                                     <p class="font-medium text-blue-800 mt-2" id="success-email">{{ session('registered_email') }}</p>
                                 </div>
                             </div>
                         </div>
                         <div class="flex flex-col sm:flex-row justify-center gap-4">
                             <a href="{{ route('verification.notice') }}" class="bg-gradient-to-r from-[#0288D1] to-[#026da8] hover:from-[#026da8] hover:to-[#0288D1] text-white py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center font-semibold shadow-lg hover:shadow-xl">
                                 <i class="fas fa-envelope-open-text mr-2"></i> Vérifier mon email
                             </a>
                             <a href="{{ url('/') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center font-medium">
                                 <i class="fas fa-home mr-2"></i> Retour à l'accueil
                             </a>
                         </div>
                     </div>
                 </div>
             </div>
        </form>
    </div>
</div>

@if ($errors->any() && !$errors->hasAny(['first_name', 'last_name', 'phone', 'restaurant_id', 'email', 'password', 'terms', 'marketing_opt_in']))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">Quelque chose s'est mal passé. Veuillez réessayer.</span>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection

@push('scripts')
    <script>
        const registrationSuccess = @json(session('registration_success', false));
        const registeredEmail = @json(session('registered_email', ''));
    </script>
    @vite('resources/js/register.js')
@endpush