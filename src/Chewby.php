<?php

namespace Chewbathra\Chewby;

use Chewbathra\Chewby\Facades\Config;
use Error;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Chewby
{
    private string $configFilename = 'chewby';

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
            // Index
            Route::get('/'.$base.'/'.$path, [$controller::class, 'index'])
                ->middleware(StartSession::class)
                ->name($base.'.'.$path.'.'.'index');
            // Show
            Route::get('/'.$base.'/'.$path.'/{id}', [$controller::class, 'show'])
                ->middleware(StartSession::class)
                ->name($base.'.'.$path.'.'.'show');
            // Delete
            Route::delete('/'.$base.'/'.$path.'/{id}', [$controller::class, 'destroy'])
                ->middleware(StartSession::class)
                ->name($base.'.'.$path.'.'.'delete');
        }
    }
    /*
    public function handleRequest(Request $request)
    {
        $requestSegments = $request->segments();
        array_shift($requestSegments); //Remove "admin" segment
        $trackedModels = Config::getTrackedModelsWithPath();
        foreach($trackedModels as $model => $path) {
            if ($requestSegments[0] === $path) {
                if (count($requestSegments) > 1) {
                    if (count($requestSegments) > 2) {
                        return abort(404);
                    }
                    if (ctype_digit($requestSegments[1])) { //Test if second segment is a integer
                        return view("posts.show", ["post" => (new $model)->find($requestSegments[1])]);
                    }
                    return abort(404);
                }
                return ["posts.index", $model];
            }
        }
        return abort(404);
    }
    */
}
