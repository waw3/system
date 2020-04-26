<?php

namespace Modules\Plugins\Blog\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Blog\Http\Requests\CategoryRequest;
use Modules\Plugins\Blog\Models\Category;
use Throwable;

class CategoryForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $list = get_categories();

        $categories = [];
        foreach ($list as $row) {
            if ($this->getModel() && $this->model->id === $row->id) {
                continue;
            }

            $categories[$row->id] = $row->indent_text . ' ' . $row->name;
        }
        $categories = [0 => trans('modules.plugins.blog::categories.none')] + $categories;

        $this
            ->setupModel(new Category)
            ->setValidatorClass(CategoryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('parent_id', 'select', [
                'label'      => trans('modules.base::forms.parent'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'select-search-full',
                ],
                'choices'    => $categories,
            ])
            ->add('description', 'textarea', [
                'label'      => trans('modules.base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('modules.base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('is_default', 'onOff', [
                'label'         => trans('modules.base::forms.is_default'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('icon', 'text', [
                'label'      => trans('modules.base::forms.icon'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => 'Ex: fa fa-home',
                    'data-counter' => 60,
                ],
            ])
            ->add('order', 'number', [
                'label'         => trans('modules.base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'placeholder' => trans('modules.base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('modules.base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
