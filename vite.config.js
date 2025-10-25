import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css", // sesuaikan dengan file CSS utama
                "resources/js/app.js", // sesuaikan dengan file JS utama
            ],
            refresh: true, // live reload otomatis
        }),
    ],
});
