<?php

namespace Chewbathra\Chewby;

use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Config
{
    private string $controllersNamespace = 'App\\Http\\Controllers\\Admin\\';

    /**
     * Return config array, transformed to Laravel Collection
     *
     * @param  string  $element Chewby subconfig element to load
     * @return Collection<int, mixed>
     */
    public function getConfig(string $element): Collection
    {
        return collect(config('chewby.'.$element));
    }

    /**
     * Return tracked models
     *
     * @return Collection<int, string> Tracked models
     */
    public function getTrackedModels(): Collection
    {
        return $this->getConfig('models');
    }

    /**
     * Return tracked models and associated url path
     *
     * @return Collection<string, string> Tracked models with paths
     */
    public function getTrackedModelsWithPath(): Collection
    {
        $models = $this->getTrackedModels();

        return collect($models)
            ->combine($models)
            ->map(fn ($model) => $this->getControllerForModel($model)->resourcePath);
    }

    /**
     * Return associated controller of given model
     *
     * @param  string|Model  $model Model classname or Model object
     * @return ResourceController
     */
    public function getControllerForModel(string|Model $model): ResourceController
    {
        $controllers = $this->getConfig('controllers');
        if ($model instanceof Model) {
            if ($controllers->has($model::class)) {
                return new $controllers[$model::class]();
            }
        } else {
            if ($controllers->has($model)) {
                return new $controllers[$model]();
            }
        }
        $modelBasename = class_basename($model);
        $controllerClassName = $this->controllersNamespace.$modelBasename.'Controller';

        if (! class_exists($controllerClassName)) {
            throw new \Error("The model \"$model\" has been 
            marked as tracked but there is no associated controller
            \"$controllerClassName\". Create it or change the associated controller in the array
            \"controllers\" in \"config/chewby.php\".");
        }

        return new $controllerClassName();
    }
}
