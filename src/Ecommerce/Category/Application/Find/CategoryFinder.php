<?php

namespace Core\Ecommerce\Category\Application\Find;

use Core\Ecommerce\Category\Domain\CategoryRepository;
use Core\Ecommerce\Category\Domain\CategoryNotFound;
use Core\Ecommerce\Category\Domain\Category;

final class CategoryFinder
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($id)
    {
        $category = $this->repository->search($id);
        $this->guard($id, $category);

        return $category;
    }

    private function guard($id, Category $category = null)
    {
        if (null === $category) {
            throw new CategoryNotFound($id);
        }
    }
}
