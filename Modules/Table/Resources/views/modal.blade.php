@include('modules.table::partials.modal-item', [
    'type' => 'danger',
    'name' => 'modal-confirm-delete',
    'title' => trans('modules.base::tables.confirm_delete'),
    'content' => trans('modules.base::tables.confirm_delete_msg'),
    'action_name' => trans('modules.base::tables.delete'),
    'action_button_attributes' => [
        'class' => 'delete-crud-entry',
    ],
])

@include('modules.table::partials.modal-item', [
    'type' => 'danger',
    'name' => 'delete-many-modal',
    'title' => trans('modules.base::tables.confirm_delete'),
    'content' => trans('modules.base::tables.confirm_delete_many_msg'),
    'action_name' => trans('modules.base::tables.delete'),
    'action_button_attributes' => [
        'class' => 'delete-many-entry-button',
    ],
])

@include('modules.table::partials.modal-item', [
    'type' => 'info',
    'name' => 'modal-bulk-change-items',
    'title' => trans('modules.base::tables.bulk_changes'),
    'content' => '<div class="modal-bulk-change-content"></div>',
    'action_name' => trans('modules.base::tables.submit'),
    'action_button_attributes' => [
        'class' => 'confirm-bulk-change-button',
        'data-load-url' => route('tables.bulk-change.data'),
    ],
])