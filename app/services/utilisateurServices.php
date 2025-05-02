<?php

namespace App\Services;

use App\Models\Utilisateur;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;

class UtilisateurServices
{
    public static string $collectionName = "utilisateurs";

    // public function getUtilisateurById($id)
    // {
    //     // Logic to fetch a user by ID
    // }

    /**
     * Crée un nouveau Utilisateur dans la base de données
     * @param Utilisateur $user - l'objet Utilisateur à créer
     * @return mixed - le résultat de la création
     */
    public static function createUtilisateur(Utilisateur $user)
    {
        if (self::utilisateurExist($user)) {
            return false;
        }

        // Génération d'un ID unique pour le document
        $documentId = null; //uniqid();

        // Appel de la méthode de création de document dans la classe Database
        $response = Database::createDocument(self::$collectionName, $documentId, $user->toArray());
        return Database::isSuccessfullRequest($response) ? $response : false;
    }


    /**
     * Met à jour un Utilisateur existant
     * @param Utilisateur $user - l'objet Utilisateur mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateUtilisateur(Utilisateur $user)
    {
        // Appel de la méthode de mise à jour de document dans la classe Database
        $response = Database::updateDocument(self::$collectionName,$user->getDocId() , $user->toArray());
        return Database::isSuccessfullRequest($response) ? $response : false;
    }

    /**
     * Vérifie si un Utilisateur existe dans la base de données
     * @param Utilisateur $user - l'objet Utilisateur à vérifier
     * @return bool - true si le Utilisateur existe, false sinon
     */
    public static function UtilisateurExist(Utilisateur $user)
    {
        // Vérification par email ou téléphone
        if (empty($user->getEmail()) && empty($user->getTelephone())) {
            return false;
        }
        // Vérification par email
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        $queryBuilder->where('email', 'EQUAL', $user->getEmail());

        // Si l'email n'est pas défini, vérifier par téléphone
        if (empty($user->getEmail()) && !empty($user->getTelephone())) {
            $queryBuilder = Database::queryBuilder(self::$collectionName);
            $queryBuilder->where('telephone', 'ARRAY_CONTAINS', $user->getTelephone()[0]);
        }

        $query = $queryBuilder->build();
        $result = Database::query($query);

        return ($result != null && count($result) > 0);
    }


    /**
     * Récupère tous les Utilisateurs
     * @param string|null $idAgence - l'ID de l'agence (optionnel)
     * @return Utilisateur[] - la liste des Utilisateurs
     */
    public static function getAllUtilisateurs($idAgence = null)
    {
        $queryBuilder = Database::queryBuilder(self::$collectionName);

        if ($idAgence != null) {
            $queryBuilder->where('idAgence', 'EQUAL', $idAgence);
        }

        $query = $queryBuilder->build();
        $result = Database::query($query);

        // Transformation des documents Firestore en objets Utilisateur
        $Utilisateurs = array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);

        return $Utilisateurs;
    }

    /**
     * Cherche le login avec le mot de passe donné et retourne les utilisateurs y correspondant
     * @param string login - le login de l'utilisateur
     * @param string password - le mot de passe déjà hashé de l'utilisateur
     * @return Utilisateur|false - retourne l'utilisateur trouvé ou null si aucun utilisateur n'est trouvé
     */
    public static function login($login, $password)
    {
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        $queryBuilder->where('login', 'EQUAL', $login);
        $queryBuilder->where('password', 'EQUAL', $password);
        $query = $queryBuilder->build();

        $result = Database::query($query);
        //var_dump($result);
        if ($result != null && count($result) > 0) {
            if (count($result) > 1) {
                // Plus d'un utilisateur trouvé, vous pouvez gérer cela comme vous le souhaitez
                echo ("Plus d'un utilisateur trouvé avec ce login et mot de passe.");
                return false;
            } else {
                // Un seul utilisateur trouvé, vous pouvez le retourner ou faire ce que vous voulez avec
                $user = $result[0];
                return self::fromFirestoreDocument($user);
            }
        } else {
            // Aucune correspondance trouvée, vous pouvez gérer cela comme vous le souhaitez
            return false;
        }
    }

    /**
     * Transforme un document Firestore en un objet Utilisateur
     * @param \MrShan0\PHPFirestore\FireStoreDocument $doc - le document Firestore à transformer
     */
    public static function fromFirestoreDocument($doc) //: self
    {
        //var_dump($doc);
        $data = $doc->toArray();
        $id = Database::getDocumentIdFromName($doc->getName());
        $utilisateur = new Utilisateur(
            $data['nom'] ?? "",
            $data['prenom'] ?? "",
            isset($data['dateNaissance'])? $data['dateNaissance'] :null,
            $data['matricule'] ?? "",
            $data['login'] ?? "",
            $data['password'] ?? "",
            $data['role'] ?? "",
            $data['telephone'] ?? [],
            $data['adresse'] ?? ""
        );
        $utilisateur->setUid($id);
        return $utilisateur;
    }
}
