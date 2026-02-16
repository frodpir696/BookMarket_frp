<?php

namespace App\Repository;

use App\Entity\Carrito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repositorio de la entidad Carrito.
 */
class CarritoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carrito::class);
    }
}
