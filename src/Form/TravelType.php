<?php

namespace App\Form;

use App\Entity\Travel;
use App\Entity\Traveler;
use App\Form\TravelerType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TravelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, [
                'label' => 'Début',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'empty_data' => '1900-01-01',
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Fin',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'empty_data' => '1900-01-01',
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('picture', TextType::class, [
                'label' => 'Photo',
                'help' => 'Lien en https://...',
                'required' => false,
            ])
            ->add('travelerNumber', NumberType::class, [
                'label' => 'Nombre de voyageurs', 
            ])
            // ->add('travelers', EntityType::class, [
            //     'label' => 'Voyageur(s)',
            //     'class' => Traveler::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            //     'expanded' => true,
            //     'mapped' => false,
            // ])
            ->add('travelers', CollectionType::class, [
                'entry_type' => TravelerType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])

           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Travel::class,
        ]);
    }
}
