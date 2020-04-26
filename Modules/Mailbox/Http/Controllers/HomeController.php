<?php

namespace Modules\Mailbox\Http\Controllers;

use Modules\Mailbox\Services\Inbox;
use BaseController;

class HomeController extends BaseController
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inbox::layout', [
            'inboxScriptVariables' => Inbox::scriptVariables(),
        ]);
    }
}
