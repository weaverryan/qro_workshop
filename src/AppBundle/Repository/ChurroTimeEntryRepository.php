<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ChurroTimeEntryRepository extends EntityRepository
{
    public function findAllDuringLastWeekOrderedNewestFirst()
    {
        $timeEntries = $this->doctrine
            ->getRepository(ChurroTimeEntry::class)
            ->createQueryBuilder('churro_time_entry')
            ->where('churro_time_entry.startCookingAt > :date')
            ->setParameter('date', new \DateTime('-1 week'))
            ->orderBy('churro_time_entry.startCookingAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
