<?php

namespace Core\Ecommerce\Product\Application;

use Illuminate\Support\Facades\Log;


final class ProductsResponse
{
    private array $products;

    public function __construct(ProductResponse ...$products)
    {
        $this->products = $products;
    }

    public function products(): array
    {
        return $this->products;
    }
}
