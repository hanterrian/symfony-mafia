<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoinGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('key', TextType::class, [
                'required' => true,
                'label'    => 'Game key',
                'attr'     => [
                    'placeholder' => 'Enter the key of the game',
                ],
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'label'    => 'Your name',
                'attr'     => [
                    'placeholder' => 'Enter your name',
                ],
            ])
            ->add('join', SubmitType::class, [
                'label' => 'Join game',
                'attr'  => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
