<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'amount'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_has_categories', 'product_id', 'category_id');
    }
}
