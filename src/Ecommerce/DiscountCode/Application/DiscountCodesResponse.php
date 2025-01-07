<?php

namespace Core\Ecommerce\DiscountCode\Application;

final class DiscountCodesResponse
{
    private array $discountCodes;

    public function __construct(DiscountCodeResponse ...$discountCodes)
    {
        $this->discountCodes = $discountCodes;
    }

    public function discountCodes(): array
    {
        return $this->discountCodes;
    }
}
