<?php

namespace Core\Ecommerce\DiscountCode\Domain;

interface DiscountCodeRepository
{
    public function save(DiscountCode $discountCode): void;

    public function update(DiscountCode $discountCode): void;

    public function delete(DiscountCode $discountCode): void;

    public function search(int $id): ?DiscountCode;

    public function searchByName(string $discountCodeName): ?DiscountCode;

    public function searchAll(): array;
}
