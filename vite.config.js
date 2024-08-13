import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: {
                funds: 'resources/js/funds.js'
            },
            refresh: true,
        }),
    ],
});
