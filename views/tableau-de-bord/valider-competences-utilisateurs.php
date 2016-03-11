<?php $titre = 'Validation des compétences'; ?>

<?php require(DOC_ROOT_PATH . '/views/tableau-de-bord/validation-utilisateurs-modal.php'); ?>

<?php ob_start(); ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
              <div class="text-small-caps">Liste des compétences</div>
            </div>

            <div class="panel-body">
              <div id="loader-competences">
                <img class="center" src="./images/loader.gif" alt="Chargement"/>
                <p class="center-text-loader">Chargement des compétences ...</p>
              </div>

              <ul id="arbreValidationCompetences" class="treeview">
                <li id="listeCompetences"></li>
              </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
              <div class="text-small-caps">Validation des étudiants</div>
            </div>
            <div id="panel-body-etudiants" class="panel-body"></div>
        </div>
    </div>
<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>
