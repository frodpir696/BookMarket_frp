<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Categoria;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', null, [
                'label' => 'Título',
            ])
            ->add('autor', null, [
                'label' => 'Autor',
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción',
            ])
            ->add('estado', null, [
                'label' => 'Estado del libro',
            ])
            ->add('precio', null, [
                'label' => 'Precio (€)',
            ])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nombre',
                'label' => 'Categoría',
            ]);
    }
}
