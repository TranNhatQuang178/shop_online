<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Customer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        View::composer('*', function ($view) {
            if(session()->has('email')){
                $customer = Customer::where('email', session('email'))->first();
                $view->with('customer', $customer);
            }
        });
        $categoriesShow = Category::where('featured_category', 1)->where('parent_id', 0)->get();
        $pages = Page::where('status', 1)->orderBy('id', 'desc')->get();
        View::share(compact('categoriesShow', 'pages'));

    }
}
