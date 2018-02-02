<?php declare(strict_types=1);

namespace NetworkInterop;

/**
 * Represents a single 48-bit MAC address
 *
 * Two MAC addresses are considered equivalent if their binary representations are identical.
 */
interface MacAddress
{
    /**
     * Returns binary string representation of this IP address instance, in network byte order
     *
     * @return string
     */
    function toBinary(): string;

    /**
     * Returns the octets of this address as an array of 4 integers in network order
     *
     * @return int[]
     */
    function getOctets(): array;

    /**
     * Compares two MAC addresses and determines whether they are equivalent. MAC addresses are considered equivalent
     * if their binary representations are identical.
     *
     * @param MacAddress $other
     * @return bool
     */
    function equals(MacAddress $other): bool;

    /**
     * Returns a human-readable string representing the MAC address
     *
     * The precise format of the string is left to the implementation, however it is recommended that the string take
     * one of the following commonly used forms:
     *
     * - A string of dash-separated octets represented as hexadecimal digits in network byte order
     * - A string of colon-separated octets represented as hexadecimal digits in network byte order
     * - A contiguous string of hexadecimal digits in network byte order
     *
     * @return string
     */
    function __toString(): string;
}
