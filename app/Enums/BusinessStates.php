<?php

namespace App\Enums;

use Konekt\Enum\Enum;

class BusinessStates extends Enum
{
    const APPROVED = 'approved';
    const PENDING = 'pending';
    const DECLINED = 'declined';
    const SUSPENDED = 'suspended';
}
