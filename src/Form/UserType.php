<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre',
                'constraints' => [new NotBlank(message: 'El nombre es obligatorio.')],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(message: 'El email es obligatorio.'),
                    new Email(message: 'El email no es válido.'),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Contraseña',
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'La contraseña es obligatoria.'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
