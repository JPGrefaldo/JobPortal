
@include('_parts/header')

<body class="bg-grey-lighter font-body">
    @include('_parts/nav-logged')

    <main class="float-left w-full px-3 py-md md:py-lg">
        <div class="container">

          <div class="w-full pb-md md:pb-lg">
                <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold">Add Position</h1>

            @include('_parts/messages')
            </div>

            <div class="hidden md:block md:w-1/4 float-left pr-8 py-md">
                <h4 class="text-sm uppercase text-grey tracking-wide mb-4">COMPLETE YOUR ACCOUNT</h4>
                <p>Complete profiles have a better chance of being selected and show up higher in search results. </p>
                <div class="text-center pt-8 pb-4">
                    <img src="/images/donut.svg" alt="" />
                </div>
                <ul class="list-reset list-check">
                    <li class="is-checked">BIO</li>
                    <li class="is-checked">SOCIAL MEDIA PROFILES</li>
                    <li class="is-checked">GENERAL WORK RESUME</li>
                    <li class="is-checked">GENERAL WORK REEL</li>
                    <li>WORK POSITIONS</li>
                </ul>
            </div>
            <div class="md:w-3/4 float-left">
                <div class="card mb-8">
                    <div class="w-full mb-6">
                        <h3 class="text-blue-dark font-semibold text-md md:text-lg mb-1 font-header">{{ $user->first_name }} {{ $user->last_name }}</h3>
                    </div>

                    <!-- form start -->
                     {{ Form::open(array('route' => 'profile-add-post', 'files' => true)) }}
    
                    
                    <div class="md:flex">
                        
                    
                        <div class="md:w-2/3">
                            <div class="p-3 md:p-6 bg-grey-lighter rounded">
                                <div class="mb-6">
                                    {{ Form::label('title', 'Job Title:', array('class' => 'block mb-3') )}}
                                    {{ Form::select('title', array('1st Assistant Director' => '1st Assistant Director', 'Camera Operator' => 'Camera Operator'),array('class' => 'form-control w-full') )}}

                                </div>
                                <div class="mb-2">
                                    {{ Form::label('bio', 'Biography:', array('class' => 'block mb-3') )}}
                                    
                                    {{ Form::textarea('bio', $biography->bio, array('class' => 'form-control w-full h-32') )}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-t-2 border-grey-lighter mt-6 py-4">
                        <div class="md:flex">
                            <div class="md:w-1/3 pr-8">
                                <h3 class="text-md font-header mb-2 md:mb-0">General resume</h3>
                            </div>
                            <div class="md:w-2/3">
                            
                                {{ form::file('resume_file', array('class' => 'btn-outline inline-block', 'value' => 'Upload file'))}}
                               
                            </div>
                        </div>
                    </div>
                    <div class="border-t-2 border-grey-lighter py-4">
                        <div class="md:flex">
                            <div class="md:w-1/3 pr-8">
                                <h3 class="text-md font-header mt-2 mb-2 md:mb-0">General reel</h3>
                            </div>
                            <div class="md:w-2/3">
                                <input type="text" class="form-control bg-light w-64 mr-2 mb-2 md:mb-0" placeholder="Add link"><div> or <br> 
                                {{ form::file('reel_file', array('class' => 'btn-outline inline-block', 'value' => 'Upload file')) }}
                                                               </div>

                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-grey-lighter">
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-6 mb-3 md:mb-1">
                                    <label class="checkbox-control"><h3 class="text-md">Camera operator</h3>
                                        <input type="checkbox" checked="checked"/>
                                        <div class="control-indicator"></div>
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <textarea class="form-control w-full h-32" placeholder="Biography"></textarea>
                                </div>
                            </div>
                        </div>
  
                        <div class="py-2">
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

                    <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <label class="checkbox-control"><h3 class="text-md">Camera Visual Effects</h3>
                                <input type="checkbox"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                    <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <label class="checkbox-control"><h3 class="text-md">Camera Visual Effects</h3>
                                <input type="checkbox"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                        <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                        {{form::submit('SAVE CHANGES', array('class' => 'btn-green')) }}
                    </div>
                </div>
                    {{ Form::close() }} 

                

                <div class="card mb-6">
                    <div class="pb-6">
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Camera</h3>
                    </div>
                    
                    <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                        <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                        <a href="#" class="btn-green">SAVE CHANGES</a>
                    </div>

                </div>
                <div class="card mb-6">
                    <div class="md:flex justify-between">
                        <h3 class="text-blue-dark font-semibold text-lg font-header mb-2 md:mb-0">Sound</h3>
                        <a href="#" class="btn-green-outline">ADD POSITION</a>
                    </div>
                </div>
            </div>
        </div>
    </main>