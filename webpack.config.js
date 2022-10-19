const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')
    .addEntry('indexPartenairejs', './assets/indexPartenaire.js')
    .addEntry('showPartenairejs', './assets/showPartenaire.js')
    .addEntry('indexStructurejs', './assets/indexStructure.js')
    .addEntry('showStructurejs', './assets/showStructure.js')
    .addStyleEntry('newPartenaire', './assets/styles/newPartenaire.css')
    .addStyleEntry('editPartenaire', './assets/styles/editPartenaire.css')
    .addStyleEntry('editModule', './assets/styles/editModule.css')
    .addStyleEntry('editUser', './assets/styles/editUser.css')
    .addStyleEntry('indexModule', './assets/styles/indexModule.css')
    .addStyleEntry('indexPartenaire', './assets/styles/indexPartenaire.css')
    .addStyleEntry('indexStructure', './assets/styles/indexStructure.css')
    .addStyleEntry('indexUser', './assets/styles/indexUser.css')
    .addStyleEntry('login', './assets/styles/login.css')
    .addStyleEntry('newModule', './assets/styles/newModule.css')
    .addStyleEntry('newMotDePasse', './assets/styles/newMotDePasse.css')
    .addStyleEntry('newStructure', './assets/styles/newStructure.css')
    .addStyleEntry('newUser', './assets/styles/newUser.css')
    .addStyleEntry('showModule', './assets/styles/showModule.css')
    .addStyleEntry('showPartenaire', './assets/styles/showPartenaire.css')
    .addStyleEntry('showStructure', './assets/styles/showStructure.css')
    .addStyleEntry('showUser', './assets/styles/showUser.css')


    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()
    //.enableForkedTypeScriptTypesChecking()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
