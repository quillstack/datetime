<?php

declare(strict_types=1);

namespace Quillstack\Datetime\Tests\Unit;

use Quillstack\Datetime\Datetime;
use Quillstack\UnitTests\AssertEqual;

/**
 * The state used to be a static property, so every instance overwrote the one before it
 * and two dates created next to each other read the same.
 */
class SeparateState
{
    public function __construct(private AssertEqual $assertEqual)
    {
        //
    }

    public function eachInstanceKeepsItsOwnDate()
    {
        $first = new Datetime('2022-01-19 21:43:12');
        $second = new Datetime('1999-12-31 23:59:59');

        $this->assertEqual->equal('2022-01-19 21:43:12', (string) $first);
        $this->assertEqual->equal('1999-12-31 23:59:59', (string) $second);
    }

    public function aNullWhenMeansNow()
    {
        $this->assertEqual->equal(
            (string) new Datetime(),
            (string) new Datetime(null)
        );
    }
}
