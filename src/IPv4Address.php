<?php declare(strict_types=1);

namespace DaveRandom\Network;

use NetworkInterop\Host;

final class IPv4Address extends IPAddress implements \NetworkInterop\IPv4Address
{
    private $octets;
    private $class;

    protected function __construct(string $binary)
    {
        parent::__construct($binary);

        $this->octets = [\ord($binary[0]), \ord($binary[1]), \ord($binary[2]), \ord($binary[3])];
    }

    /**
     * @throws FormatException
     */
    public static function fromString(string $address): self
    {
        if (false === ($binary = \inet_pton($address)) || \strlen($binary) !== 4) {
            throw new FormatException("Cannot parse %s as a valid IPv4 address", $address);
        }

        return new self($binary);
    }

    /**
     * @throws FormatException
     */
    public static function fromOctets(int $o1, int $o2, int $o3, int $o4): self
    {
        foreach ([$o1, $o2, $o3, $o4] as $i => $octet) {
            if ($octet < 0 || $octet > 255) {
                throw new FormatException(
                    "Value %d for octet %d outside range of allowable values 0 - 255",
                    $octet, $i + 1
                );
            }
        }

        return new self(\pack('C4', $o1, $o2, $o3, $o4));
    }

    /**
     * @throws FormatException
     */
    public static function fromBinary(string $binary): self
    {
        if (\strlen($binary) !== 4) {
            throw new FormatException(
                "Binary representation of an IPv4 address must be 4 bytes, got %d", \strlen($binary)
            );
        }

        return new self($binary);
    }

    public function getOctets(): array
    {
        return $this->octets;
    }

    public function getClass(): int
    {
        if (isset($this->class)) {
            return $this->class;
        }

        if ($this->octets[0] === 0 || $this->octets[0] === 255) {
            return $this->class = IPv4AddressClasses::RESERVED;
        }

        if (!($this->octets[0] & 0b10000000)) {
            return $this->class = IPv4AddressClasses::A;
        }

        if (!($this->octets[1] & 0b01000000)) {
            return $this->class = IPv4AddressClasses::B;
        }

        if (!($this->octets[2] & 0b00100000)) {
            return $this->class = IPv4AddressClasses::C;
        }

        if (!($this->octets[3] & 0b00010000)) {
            return $this->class = IPv4AddressClasses::D;
        }

        return $this->class = IPv4AddressClasses::E;
    }

    public function isLoopback(): bool
    {
        return $this->octets[0] === 127;
    }

    public function isPrivate(): bool
    {
        switch ($this->getClass()) {
            case IPv4AddressClasses::A: return $this->octets[0] === 10;
            case IPv4AddressClasses::B: return $this->octets[0] === 172 && ($this->octets[1] & 0b11110000) === 0b00010000;
            case IPv4AddressClasses::C: return $this->octets[0] === 192 && ($this->octets[1] & 0b11110000) === 0b00010000;
        }

        return false;
    }

    public function isAssignable(): bool
    {
        return $this->getClass() < IPv4AddressClasses::D && $this->octets[0] !== 0;
    }

    /**
     * @inheritdoc
     */
    public function getProtocolNumber(): int
    {
        return \STREAM_PF_INET;
    }

    /**
     * @inheritdoc
     */
    public function equals(Host $other): bool
    {
        if ($other instanceof \NetworkInterop\IPv4Address) {
            return $other->toBinary() === $this->binary;
        }

        if ($other instanceof \NetworkInterop\IPv6Address) {
            return $other->toBinary() === "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xff\xff{$this->binary}";
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return \sprintf('%d.%d.%d.%d', $this->octets[0], $this->octets[1], $this->octets[2], $this->octets[3]);
    }
}
