<?php

namespace App\Form\Back;

use App\Entity\User;
use App\Entity\Travel;
use App\Form\Back\TravelerType;
use App\Form\Back\DestinationType;
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
        ->add('title', TextType::class, [
            'label' => 'Titre'
        ])
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
        ->add('travelers', CollectionType::class, [
            'entry_type' => TravelerType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'label' => false,
            'required' => false,
        ]) 
        ->add('destinations', CollectionType::class, [
            'entry_type' => DestinationType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'label' => false,
            'required' => false,
        ])
        ->add('users', EntityType::class, [
            'label' => 'Utilisateur(s)',
            'class' => User::class,
            'choice_label' => 'id',
            'multiple' => true, 
            'expanded' => true
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
