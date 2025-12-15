import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',           // expose to Docker network
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost', // browser connects here
            port: 5173
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
