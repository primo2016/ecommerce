<?php

namespace Core\Ecommerce\DiscountCode\Domain;

use Core\Ecommerce\Shared\Application\Traits\Convertible;

final class DiscountCode
{
    use Convertible;

    public function __construct(private string $name, private int $category_id, private int $percent, private ?int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category_id = $category_id;
        $this->percent = $percent;
    }

    public static function create(string $name, int $category_id, int $percent, ?int $id = null): self
    {
        $discountCode = new self($name, $category_id, $percent, $id);

        return $discountCode;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self($primitives['name'], (int)$primitives['category_id'], (int)$primitives['percent'], $primitives['id'] ?? null);
    }

    public function toPrimitives(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'category_id' => $this->category_id, 'percent' => $this->percent];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): int
    {
        return $this->category_id = $category_id;
    }

    public function getPercent(): int
    {
        return $this->percent;
    }

    public function setPercent(int $percent): int
    {
        return $this->percent = $percent;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }
}
