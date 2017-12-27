<?php declare(strict_types=1);

namespace DaveRandom\Network;

abstract class IPAddress
{
    protected $binary;

    protected function __construct(string $binary)
    {
        $this->binary = $binary;
    }

    public static function parse(string $address): IPAddress
    {
        if (false === ($binary = @\inet_pton($address))) {
            throw new \InvalidArgumentException("Cannot parse '{$address}' as a valid IP address");
        }

        switch (\strlen($binary)) {
            case 4:
                return new IPv4Address(...\array_map('ord', \str_split($binary, 1)));

            case 16:
                return new IPv6Address(...\array_map(function($hextet) {
                    return \unpack('n', $hextet)[1];
                } , \str_split($binary, 2)));
        }

        throw new \InvalidArgumentException("Unknown IP address type: {$address}");
    }

    abstract public function getProtocolFamily(): int;
    abstract public function __toString(): string;

    public function toBinary(): string
    {
        return $this->binary;
    }

    public function __debugInfo(): array
    {
        return ['string' => $this->__toString()];
    }
}
