<?php
namespace App\Services;

use App\Database;
use App\Models\Utilisateur;
use DateTime;

class UtilisateurServices
{
    public static string $collectionName = "utilisateurs";

    // public function getUtilisateurById($id)
    // {
    //     // Logic to fetch a user by ID
    // }

    // public function createUtilisateur($data)
    // {
    //     // Logic to create a new user
    // //     return Database::createDocument(self::$collectionName,$this->matricule,$this->toArray());

    // }

    // public function updateUtilisateur($id, $data)
    // {
    //     // Logic to update an existing user
    // }

    // public function deleteUtilisateur($id)
    // {
    //     // Logic to delete a user
    // }

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
            isset($data['dateNaissance']) ? new DateTime($data['dateNaissance']) : new DateTime(),
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
