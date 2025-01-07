<?php

namespace Core\Ecommerce\Category\Application\Find;


use function Lambdish\Phunctional\map;

use Core\Ecommerce\Category\Application\CategoriesResponse;
use Core\Ecommerce\Category\Domain\Category;
use Core\Ecommerce\Category\Domain\CategoryRepository;
use Core\Ecommerce\Category\Application\CategoryResponse;
use Core\Ecommerce\Category\Domain\CategoriesNotFound;

final class CategorySearcherAll
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->getAsResponse();
    }

    private function toResponse(): callable
    {
        return static fn(Category $category) => new CategoryResponse(
            $category->getId(),
            $category->getName(),
            $category->getDescription()
        );
    }

    private function getAsResponse()
    {
        $resultArray = $this->repository->searchAll();

        if (empty($resultArray)) {
            throw new CategoriesNotFound;
        }
        
        return new CategoriesResponse(...map($this->toResponse(), $resultArray));
    }
}
