<?php

namespace Modules\Plugins\Contact\Http\Controllers;

use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Supports\EmailHandler;
use Modules\Plugins\Contact\Http\Requests\ContactRequest;
use Modules\Plugins\Contact\Repositories\Interfaces\ContactInterface;
use Modules\Setting\Supports\SettingStore;
use Exception;
use Illuminate\Routing\Controller;
use MailVariable;

class PublicController extends Controller
{
    /**
     * @var ContactInterface
     */
    protected $contactRepository;

    /**
     * @param ContactInterface $contactRepository
     */
    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param ContactRequest $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @param EmailHandler $emailHandler
     * @return BaseHttpResponse
     * @throws \Throwable
     */
    public function postSendContact(
        ContactRequest $request,
        BaseHttpResponse $response,
        SettingStore $setting,
        EmailHandler $emailHandler
    )
    {
        try {
            $contact = $this->contactRepository->getModel();
            $contact->fill($request->input());
            $this->contactRepository->createOrUpdate($contact);

            if ($setting->get('plugins_contact_notice_status')) {
                MailVariable::setModule(CONTACT_MODULE_SCREEN_NAME)
                    ->setVariableValues([
                        'contact_name'    => $contact->name ?? 'N/A',
                        'contact_subject' => $contact->subject ?? 'N/A',
                        'contact_email'   => $contact->email ?? 'N/A',
                        'contact_phone'   => $contact->phone ?? 'N/A',
                        'contact_address' => $contact->address ?? 'N/A',
                        'contact_content' => $contact->content ?? 'N/A',
                    ]);

                $content = get_setting_email_template_content('plugins', 'contact', 'notice');

                $emailHandler->send($content, $setting->get('plugins_contact_notice_subject', config('modules.plugins.contact.email.templates.notice.subject')));
            }

            return $response->setMessage(trans('modules.plugins.contact::contact.email.success'));
        } catch (Exception $ex) {
            info($ex->getMessage());
            return $response
                ->setError()
                ->setMessage(trans('modules.plugins.contact::contact.email.failed'));
        }
    }
}
