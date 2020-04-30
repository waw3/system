<?php

namespace Modules\Plugins\RealEstate\Tables;

use Modules\Plugins\RealEstate\Enums\ModerationStatusEnum;
use Modules\Plugins\RealEstate\Enums\PropertyStatusEnum;
use Modules\Plugins\RealEstate\Models\Property;
use Modules\Plugins\RealEstate\Repositories\Interfaces\PropertyInterface;
use Modules\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\DataTables;

class PropertyTable extends TableAbstract
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
     * @param PropertyInterface $propertyRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        PropertyInterface $propertyRepository
    ) {
        $this->repository = $propertyRepository;
        $this->setOption('id', 'table-plugins-real-estate-property');
        parent::__construct($table, $urlGenerator);
    }

    /**
     * Display ajax response.
     *
     * @return JsonResponse
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                return anchor_link(route('property.edit', $item->id), $item->name);
            })
            ->editColumn('image', function ($item) {
                return Html::image(get_object_image($item->image, 'thumb'), $item->name, ['width' => 50]);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->editColumn('moderation_status', function ($item) {
                return $item->moderation_status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('property.edit', 'property.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by table.
     *
     * @return \Illuminate\Database\Query\Builder|Builder
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model->select([
            're_properties.id',
            're_properties.name',
            're_properties.images',
            're_properties.status',
            're_properties.moderation_status',
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
                'name' => 're_properties.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'image' => [
                'name' => 're_properties.image',
                'title' => trans('modules.base::tables.image'),
                'width' => '60px',
                'class' => 'no-sort',
                'orderable' => false,
                'searchable' => false,
            ],
            'name' => [
                'name' => 're_properties.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'status' => [
                'name' => 're_properties.status',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
            'moderation_status' => [
                'name' => 're_properties.moderation_status',
                'title' => trans('modules.plugins.real-estate::property.moderation_status'),
                'width' => '150px',
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
        $buttons = $this->addCreateButton(route('property.create'), 'property.create');

        return apply_filters('base_filter_datatables_buttons', $buttons, Property::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('property.deletes'), 'property.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            're_properties.name' => [
                'title' => trans('modules.base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            're_properties.status' => [
                'title' => trans('modules.base::tables.status'),
                'type' => 'select',
                'choices' => PropertyStatusEnum::labels(),
                'validate' => 'required|' . Rule::in(PropertyStatusEnum::values()),
            ],
            're_properties.moderation_status' => [
                'title' => trans('modules.plugins.real-estate::property.moderation_status'),
                'type' => 'select',
                'choices' => ModerationStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', ModerationStatusEnum::values()),
            ],
            're_properties.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type' => 'date',
            ],
        ];
    }
}
