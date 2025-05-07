{{-- resources/views/partials/cuisiniers/footer.blade.php --}}
<footer class="py-4 px-6 border-t border-border-color dark:border-gray-700 mt-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} OctoPOS - Système de gestion de restaurant
            </p>
        </div>
        <div class="flex space-x-4">
            <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary">Aide</a>
            <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary">Support technique</a>
            <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary">À propos</a>
        </div>
    </div>
</footer>