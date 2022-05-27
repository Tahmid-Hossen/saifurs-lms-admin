<?php

namespace App\Models\Backend\User;

use Illuminate\Database\Eloquent\Model;

class OneTimePassword extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'one_time_passwords';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'token', 'validity'
    ];
}
