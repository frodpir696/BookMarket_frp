<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entidad Categoría.
 *
 * Sirve para organizar libros por temática.
 */
#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    /** ID único de la categoría. */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** Nombre de la categoría. */
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'El nombre es obligatorio.')]
    private ?string $nombre = null;

    /** Descripción breve de la categoría. */
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'La descripción es obligatoria.')]
    private ?string $descripcion = null;

    /** Relación 1:N con Libro (una categoría agrupa varios libros). */
    #[ORM\OneToMany(mappedBy: 'categoria', targetEntity: Book::class)]
    private Collection $books;

    public function __construct() { $this->books = new ArrayCollection(); }

    public function getId(): ?int { return $this->id; }
    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }
    public function getDescripcion(): ?string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): static { $this->descripcion = $descripcion; return $this; }

    /** @return Collection<int, Book> */
    public function getBooks(): Collection { return $this->books; }

    public function __toString(): string { return $this->nombre ?? ''; }
}
