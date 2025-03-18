<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label'    => 'Title',
                'attr'     => [
                    'placeholder' => 'Enter the title of the game',
                ],
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'label'    => 'Host name',
                'attr'     => [
                    'placeholder' => 'Enter your name',
                ],
            ])
            ->add('create', SubmitType::class, [
                'label' => 'Create game',
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
