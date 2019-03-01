<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use DB;
use Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','social_provider_id' ,'social_provider'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getAllUsers(){
        $transportes = User::select('*')
                    ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where(['role_user.role_id' => 2])
                    ->where('users.user_status','!=', '-1')
                    ->get();
        return $transportes;
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = encrypt($value);
    }

    public function getFirstNameAttribute($value)
    {
        return decrypt($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = encrypt($value);
    }

    public function getLastNameAttribute($value)
    {
        return decrypt($value);
    }
}
