<?php

namespace Chewbathra\Chewby;

use Chewbathra\Chewby\Facades\Config;
use Error;
use Illuminate\Support\Facades\Route;

class Chewby
{
    public function generateUrls(): void
    {
        $trackedModelsWithPath = Config::getTrackedModelsWithPath();
        $base = Config::getConfig('base')[0];
        if (! $base) {
            throw new Error('You need to define a base URL path for admin content in "config/chewby.php"');
        }
        foreach ($trackedModelsWithPath as $model => $path) {
            $controller = Config::getControllerForModel($model);
            // Index
            Route::get('/'.$base.'/'.$path, [$controller::class, 'index'])
                ->name($base.'.'.$path.'.'.'index');
            // Show
            Route::get('/'.$base.'/'.$path.'/{id}', [$controller::class, 'show'])
                ->name($base.'.'.$path.'.'.'show');
            // Delete
            Route::delete('/'.$base.'/'.$path.'/{id}', [$controller::class, 'delete'])
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
