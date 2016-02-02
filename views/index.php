<?php $titre = 'Accueil'; ?>

<?php ob_start(); ?>
    <div class="col-md-4">
        <?php include(DOC_ROOT_PATH . '/views/liste-competences.php'); ?>
    </div>

    <div class="col-md-4">
        <?php include(DOC_ROOT_PATH . '/views/competences_a_valider.php'); ?>
    </div>

    <div class="col-md-4">
        <?php include(DOC_ROOT_PATH . '/views/arbre-competences.php'); ?>
    </div>
<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>
