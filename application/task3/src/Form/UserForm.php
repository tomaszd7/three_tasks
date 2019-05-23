<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 3, 'max' => 100]),
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 3, 'max' => 100]),
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('pesel', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 11, 'max' => 11]),
                    new NotBlank(),
                    new NotNull()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}