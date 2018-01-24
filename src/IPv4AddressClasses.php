<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: chris.wright
 * Date: 27/12/2017
 * Time: 19:48
 */

namespace DaveRandom\Network;

use DaveRandom\Enum\Enum;

final class IPv4AddressClasses extends Enum
{
    const A = 0;
    const B = 1;
    const C = 2;
    const D = 3;
    const E = 4;
    const RESERVED = \PHP_INT_MAX;
}
