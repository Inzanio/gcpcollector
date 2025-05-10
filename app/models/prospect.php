<?php

namespace App\Models;
use App\Models\Traits\DbDataTrait;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;
use Datetime;
use InvalidArgumentException;

class Prospect extends Personne
{
    use DbDataTrait;

    /**
     * Profession du prospect
     * @var string
     */
    private string $profession;

    /**
     * Besoins objectifs financiers du prospect
     * @var string[]
     */
    private array $produitsInteresse;

    /**
     * Connaissance de la banque par le prospect
     * @var bool
     */
    private bool $connaissanceBanque;

    /**
     * id de l'agent prospecteur ayant enregistré le prospect
     * @var string
     */
    private string $idAgentProspecteur;

    /**
     * id de l'agent prospecteur ayant enregistré le prospect
     * @var string
     */
    private string $commentaire;



    /**
     * 
     */
    private string $idAgence;

    /**
     * Adresse email du prospect
     * @var string
     */
    private string $email;


    /**
     * Numéro de compte du client
     * @var string
     */
    private string $numeroCompte = "";

    /**
     * Date d'ouverture du compte
     * @var ?FireStoreTimestamp
     */
    private ?FireStoreTimestamp $dateOuvertureCompte = null;


    /**
     * Constructeur de la classe Prospect
     * @param string $nom Nom du prospect
     * @param string $prenom Prénom du prospect
     * @param ?FireStoreTimestamp|Datetime $dateNaissance Date de naissance du prospect 
     * @param string[] $telephone Liste des numéros de téléphone du prospect (optionnel)
     * @param string $adresse Adresse du prospect (optionnel)
     * @param string $profession Profession du prospect
     * @param string[] $produitsInteresse Besoins objectifs financiers du prospect
     * @param bool $connaissanceBanque Connaissance de la banque par le prospect
     */
    public function __construct(
        string $nom,
        string $prenom,
        ?FireStoreTimestamp $dateNaissance,
        array $telephone = [],
        string $adresse = "",
        string $profession = "",
        array $produitsInteresse = [],
        bool $connaissanceBanque = false,
        string $idAgentProspecteur = ""
    ) {
        parent::__construct($nom, $prenom, $dateNaissance, $telephone, $adresse);
        $this->setProfession($profession);
        $this->setproduitsInteresse($produitsInteresse);
        $this->connaissanceBanque = $connaissanceBanque;
        $this->idAgentProspecteur = $idAgentProspecteur;
        $this->commentaire = "";
        $this->docId = "";
        $this->idAgence = "";
        $this->email = ""; 
        $this->setDateNaissance($dateNaissance);
       

    }

    /**
     * Récupère le commentaire du prospect
     * @return string
     */
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }

    /**
     * Modifie le commentaire du prospect
     * @param string $commentaire Nouveau commentaire
     */
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }

    /**
     * Récupère la profession du prospect
     * @return string
     */
    public function getProfession(): string
    {
        return $this->profession;
    }

    /**
     * Modifie la profession du prospect
     * @param string $profession Nouvelle profession
     */
    public function setProfession(string $profession): void
    {
        if (!in_array($profession, PROFESSIONS)) {
            throw new InvalidArgumentException("Profession invalide");
        }
        $this->profession = $profession;
    }

    /**
     * Récupère les besoins objectifs financiers du prospect
     * @return string[]
     */
    public function getproduitsInteresse(): array
    {
        return $this->produitsInteresse;
    }

    /**
     * Modifie les besoins objectifs financiers du prospect
     * @param string[] $produitsInteresse Nouveaux besoins objectifs financiers
     */
    public function setproduitsInteresse(array $produitsInteresse): void
    {
        foreach ($produitsInteresse as $besoin) {
            if (!in_array($besoin, PRODUITS_BANQUES)) {
                throw new InvalidArgumentException("Besoin objectif financier invalide");
            }
        }
        $this->produitsInteresse = $produitsInteresse;
    }

    /**
     * Récupère la connaissance de la banque par le prospect
     * @return bool
     */
    public function getConnaissanceBanque(): bool
    {
        return $this->connaissanceBanque;
    }

    /**
     * Modifie la connaissance de la banque par le prospect
     * @param bool $connaissanceBanque Nouvelle connaissance de la banque
     */
    public function setConnaissanceBanque(bool $connaissanceBanque): void
    {
        $this->connaissanceBanque = $connaissanceBanque;
    }

    /**
     * Récupère l'ID de l'agent prospecteur
     * @return string
     */
    public function getIdAgentProspecteur(): string
    {
        return $this->idAgentProspecteur;
    }

    /**
     * Modifie l'ID de l'agent prospecteur
     * @param string $idAgentProspecteur Nouvel ID de l'agent prospecteur
     */
    public function setIdAgentProspecteur(string $idAgentProspecteur): void
    {
        $this->idAgentProspecteur = $idAgentProspecteur;
    }

    /**
     * Récupère l'ID de l'agence
     * @return string
     */
    public function getIdAgence(): string
    {
        return $this->idAgence;
    }

    /**
     * Modifie l'ID de l'agence
     * @param string $idAgence Nouvel ID de l'agence
     */
    public function setIdAgence(string $idAgence): void
    {
        $this->idAgence = $idAgence;
    }

    /**
     * Récupère l'adresse email du prospect
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Modifie l'adresse email du prospect
     * @param string $email Nouvelle adresse email
     */
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Adresse email invalide");
        }
        $this->email = $email;
    }
    /**
     * Récupère le numéro de compte du client
     * @return string
     */
    public function getNumeroCompte(): string
    {
        return $this->numeroCompte;
    }

    /**
     * Modifie le numéro de compte du client
     * @param string $numeroCompte Nouveau numéro de compte
     */
    public function setNumeroCompte(string $numeroCompte): void
    {
        $this->numeroCompte = $numeroCompte;
    }

    /**
     * Récupère la date d'ouverture du compte
     * @return ?FireStoreTimestamp
     */
    public function getDateOuvertureCompte(): ?FireStoreTimestamp
    {
        if ($this->dateOuvertureCompte == null) {
            return null;
        }
        //return $this->dateOuvertureCompte->format("Y-m-d H:i:s");
        return $this->dateOuvertureCompte;
    }

    /**
     * Modifie la date d'ouverture du compte
     * @param ?FireStoreTimestamp $dateOuvertureCompte Nouvelle date d'ouverture du compte
     */
    public function setDateOuvertureCompte(?FireStoreTimestamp $dateOuvertureCompte): void
    {
        $this->dateOuvertureCompte = $dateOuvertureCompte;
    }

    public function isClient() : bool
    {
        return $this->getNumeroCompte() != "" && $this->getDateOuvertureCompte() != null;
        
    }

}