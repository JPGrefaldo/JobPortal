<div class="w-full md:w-3/4 float-left">
    <div class="bg-white shadow-md rounded">
        <form method="post" action="{{ $accountSaveURL }}">
            <div class="py-4 px-6 md:py-8 md:px-md">
                <h3 class="font-header text-blue-dark text-lg font-semibold mb-6">{{ $subtitle }}</h3>
                {{ $accountContent }}
            </div>
            <div class="p-8 text-right bg-grey-lighter border-top border-grey-light">
                @csrf
                <a href="" class="text-grey font-bold mr-4 font-header hover:text-green">Cancel</a>
                <input type="submit" value="SAVE CHANGES" class="btn-green">
            </div>
        </form>
    </div>
</div>