<?php
// src/Entity/MaterielLogiciel.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe MaterielLogiciel
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\MaterielLogicielRepository")
 * @ORM\Table(name="materiel_logiciel")
 */
class MaterielLogiciel {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="installe_le", type="date", nullable=true)
     */
    private $installeLe = null;

    /**
     * @ORM\Column(name="cle_licence", type="string", length=255, nullable=true)
     */
    private $cleLicence = null;

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

    public function __construct(Materiel $materiel) {
        $this->setMateriel($materiel);
    }

    public function getId() {
        return $this->id;
    }

    public function getInstalleLe(): ?\DateTimeInterface {
        return $this->installeLe;
    }

    public function setInstalleLe(?\DateTimeInterface $installeLe = null): self {
        $this->installeLe = $installeLe;

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
}
