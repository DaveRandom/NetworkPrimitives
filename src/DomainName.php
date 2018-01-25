<?php declare(strict_types=1);

namespace DaveRandom\Network;

final class DomainName
{
    private $labels = [];

    public static function createFromString(string $name): DomainName
    {
        return new DomainName(\explode('.', $name));
    }

    public function __construct(array $labels, bool $validate = true)
    {
        if (!$validate) {
            $this->labels = $labels;
            return;
        }

        foreach ($labels as $label) {
            $label = \strtolower((string)$label);

            if (!\preg_match('/^[a-z0-9](?:[a-z0-9\-]*[a-z0-9])?$/', $label)) {
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
