<?php declare(strict_types=1);

namespace NetworkInterop;

interface DomainName extends Host
{
    /**
     * Returns the labels that make up the name, as an array of strings, excluding the root zone
     *
     * @return array
     */
    function getLabels(): array;
}
