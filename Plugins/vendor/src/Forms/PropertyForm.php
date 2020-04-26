<?php

namespace Modules\Plugins\Vendor\Forms;

use Assets;
use Modules\Plugins\RealEstate\Forms\PropertyForm as BaseForm;
use Modules\Plugins\RealEstate\Models\Property;
use Modules\Plugins\Vendor\Forms\Fields\CustomEditorField;
use Modules\Plugins\Vendor\Forms\Fields\MultipleUploadField;
use Modules\Plugins\Vendor\Http\Requests\PropertyRequest;

class PropertyForm extends BaseForm
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {
        parent::buildForm();

        Assets::addScriptsDirectly('vendor/core/libraries/tinymce/tinymce.min.js');

        if (!$this->formHelper->hasCustomField('customEditor')) {
            $this->formHelper->addCustomField('customEditor', CustomEditorField::class);
        }

        if (!$this->formHelper->hasCustomField('multipleUpload')) {
            $this->formHelper->addCustomField('multipleUpload', MultipleUploadField::class);
        }

        $this
            ->setupModel(new Property)
            ->setFormOption('template', 'modules.plugins.vendor::forms.base')
            ->setFormOption('enctype', 'multipart/form-data')
            ->setValidatorClass(PropertyRequest::class)
            ->setActionButtons(view('modules.plugins.vendor::forms.actions')->render())
            ->remove('is_featured')
            ->remove('moderation_status')
            ->remove('content')
            ->remove('author_id')
            ->removeMetaBox('image')
            ->addAfter('description', 'content', 'customEditor', [
                'label'      => trans('modules.base::forms.content'),
                'label_attr' => ['class' => 'control-label required'],
            ])
            ->addAfter('content', 'images', 'multipleUpload', [
                'label'      => __('Images'),
                'label_attr' => ['class' => 'control-label'],
            ]);
    }
}
