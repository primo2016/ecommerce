<?php

namespace Core\Ecommerce\DiscountCode\Application\Update;

use Core\Ecommerce\DiscountCode\Application\Find\DiscountCodeFinder;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeRepository;

final class DiscountCodeUpdater
{
    private $repository;
    private DiscountCodeFinder $finder;

    public function __construct(DiscountCodeRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new DiscountCodeFinder($repository);
    }

    public function __invoke(int $id, string $newName, int $newCategoryId, int $newPercent): void
    {
        $discountCode = $this->finder->__invoke($id);

        $discountCode->rename($newName);
        $discountCode->setCategoryId($newCategoryId);
        $discountCode->setPercent($newPercent);

        $this->repository->update($discountCode);
    }
}
