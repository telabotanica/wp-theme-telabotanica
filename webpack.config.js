const webpack = require('webpack')
const autoprefixer = require('autoprefixer')
const pixrem = require('pixrem')
const postcss = require('postcss')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const path = require('path')

const extractBundle = new ExtractTextPlugin('bundle.css');
const extractEditorStyle = new ExtractTextPlugin('editor-style.css');

module.exports = {
  entry: './assets/scripts/main.js',
  output: {
    path: './dist',
    filename: 'bundle.js'
  },
  module: {
    loaders: [
      {
        test: /main\.scss$/,
        loader: extractBundle.extract({
          fallbackLoader: 'style',
          loader: [
            'css',
            'postcss',
            'sass'
          ]
        })
      },
      {
        test: /editor-style\.scss$/,
        loader: extractEditorStyle.extract({
          fallbackLoader: 'style',
          loader: [
            'css',
            'postcss',
            'sass'
          ]
        })
      },
      {
        test: /\.svg$/,
        exclude: [
          path.resolve(__dirname, "assets/fonts")
        ],
        loader: 'svg-url-loader'
      },
      {
        test: /\.(eot|svg|ttf|woff|woff2)$/,
        include: [
          path.resolve(__dirname, "assets/fonts")
        ],
        loader: 'file?name=fonts/[name].[ext]'
      }
    ]
  },
  plugins: [
    extractBundle,
    extractEditorStyle,
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
    // Make $ and jQuery available in every module without writing require("jquery")
    new webpack.ProvidePlugin({
      $: "jquery"
    }),
  ],
  externals: {
    // require("jquery") is external and available
    //  on the global var jQuery
    "jquery": "jQuery"
  }
}
