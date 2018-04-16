<?php
// src/Entity/Batiment.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BatimentRepository")
 * @ORM\Table(name="base_materiel_batiment")
 */
class Batiment {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=30, unique=true)
     */
    private $nom;

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

    public function __toString(): string {
        return $this->nom;
    }
}
