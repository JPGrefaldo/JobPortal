@extends('layouts.default_layout')

@section('content')

    <main class="float-left w-full py-md md:py-lg">
        <div class="container">
            @include('_parts.pages.page-title', ['pageTitle' => 'Positions'])
            <table>
                @foreach ($positions as $position)

                    <tr>
                        <td>
                            <a href="{{ route('crew_position.show', $position) }}">{{ $position->name }}</a>
                        </td>
                    </tr>

                @endforeach
            </table>
        </div>
    <main>

@endsection
