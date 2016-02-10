<?php

session_start();
$_SESSION['idUtilisateur'] = 1;
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.'Projet_Licore');

include_once(DOC_ROOT_PATH . '/models/connexion_sql.php');
include_once(DOC_ROOT_PATH . '/controllers/main-controller.php');

try {
  if (isset($_GET['action'])) {
    if ($_GET['action'] == 'gestion-competences') {
        gestionCompetences();
    }
    elseif ($_GET['action'] == 'valider-competences-utilisateurs') {
        validerCompetencesUtilisateurs();
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
