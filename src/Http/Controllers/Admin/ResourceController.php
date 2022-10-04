<?php

namespace Chewbathra\Chewby\Http\Controllers\Admin;

use Chewbathra\Chewby\Facades\Chewby;
use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Models\Model;
use Illuminate\Contracts\View\View;
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

    protected const neededColumns = [
        'id' => [
            'label' => 'ID',
            'render' => null,
            "centered" => true
        ],
        'title' => [
            'label' => 'Title',
            'render' => null,
            "centered" => false
        ],
        'online' => [
            'label' => 'Online',
            'render' => [ResourceController::class, 'renderOnline'],
//            'centered' => true
        ],
        'online_from' => [
            'label' => 'Publication date',
            'render' => [ResourceController::class, 'renderOnlineFrom'],
            "centered" => true
        ],
    ];

    final public function __construct()
    {
        if (!isset($this->resourceName)) {
            throw new LogicException(get_class($this) . ' must have a $resourceName');
        }
        if (!isset($this->resourcePath)) {
            throw new LogicException(get_class($this) . ' must have a $resourcePath');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $class = get_class($this);
        $controllers = Config::getTrackedModelsWithControllers(true);
        $controllers = $controllers->flip();
        if (!$controllers->has($class)) {
            return back(404);
        }
        return view("chewby::models.index", [
            "resource" => $controllers[$class]
        ]);
    }

    /**
     * Return index column. Will automatically add needed columns to columns defined in $indexcolumns
     * @return array
     */
    public function getIndexColumns(): array
    {
        return array_merge(self::neededColumns, $this->indexColumns);
    }

    public static function renderOnline(Model $model): \Illuminate\View\View
    {
        /**
         * @phpstan-ignore-next-line
         */
        return view('chewby::components.status', [
            'attributes' => new ComponentAttributeBag(["online" => boolval($model->online)]),
        ]);
    }

    /**
     * @throws \Exception
     */
    public static function renderOnlineFrom(Model $model): string
    {
        return self::formatDateTime($model->online_from);
    }



}
