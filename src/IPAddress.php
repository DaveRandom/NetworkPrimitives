<?php declare(strict_types=1);

namespace DaveRandom\Network;

use NetworkInterop\Host;

abstract class IPAddress implements \NetworkInterop\IPAddress
{
    /**
     * @internal
     */
    protected $binary;

    /**
     * @internal
     */
    protected function __construct(string $binary)
    {
        $this->binary = $binary;
    }

    /**
     * @throws FormatException
     */
    public static function parse(string $address): IPAddress
    {
        if (false === ($binary = @\inet_pton($address))) {
            throw new FormatException("Cannot parse %s as a valid IP address", $address);
        }

        switch (\strlen($binary)) {
            case 4:  return new IPv4Address($binary);
            case 16: return new IPv6Address($binary);
        }

        throw new FormatException("Unknown IP address type: %s", $address);
    }

    /**
     * @inheritdoc
     */
    abstract public function getProtocolNumber(): int;


    /**
     * @inheritdoc
     */
    abstract public function equals(Host $other): bool;

    /**
     * @inheritdoc
     */
    public function toBinary(): string
    {
        return $this->binary;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return \inet_ntop($this->binary);
    }

    public function __debugInfo(): array
    {
        return ['address' => $this->__toString()];
    }
}
