{{-- Bunga 5 kelopak, mengacu pada swatch "color code" di palette. Warna mengikuti currentColor. --}}
<svg {{ $attributes->merge(['class' => 'flower']) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" fill="currentColor" aria-hidden="true">
    <circle cx="100" cy="54" r="36"/>
    <circle cx="100" cy="54" r="36" transform="rotate(72 100 100)"/>
    <circle cx="100" cy="54" r="36" transform="rotate(144 100 100)"/>
    <circle cx="100" cy="54" r="36" transform="rotate(216 100 100)"/>
    <circle cx="100" cy="54" r="36" transform="rotate(288 100 100)"/>
    <circle cx="100" cy="100" r="32"/>
</svg>
