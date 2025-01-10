<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function discountCode(): HasOne
    {
        return $this->hasOne(DiscountCode::class);
    }
}
