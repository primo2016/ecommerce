<?php

namespace Core\Ecommerce\Category\Domain;

use Core\Exception\DomainError;

final class CategoryNotFound extends DomainError
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'category_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('La Categoría con id: <%s> no fue encontrada.', $this->id);
    }
}
