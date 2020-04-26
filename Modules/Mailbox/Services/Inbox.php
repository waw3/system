<?php

namespace Modules\Mailbox\Services;

use BeyondCode\Mailbox\InboundEmail;
use BeyondCode\Mailbox\Facades\Mailbox;
use Modules\Mailbox\Models\InboxEmail;

class Inbox
{
    public function __invoke(InboundEmail $email)
    {
        $InboxEmail = new InboxEmail();
        $InboxEmail->to = $email->to();
        $InboxEmail->from = $email->from();
        $InboxEmail->subject = $email->subject();
        $InboxEmail->body = $email->html();
        $InboxEmail->save();
    }

    /**
     * Get the default JavaScript variables for Inbox.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => mconfig('mailbox.config.inbox_path'),
        ];
    }
}
