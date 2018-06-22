@include('_parts/header')

<body class="bg-grey-lighter font-body">
    @include('_parts/nav-logged')

    <main class="float-left w-full py-md md:py-lg px-3">
        <div class="container">
            <div class="w-full pb-6 md:pb-lg">
                <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold">My profile</h1>
            </div>

            <div class="hidden md:block w-1/4 float-left pr-8 py-md">
                <h4 class="text-sm uppercase text-grey tracking-wide mb-4">COMPLETE YOUR ACCOUNT</h4>
                <p>Complete profiles have a better chance of being selected and show up higher in search results. </p>
                <div class="text-center pt-8 pb-4">
                    <img src="images/donut.svg" alt="" />
                </div>
                <ul class="list-reset list-check">
                    <li class="is-checked">BIO</li>
                    <li class="is-checked">SOCIAL MEDIA PROFILES</li>
                    <li class="is-checked">GENERAL WORK RESUME</li>
                    <li class="is-checked">GENERAL WORK REEL</li>
                    <li>WORK POSITIONS</li>
                </ul>
            </div>
            <div class="w-full md:w-3/4 float-left">
                <a href='/my-profile/edit' class="text-grey w-full mb-2 text-sm md:text-right float-right"><i class="fas fa-pencil-alt mr-2"></i>Edit profile</a>
                <div class="card float-left md:flex mb-8">
                    <div class="md:w-1/4 md:pr-8 text-center">
                        <img src="{{ $biography->photo }}" class="rounded" alt="" />
                        <ul class="list-reset py-4">
                            <li class="py-1">
                                <a href="{{ $imdb->url }}" class="flex items-center">
                                    <div class="p-1 rounded bg-yellow-imdb w-8 h-8"><img src="images/imdb.svg" alt="" class="mr-2 img-responsive"></div><span class="ml-2 text-yellow-imdb">IMDb profile</span></a>
                            </li>
                            <li class="py-1">
                                <a href="#" class="flex items-center text-blue-linkedin">
                                    <img src="images/linkedin.svg" alt="" class="mr-2">LinkedIn profile</a>
                            </li>
                        </ul>
                    </div>
                    <div class="md:w-3/4">
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">{{ $user->first_name }} {{ $user->last_name }}</h3>

                        <span class="text-grey font-semibold font-header">{{ $jobTitle->name }} </span>
                        <div class="bg-grey-lighter p-6 rounded my-8">
                            <p>{{ $biography->bio }}
                                <a href="/my-profile/edit/{id}" class="text-sm text-grey tracking-wide">Read more</a>
                            </p>
                        </div>
                        <div class="pb-2 md:flex">
                                <a href="#" class="border md:w-1/2 flex overflow-hidden rounded md:mr-2 mb-2 md:mb-0">
                                    <div class="w-24 relative" style="background: url(images/th2.jpg); background-size: cover;">
                                        <span class="btn-play w-10 h-10"></span>
                                    </div>
                                    <span class='uppercase text-green font-semibold p-4 text-sm tracking-wide'>VIEW POSITION WORK REEL</span>
                                </a>
                                <a href="#" class="border md:w-1/2 flex items-center overflow-hidden rounded md:ml-2">
                                    <i class="far fa-file-alt px-6 text-lg"></i>
                                    <span class='uppercase text-green font-semibold px-0 py-6 text-sm tracking-wide'>VIEW POSITION RESUME</span>
                                </a>
                            </div>
                    </div>
                </div>

                <div class="py-4">
                    <a href='#' class="text-grey text-sm float-right">
                        <i class="fas fa-pencil-alt mr-2"></i>Edit section</a>
                    <h4 class='text-grey'>WORK POSITIONS</h4>
                </div>
                @foreach ($jobTitle as $title)
                <div class="card mb-6">
                    <div class="pb-6">
                        <span class="btn-toggle float-right"></span>
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">{{ $department->name }}
                            <span class="font-thin"> – {{ $jobTitle->name }}</span>
                        </h3>
                    </div>
                    <div class="md:flex">
                        <div class="md:w-1/4 pr-8 mb-2 md:mb-0">
                            <h3 class="text-md text-grey font-header">Position bio</h3>
                        </div>
                        <div class="md:w-3/4">
                            <div class="bg-grey-lighter p-6 rounded mb-8">
                                <p> {{ $position->details }} </p>
                            </div>
                            <div class="pb-2 md:flex">
                                <a href="#" class="border md:w-1/2 flex overflow-hidden rounded md:mr-2 mb-2 md:mb-0">
                                    <div class="w-24 relative" style="background: url(images/th2.jpg); background-size: cover;">
                                        <span class="btn-play w-10 h-10"></span>
                                    </div>
                                    <span class='uppercase text-green font-semibold p-4 text-sm tracking-wide'>VIEW POSITION WORK REEL</span>
                                </a>
                                <a href="#" class="border md:w-1/2 flex items-center overflow-hidden rounded md:ml-2">
                                    <i class="far fa-file-alt px-6 text-lg"></i>
                                    <span class='uppercase text-green font-semibold px-0 py-6 text-sm tracking-wide'>VIEW POSITION RESUME</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
                
                <div class="card mb-6">
                    <div class="md:flex justify-between">
                        <h3 class="text-blue-dark font-semibold text-lg font-header mb-2 md:mb-0">Sound</h3>
                        <a href="#" class="btn-green-outline">ADD POSITION</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('_parts/footer')