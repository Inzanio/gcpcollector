<?php

namespace App\Models;

use App\Models\Traits\CreatableByUserTrait;
use App\Models\Traits\DbDataTrait;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;


/**
 * Classe représentant un utilisateur
 */
class Utilisateur extends Personne
{
    use DbDataTrait;
    use CreatableByUserTrait;
    /**
     * Matricule de l'utilisateur
     * @var string
     */
    private string $matricule;

    /**
     * Login de l'utilisateur
     * @var string
     */
    private string $login;

    /**
     * Mot de passe de l'utilisateur
     * @var string
     */
    private string $password;

    /**
     * Rôle de l'utilisateur
     * @var string
     */
    private string $role;

    /**
     * Nom de la collection ou de la table des utilisateurs
     */
    private static string $collection_name = "utilisateurs";

    private ?string $idAgence = "";



    /**
     * Constructeur de la classe Utilisateur
     * @param string $nom Nom de l'utilisateur
     * @param string $prenom Prénom de l'utilisateur
     * @param ?FireStoreTimestamp $dateNaissance Date de naissance de l'utilisateur
     * @param string $matricule Matricule de l'utilisateur
     * @param string $login Login de l'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     * @param string $role Rôle de l'utilisateur
     * @param array $telephone Liste des numéros de téléphone de l'utilisateur (optionnel)
     * @param string $adresse Adresse de l'utilisateur (optionnel)
     */
    public function __construct(string $nom, string $prenom, ?FireStoreTimestamp $dateNaissance, string $matricule, string $login, string $password, string $role, array $telephone = [], string $adresse = "")
    {
        parent::__construct($nom, $prenom, $dateNaissance, $telephone, $adresse);
        $this->matricule = $matricule;
        $this->login = $login;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Récupère l'ID de l'agence de l'utilisateur
     * @return ?string
     */
    public function getIdAgence(): ?string
    {
        return $this->idAgence;
    }

    /**
     * Modifie l'ID de l'agence de l'utilisateur
     * @param ?string $idAgence Nouveau ID de l'agence
     */
    public function setIdAgence(?string $idAgence): void
    {
        $this->idAgence = $idAgence;
    }

    /**
     * Récupère le matricule de l'utilisateur
     * @return string
     */
    public function getMatricule(): string
    {

        return $this->matricule;
    }

    /**
     * Modifie le matricule de l'utilisateur
     * @param string $matricule Nouveau matricule
     */
    public function setMatricule(string $matricule): void
    {
        $this->matricule = $matricule;
    }

    /**
     * Récupère le login de l'utilisateur
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Modifie le login de l'utilisateur
     * @param string $login Nouveau login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * Donen le mot de passe hashé
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


    /**
     * Modifie le mot de passe de l'utilisateur
     * @param string $password Nouveau mot de passe
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Récupère le rôle de l'utilisateur
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Modifie le rôle de l'utilisateur
     * @param string $role Nouveau rôle
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}
