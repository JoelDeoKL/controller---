<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('email')
            ->add('nombre_place')
            ->add('rccm')
            ->add('logo')
            ->add('password')
            ->add('idnat')
            ->add('postuler', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
