<?php
// src/Entity/Sauvegarde.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SauvegardeRepository")
 * @ORM\Table(name="base_materiel_sauvegarde")
 */
class Sauvegarde {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="date_heure_sauvegarde", type="datetime")
     */
    private $dateHeureSauvegarde;

    /**
     * @ORM\Column(name="auteur", type="string", length=50)
     */
    private $auteur;

    /**
     * @ORM\Column(name="nom_fichier_sauvegarde", type="string", length=255)
     */
    private $nomFichierSauvegarde;

    /**
     * @ORM\Column(name="chemin_vers_fichier", type="string", length=255)
     */
    private $cheminVersFichier;

    /**
     * @ORM\ManyToOne(targetEntity="MethodeSauvegarde")
     * @ORM\JoinColumn(nullable=false)
     */
    private $methodeSauvegarde;

    /**
     * @ORM\ManyToOne(targetEntity="SupportSauvegarde")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supportSauvegarde;

    /**
     * @ORM\ManyToOne(targetEntity="Materiel", inversedBy="sauvegardes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    public function getId() {
        return $this->id;
    }

    public function getDateHeureSauvegarde(): ?\DateTimeInterface {
        return $this->dateHeureSauvegarde;
    }

    public function setDateHeureSauvegarde(\DateTimeInterface $dateHeureSauvegarde): self {
        $this->dateHeureSauvegarde = $dateHeureSauvegarde;

        return $this;
    }

    public function getAuteur(): ?string {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self {
        $this->auteur = $auteur;

        return $this;
    }

    public function getNomFichierSauvegarde(): ?string {
        return $this->nomFichierSauvegarde;
    }

    public function setNomFichierSauvegarde(string $nomFichierSauvegarde): self {
        $this->nomFichierSauvegarde = $nomFichierSauvegarde;

        return $this;
    }

    public function getCheminVersFichier(): ?string {
        return $this->cheminVersFichier;
    }

    public function setCheminVersFichier(string $cheminVersFichier): self {
        $this->cheminVersFichier = $cheminVersFichier;

        return $this;
    }

    public function getMethodeSauvegarde(): ?MethodeSauvegarde {
        return $this->methodeSauvegarde;
    }

    public function setMethodeSauvegarde(MethodeSauvegarde $methodeSauvegarde): self {
        $this->methodeSauvegarde = $methodeSauvegarde;

        return $this;
    }

    public function getSupportSauvegarde(): ?SupportSauvegarde {
        return $this->supportSauvegarde;
    }

    public function setSupportSauvegarde(SupportSauvegarde $supportSauvegarde): self {
        $this->supportSauvegarde = $supportSauvegarde;

        return $this;
    }

    public function getMateriel(): ?Materiel {
        return $this->materiel;
    }

    public function setMateriel(Materiel $materiel): self {
        $this->materiel = $materiel;

        return $this;
    }
}
