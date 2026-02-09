<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Pedido;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', null, [
                'widget' => 'single_text',
                'label' => 'Fecha del pedido',
            ])
            ->add('estado', null, [
                'label' => 'Estado',
            ])
            ->add('books', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'titulo',
                'multiple' => true,
                'label' => 'Libros',
            ]);
    }
}
