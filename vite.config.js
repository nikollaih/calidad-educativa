import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import preact from '@preact/preset-vite';
import path from 'path';

export default defineConfig({
    server: {
        cors: {
        origin: 'https://calidad-educativa.dev', // Allow requests from your app's origin
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        preact()
    ],

    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@utils': path.resolve(__dirname, 'resources/js/utilidades')
        }
    }
});
