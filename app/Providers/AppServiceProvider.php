<?php

namespace App\Providers;

use Core\Ecommerce\Category\Domain\CategoryRepository;
use Core\Ecommerce\Category\Infrastructure\Persistence\EloquentCategoryRepository;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeRepository;
use Core\Ecommerce\DiscountCode\Infrastructure\Persistence\EloquentDiscountCodeRepository;
use Core\Ecommerce\Product\Domain\ProductRepository;
use Core\Ecommerce\Product\Infrastructure\Persistence\EloquentProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(DiscountCodeRepository::class, EloquentDiscountCodeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
