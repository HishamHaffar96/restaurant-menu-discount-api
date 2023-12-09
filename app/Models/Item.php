<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Item extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'category_id',

    ];
    protected $dates = [
        'created_at',
        'updated_at',

    ];
    protected $appends = ['resource_url'];

     /**
     * Create an attribute with a given amount.
     *
     * @param float $amount
     * @return Attribute
     */
    private function createAttribute(float $amount): Attribute
    {
        return new Attribute(['get' => fn () => $amount]);
    }

    /* ************************ ACCESSOR ************************* */
    public function getResourceUrlAttribute()
    {
        return url('/admin/items/'.$this->getKey());
    }
     /**
     * Get the effective discount for the item.
     *
     * This method checks for item-specific, category-specific, and general menu discounts.
     *
     * @return Attribute
     */
    public function discount(): Attribute
    {
        // Check for item-specific discount
        $itemDiscount = Discount::where('type', 'item')->where('discountable_id', $this->id)->first();

        if ($itemDiscount) {
            return $this->createAttribute($itemDiscount->amount);
        }

        // Check for category-specific discount
        $categoryDiscount = $this->category->getEffectiveDiscount();

        if ($categoryDiscount) {
            return $this->createAttribute($categoryDiscount->amount);
        }

        // Check for general menu discount
        $menuDiscount = Discount::where('type', 'menu')->where('discountable_id', null)->first();

        if ($menuDiscount) {
            return $this->createAttribute($menuDiscount->amount);
        }

        // No applicable discount found, return default attribute with 0.00 amount
        return $this->createAttribute(0.00);
    }




    /* ************************ RELATIONS ************************* */
        public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }


}
