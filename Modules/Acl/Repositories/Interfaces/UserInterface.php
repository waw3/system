<?php

namespace Modules\Acl\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{

    /**
     * Get unique username from email
     *
     * @param $email
     * @return string
     *
     */
    public function getUniqueUsernameFromEmail($email);
}
