<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Admin()
 * @method static static User()
 */
final class Roles extends Enum
{
    const Admin = 'admin';

    const User = 'user';
}
