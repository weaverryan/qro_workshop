<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
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
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $quantityMade;

    /**
     * @ORM\ManyToOne(targetEntity="Baker")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
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

    /**
     * @return int The time in seconds
     */
    public function getCookingDuration()
    {
        return $this->getEndCookingAt()->getTimestamp() - $this->getStartCookingAt()->getTimestamp();
    }

    /**
     * @return int The time in seconds
     */
    public function getCleanupDuration()
    {
        return $this->getEndCleanupAt()->getTimestamp() - $this->getStartCleanupAt()->getTimestamp();
    }

    /**
     * To help improve cleanup times, we're identifying
     * any cleanup times longer than 30 minutes as "too long".
     *
     * @return bool
     */
    public function didCleanupTakeTooLong()
    {
        return ($this->getCleanupDuration() / 60) > 30;
    }

    public function setCookingAndCleanupDuration($cookingMinutes, $cleanupMinutes)
    {
        if (!$this->getStartCookingAt()) {
            throw new \Exception('Cannot set duration until startCookingAt is set!');
        }

        $this->setEndCookingAt(
            (clone $this->getStartCookingAt())->modify(sprintf('+%s minutes', $cookingMinutes))
        );
        $this->setStartCleanupAt(clone $this->getEndCookingAt());
        $this->setEndCleanupAt(
            (clone $this->getStartCleanupAt())->modify(sprintf('+%s minutes', $cleanupMinutes))
        );
    }
}
