<div class="w-full flex justify-center items-center">
        <div class="bg-white shadow-md rounded xl:w-1/2">
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

