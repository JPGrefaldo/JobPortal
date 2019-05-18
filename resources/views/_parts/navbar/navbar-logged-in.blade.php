<nav class="bg-white float-left w-full px-3 md:px-6 shadow flex justify-between items-center font-header">
    <div class="w-32 md:w-64 py-1 md:py-0 relative z-10">
        <a href="/" class="flex items-center">
            <img src="/images/logos/logo-short.svg" alt="crew calls" class="mr-2"/>
            <span class="text-blue-dark pt-6 pb-1 border-b-2 border-blue-dark text-sm font-bold font-header"/>{{ config('app.name') }}</span>
        </a>
    </div>
    <ul class="hidden md:flex items-center">
        <li class="{{ Route::is('producer.projects') ? 'border-b-2 border-red border-solid' : '' }}">
            <a class="block py-6 px-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green"
               href="/producer/projects">my projects</a>
        </li>
        <li class="{{ Route::is('findProject') ? 'border-b-2 border-red border-solid' : '' }}">
            <a class="block py-6 px-4 tracking-wide font-bold leading-none uppercase text-sm text-blue-dark hover:text-green"
               href="{{route('projects.current-projects')}}">find projects</a>
        </li>
        <li class="{{ Route::is('messages') ? 'border-b-2 border-red border-solid' : '' }}">
            <a href="{{ route('messages') }}"
                class="block py-6 px-4 tracking-wide font-bold leading-none relative uppercase text-sm text-blue-dark hover:text-green">
                messages
                @if ($unreadCount > 0)
                    <span class="h-1 w-1 bg-red absolute rounded"></span>
                @endif
            </a>
        </li>
    </ul>
    <div class="w-64 hidden md:flex items-center text-right justify-end">
        <div class="mr-3 has-dropdown">
            <div class="py-1 px-2 rounded-lg hover:bg-grey-lighter block">
                <img src="/images/bell.svg" alt="bell"/>
                <span class="h-1 w-1 bg-red absolute rounded"></span>
            </div>
            <div class="dropdown shadow-md bg-white absolute py-3 font-body">
                <ul class="text-left">
                    <li class="py-2 px-4">
                        <a href="/my-profile/{{ Auth::user()->id }}" class="block text-blue-dark hover:text-green">View
                            profile</a>
                    </li>
                    <li class="py-2 px-4">
                        <a href="#" class="block text-blue-dark hover:text-green">Subscription</a>
                    </li>
                    <li class="py-2 px-4">
                        <a href="/my-account" class="block text-blue-dark hover:text-green">Settings</a>
                    </li>

                    <li class="py-2 px-4 border-t mt-2 border-grey-light">
                        <cca-logout-link csrf="{{ csrf_token() }}"
                                         classes="block text-blue-dark hover:text-green">
                            {{ __('Sign Out') }}
                        </cca-logout-link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mr-4 items-center cursor-pointer block relative ">
            <div class="has-dropdown">
                <div class="relative flex justify-center items-center p-1 rounded-lg hover:bg-grey-lighter">
                    <span class="mr-2 inline-block font-semibold text-blue-dark text-sm">{{ Auth::user()->first_name }}</span>

                        <span class="w-10 h-10 bg-cover rounded-full inline-block"
                              style="background-image: url('{{ Auth::user()->avatar }}')"></span>

                </div>
                <div class="dropdown shadow-md bg-white absolute py-3 font-body">
                    <ul class="text-left">
                        @if(! Route::is('crew.profile.index'))
                            <li class="py-2 px-4">
                                <a href="{{ route('crew.profile.index') }}" class="block text-blue-dark hover:text-green">View
                                    profile</a>
                            </li>
                        @endif
                        @if(! Route::is('crew.profile.edit'))
                            <li class="py-2 px-4">
                                <a href="{{ route('crew.profile.edit') }}" class="block text-blue-dark hover:text-green">Edit
                                    profile</a>
                            </li>
                        @endif
                        <li class="py-2 px-4">
                            <a href="#" class="block text-blue-dark hover:text-green">Subscription</a>
                        </li>
                        <li class="py-2 px-4">
                            <a href="{{ route('account.name') }}" class="block text-blue-dark hover:text-green">Account Settings</a>
                        </li>
                        <li class="py-2 px-4 border-t mt-2 border-grey-light">
                            <cca-logout-link csrf="{{ csrf_token() }}"
                                             classes="block text-blue-dark hover:text-green">
                                {{ __('Sign Out') }}
                            </cca-logout-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile nav Section
    ******************************************-->
<a href="#" class="btn-nav md:hidden">
    <div class="icon"></div>
</a>
<nav class="nav-mobile bg-black fixed z-50 text-white w-full h-full top-0 left-0">
    <div class="p-3">
        <img src="/images/logos/logo-long-white.svg" class="w-32" alt="crew calls"/>
    </div>
    <div class="py-6 px-3 border-t border-grey-dark">
        <div class="relative flex items-center p-1 rounded-lg">

            <span class="ml-3 w-10 h-10 bg-cover rounded-full inline-block @if(! isset(Auth::user()->crew) || ! Auth::user()->crew->photo) background-missing-avatar " @else "
                  style="background-image: url(images/thumb.jpg)"
                @endif
            ></span>
            <span class="ml-2 inline-block font-semibold text-white text-sm">{{ auth()->user()->name }}</span>
        </div>
        <ul class="text-left text-sm">
            @if(! Route::is('crew.profile.index'))
                <li class="py-1 px-4">
                    <a href="{{ route('crew.profile.index') }}" class="block text-white">View profile</a>
                </li>
            @endif
            @if(! Route::is('crew.profile.edit'))
                <li class="py-1 px-4">
                    <a href="{{ route('crew.profile.edit') }}" class="block text-white">Edit profile</a>
                </li>
            @endif
            <li class="py-1 px-4">
                <a href="#" class="block text-white">Subscription</a>
            </li>
            <li class="py-1 px-4">
                <a href="{{ route('account.name') }}" class="block text-white">Account Settings</a>
            </li>
            <li class="py-1 px-4">
                <a href="#" class="block text-white">Sign out</a>
            </li>
        </ul>
    </div>
    <div class="py-6 px-3 border-t border-grey-dark">
        <ul>
            <li class="py-2">
                <a class="block py-1 px-4 font-header tracking-wide block font-bold leading-none uppercase text-sm text-white hover:text-green"
                   href="#">my projects</a>
            </li>
            <li class="py-2">
                <a class="block py-1 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-white hover:text-green"
                   href="#">find projects</a>
            </li>
            <li class="py-2">
                <a class="block py-1 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-white hover:text-green"
                   href="#">messages</a>
            </li>
            <li class="py-2">
                <a class="block py-1 px-4 font-header tracking-wide font-bold leading-none uppercase text-sm text-white hover:text-green"
                   href="#">alerts</a>
            </li>
        </ul>
    </div>
    <div class="py-6 px-3 border-t border-grey-dark">
        <ul>
            <li class="py-2">
                <a class="block py-1 px-4 font-header tracking-wide block font-bold leading-none uppercase text-sm text-white hover:text-green"
                   href="#">Questions? <span class="text-green">Contact us</span>.</a>
            </li>
        </ul>
    </div>
</nav>
