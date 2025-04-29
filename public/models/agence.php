<?php

class Agence
{
    /**
     * Liste des champs de l'agence
     */
    private string $code;
    private string $nom;
    private string $lieu;
    private string $idAdmin;

    /**
     * Constructeur de la classe Agence
     * @param string $code Code de l'agence
     * @param string $nom Nom de l'agence
     * @param string $lieu Lieu de l'agence
     * @param string $idAdmin ID de l'admin qui a créé l'agence
     */
    public function __construct(string $code, string $nom, string $lieu, string $idAdmin)
    {
        $this->setCode($code);
        $this->setNom($nom);
        $this->setLieu($lieu);
        $this->setIdAdmin($idAdmin);
    }

    /**
     * Récupère le code de l'agence
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Modifie le code de l'agence
     * @param string $code Nouveau code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Récupère le nom de l'agence
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Modifie le nom de l'agence
     * @param string $nom Nouveau nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * Récupère le lieu de l'agence
     * @return string
     */
    public function getLieu(): string
    {
        return $this->lieu;
    }

    /**
     * Modifie le lieu de l'agence
     * @param string $lieu Nouveau lieu
     */
    public function setLieu(string $lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * Récupère l'ID de l'admin
     * @return string
     */
    public function getIdAdmin(): string
    {
        return $this->idAdmin;
    }

    /**
     * Modifie l'ID de l'admin
     * @param string $idAdmin Nouvel ID
     */
    public function setIdAdmin(string $idAdmin): void
    {
        $this->idAdmin = $idAdmin;
    }

    /**
     * Convertit l'objet en tableau
     * @return array
     */
    public function toArray(): array
    {
        return [
            "code" => $this->code,
            "nom" => $this->nom,
            "lieu" => $this->lieu,
            "idAdmin" => $this->idAdmin
        ];
    }
}

class AgenceService
{
    /**
     * Nom de la collection Firestore pour les agences
     */
    private static $collectionName = "agences";

    /**
     * Crée une nouvelle agence dans la base de données
     * @param Agence $agence - l'objet Agence à créer
     * @return mixed - le résultat de la création
     */
    public static function createAgence(Agence $agence)
    {
        // Génération d'un ID unique pour le document
        $documentId = $agence->getCode();

        // Appel de la méthode de création de document dans la classe Database
        $result = Database::createDocument(self::$collectionName, $documentId, $agence->toArray());
        return $result;
    }

    /**
     * Met à jour une agence existante
     * @param string $documentId - l'ID de l'agence
     * @param Agence $agence - l'objet Agence mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateAgence($documentId, Agence $agence)
    {
        // Préparation des données pour la mise à jour
        $data = [
            ["path" => "code", "value" => $agence->getCode()],
            ["path" => "nom", "value" => $agence->getNom()],
            ["path" => "lieu", "value" => $agence->getLieu()],
            ["path" => "idAdmin", "value" => $agence->getIdAdmin()]
        ];

        // Appel de la méthode de mise à jour de document dans la classe Database
        $result = Database::updateDocument(self::$collectionName, $documentId, $data);
        return $result;
    }

    /**
     * Supprime une agence à partir de son ID
     * @param string $documentId - l'ID de l'agence
     * @return mixed - le résultat de la suppression
     */
    public static function deleteAgence($documentId)
    {
        // Appel de la méthode de suppression de document dans la classe Database
        $result = Database::deleteDocument(self::$collectionName, $documentId);
        return $result;
    }

    /**
     * Récupère toutes les agences
     * @return mixed - le résultat de la requête
     */
    public static function getAllAgences()
    {
        // Appel de la méthode de récupération de tous les documents dans la classe Database
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        // if ($idAgentProspecteur != null) {
        //     $queryBuilder->where('idAgentProspecteur', 'EQUAL', $idAgentProspecteur);
        // }
        // if ($idAgence != null) {
        //     $queryBuilder->where('idAgence', 'EQUAL', $idAgence);
        // }
        
        $query = $queryBuilder->build();
        $result = Database::query($query);
        return $result;
    }

    /**
     * Récupère une agence par son ID
     * @param string $documentId - l'ID de l'agence
     * @return mixed - le résultat de la requête
     */
    public static function getAgenceById($documentId)
    {
        // Appel de la méthode de récupération d'un document par ID dans la classe Database
        $result = Database::getDocument(self::$collectionName, $documentId);
        return $result;
    }
}


?>