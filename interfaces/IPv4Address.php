<?php declare(strict_types=1);

namespace NetworkInterop;

interface IPv4Address
{
    /**
     * Returns the octets of this address as an array of 4 integers in network order
     *
     * @return int[]
     */
    function getOctets(): array;
}
