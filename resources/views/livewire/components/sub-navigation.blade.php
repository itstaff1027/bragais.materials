<div>
    @foreach ($sub_navigation as $key => $navigation)
    <x-nav-link :key="$key" :href="route($navigation['path'])" :active="request()->routeIs($navigation['to'])">
        {{ __($navigation['name']) }}
    </x-nav-link>
    @endforeach
</div>