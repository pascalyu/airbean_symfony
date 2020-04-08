<?php

namespace App\Form;

use App\Entity\Rent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Rent1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDateAt')
            ->add('endDateAt')
            ->add('price')
            ->add('paid')
            ->add('personNbr')
            ->add('user')
            ->add('Property')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rent::class,
        ]);
    }
}
