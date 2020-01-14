<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function homepageAction()
    {
        $statsHelper = $this->container
            ->get('app.churro_time_entry_stats_helper');
        $bestTypeData = $statsHelper->getMostEfficientTypeData();

        return $this->render('AppBundle:Default:homepage.html.twig', array(
            'bestType' => $bestTypeData['type'],
            'avg' => $bestTypeData['average'],
        ));
    }
}
