<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Baker;
use AppBundle\Entity\ChurroTimeEntry;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DummyDataFixtures implements FixtureInterface
{
    /**
     * @var Baker[]
     */
    private $bakers = [];

    public function load(ObjectManager $manager)
    {
        $this->createBakers($manager);

        $types = ChurroTimeEntry::VALID_CHURRO_TYPES;

        for ($i = 0; $i < 20; $i++) {
            $startCookingTime = \DateTime::createFromFormat(
                'Y-m-d H:i',
                sprintf('2020-01-10 %s:%s', rand(0, 23), rand(10, 59))
            );
            $endCookingTime = clone $startCookingTime;
            $endCookingTime->modify(sprintf('+%s minutes', rand(10, 100)));

            $startCleanupTime = clone $endCookingTime;
            $startCleanupTime->modify(sprintf('+%s minutes', rand(1, 10)));
            $endCleanupTime = clone $startCleanupTime;
            $endCleanupTime->modify(sprintf('+%s minutes', rand(2, 40)));

            $timeEntry = new ChurroTimeEntry();
            $timeEntry->setBakedBy($this->bakers[array_rand($this->bakers)]);
            $timeEntry->setType($types[array_rand($types)]);
            $timeEntry->setStartCookingAt($startCookingTime);
            $timeEntry->setEndCookingAt($endCookingTime);
            $timeEntry->setStartCleanupAt($startCleanupTime);
            $timeEntry->setEndCleanupAt($endCleanupTime);
            $timeEntry->setQuantityMade(rand(1, 25));

            $manager->persist($timeEntry);
        }

        $manager->flush();
    }

    private function createBakers(ObjectManager $manager)
    {
        $baker1 = new Baker();
        $baker1->setUsername('weaverryan');
        $baker1->setFirstName('Ryan');
        $baker1->setLastName('Weaver');
        $manager->persist($baker1);
        $this->bakers[] = $baker1;

        $baker2 = new Baker();
        $baker2->setUsername('jwage');
        $baker2->setFirstName('Jon');
        $baker2->setLastName('Wage');
        $manager->persist($baker2);
        $this->bakers[] = $baker2;

        $baker3 = new Baker();
        $baker3->setUsername('molloKhan');
        $baker3->setFirstName('Diego');
        $baker3->setLastName('Aguilar');
        $manager->persist($baker3);
        $this->bakers[] = $baker3;

        $baker4 = new Baker();
        $baker4->setUsername('jmolivas');
        $baker4->setFirstName('Jesus');
        $baker4->setLastName('Olivas');
        $manager->persist($baker4);
        $this->bakers[] = $baker4;
    }
}
