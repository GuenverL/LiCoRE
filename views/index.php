<?php $titre = 'Accueil'; ?>
<?php require(DOC_ROOT_PATH . '/views/competences-a-valider-modal.php'); ?>

<?php ob_start(); ?>
    <div class="col-md-4">
        <?php include(DOC_ROOT_PATH . '/views/liste-competences.php'); ?>
    </div>

    <div class="col-md-4">
        <?php include(DOC_ROOT_PATH . '/views/competences-a-valider.php'); ?>
    </div>

    <div class="col-md-4">
        <?php include(DOC_ROOT_PATH . '/views/liste-competences-validees.php'); ?>
    </div>
<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>