@props(['size' => 32, 'radius' => 8])
<div style="width:{{ $size }}px;height:{{ $size }}px;background:#014BAA;border-radius:{{ $radius }}px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
    <span style="color:#fff;font-family:'Figtree',Arial,sans-serif;font-weight:800;font-size:{{ round($size * 0.45) }}px;letter-spacing:-0.5px;line-height:1;">Rp</span>
</div>