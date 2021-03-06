@if($accountMenuMobile)
    <ul class="text-left">
        @foreach($AccountMenu as $key => $text)
            <mobile-menu
                    link="{{ route($key) }}"
                    text="{{ $text }}"
                ></mobile-menu>
        @endforeach
    </ul>
@else
    <ul class="hidden md:block font-header text-right px-md">
        @foreach($AccountMenu as $key => $text)
            <li class="block py-3">
                <a href="{{ route($key) }}" class="text-blue-dark font-semibold py-2 hover:text-green @if(Route::is($key)) border-b-2 border-red @endif">{{ $text }}</a>
            </li>
        @endforeach
    </ul>
@endif
