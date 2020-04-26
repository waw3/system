<?php

namespace Modules\Acl\Repositories\Eloquent;

use Modules\Acl\Repositories\Interfaces\UserInterface;
use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;

class UserRepository extends RepositoriesAbstract implements UserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUniqueUsernameFromEmail($email)
    {
        $emailPrefix = substr($email, 0, strpos($email, '@'));
        $username = $emailPrefix;
        $offset = 1;
        while ($this->getFirstBy(['username' => $username])) {
            $username = $emailPrefix . $offset;
            $offset++;
        }

        $this->resetModel();

        return $username;
    }
}
