import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/bootstrap.js",
                "resources/css/order-china.css",
                "resources/css/dashboard.css",
                "resources/css/events.css",
                "resources/css/news.css",
                "resources/css/questions.css",
                "resources/css/recuitment.css",
                "resources/css/ship-china.css",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
