<?php $titre = 'Ajouter une compétence'; ?>

<?php ob_start(); ?>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Gestion des compétences
            </div>
            <div id="panel-body-competences" class="panel-body">
            </div>
        </div>
    </div>
<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>
