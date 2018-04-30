<?php
// src/Entity/ConfigurationIp.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfigurationIpRepository")
 * @ORM\Table(name="configuration_ip")
 */
class ConfigurationIp {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="libelle", type="string", length=50, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(name="adresse_ip", type="string", length=15)
     */
    private $adresseIp;

    /**
     * @ORM\Column(name="masque_sous_reseau", type="string", length=15)
     */
    private $masqueSousReseau;

    /**
     * @ORM\ManyToOne(targetEntity="Materiel", inversedBy="configurationsIp")
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    public function getId() {
        return $this->id;
    }

    public function getLibelle(): ?string {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle = null): self {
        $this->libelle = $libelle;

        return $this;
    }

    public function getAdresseIp(): ?string {
        return $this->adresseIp;
    }

    public function setAdresseIp(string $adresseIp): self {
        $this->adresseIp = $adresseIp;

        return $this;
    }

    public function getMasqueSousReseau(): ?string {
        return $this->masqueSousReseau;
    }

    public function setMasqueSousReseau(string $masqueSousReseau): self {
        $this->masqueSousReseau = $masqueSousReseau;

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
