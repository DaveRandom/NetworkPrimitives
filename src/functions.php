<?php declare(strict_types=1);

namespace DaveRandom\Network;

if (\function_exists('idn_to_ascii')) {
    /**
     * @throws FormatException
     */
    function normalize_dns_name(string $name): string
    {
        if (false === $result = \idn_to_ascii($name, 0, INTL_IDNA_VARIANT_UTS46)) {
            throw new FormatException("Label '{$name}' could not be processed for IDN");
        }

        return $result;
    }
} else {
    /**
     * @throws FormatException
     */
    function normalize_dns_name(string $name): string
    {
        if (\preg_match('/[^\x21-\x7e]/', $name)) {
            throw new FormatException(
                "Label '{$name}' contains non-ASCII or unprintable characters and IDN support is not available."
                . " Verify that ext/intl is installed for IDN support."
            );
        }

        return \strtolower($name);
    }
}
