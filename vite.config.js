import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { homedir } from 'os';
import { resolve } from 'path';
import fs from 'fs';

const host = 'notchpay-integration.test';
let keyPath = resolve(homedir(), `.valet/Certificates/${host}.key`)
let certificatePath = resolve(homedir(), `.valet/Certificates/${host}.crt`)

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        }
    ],
    server: {
        host,
        hmr: { host },
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    },
});
