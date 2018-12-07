@extends('layouts.default_layout')

@section('content')
    <div class="flex flex-col">
        <div class="flex text-center">
            {{-- Top bar --}}
            <div class="bg-grey w-64">Search</div>
            <div class="bg-grey flex-1">Recipient name</div>
        </div>
        <div class="flex">
            {{-- Messages Panel --}}
            <div>
                {{-- projects --}}
                {{-- hit an index endpoint as a role specified --}}
                {{-- something like /crew/messages and /producer/messages --}}
                @foreach ($projects as $project)
                    {{-- this is temporary --}}
                    {{-- this should be circular --}}
                    <div class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded rounded-full">
                        {{ $project->title }}
                    </div>
                @endforeach
            </div>
            <div>
                {{-- threads --}}
                {{-- this needs to be filtered out relative to role --}}
                {{-- if you're a crew then you should see threads that are related to projects you're contributing to --}}
                @foreach ($threads as $thread)
                    <div class="flex">
                        <div class="h-8 w-8 rounded rounded-full bg-red"></div>
                        <div class="p-2">
                            {{ $thread->subject }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                {{-- conversation --}}
                {{-- this should be filtered out by the selected thread --}}
                @foreach ($messages as $message)
                    @if (strpos($message, 'quis') !== false)
                        <div class="flex">
                            <div>
                                <div class="h-8 w-8 rounded rounded-full bg-red"></div>
                            </div>
                            <div>
                                {{ $message->body }}
                            </div>
                        </div>
                    @else
                        <div class="flex">
                            <div>
                                {{ $message->body }}
                            </div>
                            <div>
                                <div class="h-8 w-8 rounded rounded-full bg-red"></div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
