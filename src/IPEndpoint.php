<?php declare(strict_types=1);

namespace DaveRandom\Network;

final class IPEndpoint
{
    private $address;
    private $port;

    public static function parse(string $endpoint): IPEndpoint
    {
        if (2 === \count($parts = \explode(':', $endpoint))) {
            return new IPEndpoint(IPv4Address::parse($parts[0]), (int)$parts[1]);
        }

        if (\preg_match('/^\[([^\]]+)]:([0-9]+)/', $endpoint, $parts)) {
            return new IPEndpoint(IPv6Address::parse($parts[1]), (int)$parts[2]);
        }

        throw new \InvalidArgumentException("Cannot parse '{$endpoint}' as a valid IP endpoint");
    }

    public function __construct(IPAddress $address, int $port)
    {
        $this->address = $address;
        $this->port = $port;
    }

    public function getAddress(): IPAddress
    {
        return $this->address;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function equals(IPEndpoint $other): bool
    {
        return $this->port === $other->port
            && $this->address->equals($other->address)
        ;
    }

    public function __toString()
    {
        return ($this->address instanceof IPv6Address ? "[{$this->address}]" : $this->address) . ":{$this->port}";
    }
}
