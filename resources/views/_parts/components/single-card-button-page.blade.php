<div class="max-w-screen-xl flex justify-center items-center">
    <div class="w-full md:w-1/2 xl:w-1/4 float-left mb-3 md:mb-0 px-4">
        <div class="bg-white shadow-md rounded">
            {{ $cardTitle ?? '' }}
            <form method="post" action="{{ $cardRoute }}">
                <div class="p-8">
                    {{ $cardContent }}
                    <div class="pt-6">
                        @csrf
                        <input type="submit"
                               class="btn-rounded btn-blue block font-header uppercase text-sm p-4 w-full text-center"
                               value="{{ $cardButtonValue }}"
                        >
                    </div>
                </div>
            </form>
            {{ $cardUnderContent ?? '' }}
        </div>
    </div>
</div>