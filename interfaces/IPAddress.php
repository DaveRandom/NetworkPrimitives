<?php declare(strict_types=1);

namespace NetworkInterop;

/**
 * Represents a single IP address.
 *
 * Two IP Addresses are considered equivalent if they are of the same protocol version and the binary representations
 * are identical, or if the protocol version of the newer address form has an unambiguous mechanism for mapping to the
 * protocol version of the older address, and the address are considered identical using those rules.
 */
interface IPAddress extends Host
{
    /**
     * Returns the IANA-assigned protocol number for this address as an integer
     *
     * @return int
     */
    function getProtocolNumber(): int;

    /**
     * Returns binary string representation of this IP address instance, in network byte order
     *
     * @return string
     */
    function toBinary(): string;
}
