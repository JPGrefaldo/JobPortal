<div class="w-full md:w-3/4 float-left">
    <div class="bg-white shadow-md rounded">
        <div class="py-4 px-6 md:py-8 md:px-md">
            <h3 class="font-header text-blue-dark text-lg font-semibold mb-6">Subscription</h3>
            @if (Auth::user()->subscription()->onGracePeriod())
                <p>Your subscription will end on {{ Auth::user()->subscription()->ends_at->toDayDateTimeString() }}</p>
            @endif
        </div>
        <div class="p-8 text-right bg-grey-lighter border-top border-grey-light">
            <a href="{{ route('account.subscription.resume') }}" class="btn-green">Resume Subscription</a>
        </div>
    </div>
</div>