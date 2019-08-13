<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupportRepository")
 */
class Support
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_support;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit", inversedBy="supports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_produit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandLigne", mappedBy="num_support")
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

    public function getTypeSupport(): ?string
    {
        return $this->type_support;
    }

    public function setTypeSupport(string $type_support): self
    {
        $this->type_support = $type_support;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->id_produit;
    }

    public function setIdProduit(?Produit $id_produit): self
    {
        $this->id_produit = $id_produit;

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
            $commandLigne->setNumSupport($this);
        }

        return $this;
    }

    public function removeCommandLigne(CommandLigne $commandLigne): self
    {
        if ($this->commandLignes->contains($commandLigne)) {
            $this->commandLignes->removeElement($commandLigne);
            // set the owning side to null (unless already changed)
            if ($commandLigne->getNumSupport() === $this) {
                $commandLigne->setNumSupport(null);
            }
        }

        return $this;
    }
}
