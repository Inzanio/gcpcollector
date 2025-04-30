<?php

require_once "personne.php";

class Prospect extends Personne
{
    use DbDataTrait;
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
     * id prospect
     */
    private string $docId;

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
    private string $numeroCompte;

    /**
     * Date d'ouverture du compte
     * @var DateTime
     */
    private DateTime $dateOuvertureCompte;


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
        $this->commentaire = "";
        $this->docId = "";
        $this->idAgence = "";

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
     * Récupère l'ID du prospect
     * @return string
     */
    public function getDocId(): string
    {
        return $this->docId;
    }

    /**
     * Modifie l'ID du prospect
     * @param string $id Nouvel ID du prospect
     */
    public function setDocId(string $getDocId): void
    {
        $this->docId = $getDocId;
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
     * @return DateTime
     */
    public function getDateOuvertureCompte(): DateTime
    {
        return $this->dateOuvertureCompte;
    }

    /**
     * Modifie la date d'ouverture du compte
     * @param DateTime $dateOuvertureCompte Nouvelle date d'ouverture du compte
     */
    public function setDateOuvertureCompte(DateTime $dateOuvertureCompte): void
    {
        $this->dateOuvertureCompte = $dateOuvertureCompte;
    }

    public function isClient() : bool
    {
        return $this->getNumeroCompte() != null && $this->getDateOuvertureCompte() != null;
        
    }

}

//require_once "../db.php";

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

        if (self::prospectExist($prospect)) {
            return false;
        }
        // Génération d'un ID unique pour le document
        $documentId = uniqid();

        // Appel de la méthode de création de document dans la classe Database
        $response = Database::createDocument(self::$collectionName, $documentId, $prospect->toArray());
        return Database::isSuccessfullRequest($response) ? $response : false;
    }

    /**
     * Met à jour un prospect existant
     * @param string $documentId - l'ID du prospect
     * @param Prospect $prospect - l'objet Prospect mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateProspect($documentId, Prospect $prospect)
    {

        // Appel de la méthode de mise à jour de document dans la classe Database

        $champs = array_chunk($prospect->toArray(), 10, true);
        $success = true;

        foreach ($champs as $chunk) {
            try {
                $response = Database::updateDocument(self::$collectionName, $documentId, $chunk);
                if (!Database::isSuccessfullRequest($response)) {
                    $success = false;
                    break;
                }
            } catch (\Exception $e) {
                $success = false;
                break;
            }
        }
        return $success ? $response : false;
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

        $prospect->setCommentaire($data['commentaire'] ?? "");
        $prospect->setIdAgence($data['idAgence'] ?? "");
        $prospect->setEmail($data['email'] ?? "");
        $prospect->setGenre($data['genre'] ?? "");
        $prospect->setNumeroCompte($data['numeroCompte'] ?? "");
        $prospect->setDateOuvertureCompte(isset($data['dateOuvertureCompte']) ? new DateTime($data['dateOuvertureCompte']) : new DateTime());

        $prospect->setDateCreation($doc->createTime);
        $prospect->setDateModification($doc->updateTime);

        // Récupération de l'ID du document Firestore
        $id = Database::getDocumentIdFromName($doc->getName());

        // Définition de l'ID du prospect
        $prospect->setDocId($id);
        return $prospect;
    }
    /**
     * * Vérifie si un prospect existe dans la base de données
     * @param Prospect $prospect - l'objet Prospect à vérifier
     * @return bool - true si le prospect existe, false sinon
     */
    public static function prospectExist($prospect)
    {
        // Vérification de l'existence du prospect dans la base de données
        $queryBuilder = Database::queryBuilder('prospects');
        $queryBuilder->where('telephone', 'ARRAY_CONTAINS', $prospect->getTelephone()[0]);
        $query = $queryBuilder->build();

        $result = Database::query($query);
        return ($result != null && count($result) > 0);
        //     {
        //         if (count($result) > 1) {
        //             // Plus d'un prospect trouvé, vous pouvez gérer cela comme vous le souhaitez
        //             //echo("Plus d'un prospect trouvé avec ce numéro de téléphone.");
        //             return true;
        //         } else {
        //             // Un seul prospect trouvé, vous pouvez le retourner ou faire ce que vous voulez avec
        //             // $prospect = $result[0];
        //             // return self::fromFirestoreDocument($prospect);
        //             return true;
        //         }
        //     } else {
        //         // Aucune correspondance trouvée
        //         return false;
        //     }

    }
    /**
     * * Récupère tous les prospects
     * @param string|null $idAgentProspecteur - l'ID de l'agent prospecteur (optionnel)
     * @param string|null $idAgence - l'ID de l'agence (optionnel)
     * @return Prospect[] - la liste des prospects
     */
    public static function getAllProspects($idAgentProspecteur = null, $idAgence = null)
    {
        // Appel de la méthode de récupération de tous les documents dans la classe Database
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        if ($idAgentProspecteur != null) {
            $queryBuilder->where('idAgentProspecteur', 'EQUAL', $idAgentProspecteur);
        }
        if ($idAgence != null) {
            $queryBuilder->where('idAgence', 'EQUAL', $idAgence);
        }

        $query = $queryBuilder->build();
        $result = Database::query($query);
        // Transformation des documents Firestore en objets Prospect
        $prospects = array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);
        return $prospects;
    }
    /**
     * * Récupère un prospect par son ID
     * @param string $prospectId - l'ID du prospect
     * @return Prospect - le résultat de la requête
     */
    public static function getProspectById($prospectId)
    {
        // Appel de la méthode de récupération d'un document par ID dans la classe Database
        //var_dump($prospectId);
        $result = Database::getDocument(self::$collectionName, $prospectId);
        return self::fromFirestoreDocument($result);
    }
    /**
     * Confirme le succès de l'ouverture d'un compte pour un prospect
     * en entrant le code de ce compte là où il est demandé
     * et en mettant à jour le prospect avec le numéro de compte
     * @param Prospect $prospect - l'objet Prospect à mettre à jour
     * @param string $numeroCompte - le numéro de compte à associer au prospect
     */
    public static function confirmAccountOpening($prospect,$numeroCompte)
    {
        // Vérification de l'existence du prospect dans la base de données
        $prospect->setNumeroCompte($numeroCompte);
        $prospect->setDateOuvertureCompte(new DateTime());
        return self::updateProspect($prospect->getDocId(), $prospect);
    }
}
