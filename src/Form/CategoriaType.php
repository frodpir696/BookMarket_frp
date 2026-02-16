<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Formulario de Categoría con validaciones básicas.
 */
class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre',
                'constraints' => [new NotBlank(message: 'El nombre es obligatorio.')],
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'constraints' => [new NotBlank(message: 'La descripción es obligatoria.')],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Categoria::class]);
    }
}
