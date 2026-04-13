var Encore = require('@symfony/webpack-encore');

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
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('login', './vendor/eyetronic/eye-admin-bundle/Resources/assets/login.js')
    .addEntry('dashboard', './vendor/eyetronic/eye-admin-bundle/Resources/assets/dashboard.js')
    .addEntry('form', './vendor/eyetronic/eye-admin-bundle/Resources/assets/form.js')
    .addEntry('admin', './src/assets/admin/js/admin.js')
    .addEntry('priceUpdater', './src/assets/admin/js/price_updater.js')
    .addEntry('ajaxFileWidget', './src/assets/admin/js/ajax-file-widget/ajax-file-widget.js')
    .addEntry('ajaxImageCollection', './src/assets/admin/js/ajax-image-collection/ajax-image-collection.js')
    .addEntry('ajaxuploader', './public/bundles/ajaxuploader/ajax_file.js')
    .addStyleEntry('ajaxuploaderCss', './public/bundles/ajaxuploader/ajax_file.css')
    .addStyleEntry('adminCss', './src/assets/admin/css/admin.css')
    //.addEntry('page2', './assets/page2.js')

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

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

// uncomment if you use API Platform Admin (composer req api-admin)
//.enableReactPreset()
//.addEntry('admin', './assets/admin.js')
;

module.exports = Encore.getWebpackConfig();
