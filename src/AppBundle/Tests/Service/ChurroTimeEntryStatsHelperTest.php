<?php

namespace AppBundle\Tests\Service;

use AppBundle\Entity\ChurroTimeEntry;
use AppBundle\Model\ChurroTypeStats;
use AppBundle\Repository\ChurroTimeEntryRepository;
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

        $repository = $this->createMock(ChurroTimeEntryRepository::class);
        $registry->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository);

        $entry1 = new ChurroTimeEntry();
        $entry1->setType('chocolate');
        $entry1->setQuantityMade(10);

        $entry2 = new ChurroTimeEntry();
        $entry2->setType('chocolate');
        $entry2->setQuantityMade(20);

        $entry3 = new ChurroTimeEntry();
        $entry3->setType('vanilla');
        $entry3->setQuantityMade(14);

        $repository->expects($this->once())
            ->method('findAllDuringLastWeekOrderedNewestFirst')
            ->willReturn([$entry1, $entry2, $entry3]);

        $helper = new ChurroTimeEntryStatsHelper($registry, $logger);
        $stats = $helper->getMostEfficientTypeData();
        $this->assertInstanceOf(ChurroTypeStats::class, $stats);
        $this->assertSame(15, $stats->getAverageQuantityMade());
        $this->assertSame('chocolate', $stats->getType());
    }
}