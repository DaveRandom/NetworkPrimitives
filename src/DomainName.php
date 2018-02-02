<?php declare(strict_types=1);

namespace DaveRandom\Network;

use NetworkInterop\Host;

final class DomainName implements \NetworkInterop\DomainName
{
    const STRICT = 0b01;

    private $labels;

    private function __construct(array $labels)
    {
        $this->labels = $labels;
    }

    /**
     * @throws FormatException
     */
    public static function fromString(string $name, int $flags = self::STRICT): self
    {
        $labels = \explode('.', $name);

        // Remove the last label if it is empty (i.e. root zone)
        if (\end($labels) === '') {
            \array_pop($labels);
        }

        return self::fromArray($labels, $flags);
    }

    /**
     * @throws FormatException
     */
    public static function fromArray(array $labels, int $flags = self::STRICT)
    {
        $validated = [];
        $strict = $flags & self::STRICT;

        foreach ($labels as $label) {
            $label = normalize_dns_name((string)$label);

            if ($strict && !\preg_match('/^[a-z0-9](?:[a-z0-9\-]*[a-z0-9])?$/', $label)) {
                throw new FormatException("Invalid domain name label: {$label}");
            }

            $validated[] = $label;
        }

        return new self($labels);
    }

    /**
     * @inheritdoc
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @inheritdoc
     */
    public function equals(Host $other): bool
    {
        return $other instanceof \NetworkInterop\DomainName
            && $other->getLabels() === $this->labels;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return \implode('.', $this->labels);
    }

    public function __debugInfo(): array
    {
        return ['name' => $this->__toString()];
    }
}
