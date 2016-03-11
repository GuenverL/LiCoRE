<?php

define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.'Projet_Licore-master');
include_once(DOC_ROOT_PATH . '/models/competences.php');
include_once(DOC_ROOT_PATH . '/models/connexion_sql.php');

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

header('Content-Type: application/json; charset=utf-8');
$json = NULL;
$type = $_GET["type"];

switch ($type) {
  case 'sousCompetences':
    $idPere = $_GET["idPere"];
    $json = json_encode(getCompetencesFeuille($idPere));
    break;
  case 'getUtilisateursCompetence':
    $idCompetence = $_GET["idCompetence"];
    $json = json_encode(getUtilisateursCompetence($idCompetence));
    break;

  case 'getCompetencesVisibles':
    $json = json_encode(getToutesLesCompetences('visibles'));
    break;
  case 'getCompetencesVisiblesSansFeuilles':
    $json = json_encode(getCompetencesVisibles());
    break;
  case 'getCompetencesInvisibles':
    $json = json_encode(getCompetencesInvisibles());
    break;
  case 'getCompetencesValides':
    $json = json_encode(getCompetencesValides());
    break;
  case 'getToutesLesCompetences':
    $json = json_encode(getToutesLesCompetences('toutes'));
    break;
  case 'getCompetencesValidation':
    $json = json_encode(getCompetencesValidation());
    break;

  case 'validation':
  	$idCompetence = $_GET["idCompetence"];
    $explications = $_GET["explications"];
  	validerCompetence($idCompetence, $explications);
  	break;
  case 'invalidation':
  	$idCompetence = $_GET["idCompetence"];
  	invaliderCompetence($idCompetence);
  	break;

  case 'getExplicationsEtudiant':
    $idCompetence = $_GET["idCompetence"];
    $idUtilisateur = $_GET["idUtilisateur"];
    $json = json_encode(getExplicationsEtudiant($idCompetence,$idUtilisateur));
    break;
  case 'getExplications':
    $idCompetence = $_GET["idCompetence"];
    $json = json_encode(getExplications($idCompetence));
    break;
  case 'accepterValidation':
    $idCompetence = $_GET["idCompetence"];
    $idUtilisateur = $_GET["idUtilisateur"];
    validationCompetenceParTuteur($idCompetence,$idUtilisateur);
    break;
  case 'refuserValidation':
    $idCompetence = $_GET["idCompetence"];
    $idUtilisateur = $_GET["idUtilisateur"];
    $explications = $_GET["explications"];
    refuserValidationCompetenceParTuteur($idCompetence,$idUtilisateur,$explications);
    break;

  case 'ajouterCompetence':
    $idPere = $_GET["idCompetence"];
    $nomCompetence = $_GET["nomCompetence"];
    $json = json_encode(ajouterCompetence($idPere, $nomCompetence));
    break;
  case 'ajouterPlusieursCompetences':
    $idPere = $_GET["idCompetence"];
    $nomsCompetences = $_GET["nomCompetence"];
    $json = json_encode(ajouterPlusieursCompetences($idPere, $nomsCompetences));
    break;
  case 'modifierCompetence':
    $idCompetence = $_GET["idCompetence"];
    $nomCompetence = $_GET["nomCompetence"];
    $json = json_encode(modifierCompetence($idCompetence, $nomCompetence));
    break;
  case 'setCompetencesVisibles':
  	$idCompetence = $_GET["idCompetence"];
  	$json = json_encode(setCompetencesVisibles($idCompetence));
  	break;
  case 'setCompetencesInvisibles':
  	$idCompetence = $_GET["idCompetence"];
  	$json = json_encode(setCompetencesInvisibles($idCompetence));
  	break;
  case 'supprimerCompetence':
    $idCompetence = $_GET["idCompetence"];
    $nomCompetence = $_GET["nomCompetence"];
    supprimerCompetence($idCompetence, $nomCompetence);
    break;

  case 'estConnecte':
    if(isset($_SESSION['idUtilisateur'])) {
      $json = json_encode(array('estConnecte' => true));
    } else {
      $json = json_encode(array('estConnecte' => false));
    }
    break;

  default:
    $json = erreurApi("Il faut renseigner le type");
    break;
}

function erreurApi($message) {
  return '{"erreur" : '. $message . '}';
}

echo $json;

?>
