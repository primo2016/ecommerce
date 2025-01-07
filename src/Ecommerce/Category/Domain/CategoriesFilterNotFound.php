<?php

namespace Core\Ecommerce\Category\Domain;

use Core\Exception\DomainError;

final class CategoriesFilterNotFound extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'categories_not_found_by_filter';
    }

    protected function errorMessage(): string
    {
        return 'Una o varías categorías no existesn para el filtro selecionado.';
    }
}
