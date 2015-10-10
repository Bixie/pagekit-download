module.exports = [

    {
        entry: {
            "downloads": "./app/downloads.js",
            /*cart*/
            "download-section-cart": "./app/components/download-section-cart.vue",
            /*frontpage views*/
            "download": "./app/views/download.js",
            /*admin views*/
            "download-settings": "./app/views/admin/settings.js",
            "admin-categories": "./app/views/admin/categories.js",
            "admin-file": "./app/views/admin/file.js",
            "admin-category": "./app/views/admin/category.js",
            "admin-download": "./app/views/admin/download.js"
        },
        output: {
            filename: "./app/bundle/[name].js"
        },
        externals: {
            "lodash": "_",
            "jquery": "jQuery",
            "uikit": "UIkit",
            "vue": "Vue"
        },
        module: {
            loaders: [
                {test: /\.vue$/, loader: "vue"},
                {test: /\.html$/, loader: "html"}
            ]
        }
    }

];
