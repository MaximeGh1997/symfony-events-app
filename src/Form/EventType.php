<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Types;
use App\Form\SelectTypesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EventType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    protected function getConfiguration($label,$options=[]){
        return array_merge_recursive([
            'label' => $label,
            ], $options);

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration('Nom de l\'événement'))
            ->add('place', TextType::class, $this->getConfiguration('Lieu de l\'événement'))
            ->add('date', DateTimeType::class, $this->getConfiguration('Date de l\'événement'))
            ->add('description', TextareaType::class, $this->getConfiguration('Description de l\'événement'))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix de l\'événement'))
            ->add('cover', UrlType::class, $this->getConfiguration('Image de couverture'))
            ->add('slug', TextType::class, $this->getConfiguration('Adresse web (automatique)',[
                'required' => false
            ]))
            ->add('type', EntityType::class, [
                'class' => Types::class,
                'choice_label' => 'title'
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
