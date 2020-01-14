<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ChurroTimeEntry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ChurroTimeEntryController extends Controller
{
    public function listAction()
    {
        $timeEntries = $this->getDoctrine()
            ->getRepository(ChurroTimeEntry::class)
            ->createQueryBuilder('churro_time_entry')
            ->where('churro_time_entry.startCookingAt > :date')
            ->setParameter('date', new \DateTime('-1 week'))
            ->orderBy('churro_time_entry.startCookingAt', 'DESC')
            ->getQuery()
            ->getResult();

        $useFilter = true;
        $today = new \DateTime('now');
        if ($today->format('n') <= 6) {
            // don't filter if today is January-June
            $useFilter = false;
        } else {
            if (($today->format('j') === 30 || $today->format('j') === 31)
                && $today->format('n') !== 10) {
                // don't use filter if today is 30th/31st of July-December
                // except for October - always use the filter in October
                $useFilter = false;
            }
        }

        $types = [];
        foreach ($timeEntries as $timeEntry) {
            if ($useFilter && $timeEntry->getStartCookingAt()->format('H') < 6) {
                // skip
            } else {
                if ($useFilter && $timeEntry->getStartCookingAt()->format('H') >= 22) {
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

    public function showAction($id)
    {
        $timeEntry = $this->getDoctrine()
            ->getRepository(ChurroTimeEntry::class)
            ->find($id);

        if (!$timeEntry) {
            throw $this->createNotFoundException('no time entry for '.$id);
        }

        return $this->render('AppBundle:ChurroTimeEntry:show.html.twig', [
            'timeEntry' => $timeEntry
        ]);
    }
}
