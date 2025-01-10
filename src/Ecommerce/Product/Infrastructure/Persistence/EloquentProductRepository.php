<?php

namespace Core\Ecommerce\Product\Infrastructure\Persistence;

use function Lambdish\Phunctional\map;

use App\Models\Product as ModelsProduct;
use Core\Ecommerce\Category\Domain\Category;
use Core\Ecommerce\Product\Domain\Product;
use Core\Ecommerce\Product\Domain\ProductRepository;

final class EloquentProductRepository implements ProductRepository
{
    // private CacheService $cache;
    function __construct() {}

    public function save(Product $product): void
    {
        $model             = new ModelsProduct();
        $model->name       = $product->getName();
        $model->amount       = $product->getAmount();
        $model->description   = $product->getDescription();

        $collCategories = collect($product->getCategories());

        $categoryIds = $collCategories->pluck('id')->toArray();

        $model->save();
        $model->categories()->sync($categoryIds, false);
    }

    public function update(Product $product): void
    {
        $collCategories = collect($product->getCategories());
        $categoryIds = $collCategories->pluck('id')->toArray();

        $model = ModelsProduct::findOrFail($product->getId());

        $model->update(
            [
                'name' => $product->getName(),
                'amount' => $product->getAmount(),
                'description' => $product->getDescription()
            ]
        );
        $model->categories()->sync($categoryIds);
    }

    public function search(int $id): ?Product
    {
        $model = null;
        $model = ModelsProduct::with('categories.discountCode')->find($id);

        if (null === $model) {
            return null;
        }

        $categories = map(
            fn(array $category) => new Category(
                $category['name'],
                $category['description'],
                $category['id'],
                $category['discount_code']['percent'] ?? null
            ),
            $model->categories->toArray()
        );

        return new Product($model->name, $model->description, $model->amount, $categories, $model->id);
    }

    public function delete(Product $product): void
    {
        ModelsProduct::findOrFail($product->getId())->delete();
    }

    public function searchByName(string $productName): ?Product
    {

        $model = ModelsProduct::where("name", $productName)->first();
        if (null === $model) {
            return null;
        }
        return Product::fromPrimitives($model->toArray());
    }

    public function searchAll(): array
    {
        $models = [];
        $models = ModelsProduct::with('categories.discountCode')->get();

        $arrModels = map($this->toArrayFromModel(),$models);

        return map($this->toProduct(), $arrModels);
    }

    public function searchAllByIds(array $ids): array
    {
        $models = [];
        $models = ModelsProduct::with('categories.discountCode')
            ->whereIn("id", $ids)
            ->get();

        $arrModels = map($this->toArrayFromModel(),$models);

        return map($this->toProduct(), $arrModels);
    }

    private function toProduct(): callable
    {
        return static fn (array $primitives) => Product::fromPrimitives($primitives);
    }

    private function toArrayFromModel(): callable
    {
        return static fn(ModelsProduct $product) => [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'amount' => $product->amount,
            'categories' =>  map(
                fn(array $category) => new Category(
                    $category['name'],
                    $category['description'],
                    $category['id'],
                    $category['discount_code']['percent'] ?? null
                ),
                $product->categories->toArray()
            )
        ];
    }
}
