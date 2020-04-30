<?php

namespace Modules\Plugins\Blog\Tables;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Blog\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Plugins\Blog\Repositories\Interfaces\TagInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Throwable;
use Yajra\DataTables\DataTables;

class TagTable extends TableAbstract
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
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, TagInterface $tagRepository)
    {
        $this->repository = $tagRepository;
        $this->setOption('id', 'table-tags');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['tags.edit', 'tags.destroy'])) {
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
                if (!Auth::user()->hasPermission('tags.edit')) {
                    return $item->name;
                }

                return anchor_link(route('tags.edit', $item->id), $item->name);
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
                return table_actions('tags.edit', 'tags.destroy', $item);
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
                'tags.id',
                'tags.name',
                'tags.created_at',
                'tags.status',
            ]);

        return $this->applyScopes(apply_filters('base_filter_datatables_query', $query, $model));
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
                'name'  => 'tags.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'name'  => 'tags.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'status'     => [
                'name'  => 'tags.status',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
            'created_at' => [
                'name'  => 'tags.created_at',
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
        $buttons = $this->addCreateButton(route('tags.create'), 'tags.create');

        return apply_filters('base_filter_datatables_buttons', $buttons, Tag::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('tags.deletes'), 'tags.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'tags.name'       => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'tags.status'     => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:0,1',
            ],
            'tags.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
