<?php

declare(strict_types=1);

namespace Quillstack\Datetime;

use DateTime as PhpDateTime;
use Exception;
use Quillstack\Datetime\Exceptions\InvalidDatetimeFormatOrKeyException;

class Datetime
{
    public const NOW = 'now';

    private PhpDateTime $state;

    public function __construct(?string $when = self::NOW)
    {
        try {
            $this->state = new PhpDateTime($when ?? self::NOW);
        } catch (Exception $exception) {
            throw new InvalidDatetimeFormatOrKeyException("Invalid format: {$when}", 500, $exception);
        }
    }

    public function __toString(): string
    {
        return $this->state->format(FormatInterface::HUMAN_DATE_TIME);
    }
}
