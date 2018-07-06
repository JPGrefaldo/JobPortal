<?php

use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use App\Utils\UrlUtils;
use App\Models\UserRoles;
use App\Models\UserSites;
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
        $user = factory(User::class)->create([
            'first_name' => 'Mike Kevin',
            'last_name'  => 'Castro',
            'email'      => 'mikekevin.castro@hjugroup.io',
        ]);

        $site = Site::where('hostname', UrlUtils::getHostNameFromBaseUrl(config('app.url')))->first();

        UserSites::create([
            'user_id' => $user->id,
            'site_id' => $site->id,
        ]);

        $producerRole = Role::whereName(Role::PRODUCER)->firstOrFail();
        $crewRole = Role::whereName(Role::CREW)->firstOrFail();

        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => $producerRole->id,
        ]);

        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => $crewRole->id,
        ]);
    }
}
