<?php declare(strict_types=1);

namespace NetworkInterop;

interface DomainName
{
    /**
     * Returns the labels that make up the name, as an array of strings, excluding the root zone
     *
     * @return array
     */
    function getLabels(): array;

    /**
     * Compares two domain names and determines whether they are equivalent. The rules for determining equivalence are
     * not defined and are left to the implementation.
     *
     * @param DomainName $other
     * @return bool
     */
    function equals(DomainName $other): bool;

    /**
     * Returns a string that can be used directly as a host reference in the authority portion of a URI string
     *
     * @return string
     */
    function __toString(): string;
}
