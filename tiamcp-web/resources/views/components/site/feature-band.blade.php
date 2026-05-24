@props([
    'kicker',
    'title',
    'body',
])

<section {{ $attributes->merge(['class' => 'tmcp-section']) }}>
    <div class="tmcp-container grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
        <div class="tmcp-page-heading">
            <p class="tmcp-kicker">{{ $kicker }}</p>
            <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 md:text-5xl">{{ $title }}</h2>
            <p class="mt-5 text-lg leading-8 text-slate-700">{{ $body }}</p>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            {{ $slot }}
        </div>
    </div>
</section>
