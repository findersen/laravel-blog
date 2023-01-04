<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Observers\PostObserver;
use App\Observers\PostCategoryObserver;
use Illuminate\Support\ServiceProvider;

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
        Post::observe(PostObserver::class);
        PostCategory::observe(PostCategoryObserver::class);
    }
}
