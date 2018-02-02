<?php declare(strict_types=1);

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
