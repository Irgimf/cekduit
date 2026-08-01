@props(['size' => 32, 'radius' => 8])
@php $circleSize = round($size * 0.68); $fontSize = round($size * 0.33); @endphp
<svg xmlns="http://www.w3.org/2000/svg"
     width="{{ $size }}" height="{{ $size }}"
     viewBox="0 0 512 512"
     style="border-radius:{{ $radius }}px;flex-shrink:0;">
    <rect width="512" height="512" rx="114" fill="#014BAA"/>
    <circle cx="256" cy="256" r="175" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="28"/>
    <text x="256" y="310" font-family="Arial,sans-serif" font-weight="800" font-size="168" fill="white" text-anchor="middle">Rp</text>
</svg>