const base = require('./karma.base.conf.js');

const batches = {
    sl_chrome: {
        base: 'SauceLabs',
        browserName: 'chrome',
        platform: 'Windows 7'
    },
    sl_firefox: {
        base: 'SauceLabs',
        browserName: 'firefox'
    },
    sl_mac_safari: {
        base: 'SauceLabs',
        browserName: 'safari',
        platform: 'OS X 10.10'
    },


    // IE does not support Array.prototype.find which is used by vue-test-utils.
    // so exclude IE tests for now
    /*sl_ie_9: {
        base: 'SauceLabs',
        browserName: 'internet explorer',
        platform: 'Windows 7',
        version: '9'
    },
    sl_ie_10: {
        base: 'SauceLabs',
        browserName: 'internet explorer',
        platform: 'Windows 8',
        version: '10'
    },
    sl_ie_11: {
        base: 'SauceLabs',
        browserName: 'internet explorer',
        platform: 'Windows 8.1',
        version: '11'
    },*/
    sl_edge: {
        base: 'SauceLabs',
        browserName: 'MicrosoftEdge',
        platform: 'Windows 10'
    },

    // Mobile
    sl_ios_safari_9: {
        base: 'SauceLabs',
        browserName: 'iphone',
        version: '10.3'
    },
    sl_android_6_0: {
        base: 'SauceLabs',
        browserName: 'android',
        version: '6.0'
    }
};

module.exports = function(config) {
    config.set(Object.assign(base, {
        // start these browsers
        // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
        browsers: Object.keys(batches),
        customLaunchers: batches,
        reporters: process.env.CI
            ? ['dots', 'saucelabs'] // avoid spamming CI output
            : ['progress', 'saucelabs'],

        // Continuous Integration mode
        // if true, Karma captures browsers, runs the tests and exits
        singleRun: true,

        sauceLabs: {
            testName: 'VuetifyBundle unit tests',
            recordScreenshots: true,
            connectOptions: {
                'no-ssl-bump-domains': 'all' // Ignore SSL error on Android emulator
            },
            build: process.env.TRAVIS_JOB_NUMBER || Date.now(),
            tunnelIdentifier: process.env.TRAVIS_JOB_NUMBER || Date.now()
        },
        concurrency: 3,
        // mobile emulators are really slow
        captureTimeout: 300000,
        browserNoActivityTimeout: 300000,
        plugins: base.plugins.concat([
            'karma-sauce-launcher'
        ])
    }))
};
