<?php declare(strict_types=1);

namespace DaveRandom\Network;

final class DomainName
{
    private $labels = [];

    public static function createFromString(string $name, bool $strict = true): DomainName
    {
        return new DomainName(\explode('.', $name), $strict);
    }

    public function __construct(array $labels, bool $strict = true)
    {
        foreach ($labels as $label) {
            $label = normalize_dns_name((string)$label);

            if ($strict && !\preg_match('/^[a-z0-9](?:[a-z0-9\-]*[a-z0-9])?$/', $label)) {
                throw new \InvalidArgumentException("Invalid domain name label: {$label}");
            }

            $this->labels[] = $label;
        }
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function __toString(): string
    {
        return \implode('.', $this->labels);
    }

    public function equals(DomainName $other): bool
    {
        return $this->labels === $other->labels;
    }
}
