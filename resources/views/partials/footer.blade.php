<footer class="bg-gray-800 text-white">
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="mb-8 md:mb-0">
                <div class="flex items-center mb-6">
                    <div class="relative mr-2">
                        <i class="fas fa-utensils text-[#4CAF50] text-3xl absolute -top-1 -left-1 opacity-30" aria-hidden="true"></i>
                        <i class="fas fa-utensils text-[#0288D1] text-3xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold bg-gradient-to-r from-[#0288D1] to-[#4CAF50] bg-clip-text text-transparent">OctoPOS</span>
                </div>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    Le système de point de vente moderne conçu spécialement pour les restaurants, offrant une expérience utilisateur inégalée pour vous et vos clients.
                </p>
                <div class="flex space-x-5">
                    <a href="#" class="text-gray-400 hover:text-[#0288D1] transition duration-300 text-xl" aria-label="Facebook">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-[#0288D1] transition duration-300 text-xl" aria-label="Instagram">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-[#0288D1] transition duration-300 text-xl" aria-label="Twitter">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-[#0288D1] transition duration-300 text-xl" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="mb-8 md:mb-0">
                <h3 class="text-xl font-bold mb-6 relative inline-block">
                    Liens Rapides
                    <div class="w-full h-1 bg-[#0288D1] absolute -bottom-1 left-0"></div>
                </h3>
                <ul class="space-y-4">
                    <li>
                        <a href="#about" class="text-gray-400 hover:text-white transition duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-[#0288D1]" aria-hidden="true"></i> À propos
                        </a>
                    </li>
                    <li>
                        <a href="#menu" class="text-gray-400 hover:text-white transition duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-[#0288D1]" aria-hidden="true"></i> Menu
                        </a>
                    </li>
                    <li>
                        <a href="#tables" class="text-gray-400 hover:text-white transition duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-[#0288D1]" aria-hidden="true"></i> Réservations
                        </a>
                    </li>
                    <li>
                        <a href="#chefs" class="text-gray-400 hover:text-white transition duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-[#0288D1]" aria-hidden="true"></i> Nos Chefs
                        </a>
                    </li>
                    <li>
                        <a href="#contact" class="text-gray-400 hover:text-white transition duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-[#0288D1]" aria-hidden="true"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-8 md:mb-0">
                <h3 class="text-xl font-bold mb-6 relative inline-block">
                    Heures d'ouverture
                    <div class="w-full h-1 bg-[#4CAF50] absolute -bottom-1 left-0"></div>
                </h3>
                <ul class="space-y-4">
                    <li class="flex justify-between border-b border-gray-700 pb-2">
                        <span class="text-gray-400">Lundi - Vendredi:</span>
                        <span class="text-white">11h00 - 22h00</span>
                    </li>
                    <li class="flex justify-between border-b border-gray-700 pb-2">
                        <span class="text-gray-400">Samedi:</span>
                        <span class="text-white">10h00 - 23h00</span>
                    </li>
                    <li class="flex justify-between border-b border-gray-700 pb-2">
                        <span class="text-gray-400">Dimanche:</span>
                        <span class="text-white">10h00 - 23h00</span>
                    </li>
                    <li class="flex justify-between border-b border-gray-700 pb-2">
                        <span class="text-gray-400">Jours fériés:</span>
                        <span class="text-white">12h00 - 22h00</span>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-6 relative inline-block">
                    Newsletter
                    <div class="w-full h-1 bg-gradient-to-r from-[#0288D1] to-[#4CAF50] absolute -bottom-1 left-0"></div>
                </h3>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    Inscrivez-vous pour recevoir les dernières nouvelles, offres spéciales et mises à jour du système OctoPOS.
                </p>
                <form class="flex flex-col space-y-4">
                    @csrf
                    <div class="relative">
                        <input type="email" placeholder="Votre email" aria-label="Votre email pour la newsletter"
                               class="w-full px-5 py-4 rounded-full pr-12 bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-[#0288D1] text-white placeholder-gray-400">
                        <button type="button" aria-label="S'abonner"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-[#0288D1] to-[#4CAF50] w-10 h-10 rounded-full flex items-center justify-center hover:from-[#4CAF50] hover:to-[#0288D1] transition duration-300">
                            <i class="fas fa-paper-plane text-white" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</footer>