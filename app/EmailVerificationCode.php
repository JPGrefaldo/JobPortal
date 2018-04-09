<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['code'];
}
