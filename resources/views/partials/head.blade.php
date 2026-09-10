<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'StockPilot') : config('app.name', 'StockPilot') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script>
    (() => {
        const stored = localStorage.getItem('stockpilot-theme');

        const isDark =
            stored === 'dark' ||
            (
                stored !== 'light' &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            );

        document.documentElement.classList.toggle('dark', isDark);
    })();
</script>
