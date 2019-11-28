<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FieldType extends Enum
{
    const TYPE_DATE = 'DATE';
    const TYPE_NUMBER = 'NUMBER';
    const TYPE_STRING = 'STRING';
    const TYPE_BOOLEAN = 'BOOLEAN';
}
