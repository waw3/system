<?php

namespace Modules\Plugins\Member\Tables;

use Modules\Plugins\Blog\Models\Post;
use Modules\Plugins\Member\Models\Member;
use Html;
use Illuminate\Support\Arr;

class PostTable extends \Modules\Plugins\Blog\Tables\PostTable
{
    /**
     * @var bool
     */
    public $hasActions = false;

    /**
     * @var bool
     */
    public $hasCheckbox = false;

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
                return anchor_link(route('public.member.posts.edit', $item->id), $item->name);
            })
            ->editColumn('image', function ($item) {
                return Html::image(get_object_image($item->image, 'thumb'), $item->name, ['width' => 50]);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('updated_at', function ($item) {
                return implode(', ', $item->categories->pluck('name')->all());
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                $edit = 'public.member.posts.edit';
                $delete = 'public.member.posts.destroy';

                return view('modules.plugins.member::table.actions', compact('edit', 'delete', 'item'))->render();
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * {@inheritdoc}
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->with(['categories'])
            ->select([
                'posts.id',
                'posts.name',
                'posts.image',
                'posts.created_at',
                'posts.status',
                'posts.updated_at',
            ])
            ->where([
                'posts.author_id'   => auth()->guard('member')->user()->getKey(),
                'posts.author_type' => Member::class,
            ]);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
    }

    /**
     * {@inheritdoc}
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('public.member.posts.create'), null);

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Post::class);
    }

    /**
     * @return array
     */
    public function columns()
    {
        $columns = parent::columns();
        Arr::forget($columns, 'author_id');

        return $columns;
    }

    /**
     * @return array
     */
    public function getDefaultButtons(): array
    {
        return ['reload'];
    }
}
