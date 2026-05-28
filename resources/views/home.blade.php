{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="max-w-screen-xl mx-auto px-6 md:px-10 pt-40 pb-28">

    {{-- Label line --}}
    <div class="flex items-center gap-3 mb-10 fade-up delay-1">
        <span class="h-px w-8" style="background: hsl(225,5%,83%);"></span>
        <span class="text-[10px] uppercase tracking-[0.32em]" style="color: hsl(225,4%,68%);">
            v0.0.3 — experimental
        </span>
    </div>

    {{-- Headline --}}
    <h1 class="leading-[0.88] tracking-tighter select-none fade-up delay-2 mb-5"
        style="font-size: clamp(3rem, 10vw, 8.5rem); font-weight: 300; color: hsl(225,9%,20%);">
        neXus<br>
        <span style="color: hsl(225,5%,83%);">interface</span><span style="color: hsl(225,5%,54%);">.</span>
    </h1>

    <p class="text-[11px] uppercase tracking-[0.26em] max-w-xs mb-16 leading-relaxed fade-up delay-3"
       style="color: hsl(225,4%,68%);">
        systems. projects. outputs.
    </p>

    {{-- CTAs --}}
    <div class="flex flex-wrap items-center gap-4 mb-24 fade-up delay-4">
        <a href="{{ route('system') }}"
           class="inline-flex items-center gap-2.5 px-6 py-3 text-[11px] uppercase tracking-[0.22em] transition-all duration-300 no-underline"
           style="border: 1px solid hsl(225,5%,83%); color: hsl(225,5%,54%);"
           onmouseover="this.style.borderColor='hsl(225,5%,54%)'; this.style.color='hsl(225,9%,20%)';"
           onmouseout="this.style.borderColor='hsl(225,5%,83%)'; this.style.color='hsl(225,5%,54%)';">
            <span>▸</span> Enter system
        </a>
        <a href="{{ url('/output') }}"
           class="inline-flex items-center gap-2 px-6 py-3 text-[11px] uppercase tracking-[0.22em] transition-colors duration-300 no-underline"
           style="color: hsl(225,4%,68%);"
           onmouseover="this.style.color='hsl(225,9%,20%)'"
           onmouseout="this.style.color='hsl(225,4%,68%)'">
            Documentations →
        </a>
    </div>

    {{-- Ticker --}}
    <div class="relative overflow-hidden py-2 fade-up delay-5"
         style="border-top: 1px solid hsl(225,5%,83%); border-bottom: 1px solid hsl(225,5%,83%);">
        <div class="ticker-track flex gap-14 whitespace-nowrap" style="width: max-content;">
            @php
                $items = ['SAAS SYSTEMS', 'WEB APPLICATIONS', 'FULL STACK SYSTEM', 'AUTOMATIONS', 'SCALABLE PROJECTS'];
                $repeated = array_merge($items, $items);
            @endphp
            @foreach ($repeated as $item)
                <span class="text-[10px] uppercase tracking-[0.3em]" style="color: hsl(225,4%,74%);">
                    {{ $item }}<span class="mx-6" style="color: hsl(225,5%,83%);">×</span>
                </span>
            @endforeach
        </div>
    </div>

    {{-- Stats --}}
    <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-10">
        @foreach ([
            ['value' => '10+', 'label' => 'On-air projects'],
            ['value' => '2024—',   'label' => 'active since'],
            ['value' => '∞',      'label' => 'iterations'],
            ['value' => 'v0.x',   'label' => 'current phase'],
        ] as $stat)
        <div class="flex flex-col gap-1.5">
            <span class="text-[2.2rem] font-light tabular-nums" style="color: hsl(225,9%,20%); line-height:1;">
                {{ $stat['value'] }}
            </span>
            <span class="text-[10px] uppercase tracking-[0.24em]" style="color: hsl(225,4%,68%);">
                {{ $stat['label'] }}
            </span>
        </div>
        @endforeach
    </div>

    {{-- Feature strip --}}
    {{-- gap de 1px com a cor de border cria a ilusão de grade entre cards --}}
    <div class="mt-24 grid grid-cols-1 md:grid-cols-3"
         style="gap: 1px; background: hsl(225,5%,83%);">
        @foreach ([
            ['tag' => '01', 'title' => 'Signal',  'desc' => 'Input, Processing and Output across different systems.'],
            ['tag' => '02', 'title' => 'Memory',  'desc' => 'Data Persistence, Storage and Structured information.'],
            ['tag' => '03', 'title' => 'Control', 'desc' => 'Interfaces to manage, Automate and Scale Processes.'],
        ] as $card)
        <div class="relative p-8 transition-colors duration-300"
             style="background: hsl(225,6%,96%);"
             onmouseover="this.style.background='hsl(225,5%,91%)'"
             onmouseout="this.style.background='hsl(225,6%,96%)'">
            {{-- Corner marks --}}
            <span class="absolute top-0 left-0 w-3.5 h-3.5"
                  style="border-top: 1px solid hsl(225,5%,83%); border-left: 1px solid hsl(225,5%,83%);"></span>
            <span class="absolute bottom-0 right-0 w-3.5 h-3.5"
                  style="border-bottom: 1px solid hsl(225,5%,83%); border-right: 1px solid hsl(225,5%,83%);"></span>

            <span class="text-[10px] tracking-[0.28em] uppercase mb-4 block"
                  style="color: hsl(225,4%,74%);">{{ $card['tag'] }}</span>
            <h3 class="text-xs font-normal tracking-[0.2em] uppercase mb-3"
                style="color: hsl(225,5%,54%);">{{ $card['title'] }}</h3>
            <p class="text-[11px] leading-relaxed tracking-wide"
               style="color: hsl(225,4%,68%);">{{ $card['desc'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Bottom note --}}
    <div class="mt-20 pt-10" style="border-top: 1px solid hsl(225,5%,83%);">
        <p class="text-[11px] leading-relaxed max-w-sm" style="color: hsl(225,4%,68%);">
            systems evolve. outputs may change without notice.
        </p>
    </div>

</main>
@endsection