<?php

namespace Core\Ecommerce\Product\Domain;

interface ProductRepository
{
    public function save(Product $product): void;

    public function update(Product $product): void;

    public function delete(Product $product): void;

    public function search(int $id): ?Product;

    public function searchByName(string $productName): ?Product;

    public function searchAll(): array;
}
