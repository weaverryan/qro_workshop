<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\ChurroTimeEntry;
use PHPUnit\Framework\TestCase;

class ChurroTimeEntryTest extends TestCase
{
    public function testGetCookingDuration()
    {
        $entry = new ChurroTimeEntry();
        $entry->setStartCookingAt(new \DateTime('2020-01-10 12:00:00'));
        $entry->setEndCookingAt(new \DateTime('2020-01-10 12:20:20'));

        $this->assertSame(1220, $entry->getCookingDuration());
    }
}

