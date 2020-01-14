<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChurroTimeEntryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('startCookingAt')
            ->add('endCookingAt')
            ->add('startCleanupAt')
            ->add('endCleanupAt')
            ->add('quantityMade')
        ;
    }
}
