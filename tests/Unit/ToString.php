<?php

declare(strict_types=1);

namespace Quillstack\Datetime\Tests\Unit;

use Quillstack\Datetime\Datetime;
use Quillstack\UnitTests\AssertEqual;

class ToString
{
    public function __construct(private AssertEqual $assertEqual)
    {
        //
    }

    public function toString()
    {
        $datetime = new Datetime('2022-01-19 21:43:12');

        $this->assertEqual->equal('2022-01-19 21:43:12', (string) $datetime);
    }
}
