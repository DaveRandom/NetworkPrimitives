<?php declare(strict_types=1);

namespace DaveRandom\Network;

final class FormatException extends \Exception
{
    public function __construct(string $message, ...$args)
    {
        parent::__construct(\sprintf($message, $args));
    }
}
