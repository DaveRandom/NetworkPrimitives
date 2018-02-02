<?php declare(strict_types=1);

namespace DaveRandom\Network;

abstract class Endpoint implements \NetworkInterop\Endpoint
{
    /**
     * @internal
     */
    protected $port;

    /**
     * @internal
     */
    protected function __construct(int $port)
    {
        $this->port = $port;
    }

    /**
     * @throws FormatException
     */
    public static function parse(string $endpoint): self
    {
        if (false === $lastColonPos = \strrpos($endpoint, ':')) {
            throw new FormatException("Cannot parse %s as a valid endpoint", $endpoint);
        }

        $port = (int)\substr($endpoint, $lastColonPos + 1);

        if ($port < 0 || $port > 65535) {
            throw new FormatException(
                "Cannot parse %s as a valid endpoint: Port number %d outside range of allowable values 0 - 65535",
                $endpoint, $port
            );
        }

        $host = \substr($endpoint, 0, $lastColonPos);

        try {
            return new IPEndpoint(IPAddress::parse($host), $port);
        } catch (FormatException $e) {
            try {
                return new NamedEndpoint(DomainName::fromString($host), $port);
            } catch (FormatException $e) {
                throw new FormatException("Cannot parse %s as a valid endpoint: Cannot determine host type", $endpoint);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @inheritdoc
     */
    abstract public function equals(\NetworkInterop\Endpoint $other): bool;

    /**
     * @inheritdoc
     */
    abstract public function __toString(): string;
}
