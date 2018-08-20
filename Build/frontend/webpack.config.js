/**
 * Created by Jochen Rieger on 14.04.2017.
 *
 * webpack config for JS transpiling and bundling
 *
 */

// using the path tool to get proper directory information
const path = require('path');

// having the conf in our build sub directory requires us to go back to the project root
const projectRootPath = path.resolve(__dirname + '/../..'),
	webrootPath = `${projectRootPath}/web`,
	assetRootPath = `${webrootPath}/assets`;

// using minimist for nice command line argument parsing (eg. --mode development)
const argv = require('minimist')(process.argv.slice(2));
// console.log(argv);


// Variables set by npm scripts in package.json
const
    buildContext = argv['mode'] != '' ? argv['mode'] : 'production',
    isDevelopmentContext = buildContext === 'development',
    withRemoteServer = (typeof argv['env'] !== "undefined" && argv['env'].hasOwnProperty('withRemoteServer'));


// pre-configure the CSS extract plugin (moved from extract-text-webpack-plugin to mini-css-extract-plugin)
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

// pre-collect / configure the webpack plugins array
let webpackPlugins = [
    new MiniCssExtractPlugin({
        // filename based on the publicPath setting /assets/
        filename: 'css/style.css'
    })
];
// decide if we add ngrok plugin to the dev server or not
if (withRemoteServer === true) {

    // prepare ngrok / ngrock webpack extension
    const NgrockWebpackPlugin = require('ngrock-webpack-plugin');
    webpackPlugins.push(new NgrockWebpackPlugin());

}



// display info on build context
console.log('---------------------------');
console.log('Build context: ', isDevelopmentContext ? 'Development' : ' Production');
console.log('---------------------------');

// enable this if you feel you have path trouble
// console.log('----------------------------------------------------');
// console.log('Project Root Path: ' + projectRootPath);
// console.log('Web Root Path:     ' + webrootPath);
// console.log('Asset Root Path:   ' + assetRootPath);
// console.log('Source JS Path:    ' + `${assetRootPath}/src/js`);
// console.log('----------------------------------------------------');

module.exports = {

    // the app's JS's entry point – usually main.js
    entry: [
        `${assetRootPath}/src/js/main`,
        `${assetRootPath}/src/scss/style.scss`
    ],

    // target directory and file for webpack bundled js
    output: {
        path: assetRootPath,
        publicPath: 'assets/',
        filename: 'js/main.js'
    },

    module: {
        rules: [

            // let babel do its JS magic and transpile any ES6 / ES7 code to ES5
            {
                // strange naming - but this is something like a filename filter to be applied
                test: /\.js$/,

                // don't run through these directories, please
                exclude: /node_modules/,

                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                        //plugins: ['@babel/transform-runtime']
                    }
                }
            },

            // we also need some nice CSS compiled from SCSS
            {
                test: /\.(scss|sass|css)$/i,
                exclude: /node_modules/,
                use: [

                    // using the new css extract loader instead of the old text-extract one
                    // See https://github.com/webpack-contrib/mini-css-extract-plugin for further options / optimizations
                    // TODO: think about adding a hash to the css / js output filenames in prod mode – but needs to work with TYPO3 as well!
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            minimize: !isDevelopmentContext,
                            sourceMap: isDevelopmentContext
                        }
                    },
                    // TODO: maybe add image optimization methods here, using "image-webpack-loader" and "file-loader"
                    // See:
                    // * https://www.npmjs.com/package/file-loader
                    // * https://github.com/tcoopman/image-webpack-loader
                    // * https://www.youtube.com/watch?v=cDLfpth5a3s
                    {
                        loader: 'postcss-loader',
                        options: {
                            config: {
                                path: `${projectRootPath}/build/frontend/postcss.config.js`
                            },
                            sourceMap: isDevelopmentContext ? 'inline' : false
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: isDevelopmentContext
                        }
                    }
                ]
            }
        ]
    },

    // defining the plugins to be used by the loaders
    plugins: webpackPlugins,

    // activate source map feature if we're not on production mode
    devtool: isDevelopmentContext ? 'source-map' : false, // any "source-map"-like devtool is possible

    // options for webpack-dev-server
    devServer: {
        contentBase: './web',
        //publicPath: './web',
        // hot: true,
        // inline: true,
        headers: {'Access-Control-Allow-Origin': '*'},
        historyApiFallback: {
            index: 'http://localhost:8080/index.html'
        },
        open: true
    }

};
