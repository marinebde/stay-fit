<?php

namespace App\Form;

use App\Entity\Partenaire;
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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\Security;

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
            ->add('nom')
            ->add('prenom')
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
                ]);



        $builder->get('roles')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $form = $event->getForm();

                $user = $this->security->getUser();
                if ($user->getRoles('ROLE_PARTENAIRE')) {
                    $this->addPartenaire($form->getParent(), $form->getData());
                }

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback function!
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
              $data = $event->getData();
              /* @var $ville Ville */
              $user = $data->getRoles();
              $form = $event->getForm();
              if ($user) {
                // On récupère le département et la région
                $user= $user->getRoles();
                // On crée les 2 champs supplémentaires
                $this->addPartenaire($form, $user);
                // On set les données
                $form->get('roles')->setData($user);
              } else {
                // On crée les 2 champs en les laissant vide (champs utilisé pour le JavaScript)
                $this->addPartenaire($form, null);
              }
            }
          );



            //->add('partenaires', EntityType::class, [
            //    'class' => Partenaire::class,
            //    'choice_label' => 'nom',
            //])
            //->add('structures', EntityType::class, [
            //    'class' => Structure::class,
            //    'choice_label' => 'nom',
            //]);

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

private function addPartenaire(FormInterface $form)
{
  $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
    'partenaires',
    EntityType::class,
    null,
    [
        'class' => Partenaire::class,
        'choice_label' => 'nom',
        'placeholder' => '',
        'mapped' => true,
        'required' => false,
        'auto_initialize' => false,
    ]
    );
    $builder->addEventListener(
        FormEvents::POST_SUBMIT,
        function (FormEvent $event) {
          $form = $event->getForm();
        }
      );
      $form->add($builder->getForm());
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
