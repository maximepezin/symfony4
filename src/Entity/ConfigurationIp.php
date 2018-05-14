<?php
// src/Entity/ConfigurationIp.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe ConfigurationIp
 *
 * @package App\Entity
 *
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
    private $libelle = null;

    /**
     * @ORM\Column(name="adresse_ip_v4", type="string", length=15)
     */
    private $adresseIpV4;

    /**
     * @ORM\Column(name="masque_sous_reseau", type="string", length=15)
     */
    private $masqueSousReseau;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = null;

    /**
     * @ORM\ManyToOne(targetEntity="Materiel", inversedBy="configurationsIp")
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    /**
     * Constructeur ConfigurationIp
     *
     * @param Materiel $materiel Le matériel propriétaire de la configuration IP
     */
    public function __construct(Materiel $materiel) {
        $this->setMateriel($materiel);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getLibelle(): ?string {
        return $this->libelle;
    }

    /**
     * @param null|string $libelle Le libellé de la configuration IP
     *
     * @return ConfigurationIp
     */
    public function setLibelle(?string $libelle = null): self {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAdresseIpV4(): ?string {
        return $this->adresseIpV4;
    }

    /**
     * @param string $adresseIpV4 L'adresse IPv4
     *
     * @return ConfigurationIp
     */
    public function setAdresseIpV4(string $adresseIpV4): self {
        $this->adresseIpV4 = $adresseIpV4;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMasqueSousReseau(): ?string {
        return $this->masqueSousReseau;
    }

    /**
     * @param string $masqueSousReseau Le masque de sous-réseau
     *
     * @return ConfigurationIp
     */
    public function setMasqueSousReseau(string $masqueSousReseau): self {
        $this->masqueSousReseau = $masqueSousReseau;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * @param null|string $description Une description
     *
     * @return ConfigurationIp
     */
    public function setDescription(?string $description = null): self {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Materiel|null
     */
    public function getMateriel(): ?Materiel {
        return $this->materiel;
    }

    /**
     * @param Materiel $materiel Le matériel propriétaire de la configuration IP
     *
     * @return ConfigurationIp
     */
    public function setMateriel(Materiel $materiel): self {
        $this->materiel = $materiel;

        return $this;
    }
}
