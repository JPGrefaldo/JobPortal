@extends('layouts.default_layout')
@section('content')

<table>
    @foreach ($positions as $position)

        <tr>
            <td>
                {{ $position->name }}
            </td>
        </tr>

    @endforeach
</table>

@endsection
