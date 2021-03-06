<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    const PRODUCER = 'Producer';
    const MANAGER = 'Manager';
    const CREW = 'Crew';
    const ADMIN = 'Admin';
}
