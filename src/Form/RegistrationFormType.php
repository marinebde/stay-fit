<?php

namespace App\Form;

use App\Entity\Partenaire;
use App\Entity\Structure;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\CallbackTransformer;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('statut')
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle Utilisateur',
                'multiple' => false,
                'required' => true,
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Partenaire' => 'ROLE_PARTENAIRE',
                    'Structure' => 'ROLE_STRUCTURE'
                ]
                ])
            ->add('partenaires', EntityType::class, [
                'class' => Partenaire::class,
                'choice_label' => 'nom',
            ])
            ->add('structures', EntityType::class, [
                'class' => Structure::class,
                'choice_label' => 'nom',
            ]);

                $builder
                    ->get('roles')
                    ->addModelTransformer(new CallbackTransformer(
                    function ($rolesAsArray) {
                        // transform the array to a string
                        return implode(', ', $rolesAsArray);
                    },
                    function ($rolesAsString) {
                        // transform the string back to an array
                        return explode(', ', $rolesAsString);
                    }
                ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
