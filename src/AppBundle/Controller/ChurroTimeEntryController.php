<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ChurroTimeEntry;
use AppBundle\Form\ChurroTimeEntryForm;
use AppBundle\Service\ChurroTimeEntryStatsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChurroTimeEntryController extends Controller
{
    public function listAction()
    {
        $timeEntries = $this->container->get('doctrine')
            ->getRepository(ChurroTimeEntry::class)
            ->findAllDuringLastWeekOrderedNewestFirst();

        $this->container
            ->get('logger')
            ->info(sprintf('Printing %d time entries', count($timeEntries)));

        $statsHelper = $this->container
            ->get('app.churro_time_entry_stats_helper');
        $bestTypeData = $statsHelper->getMostEfficientTypeData();

        return $this->render('AppBundle:ChurroTimeEntry:list.html.twig', [
            'timeEntries' => $timeEntries,
            'bestTypeStats' => $bestTypeData,
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

    public function newAction(Request $request)
    {
        $form = $this->createForm(ChurroTimeEntryForm::class, null, [
            'csrf_protection' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            var_dump($form->getData());die;
        }

        return $this->render('AppBundle:ChurroTimeEntry:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
