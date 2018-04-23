const base = require('./karma.base.conf.js');

module.exports = function(config) {
    config.set(Object.assign(base, {
        // start these browsers
        // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
        browsers: ['Chrome', 'Firefox', 'Safari'],

        // Continuous Integration mode
        // if true, Karma captures browsers, runs the tests and exits
        singleRun: true,

        plugins: base.plugins.concat([
            'karma-chrome-launcher',
            'karma-firefox-launcher',
            'karma-safari-launcher',
        ])
    }))
};
