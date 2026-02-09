<?php

namespace App\Entity;

use App\Repository\ValoracionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValoracionRepository::class)]
class Valoracion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $puntuacion;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comentario = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $emisor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receptor = null;

    public function getId(): ?int { return $this->id; }
    public function getPuntuacion(): int { return $this->puntuacion; }
    public function setPuntuacion(int $puntuacion): static { $this->puntuacion = $puntuacion; return $this; }
    public function getComentario(): ?string { return $this->comentario; }
    public function setComentario(?string $comentario): static { $this->comentario = $comentario; return $this; }
    public function getFecha(): ?\DateTimeImmutable { return $this->fecha; }
    public function setFecha(\DateTimeImmutable $fecha): static { $this->fecha = $fecha; return $this; }
    public function getEmisor(): ?User { return $this->emisor; }
    public function setEmisor(User $emisor): static { $this->emisor = $emisor; return $this; }
    public function getReceptor(): ?User { return $this->receptor; }
    public function setReceptor(User $receptor): static { $this->receptor = $receptor; return $this; }
}


