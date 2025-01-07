<?php

namespace Core\Ecommerce\DiscountCode\Infrastructure\Persistence;

use function Lambdish\Phunctional\map;

use App\Models\DiscountCode as ModelsDiscountCode;
use Core\Ecommerce\DiscountCode\Domain\DiscountCode;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeRepository;

final class EloquentDiscountCodeRepository implements DiscountCodeRepository
{
    // private CacheService $cache;
    function __construct()
    {
    }

    public function save(DiscountCode $discountCode): void
    {
        $model             = new ModelsDiscountCode();
        $model->name       = $discountCode->getName();
        $model->percent    = $discountCode->getPercent();
        $model->category_id = $discountCode->getCategoryId();

        $model->save();
    }

    public function update(DiscountCode $discountCode): void
    {
        ModelsDiscountCode::findOrFail($discountCode->getId())->update(
            [
                'name' => $discountCode->getName(),
                'percent' => $discountCode->getPercent(),
                'category_id' => $discountCode->getCategoryId(),
            ]
        );
    }

    public function search(int $id): ?DiscountCode
    {

        $model = null;
        $model = ModelsDiscountCode::find($id);
        if (null === $model) {
            return null;
        }
        return DiscountCode::fromPrimitives($model->toArray());
    }

    public function delete(DiscountCode $discountCode): void
    {
        ModelsDiscountCode::findOrFail($discountCode->getId())->delete();
    }

    public function searchByName(string $discountCodeName): ?DiscountCode
    {

        $model = ModelsDiscountCode::where("name", $discountCodeName)->first();
        if (null === $model) {
            return null;
        }
        return DiscountCode::fromPrimitives($model->toArray());
    }

    public function searchAll(): array
    {
        $collResult = [];
        $collResult = ModelsDiscountCode::all()->toArray();

        return map($this->toDiscountCode(), $collResult);
    }

    private function toDiscountCode(): callable
    {
        return static fn (array $primitives) => DiscountCode::fromPrimitives($primitives);
    }
}
