<?php

namespace App\Form;

use App\Entity\Partenaire;
use App\Entity\User;
use App\Entity\Structure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents; 

class RegistrationFormType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class, [
            ])
            ->add('statut')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporté au minimum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle Utilisateur',
                'multiple' => false,
                'required' => true,
                'mapped' => true,
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Partenaire' => 'ROLE_PARTENAIRE',
                    'Structure' => 'ROLE_STRUCTURE',
                ]
                ])
            ->add('partenaires', EntityType::class, [
                'class' => Partenaire::class,
                'choice_label' => 'nom',
                'placeholder' =>'',
                'required' => false,
                ])
            ->add('structures', EntityType::class, [
                        'class' => Structure::class,
                        'choice_label' => 'nom',
                        'placeholder' =>'',
                        'required' => false,
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

                $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                    $user = $event->getData();
                    $form = $event->getForm();
                
                    if ($user->getRoles() == 'Partenaire') {
                        $form->add('partenaires', EntityType::class, [
                            'class' => Partenaire::class,
                            'choice_label' => 'nom',
                            'placeholder' =>'',
                            'required' => false,
                        ]);
                        };
                });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
