<?php
// src/Entity/Modele.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeleRepository")
 * @ORM\Table(name="modele")
 * @Vich\Uploadable()
 */
class Modele {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="modifie_le", type="datetime", nullable=true)
     */
    private $modifieLe = null;

    /**
     * @ORM\Column(name="nom", type="string", length=50)
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

    /**
     * @Vich\UploadableField(mapping="image_modele", fileNameProperty="nomFichierImage")
     */
    private $fichierImage;

    /**
     * @ORM\Column(name="nom_fichier_image", type="string", length=255, nullable=true)
     */
    private $nomFichierImage = null;

    public function getId() {
        return $this->id;
    }

    public function getModifieLe(): ?\DateTime {
        return $this->modifieLe;
    }

    public function setModifieLe(?\DateTime $modifieLe = null): self {
        $this->modifieLe = $modifieLe;

        return $this;
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

    public function getFichierImage(): ?File {
        return $this->fichierImage;
    }

    public function setFichierImage(?File $fichierImage = null): self {
        $this->fichierImage = $fichierImage;

        if ($this->fichierImage !== null) {
            $this->modifieLe = new \DateTime('now');
        }

        return $this;
    }

    public function getNomFichierImage(): ?string {
        return $this->nomFichierImage;
    }

    public function setNomFichierImage(?string $nomFichierImage = null): self {
        $this->nomFichierImage = $nomFichierImage;

        return $this;
    }
}
