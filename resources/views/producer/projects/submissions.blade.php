@extends('layouts.default_layout')

@section('content')
<div class="md:w-3/4 float-left">
    <div class="pb-4 md:pb-8">
        <a href="#" class="h4 text-grey">
            <span class="btn-arrow-back mr-2 inline-block"></span>Back to project list</a>
    </div>

    <div class="bg-white rounded mb-4 p-4 md:p-8 shadow-md">
        <div class="flex justify-between items-center">
            <h3 class="text-blue-dark font-semibold mb-1 text-lg font-header">Gaffer
                <span class="badge">1 needed</span>
            </h3>
            <div>
                <span class="h4 mr-2 text-yellow inline-block text-xs">
                    <a href="#" class="btn-more inline-block"></a>
            </div>
        </div>
        <div class="bg-grey-lighter rounded p-3 md:p-6 md:flex mt-4">
            <div class="md:w-1/2 px-2">
                <div class="block text-sm text-blue-dark py-1">
                    <strong>PAY:</strong> $80/hour</div>
                <div class="block text-sm text-blue-dark py-1">
                    <strong>UNION</strong> (but accepting non-union submissions)</div>
                <div class="block text-sm text-blue-dark py-1">
                    <strong>EQUIPMENT:</strong> provided by production</div>
            </div>
            <div class="md:w-1/2 px-2">
                <div class="block text-sm text-blue-dark py-1">
                    <strong>PRODUCTION TITLE:</strong> Comfort Nation</div>
                <div class="block text-sm text-blue-dark py-1">
                    <strong>PRODUCTION COMPANY: </strong> Artisan Studios</div>
                <div class="block text-sm text-blue-dark py-1">
                    <strong>LOCATION: </strong> New York</div>
            </div>
        </div>
        <div class="md:flex mt-6">
            <div class="md:w-1/4">
                <h4 class="text-grey mb-3 md:mb-0 mt-1">Project details</h4>
            </div>
            <div class="md:w-3/4">
                <p>Looking for an experienced gaffer who is easy going and able to roll with the punches to work
                    alongside a great crew...
                    <a href="#" class="text-sm">MORE</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Submissions Section
    ******************************************-->
    <div class="py-6 md:flex justify-between">
        <h3 class="text-md mb-3">Submissions
            <span class="badge bg-white">5</span>
        </h3>
        <div class="block">
            <a href="#" class="btn-outline inline-block mr-2 mb-1 md:mb-0">export "yes" selections</a>
            <a href="#" class="btn-outline inline-block bg-green text-white">CONTACT ALL “YES” SELECTIONS</a>
        </div>
    </div>
    <div class="md:hidden w-full md:w-1/4 float-left md:mb-3">
        <div class="has-menu relative">
            <div class="flex justify-between justify-center items-center rounded-lg w-full float-left mb-4 py-3 px-3 border border-grey-light bg-white cursor-pointer text-sm">
                <div>Unseen
                    <span class="badge">5</div>
                </span>
                <span class="btn-toggle float-right"></span>
            </div>
            <div class="menu w-full shadow-md bg-white absolute py-3 font-body border text-sm border-grey-light">
                <ul class="list-reset text-left">
                    <li class="py-2 px-4">
                        <a href="#" class="block text-blue-dark hover:text-green">View profile</a>
                    </li>
                    <li class="py-2 px-4">
                        <a href="#" class="block text-blue-dark hover:text-green">Subscription</a>
                    </li>
                    <li class="py-2 px-4">
                        <a href="#" class="block text-blue-dark hover:text-green">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="hidden md:block list-reset font-header text-right px-md py-6">
            <li class="block py-4">
                <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Subscription</a>
            </li>
            <li class="block py-4">
                <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Password</a>
            </li>
            <li class="block py-4">
                <a href="#" class="text-blue-dark font-semibold py-2 border-b-2 border-red hover:text-green">Add manager</a>
            </li>
            <li class="block py-4">
                <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Notification setttings</a>
            </li>
            <li class="block py-4">
                <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Close account</a>
            </li>
        </ul>
    </div>
    <div class="hidden md:flex justify-between border-b-2 border-grey-light">
        <div>
            <ul class="list-reset flex items-center">
                <li class="mr-4">
                    <a class="border-b-2 border-red block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green"
                        href="#">unseen
                        <span class="badge bg-white">5</span>
                    </a>
                </li>
                <li class="">
                    <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">seen
                        <span class="badge bg-white">5</span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <ul class="list-reset flex items-center">
                <li class="mr-4">
                    <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                        <span class="font-thin">"Yes"</span>
                        <span class="badge bg-white">5</span>
                    </a>
                </li>
                <li class="mr-4">
                    <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                        <span class="font-thin">"no"</span>
                        <span class="badge bg-white">5</span>
                    </a>
                </li>
                <li class="">
                    <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                        <span class="font-thin">"maybe"</span>
                        <span class="badge bg-white">5</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>

    <!-- Cards Section
    ******************************************-->
    <div class="w-full float-left py-6 md:py-lg grid-cards">
        <div class="bg-white rounded border-grey-lighter shadow-md w-full flex flex-col justify-between">
            <div class="p-6 relative">
                <a href="#" class="btn-more absolute pin-top-right"></a>
                <div class="rounded-full w-48 h-48 m-auto mt-3" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                <div class="py-2 w-full float-left -mt-6">
                    <ul class="list-reset text-center flex justify-center">
                        <li class="w-8 h-8 bg-yellow-imdb rounded-full responsive p-1 inline-block -mr-2">
                            <a href="#">
                                <img src="images/imdb.svg" alt="imdb">
                            </a>
                        </li>
                        <li class="w-8 h-8 bg-blue-linkedin rounded-full responsive p-1 items-center justify-center inline-block">
                            <a href="#" class="block">
                                <i class="fab fa-linkedin-in text-white"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="text-center">
                    <div class="pb-4">
                        <h3 class="mb-1">Nathan Shaw</h3>
                        <span class="text-grey">Director of photography</span>
                    </div>
                    <p class="text-sm">Nathan Shaw began his career in Hollywood as an assistant director and unit production manager...</p>
                    <a href="#" class="h4 my-4 block">view full profile</a>
                </div>

                <div class="border-t border-grey-light pt-3 mt-6 block">
                    <ul class="list-reset">
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <img src="images/play.svg" alt="" class="pos-center" />
                                </div> Professional Work Reel</a>
                        </li>
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <i class="far fa-file-alt text-white pos-center"></i>
                                </div> Professional Resume</a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="bg-grey-lighter rounded-b px-6 py-3">
                <div class="border border-grey-light overflow-hidden rounded-full flex bg-white justify-center text-center">
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        yes
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 border-r border-grey-light border-l h4 text-grey">
                        maybe
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        no
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded border-grey-lighter shadow-md w-full flex flex-col justify-between">
            <div class="p-6 relative">
                <span class="text-yellow h4 mb-2 w-full absolute text-xs pin-top-left">
                    <i class="fas fa-star mr-1"></i>requested submission</span>
                <a href="#" class="btn-more absolute pin-top-right"></a>
                <div class="rounded-full w-48 h-48 m-auto mt-3" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                <div class="py-2 w-full float-left -mt-6">
                    <ul class="list-reset text-center flex justify-center">
                        <li class="w-8 h-8 bg-yellow-imdb rounded-full responsive p-1 inline-block -mr-2">
                            <a href="#">
                                <img src="images/imdb.svg" alt="imdb">
                            </a>
                        </li>
                        <li class="w-8 h-8 bg-blue-linkedin rounded-full responsive p-1 items-center justify-center inline-block">
                            <a href="#" class="block">
                                <i class="fab fa-linkedin-in text-white"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="text-center">
                    <div class="pb-4">
                        <h3 class="mb-1">Nathan Shaw</h3>
                        <span class="text-grey">Director of photography</span>
                    </div>
                    <p class="text-sm">Nathan Shaw began his career in Hollywood as an assistant director and unit production manager...</p>
                    <a href="#" class="h4 my-4 block">view full profile</a>
                </div>

                <div class="border-t border-grey-light pt-3 mt-6 block">
                    <ul class="list-reset">
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <img src="images/play.svg" alt="" class="pos-center" />
                                </div> Professional Work Reel</a>
                        </li>
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <i class="far fa-file-alt text-white pos-center"></i>
                                </div> Professional Resume</a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="bg-grey-lighter rounded-b px-6 py-3">
                <div class="border border-grey-light overflow-hidden rounded-full flex bg-white justify-center text-center">
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        yes
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 border-r border-grey-light border-l h4 text-grey">
                        maybe
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        no
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded border-grey-lighter shadow-md w-full flex flex-col justify-between">
            <div class="p-6 relative">
                <a href="#" class="btn-more absolute pin-top-right"></a>
                <div class="rounded-full w-48 h-48 m-auto mt-3" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                <div class="py-2 w-full float-left -mt-6">
                    <ul class="list-reset text-center flex justify-center">
                        <li class="w-8 h-8 bg-yellow-imdb rounded-full responsive p-1 inline-block -mr-2">
                            <a href="#">
                                <img src="images/imdb.svg" alt="imdb">
                            </a>
                        </li>
                        <li class="w-8 h-8 bg-blue-linkedin rounded-full responsive p-1 items-center justify-center inline-block">
                            <a href="#" class="block">
                                <i class="fab fa-linkedin-in text-white"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="text-center">
                    <div class="pb-4">
                        <h3 class="mb-1">Nathan Shaw</h3>
                        <span class="text-grey">Director of photography</span>
                    </div>
                    <p class="text-sm">Nathan Shaw began his career in Hollywood as an assistant director and unit production manager...</p>
                    <a href="#" class="h4 my-4 block">view full profile</a>
                </div>

                <div class="border-t border-grey-light pt-3 mt-6 block">
                    <ul class="list-reset">
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <img src="images/play.svg" alt="" class="pos-center" />
                                </div> Professional Work Reel</a>
                        </li>
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <i class="far fa-file-alt text-white pos-center"></i>
                                </div> Professional Resume</a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="bg-grey-lighter rounded-b px-6 py-3">
                <div class="border border-grey-light overflow-hidden rounded-full flex bg-white justify-center text-center">
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        yes
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 border-r border-grey-light border-l h4 text-grey">
                        maybe
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        no
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded border-grey-lighter shadow-md w-full flex flex-col justify-between">
            <div class="p-6 relative">
                <a href="#" class="btn-more absolute pin-top-right"></a>
                <div class="rounded-full w-48 h-48 m-auto mt-3" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                <div class="py-2 w-full float-left -mt-6">
                    <ul class="list-reset text-center flex justify-center">
                        <li class="w-8 h-8 bg-yellow-imdb rounded-full responsive p-1 inline-block -mr-2">
                            <a href="#">
                                <img src="images/imdb.svg" alt="imdb">
                            </a>
                        </li>
                        <li class="w-8 h-8 bg-blue-linkedin rounded-full responsive p-1 items-center justify-center inline-block">
                            <a href="#" class="block">
                                <i class="fab fa-linkedin-in text-white"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="text-center">
                    <div class="pb-4">
                        <h3 class="mb-1">Nathan Shaw</h3>
                        <span class="text-grey">Director of photography</span>
                    </div>
                    <p class="text-sm">Nathan Shaw began his career in Hollywood as an assistant director and unit production manager...</p>
                    <a href="#" class="h4 my-4 block">view full profile</a>
                </div>

                <div class="border-t border-grey-light pt-3 mt-6 block">
                    <ul class="list-reset">
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <img src="images/play.svg" alt="" class="pos-center" />
                                </div> Professional Work Reel</a>
                        </li>
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <i class="far fa-file-alt text-white pos-center"></i>
                                </div> Professional Resume</a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="bg-grey-lighter rounded-b px-6 py-3">
                <div class="border border-grey-light overflow-hidden rounded-full flex bg-white justify-center text-center">
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        yes
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 border-r border-grey-light border-l h4 text-grey">
                        maybe
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        no
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded border-grey-lighter shadow-md w-full flex flex-col justify-between">
            <div class="p-6 relative">
                <a href="#" class="btn-more absolute pin-top-right"></a>
                <div class="rounded-full w-48 h-48 m-auto mt-3" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                <div class="py-2 w-full float-left -mt-6">
                    <ul class="list-reset text-center flex justify-center">
                        <li class="w-8 h-8 bg-yellow-imdb rounded-full responsive p-1 inline-block -mr-2">
                            <a href="#">
                                <img src="images/imdb.svg" alt="imdb">
                            </a>
                        </li>
                        <li class="w-8 h-8 bg-blue-linkedin rounded-full responsive p-1 items-center justify-center inline-block">
                            <a href="#" class="block">
                                <i class="fab fa-linkedin-in text-white"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="text-center">
                    <div class="pb-4">
                        <h3 class="mb-1">Nathan Shaw</h3>
                        <span class="text-grey">Director of photography</span>
                    </div>
                    <p class="text-sm">Nathan Shaw began his career in Hollywood as an assistant director and unit production manager...</p>
                    <a href="#" class="h4 my-4 block">view full profile</a>
                </div>

                <div class="border-t border-grey-light pt-3 mt-6 block">
                    <ul class="list-reset">
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <img src="images/play.svg" alt="" class="pos-center" />
                                </div> Professional Work Reel</a>
                        </li>
                        <li class="my-2">
                            <a href="#" class="flex items-center">
                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                    <i class="far fa-file-alt text-white pos-center"></i>
                                </div> Professional Resume</a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="bg-grey-lighter rounded-b px-6 py-3">
                <div class="border border-grey-light overflow-hidden rounded-full flex bg-white justify-center text-center">
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        yes
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 border-r border-grey-light border-l h4 text-grey">
                        maybe
                    </div>
                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey">
                        no
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection