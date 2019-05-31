@include('_parts.header.header')

<body class="bg-white">
    <header class="w-full pb-lg float-left relative has-deco-bottom deco-white overflow-hidden"
            style="background: url(/images/cover-vid.png) no-repeat center; background-size: cover;"
    >
        <video playsinline autoplay muted loop poster="images/cover-vid.png" class="bg-video">
            <source src="images/bg.mp4" type="video/mp4">
        </video>
        <div class="img-overlay"></div>
        <div class="img-overlay-multiply"></div>
        <nav class="absolute z-20 top-0 left-0 float-left w-full px-3 md:px-6">
            <div class="img-overlay darker"></div>
            <div class="py-2 md:flex justify-between items-center">
                <div class="w-32 md:w-64 py-1 md:py-0 relative z-10 flex items-center">
                    <img src="/images/logos/logo-white-2.svg" alt="crew calls" class="mr-2">
                    <span class="text-white pt-6 pb-1 border-b-2 border-white text-md font-bold font-header">{{ config('app.name') }}</span>
                </div>
                <ul class="hidden lg:flex items-center relative z-10">
                        <li>
                            <a class="block py-6 px-4 font-header tracking-wide block font-bold leading-none uppercase text-sm text-white hover:text-green"
                                href="{{ route('producer.projects.create') }}">post a project</a>
                        </li>
                        <li>
                            <a class="block py-6 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-white hover:text-green"
                                href="{{ route('projects.current-projects') }}">find a project</a>
                        </li>
                        <li>
                            <a class="block py-6 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-white hover:text-green"
                                href="{{ route('about') }}">about</a>
                        </li>
                    </ul>
                    <div id="nav-container" class="w-64 hidden lg:block relative z-10">

                        <ul class="flex items-center">
                            @guest
                            <li>
                                <a class="block py-4 px-8 font-header font-bold leading-none uppercase text-sm text-white hover:text-green" href="{{ route('login') }}">SIGN IN</a>
                            </li>
                            <li>
                                <a class="block py-4 px-8 font-header font-bold leading-none border border-white rounded-full uppercase text-sm text-white hover:border-green hover:text-green"
                                    href="{{ route('signup') }}">SIGN UP</a>
                            </li>
                            @else
                            <li>
                                <a href="{{ route('dashboard') }}"
                                   class="block py-4 px-8 font-header font-bold leading-none border border-white rounded-full text-sm text-white hover:text-green">
                                    {{ Auth::user()->first_name }}
                                    <span class="caret"></span>
                                </a>
                            </li>
                            <li>
                                <cca-logout-link csrf="{{ csrf_token() }}"
                                                 classes="block py-4 px-8 font-header font-bold leading-none uppercase text-sm text-white hover:border-green hover:text-green">
                                    {{ __('Logout') }}
                                </cca-logout-link>
                            </li>
                        @endguest
                        </ul>
                    </div>
            </div>
        </nav>

        <div class="max-w-screen-xl flex justify-center items-center py-md md:py-lg px-3 z-10 relative header-content">
            <div class="flex-1 text-center object-center md:w-2/3 md:py-lg">
                <h1 class="text-xl md:text-3xl text-header uppercase text-white pt-lg fade-up">CONNECTING
                    <br> PRODUCERS
                    <span class="font-thin">WITH</span>
                    <br> AMERICA’S TOP CREWS</h1>
                <p class="text-md text-white pt-6 pb-6 block fade-up-1">Reach out to our extensive database of production crew and staff – view sort and manage crew profiles and
                    responses.</p>
                <div class="w-full block pt-6 fade-up-2">
                    <a href="#" class="btn-white mr-2 text-black mb-2 md:mb-0">FIND CREW</a>
                    <a href="{{ route('signup') }}" class="btn-white-outline">Join as CREW</a>
                </div>
            </div>
        </div>
        <a href="#" class="btn-skip z-10"></a>
    </header>

    <!-- Partners Section
    ******************************************-->
    <section class="pt-sm p-3 pb-md md:pb-lg float-left w-full bg-white relative z-10" id="content">
        <div class="text-center">
            <h4 class="text-grey mb-6">OUR SOFTWARE HAS HELPED STAFF PROJECTS FOR...</h4>
            <ul class="list-logos">
                <li class="inline-block mx-3 align-middle">
                    <img src="images/corp-logos/hbo.png" alt="hbo" />
                </li>
                <li class="inline-block mx-3 align-middle">
                    <img src="images/corp-logos/hallmark.png" alt="hallmark" />
                </li>
                <li class="inline-block mx-3 align-middle">
                    <img src="images/corp-logos/microsoft.png" alt="microsoft" />
                </li>
                <li class="inline-block mx-3 align-middle">
                    <img src="images/corp-logos/netflix.png" alt="netflix" />
                </li>
                <li class="inline-block mx-3 align-middle">
                    <img src="images/corp-logos/tnt.png" alt="hbo" />
                </li>
                <li class="inline-block mx-3 align-middle">
                    <span class="text-grey mb-6">... and more</span>
                </li>
            </ul>
        </div>
    </section>

    <!-- Intro Section
    ******************************************-->
    <section class="w-full float-left pt-sm md:pb-lg">
        <div class="px-l pb-md">
            <div class="md:flex flex-wrap md:px-lg">
                 <h2 class="md:hidden text-center text-lg pb-3">Post or submit <br> to projects needing…</h2>
                <div class="hidden md:block square rounded-lg">
                    <div class="block absolute top-0 left-0 h-full w-full flex items-center">
                        <h2 class="text-center md:text-right md:pr-8 text-lg md:text-xl md:-ml-8">Post or submit <br> to projects needing…</h2>
                    </div>
                </div>
                <div class="square rounded-lg hover:shadow-lg" style="background: url(images/th6.jpg) no-repeat center; background-size: cover;">
                    <a href="#" class="block absolute top-0 left-0 h-full w-full">
                        <span class="text-white font-bold text-md font-header p-6 absolute bottom-0 left-0 w-full">Production Crew</span>
                    </a>
                </div>
                <div class="square rounded-lg hover:shadow-lg" style="background: url(images/th5.jpg) no-repeat center; background-size: cover;">
                    <a href="#" class="block absolute top-0 left-0 h-full w-full">
                        <span class="text-white font-bold text-md font-header p-6 absolute bottom-0 left-0 w-full">Camera Crew</span>
                    </a>
                </div>
                <div class="square rounded-lg hover:shadow-lg" style="background: url(images/th7.jpg) no-repeat center; background-size: cover;">
                    <a href="#" class="block absolute top-0 left-0 h-full w-full">
                        <span class="text-white font-bold text-md font-header p-6 absolute bottom-0 left-0 w-full">Sound Crew</span>
                    </a>
                </div>
                <div class="square rounded-lg hover:shadow-lg" style="background: url(images/th1.jpg) no-repeat center; background-size: cover;">
                    <a href="#" class="block absolute top-0 left-0 h-full w-full">
                        <span class="text-white font-bold text-md font-header p-6 absolute bottom-0 left-0 w-full">Wardrobe</span>
                    </a>
                </div>
                <div class="square rounded-lg hover:shadow-lg" style="background: url(images/th4.jpg) no-repeat center; background-size: cover;">
                    <a href="#" class="block absolute top-0 left-0 h-full w-full">
                        <span class="text-white font-bold text-md font-header p-6 absolute bottom-0 left-0 w-full">Makeup & Hair</span>
                    </a>
                </div>
                <div class="square rounded-lg hover:shadow-lg" style="background: url(images/th3.jpg) no-repeat center; background-size: cover;">
                    <a href="#" class="block absolute top-0 left-0 h-full w-full">
                        <span class="text-white font-bold text-md font-header p-6 absolute bottom-0 left-0 w-full">Lights</span>
                    </a>
                </div>
                <div class="square rounded-lg hover:shadow-lg" style="background: url(images/th2.jpg) no-repeat center; background-size: cover;">
                    <a href="#" class="block absolute top-0 left-0 h-full w-full">
                        <span class="text-white font-bold text-md font-header p-6 absolute bottom-0 left-0 w-full">... and more</span>
                    </a>
                </div>


            </div>
        </div>
    </section>

    <!-- Banner Section
    ******************************************-->
    <section class="py-3 md:py-md w-full float-left overflow-hidden circle p-3">
        <div class="flex">
            <img src="images/logos/logo-cc.svg" alt="" class="mb-1 mr-3 md:mr-8 block" />
            <span class="text-white text-sm md:text-lg font-header md:leading-normal opacity-75">Part of the Casting Calls America software network, a bonded talent listing software provider accredited by the
                Better Business Bureau.</span>
        </div>
    </section>

    <!-- Matching Section
    ******************************************-->
    <section class="py-md md:py-lg bg-white w-full float-left" style="background: url(images/cards-bk.png) no-repeat center bottom; background-size: contain;">
        <div class="text-center p-3 md:pt-md">
            <h2 class="text-lg md:text-2xl pb-6 max-w-md m-auto">Powerful and smart profile matching engine</h2>
            <span class="md:text-md max-w-md m-auto inline-block leading-normal text-blue-dark">Our cutting edge submission management software connect producers to crew, and crew to local projects needing
                their skills.
            </span>
            <div class="pt-6 md:pt-lg fade-up">
                <img src="images/cards.png" alt="" class="img-responsive" />
            </div>
        </div>
    </section>


    <!-- Features Section
    ******************************************-->
    <section class="w-full p-3 pt-md md:pt-lg float-left relative has-deco-bottom" style="background: url(images/cover3.jpg) no-repeat center; background-size: cover;">
        <div class="img-overlay darker"></div>
        <div class="img-overlay-multiply darker"></div>
        <div class="relative z-10">
            <h2 class="text-center text-white text-xl md:text-2xl md:py-md max-w-md m-auto">A platform created for your specific needs</h2>
            <div class="md:flex pt-md fade-up">
                <div class="w-full md:w-1/2 md:pr-6">
                    <div class="bg-blue rounded-lg shadow-md text-center p-6 mb-3 md:mb-0 md:p-md shadow-lg">
                        <h3 class="text-white text-lg md:text-xl">Producers and directors</h3>
                        <p class="text-white py-3 md:py-6 md:text-md opacity-50">Post your listings to have quick and easy access to the best regional crews</p>
                        <ul class="text-white list-check2 mb-2">
                            <li class="py-2">Find the right matches, effortlessly</li>
                            <li class="py-2">Post rush calls</li>
                            <li class="py-2">Manage all your projects from one online dashbaord</li>
                            <li class="py-2">Post rush calls</li>
                        </ul>
                        <a href="{{ route('about.producers') }}" class="mt-6 py-4 px-8 font-header rounded-full bg-white uppercase text-sm leading-none tracking-wide font-bold text-blue inline-block">see all features</a>
                    </div>
                </div>
                <div class="w-full md:w-1/2 md:pl-6">
                    <div class="bg-green rounded-lg shadow-md text-center p-6 md:p-md shadow-lg">
                        <h3 class="text-white md:text-lg md:text-xl">Crews and staff</h3>
                        <p class="text-white py-3 md:py-6 text-md opacity-75">Post your listings to have quick and easy access to the best regional crews</p>
                        <ul class="text-white list-check2 mb-2">
                            <li class="py-2">Find the right matches, effortlessly</li>
                            <li class="py-2">Post rush calls</li>
                            <li class="py-2">Manage all your projects from one online dashbaord</li>
                            <li class="py-2">Post rush calls</li>
                        </ul>
                        <a href="{{ route('about.producers') }}" class="mt-6 py-4 px-8 font-header rounded-full bg-white uppercase text-sm leading-none tracking-wide font-bold text-green inline-block">see all features</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Device Section
    ******************************************-->
    <section class="bg-grey-lighter py-sm md:py-lg relative w-full overflow-hidden md:overflow-visible float-left">
        <div class="md:flex px-6 py-md">
            <div class="md:w-1/2">
                <h2 class="text-lg md:text-2xl">Detailed user profiles,
                    <br> accessible from any device</h2>
                <div class="py-6 md:py-md md:flex">
                    <div class="md:w-1/2 pr-8">
                        <ul class="font-header font-bold">
                            <li class="py-2">
                                <i class="far fa-file-alt text-green text-center w-8 mr-2 text-lg"></i>Work history</li>
                            <li class="py-2">
                                <img src="images/icon-video.svg" alt="" class="mr-2" />
                                </i>Gear & equipment</li>
                            <li class="py-2">
                                <i class="far fa-play-circle text-green text-center w-8 mr-2 text-lg"></i>Work samples</li>
                        </ul>
                    </div>
                    <div class="md:w-1/2">
                        <ul class="font-header font-bold">
                            <li class="py-2">
                                <i class="far fa-user text-green mr-2 text-lg text-center w-8"></i>Detailed bios</li>
                            <li class="py-2">
                                <i class="far fa-comment-alt text-green mr-2 text-center text-lg w-8"></i>Social media</li>
                            <li class="py-2">
                                <i class="far fa-file-alt text-green mr-2 text-center text-lg w-8"></i>Work resumes</li>
                        </ul>
                    </div>
                </div>
                <div class="w-full block">
                    <a href="#" class="btn-green mr-2 mb-2 md:mb-0">FIND CREW</a>
                    <a href="{{ route('signup') }}" class="btn-green-outline">Join as CREW</a>
                </div>
            </div>
        </div>
        <div class="w-full float-left md:w-1/2 screenshots md:absolute fade-up">
            <div class="iphone">
                <div class="iphone-bg" style="background: url(images/iphonebk.png) no-repeat center top; background-size: cover;"></div>
            </div>
            <div class="webframe shadow-md">
                <div class="webframe-bg" style="background: url(images/wireframe.jpg) no-repeat center top; background-size: cover;"></div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section
    ******************************************-->
    <section class="w-full float-left py-md md:py-lg bg-wheel-left relative">
        <img src="images/light.png" class="light-1" alt="" />
        <img src="images/light2.png" class="light-2" alt="" />
        <div class="relative">
            <div class="text-center">
                <div class="text-center md:rounded-full md:border md:border-grey-light m-auto md:shadow md:overflow-hidden inline-block md:bg-white">
                    <div class="rounded-full uppercase cursor-pointer tracking-wide inline-block md:float-left text-blue-dark bg-grey-lighter font-bold font-header text-sm py-3 px-6 md:border-r border-grey-light">HEAR FROM PRODUCERS</div>
                    <div class="rounded-full uppercase cursor-pointer tracking-wide inline-block md:float-left text-grey font-bold font-header text-sm py-3 px-6">HEAR FROM CREWS</div>
                </div>
            </div>

            <div class="pt-6 md:pt-lg md:px-lg md:pb-6 testimonial-slider">
                <div class="px-3">
                    <div class="bg-white p-6 shadow-md border border-grey-light rounded">
                        <div class="rounded-full w-32 h-32 m-auto" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                        <div class="py-2 w-full float-left -mt-6">
                            <ul class="text-center">
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
                                <span class="text-grey text-sm font-header font-bold">Director of photography</span>
                            </div>
                            <p class="text-blue-dark mb-6">“Crew Calls America has been evolving into the best online service I have found as a freelancer
                                in over 15 years of working in the industry“</p>
                        </div>
                    </div>
                </div>

                <div class="px-3 mt-6">
                    <div class="bg-white p-6 shadow-md border border-grey-light rounded">
                        <div class="rounded-full w-32 h-32 m-auto" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                        <div class="py-2 w-full float-left -mt-6">
                            <ul class="text-center">
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
                                <span class="text-grey text-sm font-header font-bold">Director of photography</span>
                            </div>
                            <p class="text-blue-dark mb-6">“Crew Calls America has been evolving into the best online service I have found as a freelancer
                                in over 15 years of working in the industry“</p>
                        </div>
                    </div>
                </div>

                <div class="px-3 mt-2">
                    <div class="bg-white p-6 shadow-md border border-grey-light rounded">
                        <div class="rounded-full w-32 h-32 m-auto" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                        <div class="py-2 w-full float-left -mt-6">
                            <ul class="text-center">
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
                                <span class="text-grey text-sm font-header font-bold">Director of photography</span>
                            </div>
                            <p class="text-blue-dark mb-6">“Crew Calls America has been evolving into the best online service I have found as a freelancer
                                in over 15 years of working in the industry“</p>
                        </div>
                    </div>
                </div>
                <div class="px-3">
                    <div class="bg-white p-6 shadow-md border border-grey-light rounded">
                        <div class="rounded-full w-32 h-32 m-auto" style="background: url(images/thumb.jpg) no-repeat center; background-size: cover"></div>
                        <div class="py-2 w-full float-left -mt-6">
                            <ul class="text-center">
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
                                <span class="text-grey text-sm font-header font-bold">Director of photography</span>
                            </div>
                            <p class="text-blue-dark mb-6">“Crew Calls America has been evolving into the best online service I have found as a freelancer
                                in over 15 years of working in the industry“</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- CTA Section
    ******************************************-->
    <section class="w-full py-lg float-left relative" style="background: url(images/cover2.jpg) no-repeat center; background-size: cover;">
        <div class="img-overlay darker"></div>
        <div class="img-overlay-multiply darker"></div>
        <div class="p-sm md:py-md text-center relative z-10">
            <h2 class="text-white text-lg md:text-2xl">Let’s get started.</h2>
            <div class="py-6 md:py-md w-full block">
                <a href="#" class="btn-white mb-2 md:mb-0 mr-2">FIND CREW</a>
                <a href="{{ route('signup') }}" class="btn-white-outline">Join as CREW</a>
            </div>
            <p class="text-white md:text-md max-w-md m-auto">After you post your job or profile, our custome engineered matching engine will automatically notify you of the
                best matches, so you can start your project as quickly as possible.</p>
        </div>
    </section>

    <!-- Footer Section
    ******************************************-->
    @include('_parts.footer.footer')

    <!-- Mobile nav Section
    ******************************************-->
    <a href="#" class="btn-nav lg:hidden"><div class="icon"></div></a>
    <nav class="nav-mobile bg-black fixed z-50 text-white w-full h-full top-0 left-0">
        <div class="p-3">
            <div class="w-32 md:w-64 py-1 md:py-0 relative z-10 flex items-center">
                <img src="/images/logos/logo-white-2.svg" alt="crew calls" class="mr-2">
                <span class="text-white pt-6 pb-1 border-b-2 border-white text-md font-bold font-header">{{ config('app.name') }}</span>
            </div>
        </div>
        <div class="py-6 px-3 border-t border-grey-dark">
            <ul>
                <li class="py-2">
                    <a class="block py-1 px-4 font-header tracking-wide block font-bold leading-none uppercase text-sm text-white hover:text-green"
                        href="{{ route('producer.projects') }}">post a project</a>
                </li>
                <li class="py-2">
                    <a class="block py-1 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-white hover:text-green"
                        href="{{ route('projects.current-projects') }}">find a project</a>
                </li>
                <li class="py-2">
                    <a class="block py-1 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-white hover:text-green"
                        href="{{ route('about') }}">about</a>
                </li>
            </ul>
        </div>
        <div class="py-6 px-3 border-t border-grey-dark">
            <ul>
                <li class="py-2">
                    <a class="block py-1 px-4 font-header tracking-wide block font-bold leading-none uppercase text-sm text-white hover:text-green"
                        href="{{ route('login') }}">SIGN in</a>
                </li>
                <li class="py-2">
                    <a class="block py-1 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-white hover:text-green"
                        href="{{ route('signup') }}">sign up</a>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>
