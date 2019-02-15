<?php

use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use App\Utils\UrlUtils;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $site = Site::where('hostname', UrlUtils::getHostNameFromBaseUrl(config('app.url')))->first();
        $producerRole = Role::whereName(Role::PRODUCER)->firstOrFail();
        $crewRole = Role::whereName(Role::CREW)->firstOrFail();

        $user = factory(User::class)->create([
            'first_name' => 'Mike Kevin',
            'last_name'  => 'Castro',
            'email'      => 'mikekevin.castro@hjugroup.io',
        ]);

        $user->sites()->attach($site);
        $user->roles()->attach($producerRole);
        $user->roles()->attach($crewRole);

        $anotherUser = factory(User::class)->create([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'john@mail.com',
        ]);

        $anotherUser->sites()->attach($site);
        $anotherUser->roles()->attach($crewRole);
    }
}
