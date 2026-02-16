<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Formulario de Libro con validaciones básicas DAW.
 */
class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', null, [
                'label' => 'Título',
                'constraints' => [new NotBlank(message: 'El título es obligatorio.')],
            ])
            ->add('autor', null, [
                'label' => 'Autor',
                'constraints' => [new NotBlank(message: 'El autor es obligatorio.')],
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'constraints' => [new NotBlank(message: 'La descripción es obligatoria.')],
            ])
            ->add('precio', MoneyType::class, [
                'label' => 'Precio (€)',
                'currency' => 'EUR',
                'constraints' => [new Positive(message: 'El precio debe ser positivo.')],
            ])
            ->add('estado', null, [
                'label' => 'Estado',
                'constraints' => [new NotBlank(message: 'El estado es obligatorio.')],
            ])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nombre',
                'label' => 'Categoría',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Book::class]);
    }
}
