<ul class="list-check">
    @if (! isset($biography->bio))
        <li>BIO</li>
     @else
        <li class="is-checked">BIO</li>
    @endif

    @if (! $socmed)
        <li>SOCIAL MEDIA PROFILES</li>
    @else
        <li class="is-checked">SOCIAL MEDIA PROFILES</li>
    @endif

    @if (! isset($resume->url))
        <li>GENERAL WORK RESUME</li>
    @else
        <li class="is-checked">GENERAL WORK RESUME</li>
    @endif


    @if (! isset($reel) || empty($reel->url))
        <li>GENERAL WORK REEL</li>
    @else
        <li class="is-checked">GENERAL WORK REEL</li>
    @endif

    @if (! $positions)
        <li>WORK POSITIONS</li>
    @else
        <li class="is-checked">WORK POSITIONS</li>
    @endif
</ul>

