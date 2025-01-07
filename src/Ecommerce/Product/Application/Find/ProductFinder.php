<?php

namespace Core\Ecommerce\Product\Application\Find;

use Core\Ecommerce\Product\Domain\ProductRepository;
use Core\Ecommerce\Product\Domain\ProductNotFound;
use Core\Ecommerce\Product\Domain\Product;

final class ProductFinder
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($id)
    {
        $product = $this->repository->search($id);
        $this->guard($id, $product);

        return $product;
    }

    private function guard($id, Product $product = null)
    {
        if (null === $product) {
            throw new ProductNotFound($id);
        }
    }
}
