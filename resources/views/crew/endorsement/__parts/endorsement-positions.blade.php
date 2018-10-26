<div class="bg-white mt-4 rounded p-4 md:p-8 shadow">
    <div class="flex justify-between items-center">
        <h3 class="text-blue-dark font-semibold text-md mb-1 font-header">
            {{ $position['position']->name }}
        </h3>
    </div>
    <div class="md:flex mb-4 pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
        <a href="#" class="flex justify-between mt-4 md:mt-0 block btn-outline bg-green text-white">
            <span class="pt-1">View {{ str_plural('Endorse', $position['count']) }}</span> <span class="ml-4 badge badge-white">{{ $position['count'] }}</span>
        </a>
    </div>
</div>