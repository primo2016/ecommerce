<?php

namespace Core\Ecommerce\DiscountCode\Application\Find;

use Core\Ecommerce\DiscountCode\Domain\DiscountCodeRepository;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeNotFound;
use Core\Ecommerce\DiscountCode\Domain\DiscountCode;

final class DiscountCodeFilter
{
    private $repository;

    public function __construct(DiscountCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($code)
    {
        $discountCode = $this->repository->searchByName($code);
        $this->guard($code, $discountCode);

        return $discountCode;
    }

    private function guard($code, DiscountCode $discountCode = null)
    {
        if (null === $discountCode) {
            throw new DiscountCodeNotFound($code, 'código');
        }
    }
}
