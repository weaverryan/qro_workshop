<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ChurroTimeEntry;
use AppBundle\Service\ChurroTimeEntryStatsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ChurroTimeEntryController extends Controller
{
    public function listAction()
    {
        $timeEntries = $this->container->get('doctrine')
            ->getRepository(ChurroTimeEntry::class)
            ->createQueryBuilder('churro_time_entry')
            ->where('churro_time_entry.startCookingAt > :date')
            ->setParameter('date', new \DateTime('-1 week'))
            ->orderBy('churro_time_entry.startCookingAt', 'DESC')
            ->getQuery()
            ->getResult();

        $this->container
            ->get('logger')
            ->info(sprintf('Printing %d time entries', count($timeEntries)));

        $statsHelper = $this->container
            ->get('app.churro_time_entry_stats_helper');
        $bestTypeData = $statsHelper->getMostEfficientTypeData($timeEntries);

        return $this->render('AppBundle:ChurroTimeEntry:list.html.twig', [
            'timeEntries' => $timeEntries,
            'bestType' => $bestTypeData['type'],
            'avg' => $bestTypeData['average'],
        ]);
    }

    public function showAction($id)
    {
        /** @var ChurroTimeEntry $timeEntry */
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
