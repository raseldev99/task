<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Confirm()
 * @method static static Cancelled()
 * @method static static Completed()
 */
final class BookingStatus extends Enum
{
    const  Pending = 'pending';

    const  Confirm = 'confirm';

    const  cancelled = 'cancelled';

    const  completed = 'completed';
}
