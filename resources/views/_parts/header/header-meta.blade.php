<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,600|Noto+Sans:400,600" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

@auth
    <meta name="is-authorized" content="1">
    <meta name="api-token" content="{{ session('api-token') }}">
@endauth
