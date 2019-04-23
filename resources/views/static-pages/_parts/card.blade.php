<div class="container max-w-xl flex justify-center items-center">
        <div class="bg-white shadow-md rounded">
            <div class="p-8">
                {{ $cardTitle }}
                <div class="py-2">
                    {{ $cardContent }}
                </div>
            </div>
            <div class="p-8 text-right bg-grey-lighter border-top border-grey-light">
                <a href="{{ url()->previous() }}" class="btn-green">OK</a>
            </div>
        </div>
</div>

