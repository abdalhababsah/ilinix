import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

// vite.config.js
export default defineConfig({
    plugins: [
      laravel({
        input: ['resources/css/app.css', 'resources/css/chat.css', 'resources/js/app.jsx'],
        refresh: true,
      }),
      react(),
    ],
  });