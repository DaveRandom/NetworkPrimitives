<?php declare(strict_types=1);

namespace NetworkInterop;

interface IPEndpoint extends Endpoint
{
    /**
     * Get the IP address associated with the endpoint
     *
     * @return IPAddress
     */
    function getAddress(): IPAddress;
}
