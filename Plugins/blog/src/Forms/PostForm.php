<?php

namespace Modules\Plugins\Blog\Forms;

use Assets;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Blog\Forms\Fields\CategoryMultiField;
use Modules\Plugins\Blog\Http\Requests\PostRequest;
use Modules\Plugins\Blog\Models\Post;
use Modules\Plugins\Blog\Repositories\Interfaces\CategoryInterface;
use Throwable;

class PostForm extends FormAbstract
{

    /**
     * @var string
     */
    protected $template = 'modules.base::forms.form-tabs';

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        Assets::addScripts(['bootstrap-tagsinput', 'typeahead'])
            ->addStyles(['bootstrap-tagsinput'])
            ->addScriptsDirectly('vendor/core/js/tags.js');

        $selectedCategories = [];
        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();
        }

        if (empty($selectedCategories)) {
            $selectedCategories = app(CategoryInterface::class)
                ->getModel()
                ->where('is_default', 1)
                ->pluck('id')
                ->all();
        }

        $tags = null;

        if ($this->getModel()) {
            $tags = $this->getModel()->tags()->pluck('name')->all();
            $tags = implode(',', $tags);
        }

        if (!$this->formHelper->hasCustomField('categoryMulti')) {
            $this->formHelper->addCustomField('categoryMulti', CategoryMultiField::class);
        }

        $this
            ->setupModel(new Post)
            ->setValidatorClass(PostRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
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
            ->add('is_featured', 'onOff', [
                'label'         => trans('modules.base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('content', 'editor', [
                'label'      => trans('modules.base::forms.content'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'            => 4,
                    'placeholder'     => trans('modules.base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('format_type', 'customRadio', [
                'label'      => trans('modules.plugins.blog::posts.form.format_type'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_post_formats(true),
            ])
            ->add('categories[]', 'categoryMulti', [
                'label'      => trans('modules.plugins.blog::posts.form.categories'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_categories_with_children(),
                'value'      => old('categories', $selectedCategories),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('modules.base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('tag', 'text', [
                'label'      => trans('modules.plugins.blog::posts.form.tags'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'       => 'form-control',
                    'id'          => 'tags',
                    'data-role'   => 'tagsinput',
                    'placeholder' => trans('modules.plugins.blog::posts.form.tags_placeholder'),
                ],
                'value'      => $tags,
                'help_block' => [
                    'text' => 'Tag route',
                    'tag'  => 'div',
                    'attr' => [
                        'data-tag-route' => route('tags.all'),
                        'class'          => 'hidden',
                    ],
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
