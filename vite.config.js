import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/style.css',
                'resources/js/script.js',
                'resources/css/app.css',
                'resources/css/login.css',
                'resources/js/app.js',
                'resources/js/login.js',
                'resources/css/client-dashboard.css',
                'resources/js/client-dashboard.js',
                'resources/css/gerant.css',
                'resources/js/gerant.js',
                'resources/css/proprietaire.css',
                'resources/js/proprietaire.js',
                'resources/css/serveur.css',
                'resources/js/serveur.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
