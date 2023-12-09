<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{

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


    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/categories/'.$this->getKey());
    }
   /**
     * Get the hierarchical path of the category.
     *
     * @return Collection
     */
    private function hierarchicalPath(): Collection
    {
        $path = collect();
        $currentCategory = $this;
        $path->prepend($currentCategory);

        // Build the hierarchical path by traversing parent categories
        while ($currentCategory->parent_id !== null) {
            $currentCategory = Category::find($currentCategory->parent_id);
            $path->prepend($currentCategory);
        }

        return $path;
    }

    /**
     * Get the path of the category.
     *
     * @return Attribute
     */
    public function path(): Attribute
    {
        // Construct the path string by joining category names with '/'
        $path = $this->hierarchicalPath()->reverse()->pluck('name')->implode('/');

        return new Attribute(
            get: fn () => $path
        );
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
}
