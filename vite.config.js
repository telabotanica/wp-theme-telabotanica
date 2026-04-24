import { defineConfig } from 'vite'
import { createSvgIconsPlugin } from 'vite-plugin-svg-icons'
import path from 'path'

export default defineConfig({
  plugins: [
    createSvgIconsPlugin({
      iconDirs: [path.resolve(__dirname, 'assets/icons')],
      symbolId: 'icon-[name]'
    })
  ],
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: {
        bundle: path.resolve(__dirname, 'assets/scripts/main.js'),
        'editor-style': path.resolve(__dirname, 'assets/styles/editor-style.scss'),
        'login-style': path.resolve(__dirname, 'assets/styles/login-style.scss')
      },
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
