<?php
// src/Entity/Fabricant.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FabricantRepository")
 * @ORM\Table(name="base_materiel_fabricant")
 */
class Fabricant {
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
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $slug;

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

    public function getSlug(): ?string {
        return $this->slug;
    }

    public function __toString() {
        return $this->nom;
    }
}
