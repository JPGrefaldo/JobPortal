<div class="w-full md:w-3/4 float-left">
    <div class="bg-white shadow-md rounded">
            <div class="py-4 px-6 md:py-8 md:px-md">
                <h3 class="font-header text-blue-dark text-lg font-semibold mb-6">Close Account</h3>
                <p class="leading-normal">
                    This will close
                    @if($user->hasRole(\App\Models\Role::PRODUCER) && $user->hasRole(\App\Models\Role::CREW))
                        <span class="underline font-extrabold">both</span> accounts
                    @else
                        your account
                    @endif
                    to re-enable your account will need to contact us
                </p>
            </div>
            <div class="p-8 text-right bg-grey-lighter border-top border-grey-light">
                <form action="{{ route('account.close') }}" method="post">
                    @csrf
                    @method('PUT')
                    <a href="{{ route('account.name') }}" class="text-grey font-bold mr-4 font-header hover:text-green">Cancel</a>
                    <input type="submit" class="btn-red" value="Close" />
                </form>
            </div>
    </div>
</div>