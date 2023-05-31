<?php

namespace App\Form\Front;

use App\Entity\User;
use App\Entity\Traveler;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTravelersType extends AbstractType
{
    // to have the current user object (do not forget the use)
    public function __construct(
        private Security $security,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // grab the user, do a quick sanity check that one exists
        $user = $this->security->getUser();
        if (!$user) {
            throw new \LogicException(
                'The UserTravelersType cannot be used without an authenticated user!'
            );
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
        
            $form = $event->getForm();

            $formOptions = [
                'class' => Traveler::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    // call a method on your repository that returns the query builder
                    return $er->createQueryBuilder('u')
                        ->where('u.id = :user')
                        ->setParameters(['user' => $user->getId()]);
                },
                'choice_label' => 'name',
                'multiple' => true, 
                'expanded' => true, 
                'label' => 'Voyageur(s) de votre liste',
            ];
            // field name, field type, field options
            $form->add('travelers', EntityType::class, $formOptions);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
