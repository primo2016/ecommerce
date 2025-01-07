<?php

namespace Core\Ecommerce\DiscountCode\Domain;

use Core\Exception\DomainError;

final class DiscountCodesNotFound extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'discount_codes_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('No hay Codigos de Descuento cargados.');
    }
}
