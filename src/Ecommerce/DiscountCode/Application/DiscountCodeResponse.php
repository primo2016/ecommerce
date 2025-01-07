<?php

namespace Core\Ecommerce\DiscountCode\Application;

use Illuminate\Support\Facades\Log;


final class DiscountCodeResponse
{
    public function __construct(private int $id,private string $name, private int $category_id, private int $percent)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category_id = $category_id;
        $this->percent = $percent;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category_id(): int
    {
        return $this->category_id;
    }

    public function percent(): int
    {
        return $this->percent;
    }
}
