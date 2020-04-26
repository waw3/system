<?php

namespace Modules\Plugins\Product\Tables;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Models\ProTag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Throwable;
use Yajra\DataTables\DataTables;

class ProTagTable extends TableAbstract
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
     * TagTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param TagInterface $tagRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ProTagInterface $protagRepository)
    {
        $this->repository = $protagRepository;
        $this->setOption('id', 'table-protags');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['protags.edit', 'protags.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return JsonResponse
     *
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('protags.edit')) {
                    return $item->name;
                }

                return anchor_link(route('protags.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('protags.edit', 'protags.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by table.
     *
     * @return \Illuminate\Database\Query\Builder|Builder
     *
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->select([
                'protags.id',
                'protags.name',
                'protags.created_at',
                'protags.status',
            ]);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
    }

    /**
     * @return array
     *
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id'         => [
                'name'  => 'protags.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'name'  => 'protags.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'status'     => [
                'name'  => 'protags.status',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
            'created_at' => [
                'name'  => 'protags.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     *
     * @throws Throwable
     * @since 2.1
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('protags.create'), 'protags.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Tag::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('protags.deletes'), 'protags.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'protags.name'       => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'protags.status'     => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:0,1',
            ],
            'protags.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
