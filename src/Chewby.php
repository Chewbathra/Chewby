<?php

namespace Chewbathra\Chewby;

use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Models\Model;
use Error;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Chewby
{
    private string $configFilename = 'chewby';

    /**
     * Generate route name for given model and action
     *
     * @param  Model  $model
     * @param  string  $action Can be one of theses: "index", "show", "delete", "update"
     * @return string
     */
    public function routeNameForModel(Model $model, string $action): string
    {
        $controllers = Config::getControllerForModel($model);
        $base = Config::getConfig('base')->first();

        return $base.'.'.$controllers->resourcePath.'.'.$action;
    }

    /**
     * Generate URLs for each tracked model
     *
     * @return void
     */
    public function generateUrls(): void
    {
        if (! config($this->configFilename)) {
            // Dont generate URLs when running chewby config file dont exist to prevent errors
            Log::channel('stderr')
                ->alert("Routes not generated because \"chewby\" config file doesn't exist.
                    This error is normal if you are running \"vendor:publish\" command !
                    If it is not the case, check that you have a published the chewby config file !");

            return;
        }
        $trackedModelsWithPath = Config::getTrackedModelsWithPath();
        $base = Config::getConfig('base');
        if (count($base) == 0 || ! is_string($base->first())) {
            throw new Error('You need to define a base URL path for admin content in "config/chewby.php"');
        }
        $base = $base->first();
        foreach ($trackedModelsWithPath as $model => $path) {
            $controller = Config::getControllerForModel($model);
            Route::middleware(StartSession::class)->group(function () use ($base, $path, $controller) {
                // Index
                Route::get('/'.$base.'/'.$path, [$controller::class, 'index'])
                    ->name($base.'.'.$path.'.'.'index');
                // Create
                Route::get('/'.$base.'/'.$path.'/create', [$controller::class, 'create'])
                    ->name($base.'.'.$path.'.'.'create');
                // Show
                Route::get('/'.$base.'/'.$path.'/{id}', [$controller::class, 'show'])
                    ->name($base.'.'.$path.'.'.'show');
                // Update
                Route::patch('/'.$base.'/'.$path.'/{id}', [$controller::class, 'update'])
                    ->name($base.'.'.$path.'.'.'update');
                // Create
                Route::post('/'.$base.'/'.$path, [$controller::class, 'create'])
                    ->name($base.'.'.$path.'.'.'create');
                // Delete
                Route::delete('/'.$base.'/'.$path.'/{id}', [$controller::class, 'destroy'])
                    ->name($base.'.'.$path.'.'.'delete');
            });
        }
    }
}
