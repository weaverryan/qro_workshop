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

    /**
     * @return \DateTime
     */
    public function getStartCookingAt()
    {
        return $this->startCookingAt;
    }

    public function setStartCookingAt(\DateTime $startCookingAt)
    {
        $this->startCookingAt = $startCookingAt;
    }

    /**
     * @return \DateTime
     */
    public function getEndCookingAt()
    {
        return $this->endCookingAt;
    }

    public function setEndCookingAt(\DateTime $endCookingAt)
    {
        $this->endCookingAt = $endCookingAt;
    }

    /**
     * @return \DateTime
     */
    public function getStartCleanupAt()
    {
        return $this->startCleanupAt;
    }

    public function setStartCleanupAt(\DateTime $startCleanupAt)
    {
        $this->startCleanupAt = $startCleanupAt;
    }

    /**
     * @return \DateTime
     */
    public function getEndCleanupAt()
    {
        return $this->endCleanupAt;
    }

    public function setEndCleanupAt(\DateTime $endCleanupAt)
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

    /**
     * @return Baker
     */
    public function getBakedBy()
    {
        return $this->bakedBy;
    }

    public function setBakedBy($bakedBy)
    {
        $this->bakedBy = $bakedBy;
    }

    public function getBakerUsername()
    {
        if (!$this->getBakedBy()) {
            throw new \Exception('This ChurroTimeEntry does not have a Baker!');
        }

        return $this->getBakedBy()->getUsername();
    }

    public function getBakerDisplayName()
    {
        if (!$this->getBakedBy()) {
            throw new \Exception('This ChurroTimeEntry does not have a Baker!');
        }

        return $this->getBakedBy()->getAbbreviatedName();
    }

    public function getCookingDuration()
    {
        return $this->getEndCookingAt()->getTimestamp() - $this->getStartCookingAt()->getTimestamp();
    }
}
