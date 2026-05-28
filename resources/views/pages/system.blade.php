{{-- resources/views/pages/system.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="min-h-screen flex flex-col justify-center px-6 md:px-10 pt-20 pb-16">
<div class="max-w-xl w-full mx-auto"
     x-data="terminal()"
     x-init="boot()"
     @keydown.arrow-up.prevent="move(-1)"
     @keydown.arrow-down.prevent="move(1)"
     @keydown.enter.prevent="navigate()"
     tabindex="0"
     style="outline:none;">

    {{-- Boot lines --}}
    <div class="space-y-0.5 mb-8">
        <template x-for="(line, i) in visibleLines" :key="i">
            <div class="flex items-start gap-3 leading-relaxed"
                 :style="`animation-delay: ${i * 60}ms`"
                 style="animation: fade-up 0.4s ease forwards; opacity:0;">
                <span class="shrink-0 select-none" style="color: hsl(225,4%,74%);"
                      x-text="line.prefix"></span>
                <span class="text-[13px] tracking-wide"
                      :style="line.style"
                      x-text="line.text"></span>
            </div>
        </template>

        {{-- Cursor --}}
        <div x-show="!ready" class="flex items-center gap-3 mt-1">
            <span style="color: hsl(225,4%,74%);" class="select-none">  </span>
            <span class="inline-block w-2 h-4 align-middle"
                  style="background: hsl(225,5%,54%); animation: blink 1s step-end infinite;"></span>
        </div>
    </div>

    {{-- Modules --}}
    <div x-show="ready"
         x-transition:enter="transition duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-px">

        <div class="text-[11px] uppercase tracking-[0.28em] mb-4 select-none"
             style="color: hsl(225,4%,68%);">
            modules:
        </div>

        <template x-for="(mod, i) in modules" :key="mod.key">
            <div
                @click="select(i); navigate();"
                @mouseenter="select(i)"
                class="group flex items-center gap-4 px-4 py-3 cursor-pointer transition-all duration-150 select-none"
                :style="cursor === i
                    ? 'background: hsl(225,5%,88%); border-left: 2px solid hsl(225,5%,54%);'
                    : 'background: transparent; border-left: 2px solid transparent;'"
            >
                <span class="text-[13px] w-4 text-center shrink-0 transition-opacity duration-150"
                      :style="cursor === i
                          ? 'color: hsl(225,5%,54%); opacity:1;'
                          : 'color: hsl(225,4%,74%); opacity:0.4;'"
                      x-text="cursor === i ? '▸' : '—'">
                </span>

                <div class="flex-1 min-w-0">
                    <span class="text-[13px] tracking-wide transition-colors duration-150"
                          :style="cursor === i
                              ? 'color: hsl(225,9%,20%);'
                              : 'color: hsl(225,5%,54%);'"
                          x-text="mod.key">
                    </span>
                </div>

                <span class="text-[11px] tracking-wide hidden md:block transition-colors duration-150"
                      :style="cursor === i
                          ? 'color: hsl(225,5%,54%);'
                          : 'color: hsl(225,4%,74%);'"
                      x-text="mod.desc">
                </span>

                <span class="text-[11px] transition-all duration-150"
                      :style="cursor === i
                          ? 'color: hsl(225,5%,54%); transform: translateX(0); opacity:1;'
                          : 'color: transparent; transform: translateX(-4px); opacity:0;'">
                    →
                </span>
            </div>
        </template>
    </div>

    {{-- Hint --}}
    <div x-show="ready"
         x-transition:enter="transition duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="mt-10 flex items-center gap-6 select-none">
        <span class="text-[10px] uppercase tracking-[0.24em]" style="color: hsl(225,4%,74%);">
            ↑↓ navigate modules
        </span>
        <span class="h-3 w-px" style="background: hsl(225,5%,83%);"></span>
        <span class="text-[10px] uppercase tracking-[0.24em]" style="color: hsl(225,4%,74%);">
            enter / click to initialize
        </span>
    </div>

</div>
</main>

<style>
@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}
</style>

<script>
function terminal() {
    return {
        cursor: 0,
        ready: false,
        visibleLines: [],

        bootLines: [
            { prefix: '//',  text: 'boot sequence start',      style: 'color: hsl(225,9%,20%); font-size:13px; letter-spacing:0.04em;' },
            { prefix: '  ',  text: 'nexus v0.2',               style: 'color: hsl(225,4%,68%); font-size:11px; letter-spacing:0.06em;' },
            { prefix: '  ',  text: 'environment loaded',       style: 'color: hsl(225,4%,68%); font-size:11px; letter-spacing:0.06em;' },
            { prefix: '  ',  text: '—',                        style: 'color: hsl(225,5%,83%); font-size:11px;' },
            { prefix: '$',   text: 'mounting modules...',      style: 'color: hsl(225,5%,54%); font-size:13px; letter-spacing:0.04em;' },
        ],

        modules: [
            { key: 'nihon.journey',     desc: 'Learn Japanese',  href: 'https://hidenihon-journey.vercel.app/' },
            { key: 'pdv.local',     desc: 'local transaction system',  href: '/pdv' },
            { key: 'ai.assistant',  desc: 'inference interface',       href: '/ai' },
            { key: 'ecommerce.api', desc: 'commerce service layer',    href: '/ecommerce' },
        ],

        boot() {
            this.$el.focus();
            let delay = 0;
            this.bootLines.forEach((line) => {
                setTimeout(() => {
                    this.visibleLines.push(line);
                }, delay);
                delay += 140;
            });
            setTimeout(() => {
                this.ready = true;
            }, delay + 200);
        },

        move(dir) {
            this.cursor = (this.cursor + dir + this.modules.length) % this.modules.length;
        },

        select(i) {
            this.cursor = i;
        },

        navigate() {
            const mod = this.modules[this.cursor];
            if (mod) {
                // efeito opcional antes de navegar
                this.visibleLines.push({
                    prefix: '$',
                    text: `executing ${mod.key}`,
                    style: 'color: hsl(225,5%,54%); font-size:13px;'
                });

                setTimeout(() => {
                    window.location.href = mod.href;
                }, 300);
            }
        },
    }
}
</script>
@endsection