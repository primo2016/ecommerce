<?php

namespace Core\Ecommerce\DiscountCode\Application\Delete;

use Core\Ecommerce\DiscountCode\Application\Find\DiscountCodeFinder;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeRepository;

final class DiscountCodeDeleter
{
    private $repository;
    private DiscountCodeFinder $finder;

    public function __construct(DiscountCodeRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new DiscountCodeFinder($repository);
    }

    public function __invoke($id): void
    {
        $discountCode = $this->finder->__invoke($id);

        $this->repository->delete($discountCode);
    }
}
