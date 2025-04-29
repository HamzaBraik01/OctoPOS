{{-- resources/views/partials/gerants/footer.blade.php --}}
<footer class="mt-auto text-gray-500 dark:text-gray-400 text-xs p-6 border-t border-gray-200 dark:border-gray-700">
    <div class="flex flex-col md:flex-row justify-between items-center gap-2">
        <div class="text-center md:text-left">
            <p>© {{ date('Y') }} OctoPOS. Tous droits réservés.</p> {{-- Année dynamique --}}
            <p>Version 3.4.2 | Dernière mise à jour: 2025-04-29</p> {{-- Peut être dynamique --}}
        </div>
        <div class="flex space-x-4">
            {{-- Les liens peuvent être des routes nommées --}}
            <a href="#" class="hover:text-primary dark:hover:text-primary">Conditions</a>
            <a href="#" class="hover:text-primary dark:hover:text-primary">Confidentialité</a>
            <a href="#" class="hover:text-primary dark:hover:text-primary">Assistance</a>
        </div>
    </div>
</footer>