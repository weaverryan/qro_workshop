<?php

namespace AppBundle\Model;

class ChurroTypeStats
{
    private $type;

    private $average;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getAverage()
    {
        return $this->average;
    }

    public function setAverage($average)
    {
        $this->average = $average;
    }
}
