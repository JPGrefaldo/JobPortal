<?php include '_parts/header.php' ?>

<body class="bg-grey-lighter font-body">
    <?php include '_parts/nav.php' ?>
   
    <main class="float-left w-full py-lg">
        <div class="container max-w-xl">
            <div class="w-full md:w-1/2 float-left mb-3 md:mb-0 px-4">
                <div class="bg-white shadow-md rounded">
                    <div class="p-8">
                        <h2 class="font-header text-blue-dark text-lg text-center font-semibold">Sign in</h2>
                        <div class="py-2 text-center">
                            <p class="leading-normal text-blue-dark">Sign in to view project/role details and edit your profile.</p>
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Email</label>
                            <input class="w-full form-control" type="text" placeholder="User name or email">
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Password
                                <a href="#" class="underline text-grey text-sm float-right font-normal">Forgot your password?</a>
                            </label>
                            <input class="w-full form-control" type="password" placeholder="Password">
                        </div>
                        <div class="py-2">
                            <label class="md:w-2/3 block">
                                <input class="mr-1" type="checkbox"> Remember me
                            </label>
                        </div>
                        <div class="pt-6">
                            <a href="#" class="block font-header uppercase text-sm p-4 text-center text-white bg-blue font-bold rounded-full hover:bg-green">sign in</a>
                        </div>
                    </div>
                    <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                        Not a member yet?
                        <a href="#" class="text-red underline hover:text-green">Sign up now</a>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 float-left px-4">
                <div class="bg-white shadow-md rounded">
                    <div class="p-8 text-center border-b border-grey-light">
                        <h2 class="font-header text-blue-dark text-lg text-center font-semibold">Sign up</h2>
                    </div>
                    <div class="p-8">
                        <div class="pb-2 text-center">
                            <h4 class="uppercase text-sm">I WANT TO:</h4>
                        </div>
                        <div class="bg-white md:shadow md:border border-grey-light md:rounded-full overflow-hidden md:flex text-center items-stretch">
                            <a class="block text-center md:w-1/2 p-3 mb-2 md:mb-0 border rounded-full md:rounded-none border-grey-light text-blue-dark md:border-t-0 md:border-b-0 md:border-r hover:bg-green hover:text-white" href="#">Hire for a Project</a>
                            <a class="block border md:border-none border-grey-light md:border-none text-center text-blue-dark rounded-full md:rounded-none md:w-1/2 p-3 hover:bg-green hover:text-white" href="#">Work as Crew</a>
                        </div>
                        <div class="p-2 text-center text-sm text-grey">You can choose both</div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Full name</label>
                            <div class="flex">
                                <div class="w-1/2 md:pr-1">
                                    <input class="w-full form-control" type="text" placeholder="First name">
                                </div>
                                <div class="w-1/2 md:pl-1">
                                    <input class="w-full form-control" type="text" placeholder="Last name">
                                </div>
                            </div>

                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Email</label>
                            <input class="w-full form-control" type="text" placeholder="User name or email">
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Password
                                <span class="underline text-grey text-sm float-right font-normal">At least 8 characters</span>
                            </label>
                            <input class="w-full form-control" type="password" placeholder="Password">
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Phone
                                
                            </label>
                            <input class="w-full form-control" type="password" placeholder="083 0003 9898">
                        </div>
                        <div class="py-2">
                            <label class="block">
                                <input class="mr-1" type="checkbox"> Receive text alerts <a href="#" class="float-right rounded-full bg-grey-light text-grey bold text-sm py-0 px-1">?</a>
                            </label>
                        </div>
                        <div class="pt-6">
                            <a href="#" class="block font-header uppercase text-sm p-4 text-center text-white bg-blue font-bold rounded-full hover:bg-green">sign in</a>
                        </div>
                        <div class="py-4">
                            <p class="text-sm text-center">By joining, you agree with our <a href="#" class="text-red underline hover:text-green">Terms and Conditions</a></p>
                        </div>
                    </div>
                    <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                        Already a member?
                        <a href="#" class="text-red underline hover:text-green">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include '_parts/footer.php' ?>