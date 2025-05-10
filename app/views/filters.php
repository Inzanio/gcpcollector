<form method="POST" action="">

    <div class="form-floating">
        <input name="<?php echo FILTER_DATE_DEBUT; ?>" type="date" class="form-control" id="<?php echo FILTER_DATE_DEBUT; ?>" placeholder="Date de naissance" value="<?php echo isset($_SESSION[FILTER_DATE_DEBUT]) ? ($_SESSION[FILTER_DATE_DEBUT])->format('Y-m-d') : ''; ?>">
        <label for="<?php echo FILTER_DATE_DEBUT; ?>">Date de Début</label>
    </div>
</form>
<form method="POST" action="">

    <div class="form-floating">
        <input name="<?php echo FILTER_DATE_FIN; ?>" type="date" class="form-control" id="<?php echo FILTER_DATE_FIN; ?>" placeholder="Date de naissance" value="<?php echo isset($_SESSION[FILTER_DATE_FIN]) ? ($_SESSION[FILTER_DATE_FIN])->format('Y-m-d') : ''; ?>">
        <label for="<?php echo FILTER_DATE_FIN; ?>">Date de Fin</label>
    </div>
</form>

<form method="POST" action="">

    <div class="form-floating mb-3">
        <select name="<?php echo FILTER_PROFESSION; ?>" class="form-select" aria-label="Default select example">
            <option selected="" <?php echo empty($_SESSION[FILTER_PROFESSION]) ? 'selected' : ''; ?>>Toutes les professions</option>
            <?php foreach (PROFESSIONS as $value) : ?>
                <option value="<?php echo $value; ?>" <?php echo isset($_SESSION[FILTER_PROFESSION]) && $_SESSION[FILTER_PROFESSION] === $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="profession">Profession</label>
    </div>
</form>

<form method="POST" action="">

    <div class="form-floating mb-3">
        <select name="<?php echo FILTER_PRODUIT; ?>" class="form-select" aria-label="Default select example">
            <option selected="" <?php echo empty($_SESSION[FILTER_PRODUIT]) ? 'selected' : ''; ?>>Tous les Produits</option>
            <?php foreach (PRODUITS_BANQUES as $value) : ?>
                <option value="<?php echo $value; ?>" <?php echo isset($_SESSION[FILTER_PRODUIT]) && $_SESSION[FILTER_PRODUIT] === $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="<?php echo FILTER_PRODUIT; ?>">Produits Banque</label>
    </div>
</form>

<?php if ($_SESSION["user_role"] == ROLE_ADMIN): ?>
    <form method="POST" action="">

        <div class="form-floating mb-3">
            <select name="<?php echo FILTER_ID_AGENCE; ?>" class="form-select" id="agence">
                <option value="">Toutes les agences</option>
                <?php foreach ($agences as $agence) : ?>
                    <option value="<?php echo $agence->getCode(); ?>" <?php echo isset($_SESSION[FILTER_ID_AGENCE]) && $_SESSION[FILTER_ID_AGENCE] === $agence->getCode() ? 'selected' : ''; ?>><?php echo $agence->getNom(); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="agence">Agence</label>
        </div>
    </form>

<?php endif; ?>

<?php if ($_SESSION["user_role"] != ROLE_AGENT): ?>
    <form method="POST" action="">
        <div class="form-floating mb-3">

            <select name="<?php echo FILTER_ID_AGENT; ?>" class="form-select" id="agent">
                <option value="">Tous les agents</option>
                <?php foreach ($agents as $agent) : ?>
                    <option value="<?php echo $agent->getDocId(); ?>" <?php echo isset($_SESSION[FILTER_ID_AGENT]) && $_SESSION[FILTER_ID_AGENT] === $agent->getDocId() ? 'selected' : ''; ?>><?php echo $agent->getNom(); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="agent">Agent</label>

        </div>
    </form>
<?php endif; ?>
<script>
    document.querySelectorAll('form').forEach(form => {
        form.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('change', function() {
                form.submit();
            });
        });
    });
</script>