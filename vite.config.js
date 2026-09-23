import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),

        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

        VitePWA({
            registerType: 'autoUpdate',

            /*
             * Laravel menyimpan hasil Vite di public/build.
             */
            outDir: 'public/build',

            buildBase: '/build/',

            /*
             * PWA tetap berjalan dari root website.
             */
            base: '/',

            scope: '/',

            /*
             * Kita akan mendaftarkan service worker
             * secara manual dari app.blade.php.
             */
            injectRegister: false,

            /*
             * PWA hanya aktif ketika production build.
             */
            devOptions: {
                enabled: false,
            },

            /*
             * Jangan mengambil seluruh folder public
             * ke dalam cache.
             */
            includeAssets: [],

            workbox: {
                globPatterns: [
                    '**/*.{js,css,html,ico,jpg,jpeg,png,svg,woff,woff2,ttf,eot}',
                ],

                /*
                 * Root aplikasi menjadi fallback ketika offline.
                 */
                navigateFallback: '/',

                /*
                 * Root dan icon disimpan ke cache.
                 */
                additionalManifestEntries: [
                    {
                        url: '/',
                        revision: `${Date.now()}`,
                    },

                    {
                        url: '/icons/Logo192x192.png',
                        revision: `${Date.now()}`,
                    },

                    {
                        url: '/icons/Logo512x512.png',
                        revision: `${Date.now()}`,
                    },
                ],

                maximumFileSizeToCacheInBytes: 3000000,
            },

            manifest: {
                name: 'Belajar & Bermain',

                short_name: 'Belajar & Bermain',

                description:
                    'Game pembelajaran sederhana untuk belajar sambil bermain.',

                start_url: '/',

                scope: '/',

                id: '/',

                display: 'standalone',

                background_color: '#bcefff',

                theme_color: '#08777b',

                lang: 'id-ID',

                orientation: 'landscape',

                icons: [
                    {
                        src: '/icons/Logo192x192.png',
                        sizes: '192x192',
                        type: 'image/png',
                    },

                    {
                        src: '/icons/Logo512x512.png',
                        sizes: '512x512',
                        type: 'image/png',
                    },
                ],
            },
        }),
    ],

    build: {
        outDir: 'public/build',

        /*
         * Jangan menghapus file lain di public/build
         * yang mungkin masih dibutuhkan Laravel.
         */
        emptyOutDir: false,
    },
});