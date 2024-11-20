<?php

namespace Vsw\Comment\Providers;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;
use Vsw\Comment\CommentFunc;
use Livewire\Livewire;
use File,Theme,CFglobal;

class CommentServiceProvider extends ServiceProvider
{
    protected $moduleName = 'News';
	/**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('comment', function () {
            return new CommentFunc();
        });

        Livewire::component('listcomment', \Vsw\Comment\Livewire\ListComment::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}