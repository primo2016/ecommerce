<?php

namespace Core\Ecommerce\Category\Domain;

use Core\Exception\DomainError;

final class CategoriesNotFound extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'categories_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('No hay categorías cargadas.');
    }
}
