<?php declare(strict_types=1);

namespace NetworkInterop;

/**
 * Represents an endpoint to which an attempt may be made to establish a socket connection using mechanisms
 * based on Internet Protocol
 *
 * Two internet endpoints are equivalent if their hosts are equivalent and the port numbers are identical
 */
interface InternetEndpoint extends Endpoint
{
    /**
     * Return the host associated with the endpoint
     *
     * @return Host
     */
    function getHost(): Host;

    /**
     * Returns the port number as an integer in the range 0 - 65535
     *
     * @return int
     */
    function getPort(): int;
}
