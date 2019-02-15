<?php

use App\Models\Manager;
use App\Models\User;

$factory->define(Manager::class, function() {
    return [
        'manager_id' => factory(User::class),
        'subordinate_id' => factory(User::class),
    ];
});