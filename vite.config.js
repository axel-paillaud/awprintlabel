import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  // Disable public directory to avoid conflict with build output
  publicDir: false,
  
  build: {
    // Output directory
    outDir: 'public',
    emptyOutDir: true,

    // Generate manifest for cache busting
    manifest: true,

    rollupOptions: {
      input: {
        // Admin print label page
        'print-label': resolve(__dirname, '_dev/js/admin/print-label.js'),
      },
      output: {
        // Organize output files
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          // Organize CSS files
          if (assetInfo.names.endsWith('.css')) {
            return 'css/[name][extname]';
          }
          return 'assets/[name]-[hash][extname]';
        },
      },
    },

    // Source maps for debugging
    sourcemap: true,
  },

  server: {
    // Hot reload configuration
    port: 5173,
    strictPort: false,
    open: false,
  },

  // Base URL for assets
  base: '/modules/awprintlabel/public/',
});
