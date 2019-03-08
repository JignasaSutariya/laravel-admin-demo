<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'sub_category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'status'
    ];

    /**
     * Accessor for name
     *
     * @return array
     */
     public function getNameAttribute($value)
     {
         return ucfirst($value);
     }

     /**
      * Get the phone record associated with the user.
      */
     public function category()
     {
         return $this->hasOne('App\Category', 'category_id', 'category_id');
     }
}
