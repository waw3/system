<?php

namespace Modules\Member\Forms;

use Assets;
use Modules\Blog\Models\Post;
use Modules\Member\Forms\Fields\CustomEditorField;
use Modules\Member\Forms\Fields\CustomImageField;
use Modules\Member\Http\Requests\PostRequest;

class PostForm extends \Modules\Blog\Forms\PostForm
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {
        parent::buildForm();

        Assets::addScriptsDirectly('vendor/core/libraries/tinymce/tinymce.min.js')
            ->addScripts(['bootstrap-tagsinput', 'typeahead'])
            ->addStyles(['bootstrap-tagsinput'])
            ->addScriptsDirectly('vendor/core/js/tags.js');

        if (!$this->formHelper->hasCustomField('customEditor')) {
            $this->formHelper->addCustomField('customEditor', CustomEditorField::class);
        }

        if (!$this->formHelper->hasCustomField('customImage')) {
            $this->formHelper->addCustomField('customImage', CustomImageField::class);
        }

        $tags = null;

        if ($this->getModel()) {
            $tags = $this->getModel()->tags()->pluck('name')->all();
            $tags = implode(',', $tags);
        }

        $this
            ->setupModel(new Post)
            ->setFormOption('template', 'modules.member::forms.base')
            ->setFormOption('enctype', 'multipart/form-data')
            ->setValidatorClass(PostRequest::class)
            ->setActionButtons(view('modules.member::forms.actions')->render())
            ->remove('status')
            ->remove('is_featured')
            ->remove('content')
            ->remove('image')
            ->addAfter('description', 'content', 'customEditor', [
                'label'      => trans('modules.base::forms.content'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->addBefore('tag', 'image', 'customImage', [
                'label'      => trans('modules.base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->modify('tag', 'text', [
                'label'      => trans('modules.blog::posts.form.tags'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'       => 'form-control',
                    'id'          => 'tags',
                    'data-role'   => 'tagsinput',
                    'placeholder' => trans('modules.blog::posts.form.tags_placeholder'),
                ],
                'value'      => $tags,
                'help_block' => [
                    'text' => 'Tag route',
                    'tag'  => 'div',
                    'attr' => [
                        'data-tag-route' => route('public.member.tags.all'),
                        'class'          => 'hidden',
                    ],
                ],
            ], true)
            ->setBreakFieldPoint('format_type');
    }
}
