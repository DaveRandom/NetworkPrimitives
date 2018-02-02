<?php declare(strict_types=1);

namespace NetworkInterop;

interface IPAddress
{
    /**
     * Returns the IANA-assigned protocol number for this address as an integer
     *
     * @return int
     */
    function getProtocolFamily(): int;

    /**
     * Returns binary string representation of this IP address instance, in network byte order
     *
     * @return string
     */
    function toBinary(): string;

    /**
     * Compares two IP addresses and determines whether they are equivalent. The rules for determining equivalence are
     * not defined and are left to the implementation.
     *
     * @param IPAddress $other
     * @return bool
     */
    function equals(IPAddress $other): bool;

    /**
     * Returns a string that can be used directly as a host reference in the authority portion of a URI string
     *
     * @return string
     */
    function __toString(): string;
}
