<?php declare(strict_types=1);

namespace NetworkInterop;

/**
 * Represents the network address of a single computer.
 *
 * Two Hosts are considered equivalent if they are of the same sub-type. A sub-type may impose additional rules.
 */
interface Host
{
    /**
     * Compares two hosts and determines whether they are equivalent.
     *
     * @param DomainName $other
     * @return bool
     */
    function equals(Host $other): bool;

    /**
     * Returns a string that can be used directly as a host reference in the authority portion of a URI string
     *
     * @return string
     */
    function __toString(): string;
}
