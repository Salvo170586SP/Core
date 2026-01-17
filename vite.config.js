import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        port: 5173,
        strictPort: false, // Trova automaticamente una porta disponibile se 5173 è occupata
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
