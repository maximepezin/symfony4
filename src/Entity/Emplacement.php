<?php
// src/Entity/Emplacement.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmplacementRepository")
 * @ORM\Table(name="emplacement")
 */
class Emplacement {
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
     * @ORM\ManyToOne(targetEntity="Local")
     */
    private $local;

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

    public function getLocal(): ?Local {
        return $this->local;
    }

    public function setLocal(?Local $local = null): self {
        $this->local = $local;

        return $this;
    }
}
