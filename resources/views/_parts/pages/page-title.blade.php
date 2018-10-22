<div class="w-full pb-8 border-b-2 mb-8 border-grey-light md:flex justify-between items-center">
    <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold">{{ $pageTitle }}</h1>
    @if(isset($button))
        <a href="{{ $button['link'] }}" class="{{ isset($button['class']) ? $button['class'] : 'btn-green-outline' }}">{{ $button['text'] }}</a>
    @endif
</div>