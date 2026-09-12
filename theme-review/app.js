/*
|--------------------------------------------------------------------------
| StockPilot Application JavaScript
|--------------------------------------------------------------------------
|
| Livewire provides Alpine.js.
| The application registers its global Alpine stores here.
|
*/

document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        theme: localStorage.getItem('stockpilot-theme') || 'system',

        systemDark: window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches,

        init() {
            const mediaQuery = window.matchMedia(
                '(prefers-color-scheme: dark)'
            );

            this.systemDark = mediaQuery.matches;

            mediaQuery.addEventListener('change', (event) => {
                this.systemDark = event.matches;

                if (this.theme === 'system') {
                    this.apply();
                }
            });

            this.apply();
        },

        get dark() {
            return this.theme === 'dark'
                || (
                    this.theme === 'system'
                    && this.systemDark
                );
        },

        set(value) {
            const allowedValues = [
                'light',
                'dark',
                'system',
            ];

            if (!allowedValues.includes(value)) {
                return;
            }

            this.theme = value;

            localStorage.setItem(
                'stockpilot-theme',
                value
            );

            this.apply();
        },

        apply() {
            document.documentElement.classList.toggle(
                'dark',
                this.dark
            );
        },
    });
});
