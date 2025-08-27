<?php declare(strict_types=1);

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
    const string Pending = 'pending';
    const string Confirm = 'confirm';
    const string cancelled = 'cancelled';
    const string completed = 'completed';
}
