<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

class CambiarClaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
                /*
                ->add('oldPassword', PasswordType::class, [
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Contraseña actual',
                    'constraints' => [
                        new Assert\NotBlank(),
                        new UserPassword([
                            'message' => 'Contraseña actual incorrecta'
                        ]),
                    ],
                ])*/
                ->add('newPassword', RepeatedType::class, [
                    'label' => 'Nueva contraseña',
                    'required' => true,
                    'type' => PasswordType::class,
                    'mapped' => false,
                    'invalid_message' => 'No coinciden las contraseñas',
                    'first_options' => [
                        'label' => 'Nueva contraseña',
                        'constraints' => [
                            new Assert\NotBlank()
                        ]
                    ],
                    'second_options' => [
                        'label' => 'Repite la nueva contraseña',
                        'required' => true
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
