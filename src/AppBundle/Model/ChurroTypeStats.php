<?php

namespace AppBundle\Model;

class ChurroTypeStats
{
    private $type;

    private $averageQuantityMade;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getAverageQuantityMade()
    {
        return $this->averageQuantityMade;
    }

    public function setAverageQuantityMade($averageQuantityMade)
    {
        $this->averageQuantityMade = $averageQuantityMade;
    }
}
