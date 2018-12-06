@if (app(\App\View\InitialJS::class)->any())
    <script type="text/javascript">
        @if (app(\App\View\InitialJS::class)->countJSON())
            @foreach(app(\App\View\InitialJS::class)->getJson() as $name => $json)
                window.{{ $name }} = "{!! addslashes($json) !!}";
            @endforeach
        @endif
        @if (app(\App\View\InitialJS::class)->countVariables())
            @foreach(app(\App\View\InitialJS::class)->getVariables() as $name => $data)
                window.{{ $name }} = "{!! addslashes($data) !!}";
            @endforeach
        @endif
    </script>
@endif