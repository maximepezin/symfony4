<?php
// src/Entity/Logiciel.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Logiciel
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\LogicielRepository")
 * @ORM\Table(name="logiciel")
 */
class Logiciel {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=50, unique=true)
     */
    private $nom;

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
     * @param string $nom Le nom du logiciel
     *
     * @return Logiciel
     */
    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }
}
