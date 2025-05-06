{{-- resources/views/partials/gerants/footer.blade.php --}}
 <footer class="p-6 text-gray-500 dark:text-gray-400 text-sm border-t border-gray-200 dark:border-gray-700 mt-auto"> {{-- mt-auto si main est flex col --}}
     <div class="flex flex-col md:flex-row justify-between items-center">
         <div>
             <p>© {{ date('Y') }} OctoPOS. Tous droits réservés.</p>
             <p>Version 3.4.2 | Dernière mise à jour: 2025-04-29</p> {{-- Peut être dynamique --}}
         </div>
         <div class="mt-2 md:mt-0">
             {{-- Remplacer # par des routes réelles si nécessaire --}}
             <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 mx-2">Conditions d'utilisation</a>
             <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 mx-2">Confidentialité</a>
             <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 mx-2">Assistance</a>
         </div>
     </div>
 </footer>