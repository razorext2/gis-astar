import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // css
                "resources/css/app.css",
                // js
                "resources/js/app.js",

                // global
                "resources/js/global/alpine.js",
                "resources/js/global/bootstrap.js",
                "resources/js/global/chart.js",
                "resources/js/global/leaflet.js",
                "resources/js/global/simpleTables.js",

                // landing page
                "resources/js/landing/main.js",

                // capture
                "resources/js/capture/index.js",

                // collect
                "resources/js/collect/index.js",
                "resources/js/collect/add.js",
                "resources/js/collect/edit.js",
                "resources/js/collect/detail.js",

                // collect task
                "resources/js/collect-task/index.js",
                "resources/js/collect-task/add.js",
                // "resources/js/collect-task/edit.js",
                // "resources/js/collect-task/detail.js",
            ],
            refresh: true,
        }),
    ],
});
