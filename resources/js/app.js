document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        theme: localStorage.getItem('stockpilot-theme') || 'system',

        init() {
            this.apply();

            window
                .matchMedia('(prefers-color-scheme: dark)')
                .addEventListener('change', () => {
                    if (this.theme === 'system') {
                        this.apply();
                    }
                });
        },

        set(theme) {
            if (!['light', 'dark', 'system'].includes(theme)) {
                return;
            }

            this.theme = theme;
            localStorage.setItem('stockpilot-theme', theme);
            this.apply();
        },

        apply() {
            const isDark =
                this.theme === 'dark' ||
                (
                    this.theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches
                );

            document.documentElement.classList.toggle('dark', isDark);
        },

        isDark() {
            return document.documentElement.classList.contains('dark');
        },
    });

    Alpine.store('theme').init();
});
