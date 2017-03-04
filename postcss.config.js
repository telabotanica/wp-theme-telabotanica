module.exports = {
  plugins: [
    require('autoprefixer')({
			browsers: [
				'last 5 versions',
				'android 4',
				'opera 12',
			],
		}),
		require('pixrem')(),
		require('css-mqpacker')()
  ]
}
