<div class="card mb-6">
    <div class="pb-6">
            <span class="btn-toggle float-right"></span>
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                            {{ $post->roles->departments->name }}
                    <span class="font-thin"> – {{ $post->roles->name }}</span>
                            
                </h3>
    </div>
       <div class="md:flex">
            <div class="md:w-1/4 pr-8 mb-2 md:mb-0">
                <h3 class="text-md text-grey font-header">Position bio</h3>
            </div>
                 <div class="md:w-3/4">
                    <div class="bg-grey-lighter p-6 rounded mb-8">
                        <p>{{ $post->details }} </p>
                    </div>
                        <div class="pb-2 md:flex">
                            <a href="\{{ $post->crew->reels }}" class="border md:w-1/2 flex overflow-hidden rounded md:mr-2 mb-2 md:mb-0">
                                    <div class="w-24 relative" style="background: url(../images/th2.jpg); background-size: cover;">
                                        <span class="btn-play w-10 h-10"></span>
                                    </div>
                                    <span class='uppercase text-green font-semibold p-4 text-sm tracking-wide'>VIEW POSITION WORK REEL</span>
                             </a>
                                
                             <a href="#" class="border md:w-1/2 flex items-center overflow-hidden rounded md:ml-2">
                                    <i class="far fa-file-alt px-6 text-lg"></i>
                                    <span class='uppercase text-green font-semibold px-0 py-6 text-sm tracking-wide'>VIEW POSITION RESUME</span>
                             </a>
                             
                            </div>
                   </div>
           	</div>
</div>