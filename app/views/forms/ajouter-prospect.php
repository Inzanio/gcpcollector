<!DOCTYPE html>
<html lang="en">

<?php
require_once("../app/views/head.php");
?>

<body>


    <!-- ======= Header ======= -->
    <?php
    require_once("../app/views/header.php");
    ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php
    require_once("../app/views/sidebar.php");
    ?>
    <!-- End Sidebar-->

    <!-- ======= Main ======= -->
    <main id="main" class="main">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Enregistrement d'un Prospect</h5>

                <!-- Floating Labels Form -->
                <form class="row g-3" action="/ajouter-prospect" method="POST">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="nom" type="text" class="form-control" id="floatingName" placeholder="Nom du Prospect" required>
                            <label for="floatingName">Nom</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="prenom" type="text" class="form-control" id="floatingName" placeholder="Prenom du Prospect">
                            <label for="floatingName">Prenom</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="email" type="email" class="form-control" id="floatingEmail" placeholder="Email du Prospect">
                            <label for="floatingEmail">Email</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateNaissance" type="date" class="form-control" id="floatingDateNaissance" placeholder="Date de naissance">
                            <label for="floatingDateNaissance">Date de naissance</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="telephone" type="text" class="form-control" id="floatingTelephone" placeholder="Téléphone du Prospect" name="telephone" required>
                            <label for="floatingTelephone" require>Téléphone</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="genre" class="form-select" id="floatingGenre" required>
                                <option value="" disabled selected>Sélectionner le genre</option>
                                <option value="Homme">Homme</option>
                                <option value="Femme">Femme</option>
                            </select>
                            <label for="floatingGenre">Genre</label>
                        </div>
                    </div>
                    <?php
                    $options = [
                        "Commerçant" => "Commerçant",
                        "Entrepreneur" => "Entrepreneur",
                        "Cadre" => "Cadre",
                        "Employé" => "Employé",
                        "Étudiant" => "Étudiant",
                        "Retraité" => "Retraité",
                        "Autre" => "Autre"
                    ];
                    ?>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select name="profession" class="form-select" id="profession" required>
                                <option value="" disabled selected>Sélectionner une profession</option>
                                <?php foreach ($options as $value => $text) : ?>
                                    <option value="<?php echo $value; ?>"><?php echo $text; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="profession">Profession</label>
                        </div>

                        <!-- Saisie libre si 'Autre' -->
                        <!-- <div class="form-floating mb-3 d-none" id="autreProfessionDiv">
                            <input type="text" name="autreProfession" id="autreProfession" class="form-control" placeholder="Votre profession">
                            <label for="autreProfession">Précisez la profession</label>
                        </div> -->
                    </div>
                    <?php
                        global $campagnes;
                    ?>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select name="idCampagne" class="form-select" id="profession">
                                <option value="" selected>Aucune campagne</option>
                                <?php foreach ($campagnes as $camapagne) : ?>
                                    <option value="<?php echo $camapagne->getDocId(); ?>" <?php echo isset($camapagne_encours) && $camapagne_encours->getDocId() === $campagne->getDocId() ? 'selected' : ''; ?> ><?php echo $camapagne->getLibelle(); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="profession">Campagne</label>
                        </div>

                        <!-- Saisie libre si 'Autre' -->
                        <!-- <div class="form-floating mb-3 d-none" id="autreProfessionDiv">
                            <input type="text" name="autreProfession" id="autreProfession" class="form-control" placeholder="Votre profession">
                            <label for="autreProfession">Précisez la profession</label>
                        </div> -->
                    </div>

                    <div class="col-md-12">
                        <input name="connaissanceBanque" class="form-check-input" type="checkbox" id="connaissanceBanque">
                        <label class="form-check-label" for="connaissanceBanque">Connaissance de la banque</label>

                    </div>

                    <div class="col-md-12">
                        <label>Produits intéressés</label>
                        <?php foreach (PRODUITS_BANQUES as $value) : ?>
                            <div class="form-check">
                                <input name="produitsInteresse[]" class="form-check-input" type="checkbox" id="<?php echo $value; ?>" name="produitsInteresse[]" value="<?php echo $value; ?>">
                                <label class="form-check-label" for="<?php echo $value; ?>"><?php echo $value; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="commentaire" class="form-control" placeholder="Address" id="floatingCommentaire" style="height: 100px;"></textarea>
                            <label for="floatingTextarea">Commentaire</label>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                    </div>

                </form>
                <?php
                if (isset($error_message)) {
                    check_error_message($error_message);
                }
                ?>
            </div>
        </div>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
    require_once("../app/views/footer.php");
    ?>
    <!-- End Footer -->

</body>

</html>