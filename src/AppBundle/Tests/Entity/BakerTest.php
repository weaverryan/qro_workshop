<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Baker;
use PHPUnit\Framework\TestCase;

class BakerTest extends TestCase
{
    /**
     * @dataProvider getAbbreviatedNameTests
     */
    public function testGetAbbreviatedName($firstName, $lastName, $expected)
    {
        $baker = new Baker();
        $baker->setFirstName($firstName);
        $baker->setLastName($lastName);

        $this->assertSame($expected, $baker->getAbbreviatedName());
    }

    public function getAbbreviatedNameTests()
    {
        return [
            ['Ryan', 'Weaver', 'Ryan W.'],
            ['Ryan', null, 'Ryan'],
        ];
    }
}

