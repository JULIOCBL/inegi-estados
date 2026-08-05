import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/views/states-index.js',
                'resources/js/views/states-paginated.js',
                'resources/js/views/states-municipalities.js',
            ],
            refresh: true,
        }),
    ],
});
