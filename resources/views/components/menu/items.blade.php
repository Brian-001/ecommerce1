<div
    x-menu:items
    x-show="menuOpen"
    {{-- x-anchor.bottom-end.offset.3="document.getElementById($id('alpine-menu-button'))"--}}
    class="absolute right-0 min-w-[10rem] z-10 bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg py-1 outline-none"
    x-cloak
>
    {{ $slot }}
</div>
