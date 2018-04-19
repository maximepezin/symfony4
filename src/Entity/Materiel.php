<?php
// src/Entity/Materiel.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MaterielRepository")
 * @ORM\Table(name="base_materiel_materiel")
 * @ORM\HasLifecycleCallbacks()
 */
class Materiel {
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
    private $modifieLe;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="achete_le", type="date", nullable=true)
     */
    private $acheteLe;

    /**
     * @ORM\Column(name="numero_serie", type="string", length=50, unique=true, nullable=true)
     */
    private $numeroSerie;

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
    private $modele;

    /**
     * @ORM\ManyToOne(targetEntity="Domaine")
     */
    private $domaine;

    /**
     * @ORM\OneToMany(targetEntity="MaterielPieceRechange", mappedBy="materiel")
     */
    private $materielPieceRechanges;

    /**
     * @ORM\ManyToOne(targetEntity="Emplacement")
     */
    private $emplacement;

    /**
     * @ORM\OneToMany(targetEntity="MaterielLogiciel", mappedBy="materiel", orphanRemoval=true)
     */
    private $materielLogiciels;

    /**
     * @ORM\OneToMany(targetEntity="Sauvegarde", mappedBy="materiel", orphanRemoval=true)
     */
    private $sauvegardes;

    /**
     * @ORM\OneToMany(targetEntity="MaterielSystemeExploitation", mappedBy="materiel", orphanRemoval=true)
     */
    private $materielSystemeExploitations;

    public function __construct() {
        $this->materielPieceRechanges = new ArrayCollection();
        $this->materielLogiciels = new ArrayCollection();
        $this->sauvegardes = new ArrayCollection();
        $this->materielSystemeExploitations = new ArrayCollection();
    }

    public function getId() {
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

    public function getDescriptionCourte(): ?string {
        return substr($this->description, 0, 35) . (strlen($this->description) > 35 ? '[...]' : '');
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
     * @ORM\PrePersist()
     */
    public function prePersist() {
        /*
        if ($this->estPieceRechange && substr($this->nom, 0, 3) !== 'PR_') {
            $this->nom = 'PR_' . $this->nom;
            // Pas besoin de toucher au slug en prePersist !
        }
        */

        $this->ajouteLe = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        /*
        if ($this->estPieceRechange && substr($this->nom, 0, 3) !== 'PR_') {
            $this->nom = 'PR_' . $this->nom;
            $this->slug = 'pr-' . $this->slug;
        }
        else if (!$this->estPieceRechange && substr($this->nom, 0, 3) === 'PR_') {
            $this->nom = substr($this->nom, 3);
            $this->slug = substr($this->slug, 3);
        }
        */

        $this->modifieLe = new \DateTime('now');
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
            // set the owning side to null (unless already changed)
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
            // set the owning side to null (unless already changed)
            if ($sauvegarde->getMateriel() === $this) {
                $sauvegarde->setMateriel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MaterielPieceRechange[]
     */
    public function getMaterielPieceRechanges(): Collection {
        return $this->materielPieceRechanges;
    }

    public function addMaterielPieceRechange(MaterielPieceRechange $materielPieceRechange): self {
        if (!$this->materielPieceRechanges->contains($materielPieceRechange)) {
            $this->materielPieceRechanges[] = $materielPieceRechange;

            $materielPieceRechange->setPieceRechange($this);
        }

        return $this;
    }

    public function removeMaterielPieceRechange(MaterielPieceRechange $materielPieceRechange): self {
        if ($this->materielPieceRechanges->contains($materielPieceRechange)) {
            $this->materielPieceRechanges->removeElement($materielPieceRechange);
            // set the owning side to null (unless already changed)
            if ($materielPieceRechange->getPieceRechange() === $this) {
                $materielPieceRechange->setPieceRechange(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MaterielSystemeExploitation[]
     */
    public function getMaterielSystemeExploitations(): Collection
    {
        return $this->materielSystemeExploitations;
    }

    public function addMaterielSystemeExploitation(MaterielSystemeExploitation $materielSystemeExploitation): self
    {
        if (!$this->materielSystemeExploitations->contains($materielSystemeExploitation)) {
            $this->materielSystemeExploitations[] = $materielSystemeExploitation;
            $materielSystemeExploitation->setMateriel($this);
        }

        return $this;
    }

    public function removeMaterielSystemeExploitation(MaterielSystemeExploitation $materielSystemeExploitation): self
    {
        if ($this->materielSystemeExploitations->contains($materielSystemeExploitation)) {
            $this->materielSystemeExploitations->removeElement($materielSystemeExploitation);
            // set the owning side to null (unless already changed)
            if ($materielSystemeExploitation->getMateriel() === $this) {
                $materielSystemeExploitation->setMateriel(null);
            }
        }

        return $this;
    }
}
