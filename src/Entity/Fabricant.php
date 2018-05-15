<?php
// src/Entity/Fabricant.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Fabricant
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\FabricantRepository")
 * @ORM\Table(name="fabricant")
 */
class Fabricant {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=50)
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
     * @param string $nom Le nom du fabricant
     *
     * @return Fabricant
     */
    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }
}
