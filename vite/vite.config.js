import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'path';

export default defineConfig({
    root: './src',  // Set the root directory for Vite
    base: '/wp-content/themes/WineDivi/assets/',  // Output base path for production
    plugins: [
        react({
            include: "**/*.{jsx,js,ts,tsx}", // Support JSX, JS, TS, TSX
        })
    ],
    build: {
        outDir: resolve(__dirname, '../assets'),  // Output directory changed to assets
        emptyOutDir: true,
        manifest: true,  // Manifest for asset references in WordPress
        sourcemap: true, // Enable source maps for JS and CSS
        minify: 'esbuild', // can  Use Terser for minification 'terser'
        terserOptions: {
            compress: {
                drop_console: true, // Remove console logs
            },
        },
        rollupOptions: {
            input: {

                // Vanilla JS entry points
                main: resolve(__dirname, '../src/js/vanilla/main.js'),

                // React entry point
                // react: resolve(__dirname, '../src/js/react/main.jsx'),  // React entry

                // Vanilla JS entry points
                admin: resolve(__dirname, '../src/js/admin/main.js'),

                // SCSS entry points
                style: resolve(__dirname, '../src/scss/main.scss'),

            },
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: 'css/[name].[ext]',

            },
        },
    },
    css: {
        preprocessorOptions: {
            // scss: {
            //     additionalData: `@use "base/variables" as *;`
            // },
        },
    },
    server: {
        // Configure dev server to use your local domain
        host: 'non-alcoholic-wines.loc',
        port: 3000,
        open: true, // Automatically open the browser
        hmr: {
            host: 'non-alcoholic-wines.loc',
        }
    }
});