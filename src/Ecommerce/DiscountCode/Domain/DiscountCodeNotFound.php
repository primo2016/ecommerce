<?php

namespace Core\Ecommerce\DiscountCode\Domain;

use Core\Exception\DomainError;

final class DiscountCodeNotFound extends DomainError
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'discount_code_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('El código de descuento con id: <%s> no fue encontrado.', $this->id);
    }
}
