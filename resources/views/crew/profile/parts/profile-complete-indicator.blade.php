<div class="hidden md:block w-1/4 float-left pr-8 py-md">
    <h4 class="text-sm uppercase text-grey tracking-wide mb-4">COMPLETE YOUR ACCOUNT</h4>
    <p>Complete profiels have a better chance of being selected and show up higher in search results. </p>
    <div class="text-center pt-8 pb-4">
        <img src="images/donut.svg" alt="" />
    </div>
    <ul class="list-reset list-check">
    @if (! isset($user->crew->bio))
        <li>BIO</li>
     @else
        <li class="is-checked">BIO</li>
    @endif

    @if (! isset($user->crew->socials))
        <li>SOCIAL MEDIA PROFILES</li>
     @else
        <li class="is-checked">SOCIAL MEDIA PROFILES</li>
    @endif
    

    @if (! isset($user->crew->resumes))
        <li>GENERAL WORK RESUME</li>
     @else
        <li class="is-checked">GENERAL WORK RESUME</li>
    @endif

     @if (! isset($user->crew->reels))
        <li>GENERAL WORK REEL</li>
     @else
        <li class="is-checked">GENERAL WORK REEL</li>
    @endif

        <li>WORK POSITIONS</li>
    </ul>
</div>