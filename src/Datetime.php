<?php

declare(strict_types=1);

namespace Quillstack\Datetime;

use Quillstack\Datetime\Exceptions\InvalidDatetimeFormatOrKeyException;

class Datetime
{
    public const NOW = 'now';
    private static \DateTime|null $state;

    public function __construct(?string $when = self::NOW)
    {
        try {
            static::$state = new \DateTime($when);
        } catch (\Exception $exception) {
            throw new InvalidDatetimeFormatOrKeyException("Invalid format: {$when}", 500, $exception);
        }
    }

    public function __toString(): string
    {
        return static::$state->format(FormatInterface::HUMAN_DATE_TIME);
    }
}
