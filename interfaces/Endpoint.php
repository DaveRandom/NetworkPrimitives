<?php declare(strict_types=1);

namespace NetworkInterop;

interface Endpoint
{
    /**
     * Returns the port number as an integer in the range 0 - 65535
     *
     * @return int
     */
    function getPort(): int;

    /**
     * Compares two endpoints and determines whether they are equivalent. The rules for determining equivalence are not
     * defined and are left to the implementation.
     *
     * @param Endpoint $other
     * @return bool
     */
    function equals(Endpoint $other): bool;

    /**
     * Returns a string that can be used directly in the authority portion of a URI string
     *
     * @return string
     */
    function __toString(): string;
}
