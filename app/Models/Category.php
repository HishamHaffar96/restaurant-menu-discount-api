<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
class Category extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use HasMediaThumbsTrait;


    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'position',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];
    // these attributes are translatable


    protected $appends = [
        'resource_url',
        'media'
        //path
    ];


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
        return url('/admin/categories/'.$this->getKey());
    }
    public function getMediaAttribute()
    {
        try {
            $mediaItems = $this->getMedia('gallery');
            $publicUrl = $mediaItems[0]->getUrl();
            return $publicUrl;
        } catch (\Throwable $th) {

        }
        return null;

    }
   /**
     * Get the hierarchical path of the category.
     *
     * @return Collection
     */
    public function hierarchicalPath(): Collection
    {
        $path = collect();
        $ids=[];
        $currentCategory = $this;
        $path->push($currentCategory);
        $ids[]=$this->id;

        // Build the hierarchical path by traversing parent categories
        while ($currentCategory->parent_id !== null) {
            $currentCategory = Category::find($currentCategory->parent_id);
            $path->push($currentCategory);
            if(array_has($ids, $currentCategory->id)){
                break;
            }
            $ids[]=$this->id;
        }

        return $path;
    }

    /**
     * Get the path of the category.
     *
     * @return Attribute
     */
    public function getPathAttribute()
    {
        // Construct the path string by joining category names with '/'
        $path = $this->hierarchicalPath()->reverse();
        return ['hierarchicalPath'=>array_combine($path->pluck('id')->toArray(),$path->pluck('name')->toArray()) ,'strPath'=>$path->pluck('name')->implode('/')];

    }

    /**
     * Get the effective discount for the category based on its hierarchical path.
     *
     * @return Discount|null
     */
    public function getEffectiveDiscount(): ?Discount
    {
        // Get the IDs of categories in the hierarchical path
        $pathIds = $this->hierarchicalPath()->pluck('id');

        // Retrieve discounts for the category and its parent categories, ordered by discountable_id
        $discounts = Discount::where('type', 'category')
            ->whereIn('discountable_id', $pathIds)
            ->orderByDesc('discountable_id')
            ->get();

        // Return the first discount if available, otherwise, return null
        return $discounts->first();
    }

    /* ************************ RELATIONS ************************* */

    public function parentCategory() {
        return $this->belongsTo(Category::class,"parent_id");
    }
    public function childrenCategories() {
        return $this->hasMany(Category::class,'parent_id', 'id');
    }
}
