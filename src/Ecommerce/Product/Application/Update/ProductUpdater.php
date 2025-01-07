<?php

namespace Core\Ecommerce\Product\Application\Update;

use Core\Ecommerce\Product\Application\Find\ProductFinder;
use Core\Ecommerce\Product\Domain\ProductRepository;

final class ProductUpdater
{
    private $repository;
    private ProductFinder $finder;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new ProductFinder($repository);
    }

    public function __invoke(int $id, string $newName, string $newDescription, float $newAmount): void
    {
        $product = $this->finder->__invoke($id);

        $product->rename($newName);
        $product->setAmount($newAmount);
        $product->setDescription($newDescription);

        $this->repository->update($product);
    }
}
