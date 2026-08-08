@props(['href', 'active' => false])

<a href="{{ $href }}"
   @class([
       'flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition',
       'bg-white/10 text-white' => $active,
       'text-white/70 hover:text-white hover:bg-white/5' => ! $active,
   ])>
    {{ $slot }}
</a>
