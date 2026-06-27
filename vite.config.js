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

                // landing page
                "resources/js/landing/main.js",
                "resources/js/landing/faceDetection.js",

                // capture
                "resources/js/pages/capture/index.js",
                "resources/js/pages/capture/selfDetect.js",

                // collect
                "resources/js/pages/collect/index.js",
                "resources/js/pages/collect/edit.js",
                "resources/js/pages/collect/detail.js",

                // driver
                "resources/js/pages/driver/add.js",
                "resources/js/pages/driver/detail.js",
                "resources/js/pages/driver/edit.js",
                "resources/js/pages/driver/update.js",

                // collect task
                "resources/js/pages/collect-task/index.js",
                "resources/js/pages/collect-task/add.js",
                "resources/js/pages/collect-task/mass-assign.js",
                "resources/js/pages/collect-task/detail.js",

                // collect task ppn (idc ppn)
                "resources/js/pages/collect-task-ppn/index.js",
                "resources/js/pages/collect-task-ppn/add.js",
                "resources/js/pages/collect-task-ppn/mass-assign.js",
                "resources/js/pages/collect-task-ppn/detail.js",

                // collect idy ppn
                "resources/js/pages/collect-idy-ppn/index.js",
                "resources/js/pages/collect-idy-ppn/add.js",
                "resources/js/pages/collect-idy-ppn/mass-assign.js",
                "resources/js/pages/collect-idy-ppn/detail.js",

                // sales
                "resources/js/pages/sales/add.js",
                "resources/js/pages/sales/edit.js",
                "resources/js/pages/sales/detail.js",

                // technician
                "resources/js/pages/technician/add.js",

                // pegawai
                "resources/js/pages/pegawai/personalInfo.js",

                // placement
                "resources/js/pages/placement/placement-map.js",

                // invoice
                "resources/js/pages/invoice/detail.js",

                // spk
                "resources/js/pages/spk/show.js",

                // attendance inquiry
                "resources/js/pages/attendance-inquiry/create.js",
            ],
            refresh: true,
        }),
    ],
});
