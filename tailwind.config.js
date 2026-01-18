import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Primary font stack for Nestlify UI
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                heading: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },

            colors: {
                brand: {
                    primary: '#1F2937',    // Charcoal Blue - main nav / primary buttons
                    background: '#F9FAFB', // Warm off-white - page backgrounds
                    accent: '#14532D',     // Deep green - CTAs, highlights
                    muted: '#6B7280',      // Slate grey - secondary text
                    heading: '#111827',    // Near-black - headings
                    card: '#FFFFFF',       // Card surface
                    hover: '#1A202C',      // Slightly darker for hover states
                },
            },

            // Optional: add rounded corners for a premium feel
            borderRadius: {
                lg: '0.75rem',
                xl: '1rem',
            },

            // Optional: add custom shadows for cards and nav
            boxShadow: {
                card: '0 4px 12px rgba(0, 0, 0, 0.06)',
                nav: '0 2px 4px rgba(0, 0, 0, 0.08)',
            },
        },
    },

    plugins: [forms, typography],
};
