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
                "resources/js/bootstrap.js",
                "resources/js/main.js",

                // global
                "resources/js/global/leaflet.js",
                "resources/js/global/simpleTables.js",

                // landing page
                "resources/js/landing/main.js",
                "resources/js/landing/faceDetection.js",

                // backup
                "resources/js/backup/index.js",

                // capture
                "resources/js/capture/index.js",
                "resources/js/capture/selfDetect.js",

                // collect
                "resources/js/collect/index.js",
                "resources/js/collect/edit.js",
                "resources/js/collect/detail.js",

                // driver
                "resources/js/driver/add.js",
                "resources/js/driver/detail.js",
                "resources/js/driver/edit.js",

                // collect task
                "resources/js/collect-task/index.js",
                "resources/js/collect-task/add.js",
                "resources/js/collect-task/mass-assign.js",
                "resources/js/collect-task/detail.js",

                // collect task ppn (idc ppn)
                "resources/js/collect-task-ppn/index.js",
                "resources/js/collect-task-ppn/add.js",
                "resources/js/collect-task-ppn/mass-assign.js",
                "resources/js/collect-task-ppn/detail.js",

                // collect idy ppn
                "resources/js/collect-idy-ppn/index.js",
                "resources/js/collect-idy-ppn/add.js",
                "resources/js/collect-idy-ppn/mass-assign.js",
                "resources/js/collect-idy-ppn/detail.js",

                // sales
                "resources/js/sales/index.js",
                "resources/js/sales/add.js",
                "resources/js/sales/edit.js",
                "resources/js/sales/detail.js",

                // technician
                "resources/js/technician/index.js",
                "resources/js/technician/add.js",
                "resources/js/technician/detail.js",

                // dayoff 
                "resources/js/dayoff/index.js",
                "resources/js/dayoff/add.js",
                "resources/js/dayoff/edit.js",
                "resources/js/dayoff/detail.js",

                // announcement 
                "resources/js/announcement/index.js",

                // pegawai
                "resources/js/pegawai/personalInfo.js",
            ],
            refresh: true,
        }),
    ],
});
