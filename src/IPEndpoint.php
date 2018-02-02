<?php declare(strict_types=1);

namespace DaveRandom\Network;

use NetworkInterop\Host;
use NetworkInterop\InternetEndpoint;
use NetworkInterop\IPAddress;

final class IPEndpoint extends Endpoint implements InternetEndpoint
{
    private $address;

    protected function __construct(IPAddress $address, int $port)
    {
        parent::__construct($port);

        $this->address = $address;
    }

    /**
     * @throws FormatException
     */
    public static function fromString(string $endpoint): self
    {
        if (2 === \count($parts = \explode(':', $endpoint))) {
            try {
                $address = IPv4Address::fromString($parts[0]);
            } catch (FormatException $e) {
                throw new FormatException('Cannot parse %s as a valid IP endpoint: Invalid address', $endpoint);
            }

            $port = (int)$parts[1];
        } else if (\preg_match('/^\[([^\]]+)]:([0-9]+)/', $endpoint, $match)) {
            try {
                $address = IPv6Address::fromString($match[1]);
            } catch (FormatException $e) {
                throw new FormatException('Cannot parse %s as a valid IP endpoint: Invalid address', $endpoint);
            }

            $port = (int)$match[2];
        } else {
            throw new FormatException('Cannot parse %s as a valid IP endpoint: Unknown format', $endpoint);
        }

        if ($port < 0 || $port > 65535) {
            throw new FormatException(
                "Cannot parse %s as a valid IP endpoint: Port number %d outside range of allowable values 0 - 65535",
                $endpoint, $port
            );
        }

        return new self($address, $port);

    }

    /**
     * @throws FormatException
     */
    public function fromAddressAndPort(IPAddress $address, int $port): self
    {
        if ($port < 0 || $port > 65535) {
            throw new FormatException(
                "Cannot create IP endpoint: Port number %d outside range of allowable values 0 - 65535",
                $port
            );
        }

        return new self($address, $port);
    }

    /**
     * @return IPAddress
     */
    public function getHost(): Host
    {
        return $this->address;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function equals(\NetworkInterop\Endpoint $other): bool
    {
        return $other instanceof InternetEndpoint
            && $other->getPort() === $this->port
            && $other->getHost()->equals($this->address)
        ;
    }

    public function __toString(): string
    {
        return \sprintf(
            '%s:%d',
            $this->address instanceof \NetworkInterop\IPv6Address ? "[{$this->address}]" : $this->address,
            $this->port
        );
    }
}
