<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Property1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('surfaceArea')
            ->add('roomNbr')
            ->add('bedSmallNbr')
            ->add('bedBigNbr')
            ->add('pricePerDay')

            ->add('pictureFile', FileType::class, ['required' => false])
            ->add('Address', AddressType::class);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
