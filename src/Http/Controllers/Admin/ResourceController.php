<?php

namespace Chewbathra\Chewby\Http\Controllers\Admin;

use Chewbathra\Chewby\Facades\Chewby;
use Chewbathra\Chewby\Models\Model;
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

    public static function renderOnline(Model $model): string
    {
        /**
         * @phpstan-ignore-next-line
         */
        return view('components.status', ['online' => $model->online]);
    }

    /**
     * @throws \Exception
     */
    public static function renderOnlineFrom(Model $model): string
    {
        return self::formatDateTime($model->online_from);
    }

    /**
     * @throws \Exception
     */
    private static function formatDateTime(string|\DateTime $date): string
    {
        // @phpstan-ignore-next-line
        return (new \DateTime($date))->format(Chewby::getConfig('date_format'));
    }
}
