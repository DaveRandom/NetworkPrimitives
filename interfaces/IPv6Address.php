<?php declare(strict_types=1);

namespace NetworkInterop;

/**
 * Represents a single IPv6 address
 */
interface IPv6Address extends IPAddress
{
    /**
     * Returns the hextets of this address as an array of 8 integers in network order
     *
     * @return int[]
     */
    function getHextets(): array;
}
