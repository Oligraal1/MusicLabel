<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
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
    private $titre;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_production;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Support", mappedBy="id_produit")
     */
    private $supports;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Streaming", mappedBy="id_produit")
     */
    private $streamings;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artiste", inversedBy="produits")
     */
    private $id_artiste;

    public function __construct()
    {
        $this->supports = new ArrayCollection();
        $this->streamings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateProduction(): ?\DateTimeInterface
    {
        return $this->date_production;
    }

    public function setDateProduction(?\DateTimeInterface $date_production): self
    {
        $this->date_production = $date_production;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * @return Collection|Support[]
     */
    public function getSupports(): Collection
    {
        return $this->supports;
    }

    public function addSupport(Support $support): self
    {
        if (!$this->supports->contains($support)) {
            $this->supports[] = $support;
            $support->setIdProduit($this);
        }

        return $this;
    }

    public function removeSupport(Support $support): self
    {
        if ($this->supports->contains($support)) {
            $this->supports->removeElement($support);
            // set the owning side to null (unless already changed)
            if ($support->getIdProduit() === $this) {
                $support->setIdProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Streaming[]
     */
    public function getStreamings(): Collection
    {
        return $this->streamings;
    }

    public function addStreaming(Streaming $streaming): self
    {
        if (!$this->streamings->contains($streaming)) {
            $this->streamings[] = $streaming;
            $streaming->setIdProduit($this);
        }

        return $this;
    }

    public function removeStreaming(Streaming $streaming): self
    {
        if ($this->streamings->contains($streaming)) {
            $this->streamings->removeElement($streaming);
            // set the owning side to null (unless already changed)
            if ($streaming->getIdProduit() === $this) {
                $streaming->setIdProduit(null);
            }
        }

        return $this;
    }

    public function getIdArtiste(): ?Artiste
    {
        return $this->id_artiste;
    }

    public function setIdArtiste(?Artiste $id_artiste): self
    {
        $this->id_artiste = $id_artiste;

        return $this;
    }
    public function __toString(){
        return 'id '.$this->id;
    }
}
