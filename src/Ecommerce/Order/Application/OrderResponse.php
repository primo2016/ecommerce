<?php

namespace Core\Ecommerce\Order\Application;

final class OrderResponse
{
    public function __construct(
        private float $subtotal,
        private float $totalDiscountApplied,
        private float $additionalDiscountApplied,
        private float $total,
    ) {}

    public function subtotal(): float
    {
        return $this->subtotal;
    }

    public function total(): float
    {
        return $this->total;
    }

    public function additionalDiscountApplied(): float
    {
        return $this->additionalDiscountApplied;
    }

    public function totalDiscountApplied(): float
    {
        return $this->totalDiscountApplied;
    }
}
