<?php

namespace Core\Ecommerce\Product\Application;

use Illuminate\Support\Facades\Log;


final class ProductResponse
{
    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private float $amount,
        private array $categories
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function categories(): array
    {
        return $this->categories;
    }
}
