<?php

namespace Core\Ecommerce\Category\Application\Update;

use Core\Ecommerce\Category\Application\Find\CategoryFinder;
use Core\Ecommerce\Category\Domain\CategoryRepository;

final class CategoryUpdater
{
    private $repository;
    private CategoryFinder $finder;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new CategoryFinder($repository);
    }

    public function __invoke(int $id, string $newName, string $newDescription): void
    {
        $category = $this->finder->__invoke($id);

        $category->rename($newName);
        $category->setDescription($newDescription);

        $this->repository->update($category);
    }
}
