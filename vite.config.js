<<<<<<< HEAD
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
=======
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/filament/admin/theme.css",
            ],
=======
            input: ['resources/css/app.css', 'resources/js/app.js'],
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            refresh: true,
        }),
    ],
});
