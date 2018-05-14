<?php
// src/Entity/Utilisateur.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur implements UserInterface, \Serializable {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="ajoute_le", type="datetime")
     */
    private $ajouteLe;

    /**
     * @ORM\Column(name="modifie_le", type="datetime", nullable=true)
     */
    private $modifieLe;

    /**
     * @ORM\Column(name="username", type="string", length=30, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = ['ROLE_UTILISATEUR'];

    /**
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    public function __construct() {
        $this->roles = ['ROLE_UTILISATEUR'];
    }

    public function getId() {
        return $this->id;
    }

    public function getAjouteLe(): ?\DateTime {
        return $this->ajouteLe;
    }

    public function setAjouteLe(\DateTime $ajouteLe): self {
        $this->ajouteLe = $ajouteLe;

        return $this;
    }

    public function getModifieLe(): ?\DateTime {
        return $this->modifieLe;
    }

    public function setModifieLe(\DateTime $modifieLe = null): self {
        $this->modifieLe = $modifieLe;

        return $this;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(string $username): self {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    public function getSalt() {
        return null;
    }

    public function getRoles(): array {
        return ['ROLE_UTILISATEUR'];
        //return $this->roles;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self {
        $this->prenom = $prenom;

        return $this;
    }

    public function getGravatar(): ?string {
        $hash = md5(strtolower(trim($this->email)));

        return
            '<img src="'
            . 'https://secure.gravatar.com/avatar/'
            . $hash
            . '?d=identicon'
            . '" class="header-avatar img-circle ml10" alt="user" title="'
            . $this->username
            . '" style="width: 45px;" />'
        ;
    }

    public function eraseCredentials() {

    }

    public function serialize() {
        return serialize([
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->roles,
            $this->nom,
            $this->prenom,
        ]);
    }

    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->roles,
            $this->nom,
            $this->prenom,
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
