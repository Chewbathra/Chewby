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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'chewby');
        $this->publishes([
            __DIR__.'/../config/chewby.php' => config_path('chewby.php'),
        ]);

        $this->bootComponents("./resources/views/components");
    }

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
