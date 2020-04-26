<?php

namespace Modules\Plugins\Contact\Tables;

use Modules\Plugins\Contact\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Modules\Plugins\Contact\Enums\ContactStatusEnum;
use Modules\Plugins\Contact\Repositories\Interfaces\ContactInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ContactTable extends TableAbstract
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
     * ContactTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param ContactInterface $contactRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ContactInterface $contactRepository)
    {
        $this->repository = $contactRepository;
        $this->setOption('id', 'table-contacts');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['contacts.edit', 'contacts.destroy'])) {
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
                if (!Auth::user()->hasPermission('contacts.edit')) {
                    return $item->name;
                }

                return anchor_link(route('contacts.edit', $item->id), $item->name);
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
                return table_actions('contacts.edit', 'contacts.destroy', $item);
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
                'contacts.id',
                'contacts.name',
                'contacts.phone',
                'contacts.email',
                'contacts.created_at',
                'contacts.status',
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
                'name'  => 'contacts.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'name'  => 'contacts.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'email'      => [
                'name'  => 'contacts.email',
                'title' => trans('modules.plugins.contact::contact.tables.email'),
                'class' => 'text-left',
            ],
            'phone'      => [
                'name'  => 'contacts.phone',
                'title' => trans('modules.plugins.contact::contact.tables.phone'),
            ],
            'created_at' => [
                'name'  => 'contacts.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status'    => [
                'name'  => 'contacts.status',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     *
     * @since 2.1
     */
    public function buttons()
    {
        return apply_filters(BASE_FILTER_TABLE_BUTTONS, [], Contact::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('contacts.deletes'), 'contacts.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'contacts.name'       => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'contacts.email'      => [
                'title'    => trans('modules.base::tables.email'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'contacts.phone'      => [
                'title'    => trans('modules.plugins.contact::contact.sender_phone'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'contacts.status'    => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => ContactStatusEnum::labels(),
                'validate' => 'required|' . Rule::in(ContactStatusEnum::values()),
            ],
            'contacts.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}