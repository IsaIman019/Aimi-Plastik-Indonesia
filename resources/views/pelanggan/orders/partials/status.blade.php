@php
$map = [
    'pending'   => ['Menunggu Konfirmasi', 'yellow'],
    'diproses'  => ['Diproses', 'blue'],
    'dikirim'   => ['Dikirim', 'purple'],
    'diterima'  => ['Diterima', 'indigo'],
    'selesai'   => ['Selesai', 'green'],
];
[$label, $color] = $map[$status] ?? ['Tidak Diketahui', 'red'];
@endphp

<span class="bg-{{ $color }}-100 text-{{ $color }}-700 px-3 py-1 rounded-full text-xs font-bold">
    {{ $label }}
</span>
