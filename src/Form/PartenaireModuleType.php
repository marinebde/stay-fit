<?php

namespace App\Form;

use App\Entity\PartenaireModule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Partenaire;
use App\Entity\Module;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PartenaireModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('partenaires', EntityType::class, [
                'class' => Partenaire::class,
                'choice_label' => 'nom',
                'label' => 'Sélectionner un partenaire',
            ])
            ->add('modules', EntityType::class, [
                  'class' => Module::class,
                  'choice_label' => 'nom',
                  'label' => 'Modules par défaut',
                  'expanded' => true,
                  'multiple' => true,
                 ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PartenaireModule::class,
        ]);
    }
}
