<?php

namespace App\Models;

use App\Models\Traits\DbDataTrait;
use App\Models\Traits\ToArrayTrait;
class Agence
{
    use DbDataTrait;
    use ToArrayTrait;
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

    // /**
    //  * Convertit l'objet en tableau
    //  * @return array
    //  */
    // public function toArray(): array
    // {
    //     return [
    //         "code" => $this->code,
    //         "nom" => $this->nom,
    //         "lieu" => $this->lieu,
    //         "idAdmin" => $this->idAdmin
    //     ];
    // }
}
