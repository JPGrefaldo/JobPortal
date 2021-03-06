<nav class="relative z-20 bg-white float-left w-full px-3 md:px-6 border-b border-grey-light flex justify-between items-center">
    <div class="w-32 md:w-64 py-2 md:py-0 relative z-10">

        <a href="/" class="flex items-center">
            <img src="/images/logos/logo-short.svg" alt="crew calls" class="mr-2" />
            <span class="text-blue-dark pt-6 pb-1 border-b-2 border-blue-dark text-sm font-bold font-header"/>{{ config('app.name') }}</span>
        </a>
    </div>
    <ul class="hidden lg:flex items-center">
        <li class="{{ Route::is('producer.projects.create') ? 'border-b-2 border-red border-solid' : '' }}">
            <a class="block py-6 px-4 font-header tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green"
                href="{{ route('producer.projects.create') }}">post a project</a>
        </li>
        <li class="{{ Route::is('findProject') ? 'border-b-2 border-red border-solid' : '' }}">
            <a class="block py-6 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-blue-dark hover:text-green"
                href="{{route('projects.current-projects')}}">find a project</a>
        </li>
        <li class="{{ Route::is('about') ? 'border-b-2 border-red border-solid' : '' }}">
            <a class="block py-6 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-blue-dark hover:text-green"
                href="{{ route('about') }}">about</a>
        </li>
    </ul>
    <div class="hidden lg:block w-64">
        <ul class="flex items-center">
            <li>
                <a class="block py-4 px-8 font-header font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="{{ route('login') }}">SIGN IN</a>
            </li>
            <li>
                <a class="block py-4 px-8 font-header font-bold leading-none border border-blue-dark rounded-full uppercase text-sm text-blue-dark hover:border-green hover:text-green"
                    href="{{ route('signup') }}">SIGN UP</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Mobile nav Section
    ******************************************-->
    <a href="#" class="btn-nav lg:hidden"><div class="icon"></div></a>
    <nav class="nav-mobile bg-black fixed z-50 text-white w-full h-full top-0 left-0">
        <div class="p-3">
            <img src="/images/logos/logo-long-white.svg" class="w-32" alt="crew calls" />
        </div>
        <div class="py-6 px-3 border-t border-grey-dark">
            <ul>
                <li class="py-2">
                    <a class="block py-1 px-4 font-header tracking-wide block font-bold leading-none uppercase text-sm text-white hover:text-green"
                        href="{{ route('producer.projects.create') }}">post a project</a>
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
