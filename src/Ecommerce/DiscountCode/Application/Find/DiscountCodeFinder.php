<?php

namespace Core\Ecommerce\DiscountCode\Application\Find;

use Core\Ecommerce\DiscountCode\Domain\DiscountCodeRepository;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeNotFound;
use Core\Ecommerce\DiscountCode\Domain\DiscountCode;

final class DiscountCodeFinder
{
    private $repository;

    public function __construct(DiscountCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($id)
    {
        $discountCode = $this->repository->search($id);
        $this->guard($id, $discountCode);

        return $discountCode;
    }

    private function guard($id, DiscountCode $discountCode = null)
    {
        if (null === $discountCode) {
            throw new DiscountCodeNotFound($id);
        }
    }
}
