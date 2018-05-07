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
    private $image;

    /**
     * @ORM\Column(name="nom_fichier_image", type="string", length=255, nullable=true)
     */
    private $nomFichierImage = null;

    /**
     * @ORM\Column(name="image_ajoutee_le", type="datetime", nullable=true)
     */
    private $imageAjouteeLe = null;

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

    public function getImage(): ?File {
        return $this->image;
    }

    public function setImage(?File $image = null): self {
        $this->image = $image;

        if ($this->image !== null) {
            $this->imageAjouteeLe = new \DateTime('now');
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

    public function getImageAjouteeLe(): ?\DateTime {
        return $this->imageAjouteeLe;
    }

    public function setImageAjouteeLe(?\DateTime $imageAjouteeLe = null): self {
        $this->imageAjouteeLe = $imageAjouteeLe;

        return $this;
    }
}
