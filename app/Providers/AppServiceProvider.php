<?php

namespace App\Providers;

use App\View\Components\Post;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Paginator::useBootstrap();
        //Post là post của Components
        Blade::component('post', Post::class);
    }
}
