<?php

namespace App\Form;

use App\Entity\Partenaire;
use App\Entity\Module;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('statut')
           //->add('partenaireModules', CollectionType::class, [
           //    'entry_type' => PartenaireModuleType::class,
           //    'by_reference' => false,
           //    'allow_add' => false,
           //    'allow_delete' => false,
           //])
           //->add('modules', EntityType::class, [
           //    'class' => Module::class,
           //    'choice_label' => 'nom',
           //    'label' => 'Modules par défaut',
           //    'expanded' => true,
           //    'multiple' => true,
           //    'mapped' => false,
           // ])
             ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}
