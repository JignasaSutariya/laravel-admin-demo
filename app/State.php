<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;
    protected $table = 'states';
    protected $primaryKey = 'state_id';

    /**
        * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    public function getState($id){
        $states = State::where('country_id', $id)->get()->toArray();

        return $states;
    }

    public function country() {
        return $this->hasOne('App\Country', 'country_id', 'country_id');
    }

    public function cities() {
        return $this->hasMany('App\City', 'state_id', 'state_id');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
