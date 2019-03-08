<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\SubCategory;

class Product extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sub_category_ids', 'name', 'price', 'status'
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
     * Mutator for sub_category_ids property.
     *
     * @param  array|string $ids
     * @return void
     */
    public function setSubCategoryIdsAttribute($sub_category_ids)
    {
        $this->attributes['sub_category_ids'] = is_string($sub_category_ids) ? $sub_category_ids : implode(',', $sub_category_ids);
    }

    /**
     * Accessor for sub_category_ids property.
     *
     * @return array
     */
    public function getSubCategoryIdsAttribute($value)
    {
        return explode(',', $value);
    }

     /**
     * Access sub_category_ids relation query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sub_category()
    {
        return SubCategory::whereIn('sub_category_id', $this->sub_category_ids);
    }

    /**
     * Accessor that mimics Eloquent dynamic property.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubCategoryAttribute()
    {
        if (!$this->relationLoaded('sub_categories')) {
            $sub_categories = SubCategory::whereIn('sub_category_id', $this->sub_category_ids)->get();

            $this->setRelation('sub_categories', $sub_categories);
        }

        return $this->getRelation('sub_categories');
    }
}
