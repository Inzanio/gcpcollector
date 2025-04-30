<?php
//require_once("routes.php");
session_start();
//var_dump($_SESSION['user_role']);
if (!isset($_SESSION['user_id'])) header('Location: /login');
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Création d'un objet Prospect
    require_once("../models/Prospect.php");
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
    $result = ProspectService::createProspect($prospect);
    // Traitement du résultat
    if (!$result) {
        $error_message = "Erreur lors de l'enregistrement du prospect.";
    } else {

        $error_message = "Prospect enregistré avec succès.";
        // Redirection ou autre action après l'enregistrement réussi
        header("Location: /gestionProspects.php"); // redirection vers la liste des prospects
        exit();
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
require_once("../pages/head.php");
?>

<body>