<?php $titre = 'Gestion des compétences'; ?>

<?php require(DOC_ROOT_PATH . '/views/tableau-de-bord/gestion-competences-modal.php'); ?>

<?php ob_start(); ?>
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                Gestion des compétences
            </div>

            <div class="panel-body">
                <ul class="treeview">
                    <li><a href="#">Liste des compétences</a>
                        <?php echo afficherArbreCompetences(0,0,$competences,'gestionCompetences'); ?>
                    </li>
                </ul>
            </div>

        </div>
    </div>
<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>
