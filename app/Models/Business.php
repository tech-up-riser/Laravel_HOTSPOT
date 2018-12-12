<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'businesses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_name',
        'business_fullname',
        'owner_name',
        'address1',
        'address2',
        'city',
        'postcode',
        'country',
        'country',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'linkedin_link',
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
