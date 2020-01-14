<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Baker;
use PHPUnit\Framework\TestCase;

class BakerTest extends TestCase
{
    public function testGetAbbreviatedName()
    {
        $baker = new Baker();
        $baker->setFirstName('Ryan');
        $baker->setLastName('Weaver');

        $this->assertSame('Ryan W.', $baker->getAbbreviatedName());

        $baker = new Baker();
        $baker->setFirstName('Ryan');

        $this->assertSame('Ryan', $baker->getAbbreviatedName());
    }
}

