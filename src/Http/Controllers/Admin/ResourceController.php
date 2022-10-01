<?php

namespace Chewbathra\Chewby\Http\Controllers\Admin;

use Chewbathra\Chewby\Facades\Chewby;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LogicException;

abstract class ResourceController extends Controller
{
    public string $resourceName;

    public string $resourcePath;

    /**
     * @var array<string, array<string, mixed>>
     */
    public array $indexColumns = [];

    const neededColumns = [
        'id' => [
            'label' => 'ID',
            'render' => null,
        ],
        'title' => [
            'label' => 'Title',
            'render' => null,
        ],
        'online' => [
            'label' => 'Online',
            'render' => [ResourceController::class, 'renderOnline'],
        ],
        'online_from' => [
            'label' => 'Publication date',
            'render' => [ResourceController::class, 'renderOnlineFrom'],
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
     * @phpstan-param view-string $view
     *
     * @param  Model  $model
     * @return \Illuminate\View\View
     */
    public static function renderOnline(Model $model)
    {
        return view('components.status', ['online' => $model->online]);
    }

    /**
     * @param  Model  $model
     * @return string
     */
    public static function renderOnlineFrom(Model $model)
    {
        if (! is_null($model->online_from)) {
            return self::formatDateTime($model->online_from);
        }

        return '';
    }

    /**
     * @param  string  $date
     * @return string
     */
    private static function formatDateTime(string $date)
    {
        // @phpstan-ignore-next-line
        return (new DateTime($date))->format(Chewby::getConfig('date_format'));
    }

    /**
     * @return Collection
     */
    protected function getBreadcrumbItems(): Collection
    {
        return collect([
            'Accueil' => route('admin.dashboard'),
        ]);
    }
}
