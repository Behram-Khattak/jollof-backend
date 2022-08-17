<?php

namespace App\Enums;

use Konekt\Enum\Enum;

class DefaultRoles extends Enum
{
    const USER = 'user';
    const MERCHANT = 'merchant';
    const SUPER_ADMIN = 'super-admin';
    const DISPATCH = 'dispatch';
}
