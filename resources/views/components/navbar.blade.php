{{-- resources/views/components/navbar.blade.php --}}
<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 24 }, { passive: true })"
    :style="scrolled
        ? 'background: hsla(225,6%,96%,0.88); backdrop-filter: blur(14px);'
        : 'background: transparent; border-bottom: 1px solid transparent;'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-transparent"
>
    <nav class="max-w-7xl mx-auto px-6 md:px-10 h-14 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 no-underline">
            <span class="pulse-dot relative flex h-1.5 w-1.5 shrink-0 rounded-full"
                  style="background: hsl(150,14%,40%);"></span>
            <span class="text-[11px] tracking-[0.28em] uppercase select-none"
                  style="color: hsl(225,5%,54%);">
                hideki<span style="color: hsl(225,9%,20%);">_</span>fukuda
                <span style="color: hsl(225,9%,20%);">_</span>
            </span>
        </a>

        {{-- Desktop links --}}
        <ul class="hidden md:flex items-center gap-10 list-none m-0 p-0">
            @foreach ([
                ['label' => 'core',   'href' => '/core'],
                ['label' => 'archive', 'href' => '/archive'],
                ['label' => 'link', 'href' => '/link'],
            ] as $link)
            <li>
                <a href="{{ url($link['href']) }}"
                   class="text-[11px] tracking-[0.22em] uppercase no-underline transition-colors duration-300"
                   style="color: hsl(225,4%,68%);"
                   onmouseover="this.style.color='hsl(225,9%,20%)'"
                   onmouseout="this.style.color='hsl(225,4%,68%)'">
                    {{ $link['label'] }}
                </a>
            </li>
            @endforeach
        </ul>

        {{-- Status pill --}}
        <div class="hidden md:flex items-center gap-2 px-3 py-1 rounded-sm"
             style="border: 1px solid hsl(225,5%,83%);">
            <span class="pulse-dot h-1.5 w-1.5 rounded-full" style="background: hsl(150,14%,40%);"></span>
            <span class="text-[10px] tracking-[0.22em] uppercase" style="color: hsl(225,4%,68%);">operational</span>
        </div>

        {{-- Mobile burger --}}
        <button
            @click="open = !open"
            class="md:hidden flex flex-col gap-[5px] p-1 cursor-pointer bg-transparent border-none outline-none"
            aria-label="Toggle menu"
        >
            <span :class="open ? 'rotate-45 translate-y-[7px]' : ''"
                  class="block h-px w-5 transition-all duration-300 origin-center"
                  style="background: hsl(225,5%,54%);"></span>
            <span :class="open ? 'opacity-0 scale-x-0' : ''"
                  class="block h-px w-5 transition-all duration-300"
                  style="background: hsl(225,5%,54%);"></span>
            <span :class="open ? '-rotate-45 -translate-y-[7px]' : ''"
                  class="block h-px w-5 transition-all duration-300 origin-center"
                  style="background: hsl(225,5%,54%);"></span>
        </button>
    </nav>
</header>

{{-- Mobile overlay --}}
<div
    x-show="open"
    x-transition:enter="transition duration-400"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition duration-250"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-40 flex flex-col justify-center items-start px-10 md:hidden"
    style="background: hsl(225,6%,96%); display:none;"
>


    <ul class="list-none p-0 m-0 space-y-6 relative z-10">
        @foreach ([
            ['label' => 'core',   'href' => '/core'],
            ['label' => 'archive', 'href' => '/archive'],
            ['label' => 'link', 'href' => '/link'],
        ] as $link)
        <li>
            <a href="{{ url($link['href']) }}"
               @click="open = false"
               class="text-4xl font-light tracking-[0.18em] uppercase no-underline block transition-colors duration-300"
               style="color: hsl(225,4%,68%);"
               onmouseover="this.style.color='hsl(225,9%,20%)'"
               onmouseout="this.style.color='hsl(225,4%,68%)'">
                <span class="mr-2 text-xl" style="color: hsl(225,5%,83%);">/</span>{{ $link['label'] }}
            </a>
        </li>
        @endforeach
    </ul>

    <div class="mt-16 text-[10px] tracking-[0.32em] uppercase relative z-10" style="color: hsl(225,4%,68%);">
        systems operational.
    </div>
</div>
