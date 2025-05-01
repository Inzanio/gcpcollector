<?php
require_once "personne.php";

class Superviseur extends Personne
{
    /**
     * Liste des rôles prédéfinis pour les superviseurs
     */
    public const ROLES = [
        "Superviseur Regional",
        "Superviseur National",
        "Responsable d'agence",
        "Directeur Adjoint",
        "Directeur"
    ];

    /**
     * Rôle du superviseur dans l'organisation
     * @var string
     */
    private string $role;

    /**
     * Identifiant unique du superviseur
     * @var string
     */
    private string $idSuperviseur;

    /**
     * Date d'embauche du superviseur
     * @var DateTime
     */
    private DateTime $dateEmbauche;

    /**
     * Agence à laquelle le superviseur est affecté
     * @var string
     */
    private string $idAgence;

    /**
     * Adresse email professionnelle
     * @var string
     */
    private string $email;

    /**
     * Constructeur de la classe Superviseur
     * @param string $nom Nom du superviseur
     * @param string $prenom Prénom du superviseur
     * @param DateTime $dateNaissance Date de naissance du superviseur
     * @param array $telephone Liste des numéros de téléphone (optionnel)
     * @param string $adresse Adresse postale (optionnel)
     * @param string $role Rôle dans l'organisation
     * @param DateTime $dateEmbauche Date d'embauche
     * @param string $idAgence Agence d'affectation
     */
    public function __construct(
        string $nom,
        string $prenom,
        DateTime $dateNaissance,
        array $telephone = [],
        string $adresse = "",
        string $role = "",
        DateTime $dateEmbauche = null,
        string $idAgence = ""
    ) {
        parent::__construct($nom, $prenom, $dateNaissance, $telephone, $adresse);
        $this->setRole($role);
        $this->idSuperviseur = uniqid();
        $this->dateEmbauche = $dateEmbauche ?: new DateTime();
        $this->idAgence = $idAgence;
        $this->email = "";
    }

    /**
     * Récupère le rôle du superviseur
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Modifie le rôle du superviseur
     * @param string $role Nouveau rôle
     * @throws InvalidArgumentException Si le rôle n'est pas valide
     */
    public function setRole(string $role): void
    {
        if (!in_array($role, self::ROLES)) {
            throw new InvalidArgumentException("Rôle invalide");
        }
        $this->role = $role;
    }

    /**
     * Récupère l'identifiant du superviseur
     * @return string
     */
    public function getIdSuperviseur(): string
    {
        return $this->idSuperviseur;
    }

    /**
     * Récupère la date d'embauche
     * @return DateTime
     */
    public function getDateEmbauche(): DateTime
    {
        return $this->dateEmbauche;
    }

    /**
     * Modifie la date d'embauche
     * @param DateTime $date Nouvelle date d'embauche
     */
    public function setDateEmbauche(DateTime $date): void
    {
        $this->dateEmbauche = $date;
    }

    /**
     * Récupère l'agence d'affectation
     * @return string
     */
    public function getIdAgence(): string
    {
        return $this->idAgence;
    }

    /**
     * Modifie l'agence d'affectation
     * @param string $idAgence Nouvelle agence
     */
    public function setIdAgence(string $idAgence): void
    {
        $this->idAgence = $idAgence;
    }

    /**
     * Récupère l'email professionnel
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Modifie l'email professionnel
     * @param string $email Nouvel email
     * @throws InvalidArgumentException Si l'email est invalide
     */
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Adresse email invalide");
        }
        $this->email = $email;
    }

    /**
     * Convertit l'objet en tableau associatif
     * @return array
     */
    public function toArray(): array
    {
        return [
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'dateNaissance' => $this->getDateNaissance()->format('Y-m-d'),
            'telephone' => $this->getTelephone(),
            'adresse' => $this->getAdresse(),
            'role' => $this->role,
            'idSuperviseur' => $this->idSuperviseur,
            'dateEmbauche' => $this->dateEmbauche->format('Y-m-d'),
            'idAgence' => $this->idAgence,
            'email' => $this->email
        ];
    }
}

/**
 * Classe de service pour gérer les superviseurs
 */
class SuperviseurService
{
    /**
     * Nom de la collection Firestore pour les superviseurs
     */
    private static $collectionName = "superviseurs";

    /**
     * Crée un nouveau superviseur dans la base de données
     * @param Superviseur $superviseur - l'objet Superviseur à créer
     * @return mixed - le résultat de la création
     */
    public static function createSuperviseur(Superviseur $superviseur)
    {
        if (self::superviseurExist($superviseur)) {
            return false;
        }

        // Génération d'un ID unique pour le document
        $documentId = $superviseur->getIdSuperviseur();

        // Appel de la méthode de création de document dans la classe Database
        $response = Database::createDocument(self::$collectionName, $documentId, $superviseur->toArray());
        return Database::isSuccessfullRequest($response) ? $response : false;
    }

    /**
     * Met à jour un superviseur existant
     * @param string $documentId - l'ID du superviseur
     * @param Superviseur $superviseur - l'objet Superviseur mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateSuperviseur($documentId, Superviseur $superviseur)
    {
        // Appel de la méthode de mise à jour de document dans la classe Database
        $response = Database::updateDocument(self::$collectionName, $documentId, $superviseur->toArray());
        return Database::isSuccessfullRequest($response) ? $response : false;
    }

    /**
     * Supprime un superviseur à partir de son ID
     * @param string $documentId - l'ID du superviseur
     * @return mixed - le résultat de la suppression
     */
    public static function deleteSuperviseur($documentId)
    {
        // Appel de la méthode de suppression de document dans la classe Database
        $result = Database::deleteDocument(self::$collectionName, $documentId);
        return $result;
    }

    /**
     * Transforme un document Firestore en un objet Superviseur
     * @param \MrShan0\PHPFirestore\FireStoreDocument $doc - le document Firestore à transformer
     * @return Superviseur - l'objet Superviseur créé
     */
    public static function fromFirestoreDocument($doc)
    {
        // Récupération des données du document
        $data = $doc->toArray();

        // Création d'un objet Superviseur à partir des données récupérées
        $superviseur = new Superviseur(
            $data['nom'] ?? "",
            $data['prenom'] ?? "",
            isset($data['dateNaissance']) ? new DateTime($data['dateNaissance']) : new DateTime(),
            $data['telephone'] ?? [],
            $data['adresse'] ?? "",
            $data['role'] ?? "",
            isset($data['dateEmbauche']) ? new DateTime($data['dateEmbauche']) : new DateTime(),
            $data['idAgence'] ?? ""
        );

        // Définition des propriétés supplémentaires
        $superviseur->setEmail($data['email'] ?? "");
        $superviseur->setIdSuperviseur($data['idSuperviseur'] ?? uniqid());

        // Récupération de l'ID du document Firestore
        $id = Database::getDocumentIdFromName($doc->getName());

        return $superviseur;
    }

    /**
     * Vérifie si un superviseur existe dans la base de données
     * @param Superviseur $superviseur - l'objet Superviseur à vérifier
     * @return bool - true si le superviseur existe, false sinon
     */
    public static function superviseurExist(Superviseur $superviseur)
    {
        // Vérification par email ou téléphone
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        $queryBuilder->where('email', 'EQUAL', $superviseur->getEmail());
        
        // Si l'email n'est pas défini, vérifier par téléphone
        if (empty($superviseur->getEmail()) && !empty($superviseur->getTelephone())) {
            $queryBuilder = Database::queryBuilder(self::$collectionName);
            $queryBuilder->where('telephone', 'ARRAY_CONTAINS', $superviseur->getTelephone()[0]);
        }

        $query = $queryBuilder->build();
        $result = Database::query($query);
        
        return ($result != null && count($result) > 0);
    }

    /**
     * Récupère tous les superviseurs
     * @param string|null $idAgence - l'ID de l'agence (optionnel)
     * @return Superviseur[] - la liste des superviseurs
     */
    public static function getAllSuperviseurs($idAgence = null)
    {
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        
        if ($idAgence != null) {
            $queryBuilder->where('idAgence', 'EQUAL', $idAgence);
        }

        $query = $queryBuilder->build();
        $result = Database::query($query);

        // Transformation des documents Firestore en objets Superviseur
        $superviseurs = array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);

        return $superviseurs;
    }

    /**
     * Récupère un superviseur par son ID
     * @param string $superviseurId - l'ID du superviseur
     * @return Superviseur - le résultat de la requête
     */
    public static function getSuperviseurById($superviseurId)
    {
        $result = Database::getDocument(self::$collectionName, $superviseurId);
        return self::fromFirestoreDocument($result);
    }

    /**
     * Récupère les superviseurs par rôle
     * @param string $role - le rôle recherché
     * @return Superviseur[] - la liste des superviseurs correspondants
     */
    public static function getSuperviseursByRole($role)
    {
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        $queryBuilder->where('role', 'EQUAL', $role);
        $query = $queryBuilder->build();
        
        $result = Database::query($query);
        
        return array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);
    }
}