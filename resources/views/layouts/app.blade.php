{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Synthetic Systems') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css'])

    <style>
        :root {
            /* base derivada de hsl(225, 5.13%, 54.12%) indo para branco */
            --bg:       hsl(225, 6%, 96%);
            --surface:  hsl(225, 5%, 91%);
            --border:   hsl(225, 5%, 83%);
            --text:     hsl(225, 9%, 20%);
            --muted:    hsl(225, 5%, 54%);   /* a cor exata pedida */
            --dim:      hsl(225, 4%, 68%);
            --accent:   hsl(225, 8%, 36%);
            --faint:    hsl(225, 5%, 88%);
            --green:    hsl(150, 14%, 40%);

            /* gradient do body: quase branco no topo → névoa azulada em baixo */
            --grad: linear-gradient(
                170deg,
                hsl(225, 8%, 98%) 0%,
                hsl(225, 6%, 96%) 35%,
                hsl(225, 5%, 91%) 100%
            );
        }

        *, *::before, *::after {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            box-sizing: border-box;
        }

        body {
            background: var(--grad);
            color: var(--text);
            min-height: 100vh;
        }

        @keyframes ticker {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
        .ticker-track { animation: ticker 28s linear infinite; }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fade-up 0.9s ease forwards; opacity: 0; }
        .delay-1 { animation-delay: 0.08s; }
        .delay-2 { animation-delay: 0.20s; }
        .delay-3 { animation-delay: 0.34s; }
        .delay-4 { animation-delay: 0.48s; }
        .delay-5 { animation-delay: 0.62s; }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.35; }
        }
        .pulse-dot { animation: pulse-dot 2.4s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden antialiased">

    {{-- Ambient: gradient luminoso + grain sutil --}}
    <div class="pointer-events-none fixed inset-0 z-0" aria-hidden="true">

        {{-- Luz vinda do topo --}}
        <div class="absolute inset-0"
             style="background: linear-gradient(180deg, rgba(255,255,255,0.6) 0%, transparent 50%);">
        </div>

        {{-- Grain de textura — mantém profundidade sem ruído visual --}}
        <div class="absolute inset-0"
             style="
                background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E&quot;);
                opacity: 0.025;
                mix-blend-mode: multiply;
             ">
        </div>
    </div>

    <x-navbar />

    <div class="relative z-10">
        @yield('content')
    </div>

    <footer class="relative z-10" style="border-top: 1px solid var(--border);">
        <div class="max-w-screen-xl mx-auto px-6 md:px-10 py-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <span class="text-[10px] uppercase tracking-[0.28em]" style="color:var(--dim);">
                neXus interface &copy; {{ date('Y') }}
            </span>
            <div class="flex items-center gap-2.5">
                <span class="pulse-dot h-1.5 w-1.5 rounded-full" style="background:var(--green);"></span>
                <span class="text-[10px] uppercase tracking-[0.22em]" style="color:var(--muted);">
                    active system
                </span>
            </div>
        </div>
    </footer>

</body>
</html>