<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ChurroTimeEntry;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DummyDataFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $types = [
            'plain',
            'guava',
            'chocolate',
            'dulce de leche',
            'vanilla'
        ];

        for ($i = 0; $i < 20; $i++) {
            $timeEntry = new ChurroTimeEntry();
            $timeEntry->setType($types[array_rand($types)]);

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

            $timeEntry->setStartCookingAt($startCookingTime);
            $timeEntry->setEndCookingAt($endCookingTime);
            $timeEntry->setStartCleanupAt($startCleanupTime);
            $timeEntry->setEndCleanupAt($endCleanupTime);

            $manager->persist($timeEntry);
        }

        $manager->flush();
    }
}
