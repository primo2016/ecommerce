<?php

namespace Core\Ecommerce\DiscountCode\Domain;

use Core\Exception\DomainError;

final class DiscountCodeNotFound extends DomainError
{

    public function __construct(private string $id, private string $displayField = 'id')
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'discount_code_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('El descuento con %s: <%s> no fue encontrado.', $this->displayField, $this->id);
    }
}
