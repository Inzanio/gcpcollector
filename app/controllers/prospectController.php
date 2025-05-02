<?php

namespace App\Controllers;

use App\Services\ProspectServices;
use App\Models\Prospect;
use Datetime;

class ProspectController
{
    /**
     * Montre la liste des prospects
     */
    public static function index()
    {
        if ($_SESSION['user_role'] == ROLE_AGENT) {
            $prospects = ProspectServices::getAllProspects($idAgentProspecteur = $_SESSION['user_id'], $idAgence = $_SESSION['user_agence_id']);
        }
        if ($_SESSION['user_role'] == ROLE_SUPERVISEUR) {
            $prospects = ProspectServices::getAllProspects($idAgentProspecteur = null, $idAgence = $_SESSION['user_agence_id']);
        }
        if ($_SESSION['user_role'] == ROLE_ADMIN) {
            $prospects = ProspectServices::getAllProspects($idAgentProspecteur = null, $idAgence = null);
        }
        include '../app/views/liste-prospect.php';
    }

    public static function show($id)
    {
        // $prospect = Prospect::find($id);
        // if (!$prospect) {
        //     return redirect()->to('/404');
        // }
        // return view('prospects.show', ['prospect' => $prospect]);
    }

    public static function create()
    {

        // Récupération des données du formulaire
        $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
        $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
        $dateNaissance = !empty($_POST['dateNaissance']) ? new DateTime($_POST['dateNaissance']) : null;
        $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));
        $profession = trim(htmlspecialchars($_POST['profession'] ?? ''));
        $connaissanceBanque = isset($_POST['connaissanceBanque']) ? true : false;
        $produitsInteresse = $_POST['produitsInteresse'] ?? [];
        $email = trim(htmlspecialchars($_POST['email'] ?? ''));
        $commentaire = trim(htmlspecialchars($_POST['commentaire'] ?? ''));
        $genre = trim(htmlspecialchars($_POST['genre'] ?? ''));


        $prospect = new Prospect(
            $nom,
            $prenom,
            $dateNaissance,
            [$telephone],
            "",
            $profession,
            $produitsInteresse,
            $connaissanceBanque
        );

        // Configuration des propriétés supplémentaires du prospect
        $prospect->setIdAgentProspecteur($_SESSION['user_id']);
        $prospect->setCommentaire($commentaire);
        $prospect->setEmail($email);
        $prospect->setGenre($genre);

        // Enregistrement du prospect
        // var_dump($prospect);

        //var_dump($prospect->toArray());
        $result = ProspectServices::createProspect($prospect);
        // Traitement du résultat
        if (!$result) {
            $error_message = "Erreur lors de l'enregistrement du prospect.";
            include '../app/views/forms/ajouter-prospect.php';
        } else {

            $error_message = "Prospect enregistré avec succès.";
            // Redirection ou autre action après l'enregistrement réussi
            header("Location: /prospects"); // redirection vers la liste des prospects
        }
    }

    /**
     * Met à jour un prospect existant
     * param Prospect $prospect L'objet Prospect à mettre à jour
     */
    public static function update($prospect)
    {
        // Récupération des données du formulaire
        $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
        $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
        $dateNaissance = !empty($_POST['dateNaissance']) ? new DateTime($_POST['dateNaissance']) : null;
        $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));
        $profession = trim(htmlspecialchars($_POST['profession'] ?? ''));
        $connaissanceBanque = isset($_POST['connaissanceBanque']) ? true : false;
        $produitsInteresse = $_POST['produitsInteresse'] ?? [];
        $email = trim(htmlspecialchars($_POST['email'] ?? ''));
        $commentaire = trim(htmlspecialchars($_POST['commentaire'] ?? ''));
        $genre = trim(htmlspecialchars($_POST['genre'] ?? ''));

        $prospect->setNom($nom);
        $prospect->setPrenom($prenom);
        $prospect->setDateNaissance($dateNaissance);
        $prospect->removeTelephone($prospect->getTelephone()[0]); // Remove the old telephone number    
        $prospect->addTelephone($telephone);
        $prospect->setProfession($profession);
        $prospect->setProduitsInteresse($produitsInteresse);
        $prospect->setConnaissanceBanque($connaissanceBanque);

        // Configuration des propriétés supplémentaires du prospect
        //$prospect->setIdAgentProspecteur($_SESSION['user_id']);
        $prospect->setCommentaire($commentaire);
        $prospect->setEmail($email);
        $prospect->setGenre($genre);
        

        // Enregistrement du prospect
        //var_dump($prospect);

        // var_dump($prospect->toArray());
        $result = ProspectServices::updateProspect($prospect);
        //var_dump($result);
        // Traitement du résultat
        if (!$result) {
            $error_message = "Erreur lors de l'enregistrement du prospect.";
            include '../app/views/forms/modifier-prospect.php';
        } else {
            $error_message = "Prospect Modifié avec succès.";
            // Redirection ou autre action après l'enregistrement réussi
            // header("Location: /success.php"); // Exemple de redirection
            // exit();
            header("Location: /prospects");
        }
    }
}
