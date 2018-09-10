<div class="w-full md:w-1/4 float-left md:mb-3">
    <div class="has-menu relative md:hidden">
        <div class="flex justify-between justify-center items-center rounded-lg w-full float-left mb-4 py-3 px-3 border border-grey-light bg-white cursor-pointer text-sm">
            @foreach($menu_items as $route => $value) @if(Route::is($route)) {{ $value }} @endif @endforeach <span class="btn-toggle float-right"></span>
        </div>
        <div class="menu w-full shadow-md bg-white absolute py-3 font-body border text-sm border-grey-light">
            @include('account._parts.account-menu-build', [
                'accountMenuMobile' => true,
                'AccountMenu' => $menu_items,
            ])
        </div>
    </div>
        @include('account._parts.account-menu-build', [
            'accountMenuMobile' => false,
            'AccountMenu' => $menu_items,
        ])
</div>