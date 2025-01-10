<?php

namespace Core\Ecommerce\Category\Domain;

use App\Enums\CategoryType;
use App\Models\DiscountCode;
use Core\Ecommerce\Shared\Application\Traits\Convertible;

use function PHPUnit\Framework\isNull;

final class Category
{
    use Convertible;

    private string $categoryOutletName = 'Outlet';

    public function __construct(private string $name,private string $description, private ?int $id = null, private ?int $percent = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->percent = ($name === CategoryType::OUTLET->value) ? config('ecommerce.discount.outlet') : $percent;
        $this->description = $description;
    }

    public static function create(string $name, string $description, ?int $id = null, ?int $percent = null): self
    {
        $category = new self($name, $description, $id, $percent);

        return $category;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            $primitives['name'],
            $primitives['description'],
            $primitives['id'],
            $primitives['discountCode']['percent'] ?? null);
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

    public function setDiscountAssigned(int $percent): void
    {
        $this->percent = $percent;
    }

    public function getDiscountAssigned(): ?int
    {
        return $this->percent;
    }
}
