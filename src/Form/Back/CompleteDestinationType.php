<?php

namespace App\Form\Back;

use App\Entity\Travel;
use App\Entity\Destination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CompleteDestinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Longitude', 
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Latitude', 
            ])
            ->add('travel', EntityType::class, [
                'label' => 'Voyage(s)',
                'class' => Travel::class,
                'choice_label' => 'id',
                'multiple' => true, 
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Destination::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
