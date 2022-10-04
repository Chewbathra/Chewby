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
        return $this->getTrackedModelsWithControllers()
            ->map(fn ($controller) => $controller->resourcePath);
    }

    /**
     * Return tracked models and associated controller
     *
     * @param  bool  $classNameForControllers Return controllers as className and not object
     * @return Collection Tracked models with paths
     */
    public function getTrackedModelsWithControllers(bool $classNameForControllers = false): Collection
    {
        $models = $this->getTrackedModels();

        /**
         * @var Collection<string, ResourceController>
         */
        return collect($models)
            ->combine($models)
            ->map(fn ($model) => $classNameForControllers ? $this->getControllerForModel($model)::class : $this->getControllerForModel($model));
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
