<?php

namespace Core\Ecommerce\Product\Domain;

use Core\Exception\DomainError;

final class ProductNotFound extends DomainError
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'product_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('El Producto con id: <%s> no fue encontrado.', $this->id);
    }
}
