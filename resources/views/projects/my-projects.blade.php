@include('_parts.header.header')

<body class="bg-grey-lighter font-body">
    @include('_parts.navbar.navbar-logged-in')

    <main class="float-left w-full py-lg">
        <div class="container">
            <div class="w-full pb-8 border-b-2 mb-8 border-grey-light flex justify-between items-center">
                <h1 class="font-header text-blue-dark text-2xl font-semibold">My projects</h1>
                <a href="#" class="btn-outline py-3 rounded-full">Add new project</a>
            </div>

            <aside class="w-1/4 float-left pr-4">
                <ul class="list-reset font-header text-left py-6">
                    <li class="block py-4">
                        <a href="#" class="border-b-2 border-red text-blue-dark font-semibold py-2 hover:text-green">All projects <div class="badge bg-white ml-2">12</div></a>
                    </li>
                    <li class="block py-4">
                        <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Active projects<div class="badge bg-white ml-2">12</div></a>
                    </li>
                    <li class="block py-4">
                        <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Inactive projects<div class="badge bg-white ml-2">12</div></a>
                    </li>
                    <li class="block py-4">
                        <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Pending projects<div class="badge bg-white ml-2">12</div></a>
                    </li>
                </ul>
                <div class="py-6 pr-8">
                    <h4 class="text-grey mb-4">HOW IT WORKS VIDEO</h4>
                    <a href="#" class="pb-66 h-none rounded relative block" style="background: url(images/th2.jpg); background-size:cover;">
                        <span class="btn-play w-10 h-10"></span>
                    </a>
                </div>
                <div class="">
                    <h4 class="text-grey leading-loose">Need help?<br> <a href="#" class="text-green">Contact support</a></h4>
                </div>
            </aside>

            <div class="w-3/4 float-left">
                <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
                    <div class="p-8">
                        <div class="w-full mb-6 flex justify-between">
                            <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Audio commercial <span class="badge">24 submissions</span></h3>
                            <a href="#" class="btn-more"></a>
                        </div>
                        <div class="flex">
                            <div class="w-1/4">
                                <h3 class="text-grey">Project details</h3>
                            </div>
                            <div class="w-3/4">
                                <p>Looking for an experienced gaffer who is easy going and able to roll with the punches to work alongside a great crew... <a href="#" class="text-sm">MORE</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-grey-lighter pb-8 px-8 border-t border-grey-light rounded-b">
                        <div class="flex justify-between items-center pt-4">
                            <div>
                                <a href="#" class="h4">2 ROLES <span class="btn-toggle inline-block ml-1"></span></a>
                                <span class="badge bg-white ml-2">0 active</span>
                                <span class="badge bg-white">2 paused</span>
                            </div>
                            <a href="#" class="btn-outline">add role</a>
                        </div>
                        <div class="bg-white mt-4 rounded p-8 shadow">
                            <div class="flex justify-between items-center">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header">Gaffer <span class="badge">1 needed</span></h3>
                                <div>
                                    <span class="h4 mr-2 text-yellow inline-block text-xs"><i class="fas fa-pause mr-1"></i>paused</span>
                                    <a href="#" class="btn-more inline-block"></a>
                                </div>
                            </div>
                            <div class="bg-grey-lighter rounded p-6 flex mt-4">
                                <div class="w-1/2 px-2">
                                    <div class="block text-sm text-blue-dark py-1"><strong>PAY:</strong> $80/hour</div>
                                    <div class="block text-sm text-blue-dark py-1"><strong>UNION</strong> (but accepting non-union submissions)</div>
                                    <div class="block text-sm text-blue-dark py-1"><strong>EQUIPMENT:</strong> provided by production</div>
                                </div>
                                <div class="w-1/2 px-2">
                                    <div class="block text-sm text-blue-dark py-1"><strong>PRODUCTION TITLE:</strong>  Comfort Nation</div>
                                    <div class="block text-sm text-blue-dark py-1"><strong>PRODUCTION COMPANY: </strong> Artisan Studios</div>
                                    <div class="block text-sm text-blue-dark py-1"><strong>LOCATION: </strong> New York</div>
                                </div>
                            </div>
                            <div class="flex mt-6">
                                <div class="w-1/4">
                                    <h4 class="text-grey mt-1">Project details</h4>
                                </div>
                                <div class="w-3/4">
                                    <p>Looking for an experienced gaffer who is easy going and able to roll with the punches to work alongside a great crew... <a href="#" class="text-sm">MORE</a></p>
                                </div>
                            </div>
                            <div class="flex pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
                                <a href="#" class="h4 mr-6"><i class="fas fa-search mr-2"></i>Search staff for this position</a>
                                <a href="#" class="btn-outline bg-green text-white">View submissions <span class="badge badge-white">26</span></a>
                            </div>
                        </div>
                        <div class="bg-white mt-4 rounded p-8 shadow">
                            <div class="flex justify-between items-center">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header">Gaffer <span class="badge">1 needed</span></h3>
                                <div>
                                    <span class="h4 mr-2 text-yellow inline-block text-xs"><i class="fas fa-pause mr-1"></i>paused</span>
                                    <a href="#" class="btn-more inline-block"></a>
                                </div>
                            </div>
                            <div class="bg-grey-lighter rounded p-6 flex mt-4">
                                <div class="w-1/2 px-2">
                                    <div class="block text-sm text-blue-dark py-1"><strong>PAY:</strong> $80/hour</div>
                                    <div class="block text-sm text-blue-dark py-1"><strong>UNION</strong> (but accepting non-union submissions)</div>
                                    <div class="block text-sm text-blue-dark py-1"><strong>EQUIPMENT:</strong> provided by production</div>
                                </div>
                                <div class="w-1/2 px-2">
                                    <div class="block text-sm text-blue-dark py-1"><strong>PRODUCTION TITLE:</strong>  Comfort Nation</div>
                                    <div class="block text-sm text-blue-dark py-1"><strong>PRODUCTION COMPANY: </strong> Artisan Studios</div>
                                    <div class="block text-sm text-blue-dark py-1"><strong>LOCATION: </strong> New York</div>
                                </div>
                            </div>
                            <div class="flex mt-6">
                                <div class="w-1/4">
                                    <h4 class="text-grey mt-1">Project details</h4>
                                </div>
                                <div class="w-3/4">
                                    <p>Looking for an experienced gaffer who is easy going and able to roll with the punches to work alongside a great crew... <a href="#" class="text-sm">MORE</a></p>
                                </div>
                            </div>
                            <div class="flex pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
                                <a href="#" class="h4 mr-6"><i class="fas fa-search mr-2"></i>Search staff for this position</a>
                                <a href="#" class="btn-outline bg-green text-white">View submissions <span class="badge badge-white">26</span></a>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
                    <div class="p-8">
                        <div class="w-full mb-6 flex justify-between">
                            <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Audio commercial <span class="badge">24 submissions</span></h3>
                            <a href="#" class="btn-more"></a>
                        </div>
                        <div class="flex">
                            <div class="w-1/4">
                                <h3 class="text-grey">Project details</h3>
                            </div>
                            <div class="w-3/4">
                                <p>Looking for an experienced gaffer who is easy going and able to roll with the punches to work alongside a great crew... <a href="#" class="text-sm">MORE</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-grey-lighter pb-4 px-8 border-t border-grey-light rounded-b">
                        <div class="flex justify-between items-center pt-4">
                            <div>
                                <a href="#" class="h4">2 ROLES <span class="btn-toggle inline-block ml-1"></span></a>
                                <span class="badge bg-white ml-2">0 active</span>
                                <span class="badge bg-white">2 paused</span>
                            </div>
                            <a href="#" class="btn-outline">add role</a>
                        </div>


                    </div>



                </div>

            </div>
        </div>
    </main>

    @include('_parts.footer.footer')
