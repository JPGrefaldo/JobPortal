@include('_parts/header')

<body class="bg-grey-lighter">
    @include('_parts/nav-logged')

    <main class="float-left w-full px-3 py-md md:py-lg">
        <div class="container">
            <div class="w-full pb-6 md:pb-lg">
                <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold">Account settings</h1>
            </div>

            <div class="w-full md:w-1/4 float-left md:mb-3">
                <div class="has-menu relative md:hidden">
                    <div class="flex justify-between justify-center items-center rounded-lg w-full float-left mb-4 py-3 px-3 border border-grey-light bg-white cursor-pointer text-sm">Add manager <span class="btn-toggle float-right"></span></div>
                    <div class="menu w-full shadow-md bg-white absolute py-3 font-body border text-sm border-grey-light">
                        <ul class="list-reset text-left">
                            <li class="py-2 px-4">
                                <a href="#" class="block text-blue-dark hover:text-green">View profile</a>
                            </li>
                            <li class="py-2 px-4">
                                <a href="#" class="block text-blue-dark hover:text-green" >Subscription</a>
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
            <div class="w-full md:w-3/4 float-left">
                <div class="bg-white shadow-md rounded">
                    <div class="py-4 px-6 md:py-8 md:px-md">
                        <h3 class="font-header text-blue-dark text-lg font-semibold mb-6">Add manager</h3>
                        <p class="leading-normal">He changed professions once again, moving to vice president of production for Disney and Touchstone,
                            and was involved in the smash hit "Pretty Woman." He now serves as an executive producer, working
                            on Disney/Touchstone films like "Holy Man, " "Ten Things I Hate About You, " "and "First Kid."</p>
                        <div>
                            <h4 class="mt-8 uppercase text-sm text-blue-dark">Attach a manager to your account</h4>
                            <span class="text-sm text-grey block my-2">This person will have complete control over your account.
                                <a href="#" class="ml-2 rounded-full bg-grey-lighter text-grey bold text-sm py-0 px-2">?</a>
                            </span>
                            <input class="w-full border border-light-grey max-w-sm p-4 my-4" type="text" placeholder="User name or email">
                        </div>
                    </div>
                    <div class="p-8 text-right bg-grey-lighter border-top border-grey-light">
                        <a href="#" class="text-grey font-bold mr-4 font-header hover:text-green">Cancel</a>
                        <a href="#" class="btn-green">SAVE CHANGES</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>
    @include('_parts/footer')