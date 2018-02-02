<?php declare(strict_types=1);

namespace NetworkInterop;

interface NamedEndpoint extends Endpoint
{
    /**
     * Get the host name associated with the endpoint
     *
     * @return DomainName
     */
    public function getHostName(): DomainName;
}
