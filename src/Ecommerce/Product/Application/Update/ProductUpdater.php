<?php

namespace Core\Ecommerce\Product\Application\Update;

use Core\Ecommerce\Category\Application\CategoryResponse;
use Core\Ecommerce\Category\Domain\Category;
use Core\Ecommerce\Product\Application\Find\ProductFinder;
use Core\Ecommerce\Product\Domain\ProductRepository;

use function Lambdish\Phunctional\map;

final class ProductUpdater
{
    private $repository;
    private ProductFinder $finder;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new ProductFinder($repository);
    }

    public function __invoke(int $id, string $newName, string $newDescription, float $newAmount, array $selectedCategories): void
    {
        $product = $this->finder->__invoke($id);

        $categories = map($this->toCategory(), $selectedCategories);

        $product->rename($newName);
        $product->setAmount($newAmount);
        $product->setDescription($newDescription);
        $product->SetCategories($categories);

        $this->repository->update($product);
    }

    private function toCategory(): callable
    {
        return static fn(CategoryResponse $response) => (new Category(
            $response->name(),
            $response->description(),
            $response->id()
        ))->toPrimitives();
    }
}
