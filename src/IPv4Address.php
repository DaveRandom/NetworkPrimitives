<?php declare(strict_types=1);

namespace DaveRandom\Network;

final class IPv4Address extends IPAddress
{
    private $octet1;
    private $octet2;
    private $octet3;
    private $octet4;
    private $class;

    public static function createFromString(string $address): IPv4Address
    {
        if (false === ($binary = \inet_pton($address)) || \strlen($binary) !== 4) {
            throw new \InvalidArgumentException("Cannot parse '{$address}' as a valid IPv4 address");
        }

        return new IPv4Address(...\array_map('ord', \str_split($binary, 1)));
    }

    public function __construct(int $o1, int $o2, int $o3, int $o4)
    {
        if ($o1 < 0 || $o1 > 255) {
            throw new \OutOfRangeException("Value '{$o1}' for octet 1 outside range of allowable values 0 - 255");
        }

        if ($o2 < 0 || $o2 > 255) {
            throw new \OutOfRangeException("Value '{$o2}' for octet 2 outside range of allowable values 0 - 255");
        }

        if ($o3 < 0 || $o3 > 255) {
            throw new \OutOfRangeException("Value '{$o3}' for octet 3 outside range of allowable values 0 - 255");
        }

        if ($o4 < 0 || $o4 > 255) {
            throw new \OutOfRangeException("Value '{$o4}' for octet 4 outside range of allowable values 0 - 255");
        }

        $this->octet1 = $o1;
        $this->octet2 = $o2;
        $this->octet3 = $o3;
        $this->octet4 = $o4;

        parent::__construct(\pack('C4', $o1, $o2, $o3, $o4));
    }

    public function getOctet1(): int
    {
        return $this->octet1;
    }

    public function getOctet2(): int
    {
        return $this->octet2;
    }

    public function getOctet3(): int
    {
        return $this->octet3;
    }

    public function getOctet4(): int
    {
        return $this->octet4;
    }

    public function getClass(): int
    {
        if (isset($this->class)) {
            return $this->class;
        }

        if ($this->octet1 === 0 || $this->octet1 === 255) {
            return $this->class = IPv4AddressClasses::RESERVED;
        }

        if (!($this->octet1 & 0b10000000)) {
            return $this->class = IPv4AddressClasses::A;
        }

        if (!($this->octet1 & 0b01000000)) {
            return $this->class = IPv4AddressClasses::B;
        }

        if (!($this->octet1 & 0b00100000)) {
            return $this->class = IPv4AddressClasses::C;
        }

        if (!($this->octet1 & 0b00010000)) {
            return $this->class = IPv4AddressClasses::D;
        }

        return $this->class = IPv4AddressClasses::E;
    }

    public function isLoopback(): bool
    {
        return $this->octet1 === 127;
    }

    public function isPrivate(): bool
    {
        switch ($this->getClass()) {
            case IPv4AddressClasses::A: return $this->octet1 === 10;
            case IPv4AddressClasses::B: return $this->octet1 === 172 && ($this->octet2 & 0b11110000) === 0b00010000;
            case IPv4AddressClasses::C: return $this->octet2 === 192 && ($this->octet2 & 0b11110000) === 0b00010000;
        }

        return false;
    }

    public function isAssignable(): bool
    {
        return $this->getClass() < IPv4AddressClasses::D && $this->octet1 !== 0;
    }

    public function getProtocolFamily(): int
    {
        return \STREAM_PF_INET;
    }

    public function equals(IPAddress $other): bool
    {
        return $other instanceof IPv4Address
            && $this->octet1 === $other->octet1
            && $this->octet2 === $other->octet2
            && $this->octet3 === $other->octet3
            && $this->octet4 === $other->octet4
        ;
    }

    public function __toString(): string
    {
        return \sprintf('%d.%d.%d.%d', $this->octet1, $this->octet2, $this->octet3, $this->octet4);
    }
}
