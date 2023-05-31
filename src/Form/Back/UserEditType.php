<?php

namespace App\Form\Back;

use App\Entity\User;
use App\Entity\Travel;
use App\Entity\Traveler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER', 
                    'Modérateur' => 'ROLE_MODERATOR'
                ],
                'multiple' => true,
                'expanded' => true
                ])
            ->add('nickname', TextType::class, [
                'label' => 'Pseudo',
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Anniversaire',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'format' => 'dd-MM-yyyy',
            ])
            ->add('picture', TextType::class, [
                'label' => 'Image',
                'empty_data' => null
            ])
            ->add('travelers' , EntityType::class, [
                'label' => 'Voyageur(s)',
                'class' => Traveler::class,
                'choice_label' => 'name',
                'multiple' => true, 
                'expanded' => true 
            ])
            ->add('travels', EntityType::class, [
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
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
