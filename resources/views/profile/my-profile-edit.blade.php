
@include('_parts.header.header')


<body class="bg-grey-lighter font-body">
    @include('_parts.navbar.navbar-logged-in')

    <main class="float-left w-full px-3 py-md md:py-lg">
        <div class="container">

        @if ($errors->any())
                    <div class="bootstrap-iso">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                     </div>
         @endif

          <div class="w-full pb-md md:pb-lg">
                <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold">Edit profile</h1>

            @include('_parts/messages')
            </div>

            <div class="hidden md:block md:w-1/4 float-left pr-8 py-md">
                <h4 class="text-sm uppercase text-grey tracking-wide mb-4">COMPLETE YOUR ACCOUNT</h4>
                <p>Complete profiles have a better chance of being selected and show up higher in search results. </p>
                <div class="text-center pt-8 pb-4">
                    <img src="/images/donut.svg" alt="" />
                </div>
                <ul class="list-reset list-check">
                
                @if (($biography->bio) == '') 
                    <li>BIO</li>
                     @else 
                    <li class="is-checked">BIO</li>
                @endif
                
                @if (!isset($linkedin->url) && !isset($imdb->url) && !isset($fb->url)) 
                    <li>SOCIAL MEDIA PROFILES</li>
                    @else 
                    <li class="is-checked">SOCIAL MEDIA PROFILES</li>
                @endif

                @if (!isset($resume->url))
                    <li>GENERAL WORK RESUME</li>
                    @else 
                    <li class="is-checked">GENERAL WORK RESUME</li>
                @endif
                

                @if (!isset($reel) || isset($reel->url))    
                    <li>GENERAL WORK REEL</li>
                    @else
                    <li class="is-checked">GENERAL WORK REEL</li>
                @endif    

                @if (count($position) < 1)
                    <li>WORK POSITIONS</li>
                    @else 
                    <li class="is-checked">WORK POSITIONS</li>
                @endif

                </ul>
            </div>
            <div class="md:w-3/4 float-left">
                <div class="card mb-8">
                    <div class="w-full mb-6">
                        <h3 class="text-blue-dark font-semibold text-md md:text-lg mb-1 font-header">
                            {{ $user->first_name }} {{ $user->last_name }}</h3>
                    </div>

                     {{ Form::open(array('route' => 'profile-update', 'files' => true)) }}
                      
                    <div class="md:flex">
                        <div class="md:w-1/3 md:pr-6 mb-6">
                            <div class="flex h-none bg-grey-light items-center justify-center cursor-pointer text-center border border-grey-light w-full pb-full rounded relative" style="background: url(/{{ $biography->photo }}); background-size: cover;">
                                <span class="text-center uppercase text-sm font-semibold text-white px-2 pos-center w-full">
                                UPLOAD PROFILE PHOTO
                                {{ form::file('profile_image', array('class' => 'profile_image'))}}
                                </span>
                            </div>
                        </div>
                    
                        <div class="md:w-2/3">
                            <div class="p-3 md:p-6 bg-grey-lighter rounded">
                                <div class="mb-6">

                                    {{ Form::label('title', 'Job Title:', array('class' => 'block mb-3') )}}
                                    @if(isset($jobTitle->name))
                                    {{ Form::text('title', $jobTitle->name, array('class' => 'form-control w-full') )}}
                                    @else
                                    {{ Form::text('title',"",array('class' => 'form-control w-full') )}}
                                    @endif

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
                                  @if (isset($resume->url))

                                 <div class="bootstrap-iso">
                                      <span class="badge badge-primary">
                                        <h5>{{ $resume->url }}</h5>
                                    </span>                                        

                                      <a href='{{ url("my-profile/$resume->id/delete") }}' class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?')"><i class="fa fa-times" aria-hidden="true" ></i></a>                           
                                      
                                </div>
                                @else

                                {{ form::file('resume_file', array('class' => 'btn-outline inline-block', 'value' => 'Upload file'))}}
                               
                                @endif      
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
                                @if (isset($reel))
                                <div class="bootstrap-iso">
                                      <span class="badge badge-secondary"> {{ $reel->url }}</span>
                                </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-t-2 border-grey-lighter py-4">
                        <div class="md:flex">
                            <div class="md:w-1/3 pr-8">
                                <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Social profiles</h3>
                            </div>
                            <div class="md:w-2/3">
                                <div class="flex flex-wrap items-stretch w-full mb-2 relative">
                                    <div class="flex -mr-px">
                                        <span class="flex w-10 items-center leading-normal bg-yellow-imdb rounded rounded-r-none px-2 whitespace-no-wrap text-grey-dark"><img src="/images/imdb.svg" alt=""  /></span>
                                    </div>	
                                    
                                @if (isset($imdb->url))
                                    {{ Form::text('imdb_link', $imdb->url, array('class' => 'form-control flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative', 'placeholder' => 'add IMdb Link') )}}
                                @else
                                    {{ Form::text('imdb_link',"", array('class' => 'form-control flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative', 'placeholder' => 'add IMdb Link') )}}
                                @endif

                                </div>		
                                <div class="flex flex-wrap items-stretch w-full mb-2 relative">
                                    <div class="flex -mr-px">
                                        <span class="flex w-10 items-center leading-normal bg-blue-linkedin rounded rounded-r-none px-2 whitespace-no-wrap text-grey-dark"><i class="fab fa-linkedin-in text-lg mr-0 text-white"></i></span>
                                    </div>	
                                
                                @if ( isset($linkedin->url))    
                                    {{ Form::text('linkedin_link', $linkedin->url, array('class' => 'form-control flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative', 'placeholder' => 'add Linkedin Link') )}}
                                @else
                                {{ Form::text('linkedin_link', "", array('class' => 'form-control flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative', 'placeholder' => 'add Linkedin Link') )}}
                                @endif                              
                                </div>	

                                <div class="flex flex-wrap items-stretch w-full mb-2 relative">
                                    <div class="flex -mr-px">
                                        <span class="flex w-10 text-center items-center leading-normal bg-blue-facebook rounded rounded-r-none px-2 whitespace-no-wrap text-grey-dark"><i class="fab fa-facebook-f text-lg mr-0 text-white inline-block"></i></span>
                                    </div>

                                @if ( isset($fb->url))
                                    {{ Form::text('fb_link', $fb->url, array('class' => 'form-control flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative', 'placeholder' => 'add Facebook Link') )}}
                                @else
                                    {{ Form::text('fb_link', "", array('class' => 'form-control flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative', 'placeholder' => 'add Facebook Link') )}}
                                @endif

                                </div>		
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                        <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                        {{form::submit('SAVE CHANGES', array('class' => 'btn-green')) }}
                    </div>
                </div>
                    {{ Form::close() }} <!-- end form -->

                <div class="py-4">
                    <h4 class='text-grey'>WORK POSITIONS</h4>
                </div>

                
                <div class="card mb-6" id="addPostProduction">
                        <h3 class="text-blue-dark font-semibold text-lg font-header mb-3 md:mb-0">Production</h3>

                 <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter"></div>

                    {{ Form::open(array('route' => ['production-add-position', Auth::user()->id],'files' => true)) }}

                        
                    <div class="p-4 bg-grey-lighter rounded">
                                <div class="mb-6">
                                {{ Form::label('department', 'Choose Departments:', array('class' => 'block mb-3') )}}
                                </div>
                            <div class="md:flex">
                                @foreach ($departments as $department)
                                <div class="md:w-2/3 mb-6">
                                    <label class="checkbox-control"><h3 class="text-sm">{{ $department->name }}</h3>
                                        {!! Form::checkbox('title[]', $department->name, false) !!}
                                        <div class="control-indicator"></div>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <div class="mb-6">
                                {{ Form::label('title', 'Choose Title:', array('class' => 'block mb-3') )}}
                                <select class="form-control" name="item_id">
                                    @foreach($allpositions as $allposition)
                                        <option value="{{$allposition->name}}">{{$allposition->name}}</option>
                                    @endforeach
                            </div>
                            
                                
                            <div class="mb-6">
                                {{ Form::label('title', 'Choose Title:', array('class' => 'block mb-3') )}}  
                                </div>
                                    {{ Form::textarea('biography', $biography->bio, array('class' => 'form-control w-full h-32') )}}
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

                    <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                        <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                        {{form::submit('SAVE CHANGES', array('class' => 'btn-green')) }}
                    </div>
                         {{ Form::close() }} 
                </div>

                <!-- CAMERA -->
                        
                
                <div class="card mb-6" id="addPostProduction">

                    {{ Form::open(array('route' => ['camera-add-position', Auth::user()->id],'files' => true)) }}

                    <div class="pb-6">
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Camera</h3>
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
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-2 md:mb-0">General resume</span>
                                </div>
                                <div class="md:w-2/3">
                                    <a href="#" class="btn-outline inline-block">Upload file</a>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-2 md:mb-0">General reel</span>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="form-control bg-light w-64 mr-2 mb-3 md:mb-0" placeholder="Add link"> or <a href="#" class="btn-outline inline-block">Upload file</a>
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
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right">Union</span>
                                </div>
                                <div class="md:w-2/3">
                                    <div class="pb-4">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="form-slider"></span>
                                        </label>
                                    </div>
                                    <label for="" class="block mb-3">Please provide details of your union group?</label>
                                    <textarea class="form-control w-full h-32" placeholder="Union description"></textarea>
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
                         {{ Form::close() }} 
                </div>

            </div>
        </div>
    </main>