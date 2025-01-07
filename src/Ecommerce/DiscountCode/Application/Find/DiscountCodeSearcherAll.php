<?php

namespace Core\Ecommerce\DiscountCode\Application\Find;

use Core\Ecommerce\DiscountCode\Domain\DiscountCode;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodesNotFound;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeRepository;
use Core\Ecommerce\DiscountCode\Application\DiscountCodeResponse;
use Core\Ecommerce\DiscountCode\Application\DiscountCodesResponse;

use function Lambdish\Phunctional\map;

final class DiscountCodeSearcherAll
{
    private $repository;

    public function __construct(DiscountCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->getAsResponse();
    }

    private function toResponse(): callable
    {
        return static fn(DiscountCode $discountCode) => new DiscountCodeResponse(
            $discountCode->getId(),
            $discountCode->getName(),
            $discountCode->getCategoryId(),
            $discountCode->getPercent()
        );
    }

    private function getAsResponse()
    {
        $resultArray = $this->repository->searchAll();

        if (empty($resultArray)) {
            throw new DiscountCodesNotFound;
        }
        return new DiscountCodesResponse(...map($this->toResponse(), $resultArray));
    }
}
