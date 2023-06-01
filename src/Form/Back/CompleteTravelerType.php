<?php

namespace App\Form\Back;

use App\Entity\User;
use App\Entity\Travel;
use App\Entity\Traveler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CompleteTravelerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('users', EntityType::class, [
                'label' => 'Utilisateur(s)',
                'class' => User::class,
                'choice_label' => 'id',
                'multiple' => true, 
                'expanded' => true
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
            'data_class' => Traveler::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
