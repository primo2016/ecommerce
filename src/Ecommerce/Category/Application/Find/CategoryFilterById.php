<?php

namespace Core\Ecommerce\Category\Application\Find;

use Core\Ecommerce\Category\Application\CategoryResponse;
use Core\Ecommerce\Category\Domain\CategoriesFilterNotFound;
use Core\Ecommerce\Category\Domain\Category;
use Core\Ecommerce\Category\Domain\CategoryRepository;

use function Lambdish\Phunctional\map;

final class CategoryFilterById
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $catetory_ids): array
    {
        $resultArray = $this->repository->searchWhereIn($catetory_ids);

        if (empty($resultArray)) {
            throw new CategoriesFilterNotFound;
        }

        return map($this->toResponse(), $resultArray);
    }

    private function toResponse(): callable
    {
        return static fn(Category $reason) => new CategoryResponse(
            $reason->getId(),
            $reason->getName(),
            $reason->getDescription()
        );
    }
}
