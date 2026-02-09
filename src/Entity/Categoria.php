<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'categoria', targetEntity: Book::class)]
    private Collection $books;

    public function __construct() { $this->books = new ArrayCollection(); }

    public function getId(): ?int { return $this->id; }
    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }

    /** @return Collection<int, Book> */
    public function getBooks(): Collection { return $this->books; }
    public function addBook(Book $book): static {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setCategoria($this);
        }
        return $this;
    }
    public function removeBook(Book $book): static {
        if ($this->books->removeElement($book)) {
            if ($book->getCategoria() === $this) { $book->setCategoria(null); }
        }
        return $this;
    }

    public function __toString(): string { return $this->nombre ?? ''; }
}

