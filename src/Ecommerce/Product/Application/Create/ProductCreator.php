<?php

namespace Core\Ecommerce\Product\Application\Create;

use Core\Ecommerce\Category\Application\CategoryResponse;
use Core\Ecommerce\Category\Domain\Category;
use Core\Ecommerce\Product\Domain\ProductRepository;
use Core\Ecommerce\Product\Domain\Product;

use function Lambdish\Phunctional\map;

final class ProductCreator
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string  $name, string  $description, float $amount, array $selectedCategories): void
    {
        $categories = map($this->toCategory(), $selectedCategories);

        $product = Product::create($name, $description, $amount, $categories);

        $this->repository->save($product);
    }

    private function toCategory(): callable
    {
        return static fn(CategoryResponse $response) => (new Category(
            $response->id(),
            $response->name(),
            $response->description()
        ))->toPrimitives();
    }
}
