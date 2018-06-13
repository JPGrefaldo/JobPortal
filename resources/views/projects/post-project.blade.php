@include('_parts/header')

<body class="bg-grey-lighter font-body">
    @include('_parts/nav-logged')

    <main class="float-left w-full py-md md:py-lg px-3">
        <div class="container">
            <div class="w-full pb-md md:pb-lg">
                <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold">Post a project</h1>
            </div>

            <div class="w-1/4 float-left pr-8 py-md hidden md:block">
                <h4 class="text-grey mb-4">PROJECT TIPS</h4>
                <p>Complete projects have a better chance of being selected and show up higher in search results. </p>
                <div class="py-lg">
                    <h4 class="text-grey mb-4">HOW IT WORKS VIDEO</h4>
                    <a href="#" class="pb-66 h-none rounded relative block" style="background: url(images/th2.jpg); background-size:cover;">
                        <span class="btn-play w-10 h-10"></span>
                    </a>
                </div>
                <div>
                    <h4 class="text-grey leading-loose">Need help?<br> <a href="#" class="text-green">Contact support</a></h4>
                </div>
            </div>
            <div class="md:w-3/4 float-left">
                <div class="card mb-8">
                    <div class="w-full mb-6">
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Project details</h3>
                    </div>
                    <div class="md:flex py-3">
                        <div class="md:w-1/3 pr-6">
                            <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project title</span>  
                        </div>
                        <div class="md:w-2/3">
                            <input type="text" class="form-control w-full" placeholder="Project title">
                        </div>
                    </div>
                    <div class="md:flex py-3">
                        <div class="md:w-1/3 pr-6">
                            <span class="block md:text-right mt-1 font-header text-blue-dark font-semibold mb-3">Production company namebr <br> <small class="font-normal text-grey">(or your name if individual)</small></span>  
                        </div>
                        <div class="md:w-2/3">
                            <input type="text" class="form-control w-full mb-4" placeholder="Company or individual name">
                            <label class="checkbox-control"><span class="text-grey text-sm">Show production company name publicly</span>
                                <input type="checkbox" checked="checked"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                    <div class="md:flex py-3">
                        <div class="md:w-1/3 pr-6">
                            <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project type</span>  
                        </div>
                        <div class="md:w-2/3">
                            <select name="" id="" class="form-control w-full text-grey-dark">
                                <option value="">Select project type</option>
                                <option value="">Option 1</option>
                                <option value="">Option 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="md:flex py-3">
                        <div class="md:w-1/3 pr-6">
                            <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project information</span>  
                        </div>
                        <div class="md:w-2/3">
                            <textarea class="form-control w-full h-48" placeholder="Project details"></textarea>
                        </div>
                    </div>

                    <div class="w-full pt-8 mt-8 mb-8 block border-t-2 border-grey-lighter">
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Work positions needed</h3>
                    </div>
                    <div class="pb-6">
                        <h4 class="text-grey">Camera</h4>
                    </div>
                    <div class="p-4 border-t-2 border-grey-lighter bg-grey-lighter">
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="w-full pb-4">
                                    <label class="checkbox-control"><h3 class="text-md">Camera operator</h3>
                                        <input type="checkbox" checked="checked"/>
                                        <div class="control-indicator"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3">Persons needed</span>
                            </div>
                            <div class="md:w-2/3">
                                <div class="w-24">
                                    <div class="flex justify-center border border-grey-light rounded">
                                        <button class="w-8 h-10">–</button>
                                        <input type="text" class="bg-light text-center w-8 h-10" value="1">
                                        <button class="w-8 h-10">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Equipment provided</span>
                            </div>
                            <div class="md:w-2/3">
                                <textarea name="" id="" class="w-full form-control h-24" placeholder="Equipment provided by production"></textarea>
                            </div>
                        </div>
                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Equipment needed</span>
                            </div>
                            <div class="md:w-2/3">
                                <textarea name="" id="" class="w-full form-control h-24" placeholder="Equipment needed from operator/crew"></textarea>
                            </div>
                        </div>
                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Pay rate</span>
                            </div>
                            <div class="md:w-2/3">
                                $ <input type="text" class="w-16 text-right form-control" placeholder="00"> 
                                <select name="" id="" class="form-control w-32 text-grey-dark">
                                    <option value="">Per hour</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                            
                                <span class="my-2 block">or</span>

                                    <label class="checkbox-control control-radio mb-2">DOE
                                        <input type="radio" name="radio-group"/><div class="control-indicator"></div>
                                    </label>
                                    <label class="checkbox-control control-radio mb-2">TBD
                                        <input type="radio" name="radio-group"/><div class="control-indicator"></div>
                                    </label>
                                    <label class="checkbox-control control-radio mb-2">Unpaid / Volunteer
                                        <input type="radio" name="radio-group"/><div class="control-indicator"></div>
                                    </label>

                            </div>
                        </div>
                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3">Dates needed</span>
                            </div>
                            <div class="md:w-2/3">
                                <input type="text" class="form-control bg-light w-full" placeholder="Production dates"></a>
                            </div>
                        </div>
                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Production notes</span>
                            </div>
                            <div class="md:w-2/3">
                                <textarea name="" id="" class="w-full form-control h-24" placeholder="Production notes"></textarea>
                            </div>
                        </div>
                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header mt-2 text-blue-dark block md:text-right mb-3">Pay travel expensenses?</span>
                            </div>
                            <div class="md:w-2/3 flex items-center">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="form-slider"></span>
                                </label> <span class="ml-2 text-grey">Travel expensenses for out-of-area crew</span>
                            </div>
                        </div>
                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3">Rush call?</span>
                            </div>
                            <div class="md:w-2/3 flex items-center">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="form-slider"></span>
                                </label><span class="ml-2 text-grey">Interviews or work needed in the next 2-3 days</span>
                            </div>
                        </div>

                        <div class="py-6">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-1 block md:text-right mb-3">General resume</span>
                                </div>
                                <div class="md:w-2/3">
                                    <a href="#" class="btn-outline inline-block">Upload file</a>
                                </div>
                            </div>
                        </div>
                        <div class="py-6">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark block md:text-right mb-3">Post add on these websites:</span>
                                </div>
                                <div class="md:w-2/3 text-blue-dark">
                                    <label class="checkbox-control mb-6">Check all
                                        <input type="checkbox"/><div class="control-indicator"></div>
                                    </label>
                                    <label class="checkbox-control mb-2">Camera Visual Effects
                                        <input type="checkbox"/><div class="control-indicator"></div>
                                    </label>
                                    <label class="checkbox-control mb-2">Camera Visual Effects
                                        <input type="checkbox"/><div class="control-indicator"></div>
                                    </label>
                                    <label class="checkbox-control">Camera Visual Effects
                                        <input type="checkbox"/><div class="control-indicator"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="border-t-2 border-grey-lighter py-6">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right">Gear</span>
                                </div>
                                <div class="md:w-2/3">
                                    <div class="pb-4">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="form-slider"></span>
                                        </label>
                                    </div>
                                    <label for="" class="block mb-3">What gear do you have for this position?</label>
                                    <textarea class="form-control w-full h-32" placeholder="Your gear"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <div class="flex">
                                <label class="checkbox-control"><h3 class="text-md">Camera Visual Effects</h3>
                                    <input type="checkbox"/><div class="control-indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <div class="flex">
                                <label class="checkbox-control"><h3 class="text-md">Camera Visual Effects</h3>
                                    <input type="checkbox"/><div class="control-indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="py-4"><h4 class="text-grey">Production</h4></div>
                    <div class="p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <div class="flex">
                                <label class="checkbox-control"><h3 class="text-md">Camera Visual Effects</h3>
                                    <input type="checkbox"/><div class="control-indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <div class="flex">
                                <label class="checkbox-control"><h3 class="text-md">Camera Visual Effects</h3>
                                    <input type="checkbox"/><div class="control-indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                        <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                        <a href="#" class="btn-green">SAVE CHANGES</a>
                    </div>

                </div>

            </div>
        </div>
    </main>

    @include('_parts/footer')