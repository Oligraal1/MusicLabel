<?php

namespace App\Form;

use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('artiste', EntityType::class, [
            // 'mapped' => false,
            // 'required' => false,
            'label' => 'Voici les artistes de notre Label : ',
            'placeholder' => '--- Select ---',
            'class' => Artiste::class,
            'choice_label' => function (Artiste $artiste) {
                return sprintf(
                    '%s',
                    $artiste->getNom()
                );
            },
            'constraints' => [
                new NotBlank()
            ],
        ])
    ->add('chercher', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // 'data_class' => Artiste::class,
        ]);
    }
}