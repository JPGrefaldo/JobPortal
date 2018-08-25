<span
        class="border rounded-full border-grey flex items-center cursor-pointer my-4 w-12 js-switch
                    @if($switchOn) switch-on @else switch-off @endif"
        id="{{ $switchName }}"
>
    <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-white shadow"></span>
    <input type="hidden" value="{{ $switchValue }}" name="{{ $switchName }}">
</span>