<?php

namespace Core\Ecommerce\DiscountCode\Application\Create;

use Core\Ecommerce\DiscountCode\Domain\DiscountCodeRepository;
use Core\Ecommerce\DiscountCode\Domain\DiscountCode;

final class DiscountCodeCreator
{
    private $repository;

    public function __construct(DiscountCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string  $name, int  $category_id, int $percent): void
    {
        $discountCode = DiscountCode::create($name, $category_id, $percent);

        $this->repository->save($discountCode);
    }
}
