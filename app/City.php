<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $table = 'cities';
    protected $primaryKey = 'city_id';

    /**
        * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    public function getCity($id) {

        $cities = City::where('state_id', $id)->get()->toArray();

        return $cities;
    }

    public function state() {
        return $this->hasOne('App\State', 'state_id', 'state_id');
    }

    public function user() {
        return $this->hasMany('App\User');
    }
}
