<?php declare(strict_types=1);

namespace NetworkInterop;

/**
 * Represents a single IPv4 address
 */
interface IPv4Address extends IPAddress
{
    /**
     * Returns the octets of this address as an array of 4 integers in network order
     *
     * @return int[]
     */
    function getOctets(): array;
}
