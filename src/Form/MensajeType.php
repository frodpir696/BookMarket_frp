<?php

namespace App\Form;

use App\Entity\Mensaje;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Formulario básico para mensajes internos.
 */
class MensajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('contenido', TextareaType::class, [
            'label' => 'Contenido',
            'constraints' => [new NotBlank(message: 'El contenido es obligatorio.')],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Mensaje::class]);
    }
}
