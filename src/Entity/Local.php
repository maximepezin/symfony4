<?php
// src/Entity/Local.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocalRepository")
 * @ORM\Table(name="base_materiel_local")
 */
class Local {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="Batiment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $batiment;

    public function getId() {
        return $this->id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getBatiment(): ?Batiment {
        return $this->batiment;
    }

    public function setBatiment(Batiment $batiment): self {
        $this->batiment = $batiment;

        return $this;
    }

    public function __toString(): string {
        return $this->nom . " / " . $this->batiment->getNom();
    }
}
