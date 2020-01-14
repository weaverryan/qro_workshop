<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ChurroTimeEntry;
use Doctrine\ORM\EntityRepository;

class ChurroTimeEntryRepository extends EntityRepository
{
    /**
     * @return ChurroTimeEntry[]
     */
    public function findAllDuringLastWeekOrderedNewestFirst()
    {
        return $this
            ->createQueryBuilder('churro_time_entry')
            ->where('churro_time_entry.startCookingAt > :date')
            ->setParameter('date', new \DateTime('-1 week'))
            ->orderBy('churro_time_entry.startCookingAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
