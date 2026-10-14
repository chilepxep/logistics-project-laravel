<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Schema;
use App\Models\CompanySetting;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Paginator::useBootstrapFive();
        
        View::composer('layouts.header', function ($view) {
            $categories = Category::with(['articles' => function($query) {
                $query->where('is_active', 1)->orderBy('created_at', 'desc');
            }])->get()->keyBy('slug'); 
            
            $view->with('dynamicCategories', $categories);
        });

        //Thông tin công ty
        if (Schema::hasTable('company_settings')) {
            $globalSetting = CompanySetting::first();
            View::share('globalSetting', $globalSetting);
        }

        // Chia sẻ danh sách tỷ giá cho mọi giao diện
    if (Schema::hasTable('exchange_rates')) {
        $exchangeRates = ExchangeRate::all();
        $defaultRate = $exchangeRates->where('is_default', 1)->first() ?? $exchangeRates->first();
        View::share('globalExchangeRates', $exchangeRates);
        View::share('defaultExchangeRate', $defaultRate);
    }

        
    }
}