<?php
// src/Entity/Modele.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeleRepository")
 * @ORM\Table(name="modele")
 */
class Modele {
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
     * @ORM\ManyToOne(targetEntity="Fabricant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fabricant;

    /**
     * @ORM\ManyToOne(targetEntity="TypeMateriel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeMateriel;

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

    public function getFabricant(): ?Fabricant {
        return $this->fabricant;
    }

    public function setFabricant(Fabricant $fabricant): self {
        $this->fabricant = $fabricant;

        return $this;
    }

    public function getTypeMateriel(): ?TypeMateriel {
        return $this->typeMateriel;
    }

    public function setTypeMateriel(TypeMateriel $typeMateriel): self {
        $this->typeMateriel = $typeMateriel;

        return $this;
    }
}
