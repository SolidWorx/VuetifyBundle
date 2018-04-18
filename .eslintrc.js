module.exports = {
    root: true,
    parserOptions: {
        parser: 'babel-eslint',
        ecmaVersion: 2017,
        sourceType: 'module'
    },
    extends: [
        'standard',
        'eslint:recommended'
    ],
    env: {
        browser: true
    },
    globals: {
        'expect': true,
        'describe': true,
        'it': true,
        'jest': true,
        'process': true
    },
    rules: {
        // allow paren-less arrow functions
        'arrow-parens': [2, 'as-needed'],
        // set maximum line characters
        'max-len': [2, 140, 4, {'ignoreUrls': true, 'ignoreTemplateLiterals': true, 'ignoreStrings': true}],
        'max-statements': [2, 24],
        'no-console': 'off',
        // allow debugger during development
        'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0,
        'no-return-assign': 0,
        'prefer-promise-reject-errors': 0
    }
}