<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
class Item extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use HasMediaThumbsTrait;
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'description'

    ];
    protected $dates = [
        'created_at',
        'updated_at',

    ];
    protected $appends = [
        'resource_url',
        'media'
        //'discount'

    ];

     /**
     * Create an attribute with a given amount.
     *
     * @param float $amount
     * @return Attribute
     */
    private function createAttribute($amount= 0.00 )
    {
        return  $amount;
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('gallery')
            ->accepts('image/*')
            ->maxNumberOfFiles(20);
    }
    public function registerMediaConversions( $media = null): void
    {
        $this->autoRegisterThumb200();
    }

    /* ************************ ACCESSOR ************************* */
    public function getResourceUrlAttribute()
    {
        return url('/admin/items/'.$this->getKey());
    }

    public function getMediaAttribute()
    {
        try {
            $mediaItems = $this->getMedia('gallery');
            $publicUrl = $mediaItems[0]->getUrl();

            return $publicUrl;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return null;

    }



     /**
     * Get the effective discount for the item.
     *
     * This method checks for item-specific, category-specific, and general menu discounts.
     *
     * @return Attribute
     */
    public function getDiscountAttribute()
    {
        // Check for item-specific discount
        $itemDiscount = Discount::where('type', 'item')->where('discountable_id', $this->id)->first();

        if ($itemDiscount) {
            return $this->createAttribute($itemDiscount->amount);
        }

        // Check for category-specific discount
        try {
            $categoryDiscount = $this->category->getEffectiveDiscount();

        if ($categoryDiscount) {
            return $this->createAttribute($categoryDiscount->amount);
        }
        } catch (\Throwable $th) {
            //throw $th;
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
