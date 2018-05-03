<?php
// src/Entity/Etat.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatRepository")
 * @ORM\Table(name="etat")
 */
class Etat {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $libelle;

    public function getId() {
        return $this->id;
    }

    public function getLibelle(): ?string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self {
        $this->libelle = $libelle;

        return $this;
    }
}
