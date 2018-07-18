<?php
// src/Entity/MaterielPieceRechange.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe MaterielPieceRechange
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\MaterielPieceRechangeRepository")
 * @ORM\Table(name="materiel_piece_rechange")
 */
class MaterielPieceRechange {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Materiel", inversedBy="materielPiecesRechange")
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Materiel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pieceRechange;

    /**
     * @ORM\Column(name="est_utilisee", type="boolean")
     */
    private $estUtilisee = false;

    public function __construct(Materiel $materiel) {
        $this->materiel = $materiel;
    }

    public function getId() {
        return $this->id;
    }

    public function getMateriel(): ?Materiel {
        return $this->materiel;
    }

    public function setMateriel(Materiel $materiel): self {
        $this->materiel = $materiel;

        return $this;
    }

    public function getPieceRechange(): ?Materiel {
        return $this->pieceRechange;
    }

    public function setPieceRechange(Materiel $pieceRechange): self {
        $this->pieceRechange = $pieceRechange;

        return $this;
    }

    public function getEstUtilisee(): ?bool {
        return $this->estUtilisee;
    }

    public function setEstUtilisee(bool $estUtilisee): self {
        $this->estUtilisee = $estUtilisee;

        return $this;
    }
}
