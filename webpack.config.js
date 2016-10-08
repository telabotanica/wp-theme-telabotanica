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
        loader: ExtractTextPlugin.extract(
          'style', // backup loader when not building .css file
          'css!sass' // loaders to preprocess CSS
        )
      }
    ]
  },
  plugins: [
    new ExtractTextPlugin('../style.css'),
  ]
}
