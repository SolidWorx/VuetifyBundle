const base = require('./webpack.prod.config');
const webpack = require('webpack');
const merge = require('webpack-merge');
const OptimizeJsPlugin = require('optimize-js-plugin');

const builds = {
    development: {
        config: {
            output: {
                filename: 'vuetify-bundle.js',
                libraryTarget: 'umd'
            },
            plugins: [
                new webpack.SourceMapDevToolPlugin({
                    filename: '[file].map'
                })
            ]
        }
    },
    production: {
        config: {
            output: {
                filename: 'vuetify-bundle.min.js',
                libraryTarget: 'umd'
            }
        },
        env: 'production'
    },
};

function genConfig(opts) {
    const config = merge({}, base, opts.config)

    config.plugins = config.plugins.concat([
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify(opts.env || 'development')
        })
    ]);

    if (opts.env) {
        config.plugins = config.plugins.concat([
            new webpack.optimize.UglifyJsPlugin({
                sourceMap: false
            }),
            new OptimizeJsPlugin({
                sourceMap: false
            }),
            new webpack.optimize.ModuleConcatenationPlugin()
        ])
    }

    return config
}

if (process.env.TARGET) {
    module.exports = genConfig(builds[process.env.TARGET])
} else {
    module.exports = Object.keys(builds).map(name => genConfig(builds[name]))
}