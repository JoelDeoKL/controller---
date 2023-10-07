<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_entreprise')
            ->add('description_entreprise')
            ->add('adresse_entreprise')
            ->add('telephone_entreprise')
            ->add('etat_entreprise')
            ->add('secteur_entreprise')
            ->add('date_creation')
            ->add('date_validation')
            ->add('email_entreprise')
            ->add('nombre_place')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
