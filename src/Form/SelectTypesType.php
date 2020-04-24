<?php

namespace App\Form;

use App\Entity\Types;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SelectTypesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', ChoiceType::class, [
                'label' => 'Selectionnez un type d\'événement',
                'choices' => [
                    'Tous' => null,
                    'Concert' => 16,
                    'Festival' => 17,
                    'Cinéma' => 18,
                    'Sport' => 19,
                    'Spectacle' => 20
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Types::class,
        ]);
    }
}
