@php
    use App\View\InitialJS;
@endphp

@if (app(InitialJS::class)->countJSON())
    <script type="text/javascript">
        @foreach(app(InitialJS::class)->getJSON() as $name => $json)
            window.{{ $name }} = "{!! addslashes($json) !!}";
        @endforeach
    </script>
@endif
@if (app(InitialJS::class)->countVariables())
    <script type="text/javascript">
        @foreach(app(InitialJS::class)->getVariables() as $name => $data)
            window.{{ $name }} = "{!! addslashes($data) !!}";
        @endforeach
    </script>
@endif