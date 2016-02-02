<?php $titre = 'Erreur'; ?>

<?php ob_start(); ?>
    <div class="col-md-12">
        <p>Une erreur est survenue : <?= $msgErreur ?></p>
    </div>
<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>
