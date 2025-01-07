<?php

namespace Core\Ecommerce\Product\Application\Find;

use Core\Ecommerce\Product\Domain\Product;
use Core\Ecommerce\Product\Domain\ProductsNotFound;
use Core\Ecommerce\Product\Domain\ProductRepository;
use Core\Ecommerce\Product\Application\ProductResponse;
use Core\Ecommerce\Product\Application\ProductsResponse;

use function Lambdish\Phunctional\map;

final class ProductSearcherAll
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->getAsResponse();
    }

    private function toResponse(): callable
    {
        return static fn(Product $product) => new ProductResponse(
            $product->getId(),
            $product->getName(),
            $product->getDescription(),
            $product->getAmount(),
            $product->getCategoryMap()
        );
    }

    private function getAsResponse()
    {
        $resultArray = $this->repository->searchAll();

        if (empty($resultArray)) {
            throw new ProductsNotFound;
        }
        return new ProductsResponse(...map($this->toResponse(), $resultArray));
    }
}
