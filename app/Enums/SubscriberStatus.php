<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SubscriberStatus extends Enum
{
    const ACTIVE = 'ACTIVE';
    const UNSUBSCRIBED = 'UNSUBSCRIBED';
    const JUNK = 'JUNK';
    const BOUNCED = 'BOUNCED';
    const UNCONFIRMED = 'UNCONFIRMED';
}
