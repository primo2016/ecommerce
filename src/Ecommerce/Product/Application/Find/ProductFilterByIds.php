<?php

namespace Core\Ecommerce\Product\Application\Find;

use Core\Ecommerce\Product\Domain\Product;
use Core\Ecommerce\Product\Domain\ProductsNotFound;
use Core\Ecommerce\Product\Domain\ProductRepository;
use Core\Ecommerce\Product\Application\ProductResponse;
use Core\Ecommerce\Product\Application\ProductsResponse;

use function Lambdish\Phunctional\map;

final class ProductFilterByIds
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $productIds)
    {
        return $this->getAsResponse($productIds);
    }

    private function toResponse(): callable
    {
        return static fn(Product $product) => new ProductResponse(
            $product->getId(),
            $product->getName(),
            $product->getDescription(),
            $product->getAmount(),
            $product->getCategoryMap(),
            max(array_column($product->getCategoryMap(), 'discountAssigned')) ?? null
        );
    }

    private function getAsResponse($productIds)
    {
        $resultArray = $this->repository->searchAllByIds($productIds);

        if (empty($resultArray)) {
            throw new ProductsNotFound;
        }
        return new ProductsResponse(...map($this->toResponse(), $resultArray));
    }
}
