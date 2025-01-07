<?php

namespace Core\Ecommerce\Product\Application\Delete;

use Core\Ecommerce\Product\Application\Find\ProductFinder;
use Core\Ecommerce\Product\Domain\ProductRepository;

final class ProductDeleter
{
    private $repository;
    private ProductFinder $finder;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new ProductFinder($repository);
    }

    public function __invoke($id): void
    {
        $product = $this->finder->__invoke($id);

        $this->repository->delete($product);
    }
}
