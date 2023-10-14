<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description_tache')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'En cours',
                    'Remplie' => '>Remplie',
                    'Suspendue' => 'Suspendue'
                ],
            ])
            ->add('observation')
            ->add('date_creation')
            ->add('date_fermeture')
            ->add('etudiant')
            ->add('departement')
            ->add('editer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
