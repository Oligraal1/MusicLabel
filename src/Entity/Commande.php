<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_commande;

    /**
     * @ORM\Column(type="date")
     */
    private $date_commande;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandLigne", mappedBy="id_command")
     */
    private $commandLignes;

    public function __construct()
    {
        $this->commandLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCommande(): ?int
    {
        return $this->num_commande;
    }

    public function setNumCommande(int $num_commande): self
    {
        $this->num_commande = $num_commande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return Collection|CommandLigne[]
     */
    public function getCommandLignes(): Collection
    {
        return $this->commandLignes;
    }

    public function addCommandLigne(CommandLigne $commandLigne): self
    {
        if (!$this->commandLignes->contains($commandLigne)) {
            $this->commandLignes[] = $commandLigne;
            $commandLigne->setIdCommand($this);
        }

        return $this;
    }

    public function removeCommandLigne(CommandLigne $commandLigne): self
    {
        if ($this->commandLignes->contains($commandLigne)) {
            $this->commandLignes->removeElement($commandLigne);
            // set the owning side to null (unless already changed)
            if ($commandLigne->getIdCommand() === $this) {
                $commandLigne->setIdCommand(null);
            }
        }

        return $this;
    }
}
