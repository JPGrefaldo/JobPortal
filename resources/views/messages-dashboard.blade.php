@extends('layouts.default_layout')

@section('content')
    <div class="flex flex-col flex-1">
        {{-- Top bar --}}
        <div class="flex h-16">
            <div class="w-1/5 border-b border-r border-black p-3 flex items-center">
                <input type="text" class="mr-2 rounded rounded-full bg-white flex-1" placeholder="  Search">
                <i class="fa fa-search"></i>
            </div>
            <div class="w-4/5 border-black border-b p-3 font-bold flex justify-center items-center">
                Titanic: Leonardo Di Carpio
            </div>
        </div>
        {{-- main content --}}
        <div class="flex">
            {{-- left panel --}}
            <div class="flex w-1/5 border-r border-black">
                {{-- projects --}}
                <div class="bg-grey-dark overflow-auto">
                    {{-- hit an index endpoint as a role specified --}}
                    {{-- something like /crew/messages and /producer/messages --}}
                    @foreach ($projects as $project)
                        {{-- this is temporary --}}
                        <div class="text-center py-3 mb-2 items-center m-1 bg-blue hover:bg-blue-dark text-white font-bold h-10 w-10 rounded">
                            {{-- use vue to render acronym instead --}}
                            {{ $project->acronym }}
                        </div>
                    @endforeach
                </div>
                {{-- threads --}}
                <div class="bg-grey flex-1 overflow-auto">
                    {{-- this needs to be filtered out relative to role --}}
                    {{-- if you're a crew then you should see threads that are related to projects you're contributing to --}}
                    @foreach ($threads as $thread)
                        <div class="flex p-1">
                            <div class="h-10 w-10 rounded rounded-full bg-white background-missing-avatar"></div>
                            <div class="p-2">
                                <div>
                                    {{ str_limit($thread->subject, 12) }}
                                </div>
                                <div>
                                    {{ str_limit('You: Awesome! You\'re the best!', 12) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-4/5 bg-white flex flex-col">
            {{-- conversation --}}
            <div class="flex-1 p-4 overflow-x-auto">
                    {{-- this should be filtered out by the selected thread --}}
                    @foreach ($messages as $message)
                        @if (strpos($message, 'quis') !== false)
                            <div class="flex items-center">
                                <div>
                                    <div class="border h-10 w-10 mr-4 rounded rounded-full bg-white background-missing-avatar"></div>
                                </div>
                                <div class="rouded rounded-lg bg-grey p-3 max-w-md mb-4">
                                    {{ $message->body }}
                                </div>
                            </div>
                        @else
                            <div class="flex items-center">
                                <div class="flex-1"></div>
                                <div class="rouded rounded-lg bg-blue p-3 max-w-md mb-4 mr-4">
                                    {{ $message->body }}
                                </div>
                                <div>
                                    <div class="border h-10 w-10 mr-4 rounded rounded-full bg-white background-missing-avatar"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
            </div>
            </div>
        </div>
    </div>
@endsection
