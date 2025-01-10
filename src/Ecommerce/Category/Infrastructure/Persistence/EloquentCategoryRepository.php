<?php

namespace Core\Ecommerce\Category\Infrastructure\Persistence;

use function Lambdish\Phunctional\map;

use App\Models\Category as ModelsCategory;
use Core\Ecommerce\Category\Domain\Category;
use Core\Ecommerce\Category\Domain\CategoryRepository;

final class EloquentCategoryRepository implements CategoryRepository
{
    // private CacheService $cache;
    function __construct()
    {
    }
    public function save(Category $category): void
    {
        $model             = new ModelsCategory();
        $model->name       = $category->getName();
        $model->description   = $category->getDescription();

        $model->save();
    }

    public function update(Category $category): void
    {
        ModelsCategory::findOrFail($category->getId())->update(
            [
                'name' => $category->getName(),
                'description' => $category->getDescription()
            ]
        );
    }

    public function search(int $id): ?Category
    {

        $model = null;
        $model = ModelsCategory::with('discountCode')->find($id);
        if (null === $model) {
            return null;
        }
        return Category::fromPrimitives($model->toArray());
    }

    public function delete(Category $category): void
    {
        ModelsCategory::findOrFail($category->getId())->delete();
    }

    public function searchByName(string $name): ?Category   
    {

        $model = ModelsCategory::where("name", $name)->first();
        if (null === $model) {
            return null;
        }
        return Category::fromPrimitives($model->toArray());
    }

    public function searchWhereIn(array $category_ids): array
    {
        $collResult = [];

        $collResult = ModelsCategory::with('discountCode')->whereIn('id', $category_ids)->get()->toArray();

        return map($this->toCategory(), $collResult);
    }

    public function searchAll(): array
    {
        $collResult = [];
        $collResult = ModelsCategory::all()->toArray();

        return map($this->toCategory(), $collResult);
    }

    private function toCategory(): callable
    {
        return static fn (array $primitives) => Category::fromPrimitives($primitives);
    }
}
