<?php

namespace Core\Ecommerce\Category\Application\Delete;

use Core\Ecommerce\Category\Application\Find\CategoryFinder;
use Core\Ecommerce\Category\Domain\CategoryRepository;

final class CategoryDeleter
{
    private $repository;
    private CategoryFinder $finder;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new CategoryFinder($repository);
    }

    public function __invoke($id): void
    {
        $category = $this->finder->__invoke($id);

        $this->repository->delete($category);
    }
}
