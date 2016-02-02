<?php

session_start();
$_SESSION['idUtilisateur'] = 1;
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.'Projet_Licore');

require(DOC_ROOT_PATH . '/models/connexion_sql.php');
require(DOC_ROOT_PATH . '/controllers/main-controller.php');

try {
  if (isset($_GET['action'])) {
    if ($_GET['action'] == 'ajouter-competence') {
        ajouterCompetence();
    }
    else {
        throw new Exception("Action non valide");
    }
  }
  else {
    accueil();  // action par défaut
  }
}
catch (Exception $e) {
    erreur($e->getMessage());
}
