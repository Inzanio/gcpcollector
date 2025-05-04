<?php

namespace App\Services;

use App\Models\Prospect;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;

/**
 * Classe de service pour gérer les prospects
 */
class ProspectServices
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

        if (self::sendAccountOpeningRequest($prospect)) {
            // Génération d'un ID unique pour le document
            $documentId = null; //uniqid();

            // Appel de la méthode de création de document dans la classe Database
            $response = Database::createDocument(self::$collectionName, $documentId, $prospect->toArray());
            return Database::isSuccessfullRequest($response) ? $response : false;
        }
        return false; // Si l'envoi de la demande échoue, retourner false


    }

    /**
     * Met à jour un prospect existant
     * @param Prospect $prospect - l'objet Prospect mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateProspect(Prospect $prospect)
    {

        return Database::updateDocument(self::$collectionName, $prospect->getDocId(), $prospect->toArray());
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
            isset($data['dateNaissance']) ? $data['dateNaissance'] : null,
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
        $prospect->setDateOuvertureCompte($data['dateOuvertureCompte']);

        $prospect->setDateCreation($data['dateCreation']);
        $prospect->setDateModification($data['dateModification']);

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
     * Récupère tous les prospects
     * @param string|null $idAgentProspecteur - l'ID de l'agent prospecteur (optionnel)
     * @param string|null $idAgence - l'ID de l'agence (optionnel)
     * @param FireStoreTimestamp|null $dateDebut - la date de début (optionnel)
     * @param FireStoreTimestamp|null $dateFin - la date de fin (optionnel)
     * @param bool $excludeProspects - exclure les prospects (par défaut false)
     * @param bool $excludeClients - exclure les clients (par défaut false)
     * @return Prospect[] - la liste des prospects
     */
    public static function getAll($idAgentProspecteur = null, $idAgence = null, $dateDebut = null, $dateFin = null, $excludeProspects = false, $excludeClients = false)
    {
        // Appel de la méthode de récupération de tous les documents dans la classe Database
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        if ($excludeProspects && !$excludeClients) {
            $queryBuilder->where('numeroCompte', 'NOT_EQUAL', "");
        }
        if ($excludeClients && !$excludeProspects) {
            $queryBuilder->where('numeroCompte', 'EQUAL', "");
        }

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

        // Filtrage des prospects en fonction des dates
        if ($dateDebut !== null && $dateFin !== null) {
            $prospects = array_filter($prospects, function ($prospect) use ($dateDebut, $dateFin) {
                return $prospect->getDateCreation() >= $dateDebut && $prospect->getDateCreation() <= $dateFin;
            });
        } elseif ($dateDebut !== null) {
            $prospects = array_filter($prospects, function ($prospect) use ($dateDebut) {
                return $prospect->getDateCreation() >= $dateDebut;
            });
        } elseif ($dateFin !== null) {
            $prospects = array_filter($prospects, function ($prospect) use ($dateFin) {
                return $prospect->getDateCreation() <= $dateFin;
            });
        }

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
     * * Envoie une demande d'ouverture de compte pour un prospect
     * @param Prospect $prospect - l'objet Prospect à envoyer
     */
    public static function sendAccountOpeningRequest($prospect)
    {
        // Envoi de la demande d'ouverture de compte
        // Vous pouvez ajouter ici le code pour envoyer la demande d'ouverture de compte
        // Par exemple, en utilisant une API ou en envoyant un e-mail
        return true; // Retourne true si l'envoi a réussi, sinon false
    }


    /**
     * Confirme le succès de l'ouverture d'un compte pour un prospect
     * en entrant le code de ce compte là où il est demandé
     * et en mettant à jour le prospect avec le numéro de compte
     * @param Prospect $prospect - l'objet Prospect à mettre à jour
     * @param string $numeroCompte - le numéro de compte à associer au prospect
     */
    public static function confirmAccountOpening($prospect, $numeroCompte)
    {
        // Vérification de l'existence du prospect dans la base de données
        $prospect->setNumeroCompte($numeroCompte);
        $prospect->setDateOuvertureCompte(new FireStoreTimestamp());
        return self::updateProspect($prospect);
    }
    /**
     * Récupère tous les prospects attribués à un agent prospecteur spécifique.
     *
     * @param int $idAgentProspecteur L'ID de l'agent prospecteur
     * @param FireStoreTimestamp|null $dateDebut La date de début (optionnel)
     * @param FireStoreTimestamp|null $dateFin La date de fin (optionnel)
     * @return Prospect[] La liste des prospects
     */
    public static function getAllProspectsByAgent($idAgentProspecteur, $dateDebut = null, $dateFin = null)
    {
        return self::getAll($idAgentProspecteur, null, $dateDebut, $dateFin, false, true);
    }

    /**
     * Récupère tous les clients (prospects convertis) attribués à un agent prospecteur spécifique.
     *
     * @param int $idAgentProspecteur L'ID de l'agent prospecteur
     * @param FireStoreTimestamp|null $dateDebut La date de début (optionnel)
     * @param FireStoreTimestamp|null $dateFin La date de fin (optionnel)
     * @return Prospect[] La liste des prospects (clients)
     */
    public static function getAllClientsByAgent($idAgentProspecteur, $dateDebut = null, $dateFin = null)
    {
        return self::getAll($idAgentProspecteur, null, $dateDebut, $dateFin, true, false);
    }

    /**
     * Récupère tous les prospects attribués à une agence spécifique.
     *
     * @param int $idAgence L'ID de l'agence
     * @param FireStoreTimestamp|null $dateDebut La date de début (optionnel)
     * @param FireStoreTimestamp|null $dateFin La date de fin (optionnel)
     * @return Prospect[] La liste des prospects
     */
    public static function getAllProspectsByAgence($idAgence, $dateDebut = null, $dateFin = null)
    {
        return self::getAll(null, $idAgence, $dateDebut, $dateFin, false, true);
    }

    /**
     * Récupère tous les clients (prospects convertis) attribués à une agence spécifique.
     *
     * @param int $idAgence L'ID de l'agence
     * @param FireStoreTimestamp|null $dateDebut La date de début (optionnel)
     * @param FireStoreTimestamp|null $dateFin La date de fin (optionnel)
     * @return Prospect[] La liste des prospects (clients)
     */
    public static function getAllClientsByAgence($idAgence, $dateDebut = null, $dateFin = null)
    {
        return self::getAll(null, $idAgence, $dateDebut, $dateFin, true, false);
    }

    /**
     * Récupère tous les prospects en attente d'ouverture de compte, 
     * filtrés par agent prospecteur et/ou agence.
     *
     * @param int|null $idAgentProspecteur L'ID de l'agent prospecteur (facultatif)
     * @param int|null $idAgence L'ID de l'agence (facultatif)
     * @param FireStoreTimestamp|null $dateDebut La date de début (optionnel)
     * @param FireStoreTimestamp|null $dateFin La date de fin (optionnel)
     * @return Prospect[] La liste des prospects en attente d'ouverture de compte
     */
    public static function getAllProspectsWaitingForAccountOpening($idAgentProspecteur = null, $idAgence = null, $dateDebut = null, $dateFin = null)
    {
        return self::getAll($idAgentProspecteur, $idAgence, $dateDebut, $dateFin, false, true);
    }

}
