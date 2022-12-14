<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Computer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ComputerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model', TextType::class, [
                'label' => "Modèle de l'ordinateur"
            ])
            ->add('description', TextType::class, [
                'label' => "Description du modèle"
            ])
            ->add('price', NumberType::class, [
                'label' => "prix du bien"
            ])
            ->add('releaseYear', NumberType::class, [
                'label' => "Année de sortie"
            ])
            ->add('image', UrlType::class, [
                'label' => "Photo de l'ordinateur",
            ])
            ->add('brand', EntityType::class, [
                'choice_label'=> 'name',
                'class'=> Brand::class,
                'label'=>'Choix de la marque',
                'multiple' => false,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Computer::class,
        ]);
    }
}
