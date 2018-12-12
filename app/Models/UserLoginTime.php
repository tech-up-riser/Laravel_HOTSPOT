<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLoginTime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_login_times';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_time',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    protected $dates = [
        'deleted_at',
    ];
}
