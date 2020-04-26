<?php

namespace Modules\Plugins\Impersonate\Models;

use Modules\ACL\Models\User as BaseUser;
use Lab404\Impersonate\Models\Impersonate;

class User extends BaseUser
{
    use Impersonate;
}
