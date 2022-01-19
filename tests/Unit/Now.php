<?php

declare(strict_types=1);

namespace Quillstack\Datetime\Tests\Unit;

use Quillstack\Datetime\Datetime;
use Quillstack\Datetime\FormatInterface;
use Quillstack\UnitTests\AssertEqual;

class Now
{
    public function __construct(private AssertEqual $assertEqual)
    {
        //
    }

    public function now()
    {
        $phpDateTime = (new \DateTime())->format(FormatInterface::HUMAN_DATE_TIME);
        $datetime = new Datetime();

        $this->assertEqual->equal($phpDateTime, (string) $datetime);
    }
}
