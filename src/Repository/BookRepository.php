<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Book[]
     */
    public function findByCategoria(Categoria $categoria): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.categoria = :categoria')
            ->setParameter('categoria', $categoria)
            ->orderBy('b.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
