<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Published()
 * @method static static Draft()
 * @method static static Archived()
 */
final class ServiceStatus extends Enum
{
    const  Published = 'published';
    const  Draft = 'draft';

    const  Archived = 'archived';
}
