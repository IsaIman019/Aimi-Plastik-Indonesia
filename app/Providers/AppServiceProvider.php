<?php

namespace App\Providers;

use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $cartCount = Keranjang::where('user_id', Auth::id())
                    ->where(function ($q) {
                        $q->whereNull('status')
                        ->orWhere('status', 'Belum Checkout');
                    })
                    ->sum('qty');

                $view->with('cartCount', $cartCount);
            } else {
                $view->with('cartCount', 0);
            }
        });


   
    }
}
