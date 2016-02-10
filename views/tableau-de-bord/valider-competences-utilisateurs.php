<?php $titre = 'Valider des compétences'; ?>

<?php ob_start(); ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste des compétences
            </div>

            <div class="panel-body">
                <ul class="treeview">
                    <li><a href="#">Liste des compétences</a>
                        <?php echo afficherArbreCompetences(0,0,$competences,'validerCompetencesUtilisateurs'); ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Validation des étudiants</div>
            <div id="panel-body-etudiants" class="panel-body"></div>
        </div>
    </div>
<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>
