
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

                @include('_parts.messagebox')
            </div>

            <div class="hidden md:block md:w-1/4 float-left pr-8 py-md">
                <h4 class="text-sm uppercase text-grey tracking-wide mb-4">COMPLETE YOUR ACCOUNT</h4>
                <p>Complete profiles have a better chance of being selected and show up higher in search results. </p>
                <div class="text-center pt-8 pb-4">
                    <img src="/images/donut.svg" alt="" />
                </div>

                @include('profile.my-profile-complete-indicator')
                
            </div>
            <div class="md:w-3/4 float-left">
                <div class="card mb-8">
                    <div class="w-full mb-6">
                        <h3 class="text-blue-dark font-semibold text-md md:text-lg mb-1 font-header">
                            {{ $user->nickname_or_full_name }}</h3>
                    </div>

                     {{ Form::open(array('route' => 'profile-update', 'files' => true)) }}
                      
                    <div class="md:flex">
                        <div class="md:w-1/3 md:pr-6 mb-6">
                            
                            @if (isset($biography->photo))
                            <div class="flex h-none bg-grey-light items-center justify-center cursor-pointer text-center border border-grey-light w-full pb-full rounded relative" style="background: url(/{{ $biography->photo }}); background-size: cover;">
                                <label for="file" class="text-center uppercase text-sm font-semibold text-white px-2 pos-center w-full">
                                UPLOAD PROFILE PHOTO
                                {{ form::file('profile_image', array('id' => 'file', 'class' => 'profile_image', 'style' => 'opacity:0;'))}}
                                </label>
                            </div>
                            @else 
                            <div class="flex h-none bg-grey-light items-center justify-center cursor-pointer text-center border border-grey-light w-full pb-full rounded relative" style="background: url(http://i.pravatar.cc/300); background-size: cover;">
                                <span class="text-center uppercase text-sm font-semibold text-white px-2 pos-center w-full">
                                UPLOAD PROFILE PHOTO
                                {{ form::file('profile_image', array('class' => 'profile_image'))}}
                                </span>
                            </div>
                            @endif

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
                                    
                                    @if (isset($biography->bio))
                                    {{ Form::textarea('bio', $biography->bio, array('class' => 'form-control w-full h-32') )}}
                                        @else
                                         {{ Form::textarea('bio', 'Biography', array('class' => 'form-control w-full h-32') )}}
                                    @endif
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
                                <label class="btn-outline" for="resume_file">UPLOAD FILE
                                {{ form::file('resume_file', array('class' => 'btn-outline inline-block', 'value' => 'Upload file', 'id' => 'resume_file', 'style' => 'opacity:0;width:1px;'))}}
                               </label>
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
                                @if (isset($reel))
                                 <div class="bootstrap-iso">
                                      <span class="badge badge-primary">
                                        <h5>{{ $reel->url }}</h5>
                                    </span>                                        

                                <a href='{{ url("my-profile/$reel->id/deleteReel") }}' class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?')">
                                <i class="fa fa-times" aria-hidden="true" ></i></a>                           
                                      
                                </div>
                                @else
                                
                                {{ Form::text('reel_link',"",array('class' => 'form-control bg-light w-64 mr-2 mb-2 md:mb-0','placeholder' => 'Add link') )}}
                                <div> or <br>
                                <label class="btn-outline" for="reel_file"> UPLOAD FILE 
                                {{ form::file('reel_file', array('class' => 'btn-outline inline-block', 'id' => 'reel_file','style' => 'opacity:0;width:1px;')) }}
                                </label>
                                </div>
                                @endif
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

    

    <!-- ADD NEW WORK POSITION -->
    <div class="py-4">
        <h4 class='text-grey'>WORK POSITIONS</h4>
    </div>

    <h3 class="text-blue-dark font-semibold text-lg font-header mb-3 md:mb-0">Positions by Department</h3>
                
    {{ Form::open(array('route' => ['add-position', Auth::user()->id],'files' => true)) }}

    <div class="pt-8 pb-4 border-t-2 border-grey-lighter">
        <div class="py-2">
                    {{ Form::label('departments', 'Select Department:', array('class' => 'block mb-3') )}}
        </div>
        <div class="bootstrap-iso">
            
            <ul class="nav nav-tabs">
                @foreach($departments as $department)
                   <li><a data-toggle="tab" href="#{{ $department->name }}">{{ $department->name}}</a></li>
                @endforeach
            </ul>
  
            <div class="tab-content">     
                <div id="Production" class="tab-pane fade in active">
                            <div class="md:w-2/3">
                                <select multiple class="form-control" name="title">
                                    @foreach ($productionPositions  as $productionPosition)
                                        <option>{{ $productionPosition->name }}</option>
                                    @endforeach
                                </select>

                            </div> 
                </div>

                <div id="Art" class="tab-pane fade">
                  <div class="md:w-2/3">
                                <select multiple class="form-control" name="title">
                                    @foreach ($artPositions  as $artPosition)
                                        <option>{{ $artPosition->name }}</option>
                                    @endforeach
                                </select>
                    </div>
                </div>

                <div id="Camera" class="tab-pane fade">
                  <div class="md:w-2/3">      
                                <select multiple class="form-control" name="title">
                                    @foreach ($cameraPositions  as $cameraPosition)
                                        <option>{{ $cameraPosition->name }}</option>
                                    @endforeach
                                </select>  
                    </div>
                </div>

                <div id="Grip_Electric" class="tab-pane fade">
                  <div class="md:w-2/3">      
                                <select multiple class="form-control" name="title">
                                    @foreach ($gripElectricPositions  as $gripElectricPosition)
                                        <option>{{ $gripElectricPosition->name }}</option>
                                    @endforeach
                                </select>  
                    </div>
                </div>

                <div id="MUaH_Wardrobe" class="tab-pane fade">
                  <div class="md:w-2/3">      
                                <select multiple class="form-control" name="title">
                                    @foreach ($muahWardrobePositions  as $muahWardrobePosition)
                                        <option>{{ $muahWardrobePosition->name }}</option>
                                    @endforeach
                                </select>  
                    </div>
                </div>

                <div id="Sound" class="tab-pane fade">
                  <div class="md:w-2/3">      
                                <select multiple class="form-control" name="title">
                                    @foreach ($soundPositions  as $soundPosition)
                                        <option>{{ $soundPosition->name }}</option>
                                    @endforeach
                                </select>  
                    </div>
                </div>

              </div>                
        </div>                   
    </div>
                

                <div class="p-4 bg-grey-lighter">
                    <div class="py-2">                
                        <div class="container">
         

                        <div class="py-2">
                                    {{ Form::label('bio', '2. Biography:', array('class' => 'block mb-3') )}}
                            <div class="md:flex">
                             {{ Form::textarea('biography','', array('class' => 'form-control w-full h-32','placeholder' => 'Enter details') )}}
                            </div>
                        </div>
                        
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-2 md:mb-0">General resume</span>
                                </div>
                                <div class="md:w-2/3">
                                    <label for="resume_file" class="btn-outline">Upload file
                                    {{ form::file('resume_file', array('class' => 'btn-outline', 'id' => 'resume_file', 'style' => 'opacity:0;width:1px;'))}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-2 md:mb-0">General reel</span>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="form-control bg-light w-64 mr-2 mb-3 md:mb-0" placeholder="Add link"> or <br>
                                    <label for="reel_file" class="btn-outline">Upload file
                                    {{ form::file('reel_file', array('class' => 'btn-outline inline-block', 'id' => 'reel_file', 'style' => 'opacity:0;width:1px;')) }}
                                    </label>
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
                                    {{ Form::textarea('gear_details', '', array('class' => 'form-control w-full h-32', 'placeholder' => 'Your Gear') )}}
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
                                     {{ Form::textarea('union_details', '', array('class' => 'form-control w-full h-32', 'placeholder' => 'Union decription') )}}
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

            </div>
          </div>
        </div>
    </main>

