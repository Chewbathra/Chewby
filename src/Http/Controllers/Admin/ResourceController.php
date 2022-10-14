<?php

namespace Chewbathra\Chewby\Http\Controllers\Admin;

use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Models\Model;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\ComponentAttributeBag;
use LogicException;

abstract class ResourceController extends Controller
{
    public string $resourceName;

    public string $resourcePath;

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $indexColumns = [];

    final protected const neededColumns = [
        'id' => [
            'label' => 'ID',
            'render' => null,
            'centered' => true,
        ],
        'title' => [
            'label' => 'Title',
            'render' => null,
        ],
        'online' => [
            'label' => 'Online',
            'render' => [ResourceController::class, 'renderOnline'],
            'centered' => true,
        ],
        'online_from' => [
            'label' => 'Publication date',
            'render' => [ResourceController::class, 'renderOnlineFrom'],
            'centered' => true,
        ],
    ];

    final public function __construct()
    {
        if (! isset($this->resourceName)) {
            throw new LogicException(get_class($this).' must have a $resourceName');
        }
        if (! isset($this->resourcePath)) {
            throw new LogicException(get_class($this).' must have a $resourcePath');
        }
    }

    /**
     * Return attributes types of given model
     *
     * @param  Model  $model
     * @return Collection<string, string>
     */
    final public function getModelTypes(Model $model): Collection
    {
        $types = DB::table('chewby_types')->where('tableName', '=', $model->getTable())->get();

        /**
         * @var Collection<string, string>
         */
        return $types->mapWithKeys(function ($type) {
            return [$type->columnName => $type->columnType];
        });
    }

    /**
     * Return  model associated to this controller
     *
     * @param  bool  $asObject Return model as object or className
     * @return string|Model
     */
    final public function getModel(bool $asObject = false): string|Model
    {
        $class = get_class($this);
        /** @var Collection<string, string> $controllers */
        $controllers = Config::getTrackedModelsWithControllers(true);
        $controllers = $controllers->flip();
        if (! $controllers->has($class)) {
            throw new \Error('You try to index, show or delete from a controller that is not linked to a specific model');
        }

        return ! $asObject ? $controllers[$class] : new $controllers[$class]();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chewby::models.index', [
            'resource' => $this->getModel(),
        ]);
    }

    /**
     * Display and edit the specified resource.
     */
    public function show(int $id): View
    {
        /**
         * @var Model $model
         */
        $model = $this->getModel(true);
        $instance = $model->find($id);
        $types = $this->getModelTypes($model);

        return view('chewby::models.show', [
            'model' => $instance,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->all();
        $model = $this->getModel(true);
        $instance = $model->find($id);
        $types = $this->getModelTypes($model);
        // Verify boolean attributes (as checkbox) to set the value to 0 since "Resquest->all()" don't store checkbox value if they are not checked
        foreach ($types as $attribute => $type) {
            if ($type === 'boolean') {
                if (array_key_exists($attribute, $data)) {
                    $data[$attribute] = 1;
                } else {
                    $data[$attribute] = 0;
                }
            }
        }
        foreach ($instance->getAttributes() as $attribute => $value) {
            if (array_key_exists($attribute, $data) && $value !== $data[$attribute]) {
                $instance->$attribute = $data[$attribute];
            }
        }
        $instance->save();

        return back()->with('success', 'Model updated');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $model = new ($this->getModel())();
        dd('create', $model);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        /**
         * @var Model $model
         */
        $model = new($this->getModel())();
        $instance = $model->findOrFail($id);
        $instance->delete();

        return back()->with('success', 'Delete successful');
    }

    /**
     * Return index column. Will automatically add needed columns to columns defined in $indexcolumns
     *
     * @return array
     */
    final public function getIndexColumns(): array
    {
        return array_merge(self::neededColumns, $this->indexColumns);
    }

    public static function renderOnline(Model $model): \Illuminate\View\View
    {
        /**
         * @phpstan-ignore-next-line
         */
        return view('chewby::components.status', ['attributes' => new ComponentAttributeBag(['online' => boolval($model->online)])]);
    }

    /**
     * @throws \Exception
     */
    public static function renderOnlineFrom(Model $model): string
    {
        /**
         * @phpstan-ignore-next-line
         */
        return self::formatDateTime($model->online_from);
    }
}
