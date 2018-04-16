<?php
// src/Entity/MaterielLogiciel.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MaterielLogicielRepository")
 * @ORM\Table(name="base_materiel_materiel_logiciel")
 */
class MaterielLogiciel {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="date_installation", type="date", nullable=true)
     */
    private $dateInstallation;

    /**
     * @ORM\Column(name="cle_licence", type="string", length=255, unique=true, nullable=true)
     */
    private $cleLicence;

    /**
     * @ORM\ManyToOne(targetEntity="Materiel", inversedBy="materielLogiciels", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    /**
     * @ORM\ManyToOne(targetEntity="Logiciel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $logiciel;

    public function getId() {
        return $this->id;
    }

    public function getDateInstallation(): ?\DateTimeInterface {
        return $this->dateInstallation;
    }

    public function setDateInstallation(?\DateTimeInterface $dateInstallation): self {
        $this->dateInstallation = $dateInstallation;

        return $this;
    }

    public function getCleLicence(): ?string {
        return $this->cleLicence;
    }

    public function setCleLicence(?string $cleLicence = null): self {
        $this->cleLicence = $cleLicence;

        return $this;
    }

    public function getMateriel(): ?Materiel {
        return $this->materiel;
    }

    public function setMateriel(Materiel $materiel): self {
        $this->materiel = $materiel;

        return $this;
    }

    public function getLogiciel(): ?Logiciel {
        return $this->logiciel;
    }

    public function setLogiciel(Logiciel $logiciel): self {
        $this->logiciel = $logiciel;

        return $this;
    }

    public function __toString() {
        return $this->logiciel->getNom();
    }
}
