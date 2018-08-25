@if($accountMenuMobile)
    <ul class="list-reset text-left">
        @foreach($AccountMenu as $key => $text)
            <li class="py-2 px-4">
                <a href="{{ route($key) }}" class="block text-blue-dark hover:text-green">{{ $text }}</a>
            </li>
        @endforeach
    </ul>
@else
    <ul class="hidden md:block list-reset font-header text-right px-md py-6">
        @foreach($AccountMenu as $key => $text)
            <li class="block py-4">
                <a href="{{ route($key) }}" class="text-blue-dark font-semibold py-2 hover:text-green @if(Route::is($key)) border-b-2 border-red @endif">{{ $text }}</a>
            </li>
        @endforeach
    </ul>
@endif