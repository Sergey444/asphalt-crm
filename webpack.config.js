const path = require("path");

const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, argv) => {
     return  {
        mode: 'development',
        devtool: "source-map",
        entry: {
            main: "./web/src/index.js"
        },
        output: {
            path: path.join(__dirname + '/web', "build"),
            filename: "./js/bundle.js"
        },
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            hmr: argv.mode === 'development',
                            reloadAll: true,
                        }
                    },
                    'css-loader', 
                    {
                        loader: 'postcss-loader',
                        options: { sourceMap: true, config: { path: './postcss.config.js' } }
                    }, 
                    'sass-loader'
                    ],
                },
                // {
                //     test: /\.(png|jpe?g|gif|ttf)$/i,
                //     use: [{
                //         loader: 'file-loader',
                //         options: {
                //             limit: 10000,
                //             name: '[name].[ext]?[hash]',
                //             outputPath: 'fonts/',
                //         }
                //     }],
                // },
                // {
                //     test: /\.scss$/,
                //     use: ['style-loader', 'css-loader', 'sass-loader'],
                // },
            ]
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: "./css/style.css"
            }),
        ]
    }
};