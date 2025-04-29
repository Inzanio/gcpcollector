<?php 

require_once "personne.php";


/**
 * Classe représentant un utilisateur
 */
class Utilisateur extends Personne
{

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
     * UID de l'utilisateur
     * @var string
     */
    private string $uid;

    /**
     * Nom de la collection ou de la table des utilisateurs
     */
    private static string $collection_name = "utilisateurs" ;

    /**
     * Constructeur de la classe Utilisateur
     * @param string $nom Nom de l'utilisateur
     * @param string $prenom Prénom de l'utilisateur
     * @param DateTime $dateNaissance Date de naissance de l'utilisateur
     * @param string $matricule Matricule de l'utilisateur
     * @param string $login Login de l'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     * @param string $role Rôle de l'utilisateur
     * @param array $telephone Liste des numéros de téléphone de l'utilisateur (optionnel)
     * @param string $adresse Adresse de l'utilisateur (optionnel)
     */
    public function __construct(string $nom, string $prenom, DateTime $dateNaissance, string $matricule, string $login, string $password, string $role, array $telephone = [], string $adresse = "")
    {
        parent::__construct($nom, $prenom, $dateNaissance, $telephone, $adresse);
        $this->matricule = $matricule;
        $this->login = $login;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->role = $role;
    }
    /**
     * Récupère l'UID de l'utilisateur
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * Modifie l'UID de l'utilisateur
     * @param string $uid Nouveau UID
     */
    public function setUid(string $uid): void
    {
        $this->uid = $uid;
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
     * Vérifie si le mot de passe est correct
     * @param string $password Mot de passe à vérifier
     * @return bool
     */
    public function checkpassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * Modifie le mot de passe de l'utilisateur
     * @param string $password Nouveau mot de passe
     */
    public function setpassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
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
    /**
     * Insert les données de l'utilisateur dans la base de données comme une nouvelle ligne
     */
    // public function create () : string 
    // {
    //     return Database::createDocument(self::$collection_name,$this->matricule,$this->toArray());
    // }
    /**
     * Cherche le login avec le mot de passe donné et retourne les utilisateurs y correspondant
     * @param string login - le login de l'utilisateur
     * @param string password - le mot de passe déjà hashé de l'utilisateur
     * @return Utilisateur|false - retourne l'utilisateur trouvé ou null si aucun utilisateur n'est trouvé
     */
    public static function login($login,$password)
    {
        $queryBuilder = Database::queryBuilder('utilisateurs');
        $queryBuilder->where('login', 'EQUAL', $login);
        $queryBuilder->where('password', 'EQUAL', $password);
        $query = $queryBuilder->build();

        $result = Database::query($query);
        //var_dump($result);
        if ($result != null && count($result) > 0) {
            if (count($result) > 1) {
                // Plus d'un utilisateur trouvé, vous pouvez gérer cela comme vous le souhaitez
                echo("Plus d'un utilisateur trouvé avec ce login et mot de passe.");
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
    public static function fromFirestoreDocument($doc)//: self
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
?>