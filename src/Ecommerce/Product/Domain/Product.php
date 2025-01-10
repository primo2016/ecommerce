<?php

namespace Core\Ecommerce\Product\Domain;

use Core\Ecommerce\Category\Domain\Category;
use Core\Ecommerce\Shared\Application\Traits\Convertible;

use function Lambdish\Phunctional\map;

final class Product
{
    use Convertible;

    public function __construct(
        private string $name,
        private string $description,
        private float $amount,
        private array $categories,
        private ?int $id = null
    ) {}

    public static function create(string $name, string $description, float $amount, array $categories, ?int $id = null): self
    {
        $product = new self($name, $description, $amount, $categories, $id);

        return $product;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self($primitives['name'], $primitives['description'], (float)$primitives['amount'], $primitives['categories'], $primitives['id'] ?? null);
    }

    public function toPrimitives(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'description' => $this->description];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): string
    {
        return $this->description = $description;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): float
    {
        return $this->amount = $amount;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getCategoryMap(): array
    {
        return map(
            fn(Category $category) => [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'description' => $category->getDescription(),
                'discountAssigned' => $category->getDiscountAssigned()
            ],$this->getCategories());
    }
}
