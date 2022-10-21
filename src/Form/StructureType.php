<?php

namespace App\Form;

use App\Entity\Partenaire;
use App\Entity\Structure;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('code_postal', IntegerType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le code postal doit comporté 5 caractères',
                        'max' => 5,
                    ]),
                ],
            ])
            ->add('ville')
            ->add('statut')
            ->add('nom_gerant')
            ->add('partenaire', EntityType::class, [
                'class' => Partenaire::class,
                'choice_label' => 'nom',
                'label' => 'Partenaire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
