<?php

namespace App\Form;

use App\Entity\Cote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cote')
            ->add('etudiant')
            ->add('promotion')
            ->add('date_cotation')
            ->add('provenance', ChoiceType::class, [
                'choices' => [
                    'Entreprise' => 'Entreprise',
                    'ESIS' => 'ESIS'
                ],
            ])
            ->add('entreprise')
            ->add('editer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cote::class,
        ]);
    }
}
