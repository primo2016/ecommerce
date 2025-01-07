<?php

namespace Core\Ecommerce\Category\Application\Create;

use Core\Ecommerce\Category\Domain\CategoryRepository;
use Core\Ecommerce\Category\Domain\Category;

final class CategoryCreator
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string  $name, string  $description): void
    {
        $category = Category::create($name, $description);

        $this->repository->save($category);
    }
}
