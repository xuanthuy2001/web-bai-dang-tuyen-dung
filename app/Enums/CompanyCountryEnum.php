<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CompanyCountryEnum extends Enum
{
    public const VN = 'Vietnam';
    public const US = 'United State';
    public const UK = 'United Kingdom';
    public const JP = 'Japan';
    public const CN = 'China';
    public const KR = 'Korea';
}
