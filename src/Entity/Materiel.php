<?php
// src/Entity/Materiel.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Classe Logiciel
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\MaterielRepository")
 * @ORM\Table(name="materiel")
 * @ORM\HasLifecycleCallbacks()
 */
class Materiel {
    public const NOMBRE_ITEMS = 10;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=30, unique=true)
     */
    private $nom;

    /**
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(name="ajoute_le", type="datetime")
     */
    private $ajouteLe;

    /**
     * @ORM\Column(name="modifie_le", type="datetime", nullable=true)
     */
    private $modifieLe = null;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = null;

    /**
     * @ORM\Column(name="achete_le", type="date", nullable=true)
     */
    private $acheteLe = null;

    /**
     * @ORM\Column(name="numero_serie", type="string", length=50, nullable=true)
     */
    private $numeroSerie = null;

    /**
     * @ORM\Column(name="antivirus_installe", type="boolean")
     */
    private $antivirusInstalle = false;

    /**
     * @ORM\Column(name="est_maj_via_wsus", type="boolean")
     */
    private $estMajViaWsus = false;

    /**
     * @ORM\Column(name="est_reference_glpi", type="boolean")
     */
    private $estReferenceGlpi = false;

    /**
     * @ORM\Column(name="est_actif_reseau", type="boolean")
     */
    private $estActifReseau = false;

    /**
     * @ORM\Column(name="est_piece_rechange", type="boolean")
     */
    private $estPieceRechange = false;

    /**
     * @ORM\ManyToOne(targetEntity="Modele")
     */
    private $modele = null;

    /**
     * @ORM\ManyToOne(targetEntity="Domaine")
     */
    private $domaine = null;

    /**
     * @ORM\ManyToOne(targetEntity="Emplacement")
     */
    private $emplacement;

    /**
     * @ORM\OneToMany(targetEntity="MaterielPieceRechange", mappedBy="materiel", orphanRemoval=true)
     */
    private $materielPiecesRechange;

    /**
     * @ORM\OneToMany(targetEntity="MaterielSystemeExploitation", mappedBy="materiel", orphanRemoval=true)
     */
    private $materielSystemesExploitation;

    /**
     * @ORM\OneToMany(targetEntity="MaterielLogiciel", mappedBy="materiel", orphanRemoval=true)
     */
    private $materielLogiciels;

    /**
     * @ORM\OneToMany(targetEntity="Sauvegarde", mappedBy="materiel", orphanRemoval=true)
     */
    private $sauvegardes;

    /**
     * @ORM\OneToMany(targetEntity="ConfigurationIp", mappedBy="materiel", orphanRemoval=true)
     */
    private $configurationsIp;

    public function __construct() {
        $this->materielPiecesRechange = new ArrayCollection();
        $this->materielSystemesExploitation = new ArrayCollection();
        $this->materielLogiciels = new ArrayCollection();
        $this->sauvegardes = new ArrayCollection();
        $this->configurationsIp = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = strtoupper($nom);

        return $this;
    }

    public function getSlug(): ?string {
        return $this->slug;
    }

    public function getAjouteLe(): ?\DateTimeInterface {
        return $this->ajouteLe;
    }

    public function setAjouteLe(\DateTimeInterface $ajouteLe): self {
        $this->ajouteLe = $ajouteLe;

        return $this;
    }

    public function getModifieLe(): ?\DateTimeInterface {
        return $this->modifieLe;
    }

    public function setModifieLe(?\DateTimeInterface $modifieLe = null): self {
        $this->modifieLe = $modifieLe;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description = null): self {
        $this->description = $description;

        return $this;
    }

    public function getAcheteLe(): ?\DateTimeInterface {
        return $this->acheteLe;
    }

    public function setAcheteLe(?\DateTimeInterface $acheteLe = null): self {
        $this->acheteLe = $acheteLe;

        return $this;
    }

    public function getNumeroSerie(): ?string {
        return $this->numeroSerie;
    }

    public function setNumeroSerie(?string $numeroSerie = null): self {
        $this->numeroSerie = $numeroSerie;

        return $this;
    }

    public function getAntivirusInstalle(): ?bool {
        return $this->antivirusInstalle;
    }

    public function setAntivirusInstalle(bool $antivirusInstalle): self {
        $this->antivirusInstalle = $antivirusInstalle;

        return $this;
    }

    public function getEstMajViaWsus(): ?bool {
        return $this->estMajViaWsus;
    }

    public function setEstMajViaWsus(bool $estMajViaWsus): self {
        $this->estMajViaWsus = $estMajViaWsus;

        return $this;
    }

    public function getEstReferenceGlpi(): ?bool {
        return $this->estReferenceGlpi;
    }

    public function setEstReferenceGlpi(bool $estReferenceGlpi): self {
        $this->estReferenceGlpi = $estReferenceGlpi;

        return $this;
    }

    public function getEstActifReseau(): ?bool {
        return $this->estActifReseau;
    }

    public function setEstActifReseau(bool $estActifReseau): self {
        $this->estActifReseau = $estActifReseau;

        return $this;
    }

    public function getEstPieceRechange(): ?bool {
        return $this->estPieceRechange;
    }

    public function setEstPieceRechange(bool $estPieceRechange): self {
        $this->estPieceRechange = $estPieceRechange;

        return $this;
    }

    public function getModele(): ?Modele {
        return $this->modele;
    }

    public function setModele(?Modele $modele = null): self {
        $this->modele = $modele;

        return $this;
    }

    public function getDomaine(): ?Domaine {
        return $this->domaine;
    }

    public function setDomaine(?Domaine $domaine = null): self {
        $this->domaine = $domaine;

        return $this;
    }

    public function getEmplacement(): ?Emplacement {
        return $this->emplacement;
    }

    public function setEmplacement(?Emplacement $emplacement = null): self {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * @return Collection|MaterielPieceRechange[]
     */
    public function getMaterielPiecesRechange(): Collection {
        return $this->materielPiecesRechange;
    }

    public function addMaterielPieceRechange(MaterielPieceRechange $materielPieceRechange): self {
        if (!$this->materielPiecesRechange->contains($materielPieceRechange)) {
            $this->materielPiecesRechange[] = $materielPieceRechange;

            $materielPieceRechange->setPieceRechange($this);
        }

        return $this;
    }

    public function removeMaterielPieceRechange(MaterielPieceRechange $materielPieceRechange): self {
        if ($this->materielPiecesRechange->contains($materielPieceRechange)) {
            $this->materielPiecesRechange->removeElement($materielPieceRechange);

            if ($materielPieceRechange->getPieceRechange() === $this) {
                $materielPieceRechange->setPieceRechange(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MaterielSystemeExploitation[]
     */
    public function getMaterielSystemesExploitation(): Collection {
        return $this->materielSystemesExploitation;
    }

    public function addMaterielSystemeExploitation(MaterielSystemeExploitation $materielSystemeExploitation): self {
        if (!$this->materielSystemesExploitation->contains($materielSystemeExploitation)) {
            $this->materielSystemesExploitation[] = $materielSystemeExploitation;
            $materielSystemeExploitation->setMateriel($this);
        }

        return $this;
    }

    public function removeMaterielSystemeExploitation(MaterielSystemeExploitation $materielSystemeExploitation): self
    {
        if ($this->materielSystemesExploitation->contains($materielSystemeExploitation)) {
            $this->materielSystemesExploitation->removeElement($materielSystemeExploitation);

            if ($materielSystemeExploitation->getMateriel() === $this) {
                $materielSystemeExploitation->setMateriel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MaterielLogiciel[]
     */
    public function getMaterielLogiciels(): Collection {
        return $this->materielLogiciels;
    }

    public function addMaterielLogiciel(MaterielLogiciel $materielLogiciel): self {
        if (!$this->materielLogiciels->contains($materielLogiciel)) {
            $this->materielLogiciels[] = $materielLogiciel;

            $materielLogiciel->setMateriel($this);
        }

        return $this;
    }

    public function removeMaterielLogiciel(MaterielLogiciel $materielLogiciel): self {
        if ($this->materielLogiciels->contains($materielLogiciel)) {
            $this->materielLogiciels->removeElement($materielLogiciel);

            if ($materielLogiciel->getMateriel() === $this) {
                $materielLogiciel->setMateriel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sauvegarde[]
     */
    public function getSauvegardes(): Collection {
        return $this->sauvegardes;
    }

    public function addSauvegarde(Sauvegarde $sauvegarde): self {
        if (!$this->sauvegardes->contains($sauvegarde)) {
            $this->sauvegardes[] = $sauvegarde;

            $sauvegarde->setMateriel($this);
        }

        return $this;
    }

    public function removeSauvegarde(Sauvegarde $sauvegarde): self {
        if ($this->sauvegardes->contains($sauvegarde)) {
            $this->sauvegardes->removeElement($sauvegarde);

            if ($sauvegarde->getMateriel() === $this) {
                $sauvegarde->setMateriel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConfigurationIp[]
     */
    public function getConfigurationsIp(): Collection {
        return $this->configurationsIp;
    }

    public function addConfigurationIp(ConfigurationIp $configurationIp): self {
        if (!$this->configurationsIp->contains($configurationIp)) {
            $this->configurationsIp[] = $configurationIp;

            $configurationIp->setMateriel($this);
        }

        return $this;
    }

    public function removeConfigurationIp(ConfigurationIp $configurationIp): self {
        if ($this->configurationsIp->contains($configurationIp)) {
            $this->configurationsIp->removeElement($configurationIp);

            if ($configurationIp->getMateriel() === $this) {
                $configurationIp->setMateriel(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->ajouteLe = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->modifieLe = new \DateTime('now');
    }
}
