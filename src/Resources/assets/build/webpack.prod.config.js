const merge = require('webpack-merge');
const baseWebpackConfig = require('./webpack.base.config');

// Helpers
const resolve = file => require('path').resolve(__dirname, file)

module.exports = merge(baseWebpackConfig, {
    entry: {
        app: './src/Resources/assets/js/index.js'
    },
    output: {
        path: resolve('../dist'),
        publicPath: '/dist/',
        library: 'VuetifyBundle',
        libraryTarget: 'umd',
        libraryExport: 'default'
    },
    module: {
        noParse: /es6-promise\.js$/, // avoid webpack shimming process
        rules: [
            {
                test: /\.vue$/,
                use: [
                    {
                        loader: 'vue-loader'
                    },
                    'eslint-loader'
                ],
                exclude: /node_modules/
            },
            {
                test: /\.js$/,
                loaders: ['babel-loader', 'eslint-loader'],
                exclude: /node_modules/
            }
        ]
    },
    performance: {
        hints: false
    }
});