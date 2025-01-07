<?php

namespace Core\Ecommerce\Category\Domain;

interface CategoryRepository
{
    public function save(Category $category): void;

    public function update(Category $category): void;

    public function delete(Category $category): void;

    public function search(int $id): ?Category;

    public function searchByName(string $name): ?Category;

    public function searchWhereIn(array $category_ids): array;

    public function searchAll(): array;
}
