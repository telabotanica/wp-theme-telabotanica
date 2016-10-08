const webpack = require('webpack')
const autoprefixer = require('autoprefixer')
const pixrem = require('pixrem')
const postcss = require('postcss')
const ExtractTextPlugin = require('extract-text-webpack-plugin')

module.exports = {
  entry: './assets/scripts/main.js',
  output: {
    path: './dist',
    publicPath: '/wp-content/themes/telabotanica/dist/',
    filename: 'bundle.js'
  },
  module: {
    loaders: [
      {
        test: /\.scss$/,
        //include: './assets/styles',
        loader: ExtractTextPlugin.extract({
          fallbackLoader: 'style',
          loader: [
            'css',
            'postcss',
            'sass'
          ]
        })
      }
    ]
  },
  plugins: [
    new ExtractTextPlugin('bundle.css'),
    new webpack.optimize.UglifyJsPlugin(),
    new webpack.LoaderOptionsPlugin({
      minimize: true,
      postcss: [
        autoprefixer({
          browsers: [
            'last 5 versions',
            'android 4',
            'opera 12',
          ],
        }),
      ],
    }),
  ]
}
