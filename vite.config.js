import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';

const host = 'localhost';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host,
        hmr: { host },
        https: {
            key: fs.readFileSync(`./node/${host}.key`),
            cert: fs.readFileSync(`./node/${host}.crt`),
        },
    },
});
