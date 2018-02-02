<?php declare(strict_types=1);

namespace DaveRandom\Network;

final class NamedEndpoint extends Endpoint implements \NetworkInterop\NamedEndpoint
{
    private $hostName;

    protected function __construct(\NetworkInterop\DomainName $hostName, int $port)
    {
        parent::__construct($port);

        $this->hostName = $hostName;
    }

    /**
     * @throws FormatException
     */
    public static function fromString(string $endpoint): self
    {
        if (false === $lastColonPos = \strrpos($endpoint, ':')) {
            throw new FormatException("Cannot parse %s as a valid named endpoint", $endpoint);
        }

        $port = (int)\substr($endpoint, $lastColonPos + 1);

        if ($port < 0 || $port > 65535) {
            throw new FormatException(
                "Cannot parse %s as a valid named endpoint: Port number %d outside range of allowable values 0 - 65535",
                $endpoint, $port
            );
        }

        try {
            $hostName = DomainName::fromString(\substr($endpoint, 0, $lastColonPos));
        } catch (FormatException $e) {
            throw new FormatException("Cannot parse %s as a valid named endpoint: Invalid host name", $endpoint);
        }

        return new self($hostName, $port);
    }

    /**
     * @throws FormatException
     */
    public function fromAddressAndPort(\NetworkInterop\DomainName $hostName, int $port): self
    {
        if ($port < 0 || $port > 65535) {
            throw new FormatException(
                "Cannot create named endpoint: Port number %d outside range of allowable values 0 - 65535",
                $port
            );
        }

        return new self($hostName, $port);
    }

    /**
     * @inheritdoc
     */
    public function getHostName(): \NetworkInterop\DomainName
    {
        return $this->hostName;
    }

    /**
     * @inheritdoc
     */
    public function equals(\NetworkInterop\Endpoint $other): bool
    {
        return $other instanceof NamedEndpoint
            && $other->getPort() === $this->port
            && $other->getHostName()->equals($this->hostName);
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return "{$this->hostName}:{$this->port}";
    }
}
