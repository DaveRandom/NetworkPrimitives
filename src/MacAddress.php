<?php declare(strict_types=1);

namespace DaveRandom\Network;

final class MacAddress implements \NetworkInterop\MacAddress
{
    private $binary;
    private $octets;

    public static function fromString(string $address): self
    {
        $stripped = \preg_replace('/[^0-9a-f]+/i', '', $address);

        if (\strlen($stripped) !== 12) {
            throw new \InvalidArgumentException("Cannot parse '{$address}' as a valid MAC address");
        }

        return new self(\pack('H12', $stripped));
    }

    public static function fromOctets(int $o1, int $o2, int $o3, int $o4, int $o5, int $o6): self
    {
        foreach ([$o1, $o2, $o3, $o4, $o5, $o6] as $i => $octet) {
            if ($octet < 0 || $octet > 255) {
                throw new \OutOfRangeException(\sprintf(
                    "Value %d for octet %d outside range of allowable values 0 - 255",
                    $octet, $i + 1
                ));
            }
        }

        return new self(\pack('C6', $o1, $o2, $o3, $o4, $o5, $o6));
    }

    public static function fromBinary(string $binary): self
    {
        if (\strlen($binary) !== 6) {
            throw new \InvalidArgumentException(
                "Binary representation of an MAC address must be 6 bytes, got " . \strlen($binary)
            );
        }

        return new self($binary);
    }

    private function __construct(string $binary)
    {
        $this->binary = $binary;
    }

    /**
     * @inheritdoc
     */
    public function getOctets(): array
    {
        if (isset($this->octets)) {
            return $this->octets;
        }

        return $this->octets = \array_values(\unpack('C6', $this->binary));
    }

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
    public function equals(\NetworkInterop\MacAddress $other): bool
    {
        return $other->toBinary() === $this->binary;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return \sprintf(
            '%02x:%02x:%02x:%02x:%02x:%02x',
            ...$this->getOctets()
        );
    }

    public function __debugInfo(): array
    {
        return ['string' => $this->__toString()];
    }
}
