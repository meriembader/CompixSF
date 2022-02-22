<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")

     *  @Assert\NotNull
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")

     *  @Assert\NotNull
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)

     *  @Assert\NotNull
     * @Assert\Length(min=3)
     */
    private $destination;

     /**
     * @ORM\Column(type="date")
     */
    private $Date;

   /**
     * @ORM\Column(type="date")
     */
    private $Heure;
        /**
     * @ORM\Column(type="integer")
   
  
     */
    private $id_evenement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->Heure;
    }

    public function setHeure(\DateTimeInterface $Heure): self
    {
        $this->Heure = $Heure;

        return $this;
    }
    public function getIdEvenement(): ?int
    {
        return $this->id_evenement;
    }

    public function setIdEvenement(int $id_evenement): self
    {
        $this->id_evenement = $id_evenement;

        return $this;
    }
}
