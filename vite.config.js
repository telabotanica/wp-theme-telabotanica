import { defineConfig } from 'vite'
import path from 'path'

export default defineConfig({
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: {
        bundle: path.resolve(__dirname, 'assets/scripts/main.js'),
        'editor-style': path.resolve(__dirname, 'assets/styles/editor-style.scss'),
        'login-style': path.resolve(__dirname, 'assets/styles/login-style.scss')
      },
      external: ['leaflet'],
      output: {
        entryFileNames: '[name].js',
        assetFileNames: (assetInfo) => {
          if (!assetInfo.name) return '[name][extname]'
          if (assetInfo.name.endsWith('.css')) {
            return '[name][extname]'
          }
          if (/\.(woff2?|ttf|eot|otf)$/.test(assetInfo.name)) {
            return 'fonts/[name][extname]'
          }
          if (/\.(png|jpe?g|gif|svg)$/.test(assetInfo.name)) {
            return 'images/[name][extname]'
          }
          return '[name][extname]'
        }
      }
    }
  },
  css: {
    postcss: {
      plugins: [
        require('autoprefixer')
      ]
    }
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'assets')
    }
  }
})
