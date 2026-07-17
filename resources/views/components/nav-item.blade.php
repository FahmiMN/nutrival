@props(['route', 'icon'])
<a href="{{ route($route) }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition
   {{ request()->routeIs(str_replace('.index', '.*', $route)) || request()->routeIs($route)
       ? 'bg-emerald-50 text-emerald-700 font-semibold'
       : 'text-slate-600 hover:bg-stone-100' }}">
    <span>{{ $icon }}</span>
    <span>{{ $slot }}</span>
</a>
