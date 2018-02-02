<?php declare(strict_types=1);

namespace NetworkInterop;

interface IPv6Address
{
    /**
     * Returns the hextets of this address as an array of 8 integers in network order
     *
     * @return int[]
     */
    function getHextets(): array;
}
