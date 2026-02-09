<?php

namespace App\Entity;

use App\Repository\MensajeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MensajeRepository::class)]
class Mensaje
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $contenido = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaEnvio = null;

    #[ORM\Column]
    private bool $leido = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $emisor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receptor = null;

    public function getId(): ?int { return $this->id; }
    public function getContenido(): ?string { return $this->contenido; }
    public function setContenido(string $contenido): static { $this->contenido = $contenido; return $this; }
    public function getFechaEnvio(): ?\DateTimeImmutable { return $this->fechaEnvio; }
    public function setFechaEnvio(\DateTimeImmutable $fechaEnvio): static { $this->fechaEnvio = $fechaEnvio; return $this; }
    public function isLeido(): bool { return $this->leido; }
    public function setLeido(bool $leido): static { $this->leido = $leido; return $this; }
    public function getEmisor(): ?User { return $this->emisor; }
    public function setEmisor(User $emisor): static { $this->emisor = $emisor; return $this; }
    public function getReceptor(): ?User { return $this->receptor; }
    public function setReceptor(User $receptor): static { $this->receptor = $receptor; return $this; }
}


