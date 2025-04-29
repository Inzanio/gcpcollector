<?php

require_once "../models/personne.php";

class Prospect extends Personne
{

    /**
     * Liste des professions prédéfinies
     */
    public const PROFESSIONS = [
        "Commerçant",
        "Entrepreneur",
        "Cadre",
        "Employé",
        "Étudiant",
        "Retraité",
        "Autre"
    ];

    /**
     * Liste des besoins objectifs financiers prédéfinis
     */
    public const PRODUITS_BANQUES = [
        "Épargne",
        "Investissement",
        "Crédit",
        "Assurance",
        "Gestion de patrimoine"
    ];

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
     * Constructeur de la classe Prospect
     * @param string $nom Nom du prospect
     * @param string $prenom Prénom du prospect
     * @param DateTime $dateNaissance Date de naissance du prospect
     * @param string[] $telephone Liste des numéros de téléphone du prospect (optionnel)
     * @param string $adresse Adresse du prospect (optionnel)
     * @param string $profession Profession du prospect
     * @param string[] $produitsInteresse Besoins objectifs financiers du prospect
     * @param bool $connaissanceBanque Connaissance de la banque par le prospect
     */
    public function __construct(
        string $nom,
        string $prenom,
        DateTime $dateNaissance,
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
        if (!in_array($profession, self::PROFESSIONS)) {
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
            if (!in_array($besoin, self::PRODUITS_BANQUES)) {
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
}

require_once "../db.php";

/**
 * Classe de service pour gérer les prospects
 */
class ProspectService
{
    /**
     * Nom de la collection Firestore pour les prospects
     */
    private static $collectionName = "prospects";

    /**
     * Crée un nouveau prospect dans la base de données
     * @param Prospect $prospect - l'objet Prospect à créer
     * @return mixed - le résultat de la création
     */
    public static function createProspect(Prospect $prospect)
    {
        // Préparation des données pour la création
        $data = [
            "nom" => $prospect->getNom(),
            "prenom" => $prospect->getPrenom(),
            "dateNaissance" => $prospect->getDateNaissance()->format("Y-m-d"),
            "telephone" => $prospect->getTelephone(),
            "adresse" => $prospect->getAdresse(),
            "profession" => $prospect->getProfession(),
            "produitsInteresse" => $prospect->getproduitsInteresse(),
            "connaissanceBanque" => $prospect->getConnaissanceBanque(),
            "idAgentProspecteur" => $prospect->getIdAgentProspecteur()
        ];

        // Génération d'un ID unique pour le document
        $documentId = uniqid();

        // Appel de la méthode de création de document dans la classe Database
        $result = Database::createDocument(self::$collectionName, $documentId, $data);
        return $result;
    }

    /**
     * Met à jour un prospect existant
     * @param string $documentId - l'ID du prospect
     * @param Prospect $prospect - l'objet Prospect mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateProspect($documentId, Prospect $prospect)
    {
        // Préparation des données pour la mise à jour
        $data = [
            ["path" => "nom", "value" => $prospect->getNom()],
            ["path" => "prenom", "value" => $prospect->getPrenom()],
            ["path" => "dateNaissance", "value" => $prospect->getDateNaissance()->format("Y-m-d")],
            ["path" => "telephone", "value" => $prospect->getTelephone()],
            ["path" => "adresse", "value" => $prospect->getAdresse()],
            ["path" => "profession", "value" => $prospect->getProfession()],
            ["path" => "produitsInteresse", "value" => $prospect->getproduitsInteresse()],
            ["path" => "connaissanceBanque", "value" => $prospect->getConnaissanceBanque()],
            ["path" => "idAgentProspecteur", "value" => $prospect->getIdAgentProspecteur()]
        ];

        // Appel de la méthode de mise à jour de document dans la classe Database
        $result = Database::updateDocument(self::$collectionName, $documentId, $data);
        return $result;
    }

    /**
     * Supprime un prospect à partir de son ID
     * @param string $documentId - l'ID du prospect
     * @return mixed - le résultat de la suppression
     */
    public static function deleteProspect($documentId)
    {
        // Appel de la méthode de suppression de document dans la classe Database
        $result = Database::deleteDocument(self::$collectionName, $documentId);
        return $result;
    }

    /**
     * Transforme un document Firestore en un objet Prospect
     * @param \MrShan0\PHPFirestore\FireStoreDocument $doc - le document Firestore à transformer
     * @return Prospect - l'objet Prospect créé
     */
    public static function fromFirestoreDocument($doc)
    {
        // Récupération des données du document
        $data = $doc->toArray();

        // Création d'un objet Prospect à partir des données récupérées
        $prospect = new Prospect(
            $data['nom'] ?? "",
            $data['prenom'] ?? "",
            isset($data['dateNaissance']) ? new DateTime($data['dateNaissance']) : new DateTime(),
            $data['telephone'] ?? [],
            $data['adresse'] ?? "",
            $data['profession'] ?? "",
            isset($data['produitsInteresse']) ? (array) $data['produitsInteresse'] : [],
            $data['connaissanceBanque'] ?? false,
            $data['idAgentProspecteur'] ?? ""
        );
        return $prospect;
    }
}
