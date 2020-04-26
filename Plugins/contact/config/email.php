<?php

return [
    'name'        => 'modules.plugins.contact::contact.settings.email.title',
    'description' => 'modules.plugins.contact::contact.settings.email.description',
    'templates'   => [
        'notice' => [
            'title'       => 'modules.plugins.contact::contact.settings.email.templates.notice_title',
            'description' => 'modules.plugins.contact::contact.settings.email.templates.notice_description',
            'subject'     => 'New contact from your site',
            'can_off'     => true,
        ],
    ],
];