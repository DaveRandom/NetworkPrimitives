<?php declare(strict_types=1);

namespace NetworkInterop;

/**
 * Represents an endpoint to which an attempt may be made to establish a socket connection
 *
 * Two Endpoints are considered equivalent if they are of the same sub-type. A sub-type may impose additional rules.
 */
interface Endpoint
{
    /**
     * Compares two endpoints and determines whether they are equivalent.
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
