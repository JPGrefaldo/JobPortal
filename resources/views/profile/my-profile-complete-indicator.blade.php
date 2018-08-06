<ul class="list-reset list-check">

                @if (!isset($biography->bio)) 
                    <li>BIO</li>
                     @else 
                    <li class="is-checked">BIO</li>
                @endif
                
                @if (count($socmed) < 1) 
                    <li>SOCIAL MEDIA PROFILES</li>
                    @else 
                    <li class="is-checked">SOCIAL MEDIA PROFILES</li>
                @endif

                @if (!isset($resume->url))
                    <li>GENERAL WORK RESUME</li>
                    @else 
                    <li class="is-checked">GENERAL WORK RESUME</li>
                @endif
                

                @if (!isset($reel) || $reel->url == '')    
                    <li>GENERAL WORK REEL</li>
                    @else
                    <li class="is-checked">GENERAL WORK REEL</li>
                @endif    

                @if (count($positions) < 1)
                    <li>WORK POSITIONS</li>
                    @else 
                    <li class="is-checked">WORK POSITIONS</li>
                @endif

</ul>

