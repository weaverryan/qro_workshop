<?php

namespace AppBundle\Service;

use AppBundle\Entity\ChurroTimeEntry;
use AppBundle\Model\ChurroTypeStats;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Psr\Log\LoggerInterface;

class ChurroTimeEntryStatsHelper
{
    private $doctrine;
    private $logger;

    public function __construct(Registry $doctrine, LoggerInterface $logger)
    {
        $this->doctrine = $doctrine;
        $this->logger = $logger;
    }

    /**
     * Determines which "type" cooks the most churros on average
     * and returns that inside an array with "type" and "average" keys.
     *
     * @return ChurroTypeStats
     */
    public function getMostEfficientTypeData()
    {
        $timeEntries = $this->doctrine
            ->getRepository(ChurroTimeEntry::class)
            ->findAllDuringLastWeekOrderedNewestFirst();

        $useFilter = $this->shouldUseTimeFilter();

        $types = [];
        foreach ($timeEntries as $timeEntry) {
            if ($useFilter && $timeEntry->getStartCookingAt()->format('H') < 6) {
                continue;
            }

            if ($useFilter && $timeEntry->getStartCookingAt()->format('H') >= 22) {
                continue;
            }

            // initialize key if necessary
            if (!isset($types[$timeEntry->getType()])) {
                $types[$timeEntry->getType()] = [];
            }

            $types[$timeEntry->getType()][] = $timeEntry->getQuantityMade();
        }

        $bestType = null;
        $bestTypeAverage = 0;
        foreach ($types as $type => $data) {
            $thisAverage = $this->calculateAverage($data);

            if ($thisAverage <= $bestTypeAverage) {
                continue;
            }

            // new best average found!
            $bestTypeAverage = $thisAverage;
            $bestType = $type;
        }

        $this->logger->info('Most efficient type is '.$bestType);

        return new ChurroTypeStats($bestType, $bestTypeAverage);
    }

    /**
     * Complex business logic given to us about when we should
     * filter early and late hour reports. This is because of XX
     * reason and was told to us by YY person.
     */
    private function shouldUseTimeFilter()
    {
        $today = new \DateTime('now');

        if ($today->format('n') <= 6) {
            // don't filter if today is January-June
            return false;
        }

        // always use the filter in October
        if ($today->format('n') === 10) {
            return false;
        }

        if (($today->format('j') === 30 || $today->format('j') === 31)) {
            // don't use filter if today is 30th/31st of July-December
            return false;
        }

        return true;
    }

    private function calculateAverage(array $data)
    {
        $total = 0;
        foreach ($data as $quantity) {
            $total += $quantity;
        }

        return $total / count($data);
    }
}
