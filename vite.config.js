import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      hotFile: 'public/vendor/eloquent-stalker/eloquent-stalker.hot', // Most important lines
      buildDirectory: 'dist', // Most important lines
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  build: {
    outDir: 'resources/dist'
  }
});
