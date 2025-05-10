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
                <h5 class="card-title"><?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'Confirmer l\'ouverture de Compte' : 'Modification d\'un Prospect'; ?></h5>
                <!-- Floating Labels Form -->
                <form class="row g-3" action="" method="POST">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="nom" type="text" class="form-control" id="floatingName" placeholder="Nom du Prospect" value="<?php echo $prospect->getNom(); ?>" <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                            <label for="floatingName">Nom</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="prenom" type="text" class="form-control" id="floatingName" placeholder="Prenom du Prospect" value="<?php echo $prospect->getPrenom(); ?>" <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                            <label for="floatingName">Prenom</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="email" type="email" class="form-control" id="floatingEmail" placeholder="Email du Prospect" value="<?php echo $prospect->getEmail(); ?>" <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                            <label for="floatingEmail">Email</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateNaissance" type="date" class="form-control" id="floatingDateNaissance" placeholder="Date de naissance" value="<?php echo (new Datetime(($prospect->getDateNaissance()->parseValue())))->format('Y-m-d'); ?>" <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                            <label for="floatingDateNaissance">Date de naissance</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="telephone" type="text" class="form-control" id="floatingTelephone" placeholder="Téléphone du Prospect" name="telephone" value="<?php echo $prospect->getTelephone()[0]; ?>" <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                            <label for="floatingTelephone">Téléphone</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="genre" class="form-select" id="floatingGenre" <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                                <option value="">Sélectionner le genre</option>
                                <option value="Homme" <?php echo $prospect->getGenre() === 'Homme' ? 'selected' : ''; ?>>Homme</option>
                                <option value="Femme" <?php echo $prospect->getGenre() === 'Femme' ? 'selected' : ''; ?>>Femme</option>
                            </select>
                            <label for="floatingGenre">Genre</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select name="profession" class="form-select" aria-label="Default select example" <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                                <option selected="">Open this select menu</option>
                                <?php foreach (PROFESSIONS as $value) : ?>
                                    <option value="<?php echo $value; ?>" <?php echo $prospect->getProfession() === $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
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

                    <div class="col-md-12">
                        <input name="connaissanceBanque" class="form-check-input" type="checkbox" id="connaissanceBanque" <?php echo $prospect->getConnaissanceBanque() ? 'checked' : ''; ?> <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                        <label class="form-check-label" for="connaissanceBanque">Connaissance de la banque</label>
                    </div>
                    <div class="col-md-12">
                        <label>Produits intéressés</label>
                        <?php foreach (PRODUITS_BANQUES as $value) : ?>
                            <div class="form-check">
                                <input name="produitsInteresse[]" class="form-check-input" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php echo in_array($value, $prospect->getProduitsInteresse()) ? 'checked' : ''; ?> <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>>
                                <label class="form-check-label" for="<?php echo $value; ?>"><?php echo $value; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="commentaire" class="form-control" placeholder="Commentaire" id="floatingCommentaire" style="height: 100px;" <?php echo ($_SESSION['user_role'] !== ROLE_AGENT) ? 'disabled' : ''; ?>><?php echo $prospect->getCommentaire(); ?></textarea>
                            <label for="floatingCommentaire">Commentaire</label>
                        </div>
                    </div>

                    <?php if ($_SESSION['user_role'] !== ROLE_AGENT) : ?>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input name="numeroCompte" type="text" class="form-control" id="floatingName" placeholder="Le numéro du compte de ce prospect" value="<?php echo $prospect->getNumeroCompte(); ?>">
                                <label for="floatingName">Numero du Compte</label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                    </div>

                </form>
                <!-- End floating Labels Form -->
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