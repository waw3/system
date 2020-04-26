<?php

namespace Modules\Plugins\Contact\Forms;

use Assets;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Contact\Enums\ContactStatusEnum;
use Modules\Plugins\Contact\Http\Requests\EditContactRequest;
use Modules\Plugins\Contact\Models\Contact;

class ContactForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {

        Assets::addScriptsDirectly('vendor/core/plugins/contact/js/contact.js')
            ->addStylesDirectly('vendor/core/plugins/contact/css/contact.css');

        $this
            ->setupModel(new Contact)
            ->setValidatorClass(EditContactRequest::class)
            ->withCustomFields()
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => ContactStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status')
            ->addMetaBoxes([
                'information' => [
                    'title'      => trans('modules.plugins.contact::contact.contact_information'),
                    'content'    => view('modules.plugins.contact::contact-info', ['contact' => $this->getModel()])->render(),
                    'attributes' => [
                        'style' => 'margin-top: 0',
                    ],
                ],
                'replies' => [
                    'title'      => trans('modules.plugins.contact::contact.replies'),
                    'content'    => view('modules.plugins.contact::reply-box', ['contact' => $this->getModel()])->render(),
                ],
            ]);
    }
}
