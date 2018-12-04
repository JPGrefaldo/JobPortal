@if (isset($initJS))
    <script type="text/javascript">
        @if (isset($initJS['json']))
            @foreach($initJS['json'] as $name => $json)
                window.{{ $name }} = "{!! addslashes(json_encode($json->toArray())) !!}";
            @endforeach
        @endif
    </script>
@endif


<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
<script type="text/javascript" src="{{ mix('/js/all.js') }}"></script>
<script type="text/javascript" src="{{ mix('/js/scripts.js') }}"></script>
@stack('javascripts')