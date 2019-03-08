<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    protected $table = 'countries';
    protected $primaryKey = 'country_id';

    /**
        * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    public function user() {
        return $this->hasMany('App\User');
    }

    public function states() {
        return $this->hasMany('App\State', 'country_id', 'country_id');
    }
}
