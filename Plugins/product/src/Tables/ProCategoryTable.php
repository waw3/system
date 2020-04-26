<?php

namespace Modules\Plugins\Product\Tables;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Models\ProCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Throwable;
use Yajra\DataTables\DataTables;

class ProCategoryTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $useDefaultSorting = false;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * CategoryTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ProCategoryInterface $procategoryRepository)
    {
        $this->repository = $procategoryRepository;
        $this->setOption('id', 'table-procategories');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['procategories.edit', 'procategories.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return JsonResponse
     *
     * @throws Exception
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->of($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('procategories.edit')) {
                    return $item->name;
                }

                return anchor_link(route('procategories.edit', $item->id), $item->indent_text . ' ' . $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('updated_at', function ($item) {
                return date_from_database($item->updated_at, 'd-m-Y');
            })
            ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            })
            ->removeColumn('is_default');

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return view('modules.plugins.product::procategories.actions', compact('item'))->render();
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by table.
     *
     * @return Collection
     *
     * @since 2.1
     */
    public function query()
    {
        return collect(get_procategories([]));
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
                'name'  => 'id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'name'  => 'name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'updated_at' => [
                'name'  => 'updated_at',
                'title' => trans('modules.base::tables.updated_at'),
                'width' => '100px',
            ],
            'status'     => [
                'name'  => 'status',
                'title' => trans('modules.base::tables.status'),
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
        $buttons = $this->addCreateButton(route('procategories.create'), 'procategories.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, ProCategory::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('procategories.deletes'), 'procategories.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'procategories.name'       => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'procategories.status'     => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:0,1',
            ],
            'procategories.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
