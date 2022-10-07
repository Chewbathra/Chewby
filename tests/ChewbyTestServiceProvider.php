<?php

namespace Chewbathra\Chewby\Tests;

use Chewbathra\Chewby\Http\Livewire\Models\Row;
use Chewbathra\Chewby\Http\Livewire\Models\Table;
use DirectoryIterator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ChewbyTestServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/blade-lucide-icons.php', 'blade-lucide-icons'
        );
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
//        $this->bootLivewireComponents();
        $this->shareDataToView();
    }

    private function shareDataToView(): void
    {
        View::share('nav', [
            'testPost' => 'admin.testPosts.index',
            'testPost2' => 'admin.testPosts2.index',
        ]);
    }

    private function bootLivewireComponents(): void
    {
        Livewire::component('model-table', Table::class);
        Livewire::component('model-row', Row::class);
    }

    /**
     * @param  string  $directory
     * @param  bool  $recursively Search recursively in sub folder
     * @return void
     */
    private function bootComponents(string $directory, bool $recursively = false): void
    {
        foreach (new DirectoryIterator($directory) as $file) {
            $filename = $file->getFilename();
            if ($file->isDir()) {
                if (! in_array($filename, ['.', '..'])) {
                    $this->bootComponents($directory.'/'.$filename, $recursively);
                }
            } else {
                $componentName = explode('.', $filename)[0];
                Blade::component('chewby::'.$componentName, 'components.'.$componentName);
            }
        }
    }
}
