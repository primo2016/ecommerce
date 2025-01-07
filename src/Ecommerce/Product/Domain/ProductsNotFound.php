<?php

namespace Core\Ecommerce\Product\Domain;

use Core\Exception\DomainError;

final class ProductsNotFound extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'products_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('No hay productos cargados.');
    }
}
