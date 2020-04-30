<?php

namespace Modules\Plugins\Product\Tables;

use Auth;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Repositories\Interfaces\FeaturesInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Modules\Plugins\Product\Models\Features;

class FeaturesTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * FeaturesTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlDevTool
     * @param FeaturesInterface $featuresRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlDevTool, FeaturesInterface $featuresRepository)
    {
        $this->repository = $featuresRepository;
        $this->setOption('id', 'table-plugins-features');
        parent::__construct($table, $urlDevTool);

        if (!Auth::user()->hasAnyPermission(['features.edit', 'features.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('features.edit')) {
                    return $item->name;
                }
                return anchor_link(route('features.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('features.edit', 'features.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by table.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model->select([
            'features.id',
            'features.name',
            'features.created_at',
            'features.status',
        ]);

        return $this->applyScopes(apply_filters('base_filter_datatables_query', $query, $model));
    }

    /**
     * @return array
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'features.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'features.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'features.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'features.status',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     * @since 2.1
     * @throws \Throwable
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('features.create'), 'features.create');

        return apply_filters('base_filter_datatables_buttons', $buttons, Features::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('features.deletes'), 'features.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'features.name' => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'features.status' => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'features.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
