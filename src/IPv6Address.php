<?php declare(strict_types=1);

namespace DaveRandom\Network;

use NetworkInterop\Host;

final class IPv6Address extends IPAddress implements \NetworkInterop\IPv6Address
{
    private $hextets;

    protected function __construct(string $binary)
    {
        parent::__construct($binary);

        $this->hextets = \array_values(\unpack('n8', $binary));
    }

    /**
     * @throws FormatException
     */
    public static function fromString(string $address): self
    {
        if (false === ($binary = \inet_pton($address)) || \strlen($binary) !== 16) {
            throw new FormatException("Cannot parse %s as a valid IPv6 address", $address);
        }

        return new self($binary);
    }

    /**
     * @throws FormatException
     */
    public static function fromHextets(int $h1, int $h2, int $h3, int $h4, int $h5, int $h6, int $h7, int $h8): self
    {
        foreach ([$h1, $h2, $h3, $h4, $h5, $h6, $h7, $h8] as $i => $hextet) {
            if ($hextet < 0 || $hextet > 65535) {
                throw new FormatException(
                    "Value %d for hextet %d outside range of allowable values 0 - 65535",
                    $hextet, $i + 1
                );
            }
        }

        return new self(\pack('n8', $h1, $h2, $h3, $h4, $h5, $h6, $h7, $h8));
    }

    /**
     * @throws FormatException
     */
    public static function fromBinary(string $binary): self
    {
        if (\strlen($binary) !== 16) {
            throw new FormatException(
                "Binary representation of an IPv6 address must be 16 bytes, got %d", \strlen($binary)
            );
        }

        return new self($binary);
    }

    /**
     * @inheritdoc
     */
    public function getHextets(): array
    {
        return $this->hextets;
    }

    /**
     * @inheritdoc
     */
    public function getProtocolNumber(): int
    {
        return \STREAM_PF_INET6;
    }

    /**
     * @inheritdoc
     */
    public function equals(Host $other): bool
    {
        if ($other instanceof \NetworkInterop\IPv6Address) {
            return $other->toBinary() === $this->binary;
        }

        if ($other instanceof \NetworkInterop\IPv4Address) {
            return $this->binary === "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xff\xff{$other->toBinary()}";
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return \inet_ntop($this->binary);
    }
}
