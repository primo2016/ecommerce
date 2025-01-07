<?php

namespace Core\Ecommerce\Category\Application;

use Illuminate\Support\Facades\Log;


final class CategoriesResponse
{
    private array $categories;

    public function __construct(CategoryResponse ...$categories)
    {
        $this->categories = $categories;
    }

    public function categories(): array
    {
        return $this->categories;
    }
}
