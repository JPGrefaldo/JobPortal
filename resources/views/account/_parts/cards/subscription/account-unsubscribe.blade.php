<div class="w-full md:w-3/4 float-left">
    <div class="bg-white shadow-md rounded">
            <div class="py-4 px-6 md:py-8 md:px-md">
                <h3 class="font-header text-blue-dark text-lg font-semibold mb-6">Subscription</h3>
                @if (Auth::user()->subscribed())
                    @if (Auth::user()->invoices())
                        <div class="font-sans flex items-center justify-center bg-blue-darker w-full py-8">
                            <div class="overflow-hidden bg-white rounded max-w-xs w-full shadow-lg leading-normal">
                                @foreach (Auth::user()->invoices() as $invoice)
                                    <div class="block group p-4">
                                        <p class="font-bold text-lg mb-1 text-black">{{ $invoice->date()->toFormattedDateString() }}</p>
                                        <p class="text-grey-darker mb-2">
                                            {{ $invoice->total() }}
                                        </p>
                                        <p class="text-grey-darker mb-2 text-right @if (! $loop->last) border-b pb-4 @endif ">
                                            <a href="{{ route('account.subscription.invoice', $invoice->id) }}" class="btn-green">Download Invoice</a>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <h3>No invoices found</h3>
                    @endif
                @endif
            </div>
            <div class="p-8 text-right bg-grey-lighter border-top border-grey-light">
                <a href="{{ route('account.subscription.unsubscribe') }}" class="btn-red">Unsubscribe</a>
            </div>
    </div>
</div>