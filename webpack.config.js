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
        pattern: /\.(png|jpg|jpeg|svg)$/,
        includeSubdirectories: true,
    })
    .copyFiles({
        from: './assets/img',
        to: 'img/[path][name].[ext]',
        pattern: /\.(png|jpg|jpeg|svg)$/,
        includeSubdirectories: true,
    })
    .addEntry('app', './assets/app.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .enableSassLoader()
    .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();
