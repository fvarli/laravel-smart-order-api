<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\CustomerRepository;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Services\DiscountService;
use App\Services\Discounts\Strategies\CategoryMultipleItemsDiscount;
use App\Services\Discounts\Strategies\CategoryQuantityDiscount;
use App\Services\Discounts\Strategies\TotalAmountDiscount;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register repositories
        $this->app->bind(OrderRepositoryInterface::class, function ($app) {
            return new OrderRepository(new Order());
        });

        $this->app->bind(ProductRepositoryInterface::class, function ($app) {
            return new ProductRepository(new Product());
        });

        $this->app->bind(CustomerRepositoryInterface::class, function ($app) {
            return new CustomerRepository(new Customer());
        });

        // Register discount service with strategies
        $this->app->singleton(DiscountService::class, function ($app) {
            $strategies = [
                new CategoryQuantityDiscount(),
                new CategoryMultipleItemsDiscount(),
                new TotalAmountDiscount(),
            ];

            return new DiscountService(
                $app->make(OrderRepositoryInterface::class),
                $strategies
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
