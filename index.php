<?php

session_start();
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.'Projet_Licore-master');

include_once(DOC_ROOT_PATH . '/models/connexion_sql.php');
include_once(DOC_ROOT_PATH . '/controllers/main-controller.php');

try {
  if (isset($_GET['action'])) {
    if (($_GET['action'] == 'gestion-competences') && (estAccessible('gestion-competences'))) {
        gestionCompetences();
    }
    elseif (($_GET['action'] == 'valider-competences-utilisateurs') && (estAccessible('valider-competences-utilisateurs'))) {
        validerCompetencesUtilisateurs();
    }
    elseif ($_GET['action'] == 'connexion') {
        connexion();
    }
    elseif ($_GET['action'] == 'deconnexion') {
        deconnexion();
    }
    else {
        throw new Exception("Erreur 503 : Accès refusé, vos droits d'accès ne permettent pas d'accéder à cette ressource");
    }
  }
  else {
    accueil();  // action par défaut
  }
}
catch (Exception $e) {
    erreur($e->getMessage());
}
