<?php
// src/Entity/Local.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Local
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\LocalRepository")
 * @ORM\Table(name="local")
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
     * @param string $nom Le nom du local
     *
     * @return Local
     */
    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Batiment|null
     */
    public function getBatiment(): ?Batiment {
        return $this->batiment;
    }

    /**
     * @param Batiment $batiment Le bâtiment où se trouve le local
     *
     * @return Local
     */
    public function setBatiment(Batiment $batiment): self {
        $this->batiment = $batiment;

        return $this;
    }
}
