<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: chris.wright
 * Date: 27/12/2017
 * Time: 19:48
 */

namespace DaveRandom\Network;

final class IPv4AddressClasses
{
    public const A = 0;
    public const B = 1;
    public const C = 2;
    public const D = 3;
    public const E = 4;
    public const RESERVED = \PHP_INT_MAX;

    private function __construct() { }
}
