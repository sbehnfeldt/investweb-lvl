import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: {
                funds: 'resources/js/funds.js',
                fundForm: 'resources/js/fund-form.js',
                accounts: 'resources/js/accounts.js',
                accountForm: 'resources/js/account-form.js'
            },
            refresh: true,
        }),
    ],
});
