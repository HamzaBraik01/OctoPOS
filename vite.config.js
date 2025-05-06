import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

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
                'resources/css/serveur.css',
                'resources/js/serveur.js',
                'resources/css/register.css',
                'resources/js/register.js',
                'resources/js/app.js', 
                'resources/css/app.css',
            ],
            refresh: true,
        }),
    ],
});
