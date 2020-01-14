<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class ChurroTimeEntryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('startCookingAt', DateTimeType::class)
            ->add('endCookingAt', DateTimeType::class)
            ->add('startCleanupAt', DateTimeType::class)
            ->add('endCleanupAt', DateTimeType::class)
            ->add('quantityMade', IntegerType::class)
        ;
    }
}
