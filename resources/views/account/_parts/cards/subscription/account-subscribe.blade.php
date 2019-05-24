@component('account._parts.account-card')
    @slot('subtitle')
        Subscription
    @endslot

    @slot('accountContent')
        @if (! Auth::user()->subscribed())
            <div>
                <div id="card-number" class="w-full border border-light-grey max-w-sm p-2 my-2"></div>
            </div>
            <div class="flex">
                <div class="flex-1 ">
                    <div id="card-expiry" class="border border-light-grey p-2 my-2"></div>
                </div>
                <div class="flex-1 ">
                    <div id="card-cvc" class=" border border-light-grey p-2 my-2"></div>
                </div>
            </div>
            <div>
                <input id="zip-code"
                       type="text"
                       class="w-full border border-light-grey max-w-sm p-2 my-2"
                       placeholder="Zip Code"
                />
            </div>

            <div id="card-errors" class="text-red-error mt-4" role="alert"></div>
        @else
            <h3 class="text-error-message">Subscription error</h3>
        @endif
    @endslot

    @slot('accountSaveURL')
        {{ route('account.subscription.subscribe') }}
    @endslot

    @slot('accountSaveButton')
        Subscribe
    @endslot
@endcomponent

@push('javascripts')
    <script src="https://js.stripe.com/v3"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ Config::get('services.stripe.key') }}');
        var elements = stripe.elements({
            fonts: [
                {
                    cssSrc: 'https://fonts.googleapis.com/css?family=Noto+Sans',
                },
            ]
        });

        var style = {
            base: {
                color: '#32325d',
                lineHeight: '1.5',
                fontFamily: "'Noto Sans','Helvetica Neue','sans-serif'",
                fontSmoothing: 'antialiased'
            },
            invalid: {
                color: '#D8000C',
                iconColor: '#D8000C'
            }
        };

        var cardNumber = elements.create('cardNumber', {
            style: style
        });
        cardNumber.mount('#card-number');

        var cardExpiry = elements.create('cardExpiry', {
            style: style
        });
        cardExpiry.mount('#card-expiry');

        var cardCvc = elements.create('cardCvc', {
            style: style
        });
        cardCvc.mount('#card-cvc');

        cardNumber.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        cardExpiry.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        cardCvc.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var custData = {
            address_zip: document.getElementById('zip-code').value
        };

        var form = document.getElementById('account-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            stripe.createToken(cardNumber, custData).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('account-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
@endpush