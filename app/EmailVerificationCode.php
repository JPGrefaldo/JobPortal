<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];
}
