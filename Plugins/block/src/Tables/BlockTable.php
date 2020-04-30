<?php

namespace Modules\Plugins\Block\Tables;

use Modules\Plugins\Block\Models\Block;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Block\Repositories\Interfaces\BlockInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class BlockTable extends TableAbstract
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
     * BlockTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param BlockInterface $blockRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, BlockInterface $blockRepository)
    {
        $this->repository = $blockRepository;
        $this->setOption('id', 'table-static-blocks');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['block.edit', 'block.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('block.edit')) {
                    return $item->name;
                }

                return anchor_link(route('block.edit', $item->id), $item->name);
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

        if (function_exists('shortcode')) {
            $data = $data->editColumn('alias', function ($item) {
                return generate_shortcode('static-block', ['alias' => $item->alias]);
            });
        }

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('block.edit', 'block.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by the table.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     *
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->select([
                'blocks.id',
                'blocks.alias',
                'blocks.name',
                'blocks.created_at',
                'blocks.status',
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
                'name'  => 'blocks.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'name'  => 'blocks.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'alias'      => [
                'name'  => 'blocks.alias',
                'title' => trans('modules.base::tables.shortcode'),
            ],
            'created_at' => [
                'name'  => 'blocks.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status'     => [
                'name'  => 'blocks.status',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     *
     * @throws \Throwable
     * @since 2.1
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('block.create'), 'block.create');

        return apply_filters('base_filter_datatables_buttons', $buttons, Block::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('block.deletes'), 'block.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'blocks.name'       => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'blocks.status'     => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|' . Rule::in(BaseStatusEnum::values()),
            ],
            'blocks.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
