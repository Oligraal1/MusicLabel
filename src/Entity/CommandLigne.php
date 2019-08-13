<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandLigneRepository")
 */
class CommandLigne
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
    private $num_command;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Support", inversedBy="commandLignes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_support;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="commandLignes")
     */
    private $id_command;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCommand(): ?int
    {
        return $this->num_command;
    }

    public function setNumCommand(int $num_command): self
    {
        $this->num_command = $num_command;

        return $this;
    }

    public function getNumSupport(): ?Support
    {
        return $this->num_support;
    }

    public function setNumSupport(?Support $num_support): self
    {
        $this->num_support = $num_support;

        return $this;
    }

    public function getIdCommand(): ?Commande
    {
        return $this->id_command;
    }

    public function setIdCommand(?Commande $id_command): self
    {
        $this->id_command = $id_command;

        return $this;
    }
}
