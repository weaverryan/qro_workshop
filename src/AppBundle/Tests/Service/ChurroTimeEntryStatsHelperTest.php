<?php

namespace AppBundle\Tests\Service;

use AppBundle\Model\ChurroTypeStats;
use AppBundle\Service\ChurroTimeEntryStatsHelper;
use Doctrine\Bundle\DoctrineBundle\Registry;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ChurroTimeEntryStatsHelperTest extends TestCase
{
    public function testGetMostEfficientTypeData()
    {
        $registry = $this->createMock(Registry::class);
        $logger = $this->createMock(LoggerInterface::class);

        $helper = new ChurroTimeEntryStatsHelper($registry, $logger);
        $stats = $helper->getMostEfficientTypeData();
        $this->assertInstanceOf(ChurroTypeStats::class, $stats);
    }
}