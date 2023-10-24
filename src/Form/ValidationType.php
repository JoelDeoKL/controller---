<?php

namespace App\Form;

use App\Entity\Validation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etudiant')
            ->add('date_debut')
            ->add('date_fin')
            ->add('duree')
            ->add('observation')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Stage Academique' => 'Stage Academique',
                    '>Stage Proffessionel' => '>Stage Proffessionel'
                ],
            ])
            ->add('entreprise')
            ->add('editer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Validation::class,
        ]);
    }
}
