const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .copyFiles({
        from: './assets/favicon',
        to: 'favicon/[path][name].[ext]',
        pattern: /\.(png|jpg|jpeg)$/,
        includeSubdirectories: true,
    })
    .copyFiles({
        from: './assets/img',
        to: 'img/[path][name].[ext]',
        pattern: /\.(png|jpg|jpeg)$/,
        includeSubdirectories: true,
    })
    .addEntry('frontend', './assets/frontend.js')
    .addEntry('backend', './assets/backend.js')
    .enableStimulusBridge('./assets/controllers.json')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()

    //.enableTypeScriptLoader()
    //.enableReactPreset()
    //.enableIntegrityHashes(Encore.isProduction())
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
