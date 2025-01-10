<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountCode extends Model
{
    protected $fillable = ['name', 'percent', 'category_id'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
