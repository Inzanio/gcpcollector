<?php

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
     * Liste des niveaux de revenu prédéfinis
     */
    public const NIVEAUX_REVENU = [
        "Moins de 20 000 FCFA" => "0-20000",
        "20 000 - 50 000 FCFA" => "20000-50000",
        "50 000 - 100 000 FCFA" => "50000-100000",
        "100 000 - 200 000 FCFA" => "100000-200000",
        "200 000 - 500 000 FCFA" => "200000-500000",
        "Plus de 500 000 FCFA" => "500000+"
    ];

    /**
     * Profession du prospect
     * @var string
     */
    private string $profession;

    /**
     * Situation familiale du prospect
     * @var string
     */
    private string $situationFamiliale;

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
     * Niveau de revenu du prospect
     * @var string
     */
    private string $niveauRevenu;

    /**
     * Constructeur de la classe Prospect
     * @param string $nom Nom du prospect
     * @param string $prenom Prénom du prospect
     * @param DateTime $dateNaissance Date de naissance du prospect
     * @param string[] $telephone Liste des numéros de téléphone du prospect (optionnel)
     * @param string $adresse Adresse du prospect (optionnel)
     * @param string $profession Profession du prospect
     * @param string $situationFamiliale Situation familiale du prospect
     * @param string[] $produitsInteresse Besoins objectifs financiers du prospect
     * @param bool $connaissanceBanque Connaissance de la banque par le prospect
     * @param string $niveauRevenu Niveau de revenu du prospect
     */
    public function __construct(
        string $nom,
        string $prenom,
        DateTime $dateNaissance,
        array $telephone = [],
        string $adresse = "",
        string $profession = "",
        string $situationFamiliale = "",
        array $produitsInteresse = [],
        bool $connaissanceBanque = false,
        string $niveauRevenu = ""
    ) {
        parent::__construct($nom, $prenom, $dateNaissance, $telephone, $adresse);
        $this->setProfession($profession);
        $this->setproduitsInteresse($produitsInteresse);
        $this->connaissanceBanque = $connaissanceBanque;
        $this->setNiveauRevenu($niveauRevenu);
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
     * Récupère le niveau de revenu du prospect
     * @return string
     */
    public function getNiveauRevenu(): string
    {
        return $this->niveauRevenu;
    }

    /**
     * Modifie le niveau de revenu du prospect
     * @param string $niveauRevenu Nouveau niveau de revenu
     */
    public function setNiveauRevenu(string $niveauRevenu): void
    {
        if (!array_key_exists($niveauRevenu, self::NIVEAUX_REVENU)) {
            throw new InvalidArgumentException("Niveau de revenu invalide");
        }
        $this->niveauRevenu = $niveauRevenu;
    }
}
require_once "../database.php";

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
            "niveauRevenu" => $prospect->getNiveauRevenu()
        ];

        // Génération d'un ID unique pour le document
        $documentId = uniqid();

        // Appel de la méthode de création de document dans la classe Database
        $result = Database::createDocument(self::$collectionName, $documentId, $data);
        return $result;
    }

    /**
     * Récupère un prospect à partir de son ID
     * @param string $documentId - l'ID du prospect
     * @return Prospect|null - l'objet Prospect ou null si non trouvé
     */
    // public static function getProspect($documentId)
    // {
    //     // Appel de la méthode de récupération de document dans la classe Database
    //     $result = Database::getDocument(self::$collectionName, $documentId);
    //     if ($result) {
    //         // Création d'un objet Prospect à partir des données récupérées
    //         $data = $result->getData();
    //         $prospect = new Prospect(
    //             $data["nom"],
    //             $data["prenom"],
    //             new DateTime($data["dateNaissance"]),
    //             $data["telephone"],
    //             $data["adresse"],
    //             $data["profession"],
    //             $data["situationFamiliale"],
    //             $data["produitsInteresse"],
    //             $data["connaissanceBanque"],
    //             $data["niveauRevenu"]
    //         );
    //         return $prospect;
    //     } else {
    //         return null;
    //     }
    // }

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
            ["path" => "niveauRevenu", "value" => $prospect->getNiveauRevenu()]
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
    public static function fromFirestoreDocument($doc)//: self
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
            $data['situationFamiliale'] ?? "",
            isset($data['produitsInteresse']) ? (array) $data['produitsInteresse'] : [],
            $data['connaissanceBanque'] ?? false,
            $data['niveauRevenu'] ?? ""
        );
        return $prospect;
    }
}
?>