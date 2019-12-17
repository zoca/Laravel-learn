<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Model\Page;

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
        Schema::defaultStringLength(191);

        $topLevelPages = Page::notdeleted()
            ->toplevel()
            ->active()
            ->orderbyordnum()
            ->get();
        //dd($topLevelPages);
        view()->share('pagesTopLevel', $topLevelPages);
    }
}
