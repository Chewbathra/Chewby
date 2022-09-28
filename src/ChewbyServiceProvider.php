<?php

namespace Chewbathra\Chewby;

use DirectoryIterator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ChewbyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/chewby.php' => config_path('chewby.php'),
        ], 'chewby-config');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'chewby');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/chewby'),
        ], 'chewby-views');
        $this->bootComponents(__DIR__.'/../resources/views/components');
    }

    /**
     * @param  string  $directory
     * @return void
     */
    private function bootComponents(string $directory): void
    {
        foreach (new DirectoryIterator($directory) as $file) {
            $filename = $file->getFilename();
            if (! in_array($filename, ['.', '..'])) {
                $componentName = explode('.', $filename)[0];
                Blade::component('chewby::'.$componentName, 'components.'.$componentName);
            }
        }
    }
}
