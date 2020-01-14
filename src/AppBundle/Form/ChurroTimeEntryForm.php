<?php

namespace AppBundle\Form;

use AppBundle\Entity\Baker;
use AppBundle\Entity\ChurroTimeEntry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class ChurroTimeEntryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => ChurroTimeEntry::VALID_CHURRO_TYPES_TEXT,
                'placeholder' => 'Choose a type'
            ])
            ->add('quantityMade', IntegerType::class)
            ->add('bakedBy', EntityType::class, [
                'class' => Baker::class,
                'choice_label' => 'abbreviatedName',
                'placeholder' => 'Choose a baker'
            ])
            ->add('startCookingAt', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('cookingDuration', IntegerType::class, [
                'mapped' => false,
                'label' => 'Cooking time (minutes)',
            ])
            ->add('cleanupDuration', IntegerType::class, [
                'mapped' => false,
                'label' => 'Cleanup time (minutes)',
            ])
        ;
    }
}
