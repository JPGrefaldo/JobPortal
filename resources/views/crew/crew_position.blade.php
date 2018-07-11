@include('_parts.header.header')

<body class="bg-grey-lighter font-body">
    @include('_parts.navbar.navbar-logged-in')

    <main class="float-left w-full py-md md:py-lg px-3">
        <div class="container">
            <div class="w-full pb-md md:pb-lg">
                <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold">Crew Position</h1>
            </div>

            <div class="w-1/4 float-left pr-8 py-md hidden md:block">
                <h4 class="text-grey mb-4">JOB TIPS</h4>
                <p>The more people you get to endorse you, the higher chance of you being selected for a job.</p>
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
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Job details</h3>
                    </div>
                    <div class="md:flex py-3">
                        <div class="md:w-1/3 pr-6">
                            <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Endorse a good candidate.</span>
                        </div>
                        <form action="/crew-positions/1/endorsements" method="post">
                            {{ csrf_field() }}
                            <div class="md:w-2/3">
                                <input type="text" class="form-control w-full" name="endorser_email" placeholder="Endorser's email." dusk="endorser_email">
                            </div>
                            <br>
                            <input type="submit" value="Ask Endorsement" dusk="ask_endorsement">
                            {{-- <button>Ask Endorsement</button> --}}

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('_parts/footer')
