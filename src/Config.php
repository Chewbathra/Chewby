<?php

namespace Chewbathra\Chewby;

use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;
use Chewbathra\Chewby\Models\Model;
use Illuminate\Support\Collection;

class Config
{
    private string $controllersNamespace = 'App\\Http\\Controllers\\Admin\\';

    private string $configFilename = 'chewby';

    /**
     * Return config array, transformed to Laravel Collection
     *
     * @param  string  $element Chewby subconfig element to load
     * @return Collection<int, mixed>
     */
    public function getConfig(string $element): Collection
    {
        /** @var array<int, mixed> $config */
        $config = config($this->configFilename.'.'.$element);

        return collect($config);
    }

    /**
     * Return tracked models
     *
     * @param  bool  $asObject Define if model are returned as classname or object
     * @return Collection<int, class-string<Model> | Model> Tracked models
     */
    public function getTrackedModels(bool $asObject = false): Collection
    {
        if (! $asObject) {
            return $this->getConfig('models');
        } else {
            /**
             * @var Collection<int, class-string<Model> | Model>
             */
            return $this->getConfig('models')->map(fn ($model) => (new $model()));
        }
    }

    /**
     * Return tracked models and associated url path
     *
     * @return Collection<string, string> Tracked models with paths
     */
    public function getTrackedModelsWithPath(): Collection
    {
        return $this->getTrackedModelsWithControllers()
            ->map(fn ($controller) => $controller->resourcePath);
    }

    /**
     * Return tracked models and associated controller
     *
     * @param  bool  $controllersAsClassName Define if controllers are returned as classname or object
     * @return Collection<string, class-string<ResourceController>|ResourceController> Tracked models with paths
     */
    public function getTrackedModelsWithControllers(bool $controllersAsClassName = false): Collection
    {
        $models = $this->getTrackedModels();
        /**
         * @var Collection<string, class-string<ResourceController>|ResourceController>
         */
        return $models
            ->combine($models)
            ->map(fn ($model) => $controllersAsClassName ? $this->getControllerForModel($model)::class : $this->getControllerForModel($model));
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
