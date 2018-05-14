<?php
// src/Entity/Emplacement.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Emplacement
 *
 * @package App\Entity
 *
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

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getNom(): ?string {
        return $this->nom;
    }

    /**
     * @param string $nom Le nom de l'emplacement
     *
     * @return Emplacement
     */
    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Local|null
     */
    public function getLocal(): ?Local {
        return $this->local;
    }

    /**
     * @param Local $local Le local auquel est rattaché l'emplacement
     *
     * @return Emplacement
     */
    public function setLocal(Local $local): self {
        $this->local = $local;

        return $this;
    }
}
