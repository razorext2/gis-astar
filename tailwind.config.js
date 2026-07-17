import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        "./app/Livewire/**/*.php",
        "./vendor/power-components/livewire-powergrid/resources/views/**/*.php",
        "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php",
    ],
    presets: [
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
                gaming: ["Bungee", "cursive"],
                montserrat: ["Montserrat"],
            },
            colors: {
                "pg-primary": colors.zinc,
                primary: colors.red[600],
                "dark-primary": "#18181b",
                "dark-secondary": "#242427",

                // Glassmorphism design tokens
                // Usage: bg-glass-light / dark:bg-glass-dark, border-glass-border-light / dark:border-glass-border-dark
                "glass-light": "rgba(255,255,255,0.50)",
                "glass-dark": "rgba(24,24,27,0.60)",
                "glass-border-light": "rgba(228,228,231,0.50)",
                "glass-border-dark": "rgba(255,255,255,0.10)",
                "glass-text-light": "rgba(24,24,27,0.90)",
                "glass-text-dark": "rgba(255,255,255,0.90)",
                "glass-muted-light": "rgba(24,24,27,0.55)",
                "glass-muted-dark": "rgba(255,255,255,0.55)",
                "glass-divider-light": "rgba(24,24,27,0.12)",
                "glass-divider-dark": "rgba(255,255,255,0.12)",
                "glass-hover-light": "rgba(24,24,27,0.06)",
                "glass-hover-dark": "rgba(255,255,255,0.08)",
            },
        },
    },
    plugins: [forms, typography],
};
