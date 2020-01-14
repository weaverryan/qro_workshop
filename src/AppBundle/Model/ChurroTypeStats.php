<?php

namespace AppBundle\Model;

class ChurroTypeStats
{
    private $type;

    private $averageQuantityMade;

    public function __construct($type, $averageQuantityMade)
    {
        $this->type = $type;
        $this->averageQuantityMade = $averageQuantityMade;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAverageQuantityMade()
    {
        return $this->averageQuantityMade;
    }
}
