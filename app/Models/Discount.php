<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
    "type",
    "discountable_type",
    "discountable_id",
    "amount"
    ];
    public static $types=[
                ["name"=>"menu"],
                ["name"=>"category"],
                ["name"=>"item"]
            ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/discounts/'.$this->getKey());
    }

    /* ************************ RELATIONS ************************* */
    public function category() {
        return $this->belongsTo(Category::class,"discountable_id");
    }

    public function item() {
        return $this->belongsTo(Item::class,"discountable_id");
    }
}
