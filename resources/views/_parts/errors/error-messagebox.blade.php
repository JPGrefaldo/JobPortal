@if($errors->count())
    <div class="bg-red-lightest border-t-4 border-red rounded-b px-4 py-3 shadow-md" role="alert">
        <div class="flex">
            <div class="py-1">
                <svg class="fill-current h-6 w-6 text-red mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </div>
            <div class="text-red-dark">
                <p class="font-bold text-red-dark">
                    {{ str_plural('Error', count($errors)) }}
                </p>
                <p>
                    <ul class="text-sm text-red-dark">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </p>
            </div>
        </div>
    </div>
@endif