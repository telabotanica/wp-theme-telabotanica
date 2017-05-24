const webpack = require('webpack')
const postcss = require('postcss')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const path = require('path')

const extractBundle = new ExtractTextPlugin('bundle.css');
const extractEditorStyle = new ExtractTextPlugin('editor-style.css');
const extractLoginStyle = new ExtractTextPlugin('login-style.css');

module.exports = {
	devtool: 'source-map',
	entry: './assets/scripts/main.js',
	output: {
		path: path.resolve(__dirname, './dist'),
		filename: 'bundle.js'
	},
	module: {
		rules: [
			{
				test: /main\.scss$/,
				use: extractBundle.extract({
					fallback: 'style-loader',
					use: [ 'css-loader', 'postcss-loader', 'sass-loader' ]
				})
			},
			{
				test: /editor-style\.scss$/,
				use: extractEditorStyle.extract({
					fallback: 'style-loader',
					use: [ 'css-loader', 'postcss-loader', 'sass-loader' ]
				})
			},
			{
				test: /login-style\.scss$/,
				use: extractLoginStyle.extract({
					fallback: 'style-loader',
					use: [ 'css-loader', 'postcss-loader', 'sass-loader' ]
				})
			},
			{
				test: /\.pug$/,
				include: [
					path.resolve(__dirname, "modules")
				],
				use: 'pug-loader'
			},
			{
				test: /\.svg$/,
				include: [
					path.resolve(__dirname, "assets/icons")
				],
				use: 'svg-sprite-loader?name=icon-[name]'
			},
			{
				test: /\.(eot|svg|ttf|woff|woff2)$/,
				include: [
					path.resolve(__dirname, "assets/fonts")
				],
				use: 'file-loader?name=fonts/[name].[ext]'
			},
			{
				test: /\.svg$/,
				exclude: [
					path.resolve(__dirname, "assets/fonts"),
					path.resolve(__dirname, "assets/icons")
				],
				use: 'svg-url-loader'
			},
			{
				test: /\.(jpe?g|png|gif)$/i,
				exclude: [
					path.resolve(__dirname, "assets/fonts"),
					path.resolve(__dirname, "assets/icons")
				],
				use: 'url-loader?limit=10000'
			},
		]
	},
	plugins: [
		extractBundle,
		extractEditorStyle,
		extractLoginStyle,
		new webpack.optimize.UglifyJsPlugin({
			sourcemap: true
		}),
		new webpack.LoaderOptionsPlugin({
			minimize: true
		}),
		// Make $ and jQuery available in every module without writing require("jquery")
		new webpack.ProvidePlugin({
			$: "jquery"
		}),
		// Load only fr locale in moment.js
		new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /fr/),
	],
	externals: {
		// require("jquery") is external and available
		//	on the global var jQuery
		"jquery": "jQuery"
	}
}
