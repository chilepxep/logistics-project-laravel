<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use App\Models\CompanySetting;


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
    }
}