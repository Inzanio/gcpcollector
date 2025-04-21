<?php 
/**
 * Classe représentant une personne
 */
class Personne
{
    /**
     * Nom de la personne
     * @var string
     */
    private string $nom;

    /**
     * Prénom de la personne
     * @var string
     */
    private string $prenom;

    /**
     * Date de naissance de la personne
     * @var DateTime
     */
    private DateTime $dateNaissance;

    /**
     * Liste des numéros de téléphone de la personne
     * @var string[]
     */
    private array $telephone;

    /**
     * Adresse de la personne
     * @var string
     */
    private string $adresse;

    /**
     * Constructeur de la classe Personne
     * @param string $nom Nom de la personne
     * @param string $prenom Prénom de la personne
     * @param DateTime $dateNaissance Date de naissance de la personne
     * @param string[] $telephone Liste des numéros de téléphone de la personne (optionnel)
     * @param string $adresse Adresse de la personne (optionnel)
     */
    public function __construct(string $nom, string $prenom, DateTime $dateNaissance, array $telephone = [], string $adresse = "")
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
    }

    /**
     * Récupère le nom de la personne
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Modifie le nom de la personne
     * @param string $nom Nouveau nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * Récupère le prénom de la personne
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * Modifie le prénom de la personne
     * @param string $prenom Nouveau prénom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * Récupère la date de naissance de la personne
     * @return DateTime
     */
    public function getDateNaissance(): DateTime
    {
        return $this->dateNaissance;
    }

    /**
     * Modifie la date de naissance de la personne
     * @param DateTime $dateNaissance Nouvelle date de naissance
     */
    public function setDateNaissance(DateTime $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * Récupère la liste des numéros de téléphone de la personne
     * @return string[]
     */
    public function getTelephone(): array
    {
        return $this->telephone;
    }

    /**
     * Ajoute un numéro de téléphone à la liste
     * @param string $telephone Nouveau numéro de téléphone
     */
    public function addTelephone(string $telephone): void
    {
        $this->telephone[] = $telephone;
    }

    /**
     * Supprime un numéro de téléphone de la liste
     * @param string $telephone Numéro de téléphone à supprimer
     */
    public function removeTelephone(string $telephone): void
    {
        $this->telephone = array_filter($this->telephone, function ($t) use ($telephone) {
            return $t !== $telephone;
        });
    }

    /**
     * Récupère l'adresse de la personne
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * Modifie l'adresse de la personne
     * @param string $adresse Nouvelle adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }
}
?>