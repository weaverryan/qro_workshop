<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChurroTimeEntryRepository")
 * @ORM\Table()
 */
class ChurroTimeEntry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startCookingAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endCookingAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startCleanupAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endCleanupAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityMade;

    /**
     * @ORM\ManyToOne(targetEntity="Baker")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bakedBy;

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getStartCookingAt()
    {
        return $this->startCookingAt;
    }

    public function setStartCookingAt($startCookingAt)
    {
        $this->startCookingAt = $startCookingAt;
    }

    public function getEndCookingAt()
    {
        return $this->endCookingAt;
    }

    public function setEndCookingAt($endCookingAt)
    {
        $this->endCookingAt = $endCookingAt;
    }

    public function getStartCleanupAt()
    {
        return $this->startCleanupAt;
    }

    public function setStartCleanupAt($startCleanupAt)
    {
        $this->startCleanupAt = $startCleanupAt;
    }

    public function getEndCleanupAt()
    {
        return $this->endCleanupAt;
    }

    public function setEndCleanupAt($endCleanupAt)
    {
        $this->endCleanupAt = $endCleanupAt;
    }

    public function getQuantityMade()
    {
        return $this->quantityMade;
    }

    public function setQuantityMade($quantityMade)
    {
        $this->quantityMade = $quantityMade;
    }

    public function getBakedBy()
    {
        return $this->bakedBy;
    }

    public function setBakedBy($bakedBy)
    {
        $this->bakedBy = $bakedBy;
    }
}
