<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ManagerDeleted
{
    use Dispatchable, SerializesModels;

    public $manager;

    public $subordinate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($manager, $subordinate)
    {
        $this->manager = $manager;
        $this->subordinate = $subordinate;
    }
}
