<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ChurroTimeEntry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChurroTimeEntryController extends Controller
{
    public function listAction()
    {
        $timeEntries = $this->getDoctrine()
            ->getManager()
            ->getRepository(ChurroTimeEntry::class)
            ->createQueryBuilder('churro_time_entry')
            ->where('churro_time_entry.startCookingAt > :date')
            ->setParameter('date', new \DateTime('-1 week'))
            ->orderBy('churro_time_entry.startCookingAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('AppBundle:ChurroTimeEntry:list.html.twig', [
            'timeEntries' => $timeEntries,
        ]);
    }
}
