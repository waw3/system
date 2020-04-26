<?php

namespace Modules\Plugins\CustomField\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\CustomField\Http\Requests\CreateFieldGroupRequest;
use Modules\Plugins\CustomField\Models\CustomField as CustomFieldModel;
use Modules\Plugins\CustomField\Repositories\Interfaces\FieldGroupInterface;
use CustomField;
use Throwable;

class CustomFieldForm extends FormAbstract
{

    /**
     * @var FieldGroupInterface
     */
    protected $fieldGroupRepository;

    /**
     * CustomFieldForm constructor.
     * @param FieldGroupInterface $fieldGroupRepository
     * @throws Throwable
     */
    public function __construct(FieldGroupInterface $fieldGroupRepository)
    {
        $this->fieldGroupRepository = $fieldGroupRepository;
        parent::__construct();
    }

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $customFieldItems = [];
        if ($this->getModel()) {
            $customFieldItems = $this->fieldGroupRepository->getFieldGroupItems($this->getModel()->id);
            $this->setActionButtons(view('modules.plugins.custom-field::actions', ['object' => $this->getModel()])->render());
        }
        $this
            ->setupModel(new CustomFieldModel)
            ->setValidatorClass(CreateFieldGroupRequest::class)
            ->setFormOption('class', 'form-update-field-group')
            ->withCustomFields()
            ->add('title', 'text', [
                'label'      => trans('modules.base::forms.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 120,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('order', 'number', [
                'label'         => trans('modules.base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'placeholder' => trans('modules.base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->setBreakFieldPoint('status')
            ->addMetaBoxes([
                'rules'            => [
                    'title'   => trans('modules.plugins.custom-field::base.form.rules.rules'),
                    'content' => view('modules.plugins.custom-field::rules', [
                        'object'           => $this->getModel(),
                        'customFieldItems' => json_encode($customFieldItems),
                        'rules_template'   => CustomField::renderRules(),
                    ])->render(),
                ],
                'field-items-list' => [
                    'title'   => trans('modules.plugins.custom-field::base.form.field_items_information'),
                    'content' => view('modules.plugins.custom-field::field-items-list')->render(),
                ],
            ]);
    }
}
