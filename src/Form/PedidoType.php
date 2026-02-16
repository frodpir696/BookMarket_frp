<?php

namespace App\Form;

use App\Entity\Pedido;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Formulario simple de pedido.
 */
class PedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('total', MoneyType::class, [
                'label' => 'Total (€)',
                'currency' => 'EUR',
                'constraints' => [new Positive(message: 'El total debe ser positivo.')],
            ])
            ->add('estado', null, [
                'label' => 'Estado',
                'constraints' => [new NotBlank(message: 'El estado es obligatorio.')],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Pedido::class]);
    }
}
