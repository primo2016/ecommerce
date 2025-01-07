<?php

namespace Core\Ecommerce\Category\Domain;

use Core\Ecommerce\Shared\Application\Traits\Convertible;

final class Category
{
    use Convertible;

    public function __construct(private string $name,private string $description, private ?int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public static function create(string $name, string $description, ?int $id = null): self
    {
        $category = new self($name, $description, $id);

        return $category;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self($primitives['name'], $primitives['description'], $primitives['id'] ?? null);
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

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }
}
