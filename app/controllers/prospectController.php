<?php

namespace App\Controllers;

use App\Services\ProspectServices;
use App\Models\Prospect;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;
use Datetime;

class ProspectController
{
    /**
     * Montre la liste des prospects
     */
    public static function index()
    {
        if ($_SESSION['user_role'] == ROLE_AGENT) {
            // var_dump($_SESSION[FILTER_DATE_DEBUT]);
            // exit();
            $prospects = ProspectServices::getAll(false,$_SESSION['user_id'], $_SESSION['user_agence_id'],$_SESSION[FILTER_DATE_DEBUT],$_SESSION[FILTER_DATE_FIN],$_SESSION[FILTER_ID_CAMPAGNE],$_SESSION[FILTER_PROFESSION]);
        }
        if ($_SESSION['user_role'] == ROLE_SUPERVISEUR) {
            $prospects = ProspectServices::getAllProspectsWaitingForAccountOpening($_SESSION[FILTER_ID_AGENT], $_SESSION['user_agence_id'],$_SESSION[FILTER_DATE_DEBUT],$_SESSION[FILTER_DATE_FIN],$_SESSION[FILTER_ID_CAMPAGNE],$_SESSION[FILTER_PROFESSION]);
        }
        if ($_SESSION['user_role'] == ROLE_ADMIN) {
            
            $prospects = ProspectServices::getAllProspectsWaitingForAccountOpening($_SESSION[FILTER_ID_AGENT], $_SESSION[FILTER_ID_AGENCE],$_SESSION[FILTER_DATE_DEBUT],$_SESSION[FILTER_DATE_FIN],$_SESSION[FILTER_ID_CAMPAGNE],$_SESSION[FILTER_PROFESSION]);
        }
        if ($_SESSION['user_role'] !== ROLE_AGENT) {
            $_SESSION["total_compte_en_attente_ouverture"] = count($prospects);
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
        $dateNaissance = !empty($_POST['dateNaissance']) ? new Datetime($_POST['dateNaissance']) : null;
        $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));
        $profession = trim(htmlspecialchars($_POST['profession'] ?? ''));
        $connaissanceBanque = isset($_POST['connaissanceBanque']) ? true : false;
        $produitsInteresse = $_POST['produitsInteresse'] ?? [];
        $email = trim(htmlspecialchars($_POST['email'] ?? ''));
        $commentaire = trim(htmlspecialchars($_POST['commentaire'] ?? ''));
        $genre = trim(htmlspecialchars($_POST['genre'] ?? ''));
        $idCampagne = trim(htmlspecialchars($_POST['idCampagne'] ?? ''));

        $prospect = new Prospect(
            $nom,
            $prenom,
            new FireStoreTimestamp($dateNaissance),
            [$telephone],
            "",
            $profession,
            $produitsInteresse,
            $connaissanceBanque
        );

        // Configuration des propriétés supplémentaires du prospect
        $prospect->setIdAgentProspecteur($_SESSION['user_id']);
        $prospect->setIdAgence($_SESSION['user_agence_id']);

        $prospect->setIdCampagne($idCampagne);
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
    public static function update(Prospect $prospect)
    {
        if (isset($_POST['nom'])) {
            $prospect->setNom(trim(htmlspecialchars($_POST['nom'])));
        }
        if (isset($_POST['prenom'])) {
            $prospect->setPrenom(trim(htmlspecialchars($_POST['prenom'])));
        }
        if (isset($_POST['dateNaissance']) && !empty($_POST['dateNaissance'])) {
            $prospect->setDateNaissance(new DateTime($_POST['dateNaissance']));
        }
        if (isset($_POST['telephone'])) {
            $prospect->removeTelephone($prospect->getTelephone()[0]); // Remove the old telephone number    
            $prospect->addTelephone(trim(htmlspecialchars($_POST['telephone'])));
        }
        if (isset($_POST['profession'])) {
            $prospect->setProfession(trim(htmlspecialchars($_POST['profession'])));
        }
        if (isset($_POST['connaissanceBanque'])) {
            $prospect->setConnaissanceBanque(true);
        } else {
            $prospect->setConnaissanceBanque(false);
        }
        if (isset($_POST['produitsInteresse'])) {
            $prospect->setProduitsInteresse($_POST['produitsInteresse']);
        }
        if (isset($_POST['email'])) {
            $prospect->setEmail(trim(htmlspecialchars($_POST['email'])));
        }
        if (isset($_POST['commentaire'])) {
            $prospect->setCommentaire(trim(htmlspecialchars($_POST['commentaire'])));
        }
        if (isset($_POST['genre'])) {
            $prospect->setGenre(trim(htmlspecialchars($_POST['genre'])));
        }
        if (isset($_POST['numeroCompte'])) {
            $prospect->setNumeroCompte(trim(htmlspecialchars($_POST['numeroCompte'])));
            $prospect->setDateOuvertureCompte(new FireStoreTimestamp(new Datetime()));
            $prospect->setIdAccountValidator($_SESSION["user_id"]);
        }


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
