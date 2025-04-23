<?php 

require_once "personne.php";
require_once "traits.php";

/**
 * Classe représentant un utilisateur
 */
class Utilisateur extends Personne
{
    use ToArrayTrait;
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
    private string $motDePasse;

    /**
     * Rôle de l'utilisateur
     * @var string
     */
    private string $role;

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
     * @param string $motDePasse Mot de passe de l'utilisateur
     * @param string $role Rôle de l'utilisateur
     * @param array $telephone Liste des numéros de téléphone de l'utilisateur (optionnel)
     * @param string $adresse Adresse de l'utilisateur (optionnel)
     */
    public function __construct(string $nom, string $prenom, DateTime $dateNaissance, string $matricule, string $login, string $motDePasse, string $role, array $telephone = [], string $adresse = "")
    {
        parent::__construct($nom, $prenom, $dateNaissance, $telephone, $adresse);
        $this->matricule = $matricule;
        $this->login = $login;
        $this->motDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);
        $this->role = $role;
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
     * @param string $motDePasse Mot de passe à vérifier
     * @return bool
     */
    public function checkMotDePasse(string $motDePasse): bool
    {
        return password_verify($motDePasse, $this->motDePasse);
    }

    /**
     * Modifie le mot de passe de l'utilisateur
     * @param string $motDePasse Nouveau mot de passe
     */
    public function setMotDePasse(string $motDePasse): void
    {
        $this->motDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);
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
     * @return void|Google\Cloud\Firestore\DocumentSnapshot[]
     */
    public static function login($login,$password)
    {
        $queryBuilder = Database::queryBuilder('utilisateurs');
        $queryBuilder->where('login', 'EQUAL', 'edouard237');
        $queryBuilder->where('password', 'EQUAL', 'edouard.noa@237');
        $query = $queryBuilder->build();

        $result = Database::query($query);
        if (count($result) > 0) {
            if (count($result) > 1) {
                // Plus d'un utilisateur trouvé, vous pouvez gérer cela comme vous le souhaitez
                echo "Plus d'un utilisateur trouvé avec ce login et mot de passe.";
            } else {
                // Un seul utilisateur trouvé, vous pouvez le retourner ou faire ce que vous voulez avec
                $user = $result[0];
                return $user;
            }
        } else {
            // Aucune correspondance trouvée, vous pouvez gérer cela comme vous le souhaitez
            echo "Aucun utilisateur trouvé avec ce login et mot de passe.";
        }
    }
}
?>