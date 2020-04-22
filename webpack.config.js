const path = require("path");

module.exports = (env, argv) => {
     return  {
        mode: 'production',
        devtool: "source-map",
        entry: {
            main: "./web/src/index.ts"
        },
        output: {
            path: path.join(__dirname + '/web', "build"),
            filename: "./js/bundle.js"
        },
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: ['style-loader', 'css-loader', 'sass-loader'],
                },
                {
                    test: /\.ts$/,
                    use: 'ts-loader',
                    exclude: /node_modules/,
                },
            ]
        }
    }
};