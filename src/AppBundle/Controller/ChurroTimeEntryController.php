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

        $types = [];
        foreach ($timeEntries as $timeEntry) {
            if ($timeEntry->getStartCookingAt()->format('H') < 6) {
                // skip
            } else {
                if (isset($types[$timeEntry->getType()])) {
                    $types[$timeEntry->getType()][] = $timeEntry->getQuantityMade();
                } else {
                    $types[$timeEntry->getType()] = [];
                    $types[$timeEntry->getType()][] = $timeEntry->getQuantityMade();
                }
            }
        }

        $bestType = null;
        $avg = 0;
        foreach ($types as $type => $data) {
            $total = 0;
            foreach ($data as $quantity) {
                $total += $quantity;
            }

            $thisAverage = $total / count($data);
            if ($thisAverage > $avg) {
                $avg = $thisAverage;
                $bestType = $type;
            }
        }

        return $this->render('AppBundle:ChurroTimeEntry:list.html.twig', [
            'timeEntries' => $timeEntries,
            'bestType' => $bestType,
            'avg' => $avg,
        ]);
    }
}
