<?php

declare(strict_types=1);

namespace Quillstack\Datetime\Tests\Unit;

use Quillstack\Datetime\Datetime;
use Quillstack\Datetime\Exceptions\InvalidDatetimeFormatOrKeyException;
use Quillstack\UnitTests\AssertExceptions;

class ConstructException
{
    public function __construct(private AssertExceptions $assertExceptions)
    {
        //
    }

    public function invalidFormat()
    {
        $this->assertExceptions->expect(InvalidDatetimeFormatOrKeyException::class);

        new Datetime('invalid');
    }
}
