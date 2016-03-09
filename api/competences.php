<?php

define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.'Projet_Licore-master');
include_once(DOC_ROOT_PATH . '/models/competences.php');
include_once(DOC_ROOT_PATH . '/models/connexion_sql.php');

header('Content-Type: application/json; charset=utf-8');
$json = NULL;
$type = $_GET["type"];

switch ($type) {
  case 'sousCompetences':
    $idPere = $_GET["idPere"];
    $json = getCompetencesFeuilleApi($idPere);
    break;
  case 'getUtilisateursCompetence':
    $idCompetence = $_GET["idCompetence"];
    $json = getUtilisateursCompetenceApi($idCompetence);
    break;

  case 'getCompetencesVisibles':
    $json = getCompetencesApi('visibles');
    break;
  case 'getCompetencesVisiblesSansFeuilles':
    $json = getCompetencesVisiblesSansFeuillesApi();
    break;
  case 'getCompetencesInvisibles':
    $json = getCompetencesInvisiblesApi();
    break;
  case 'getCompetencesValides':
    $json = getCompetencesValidesApi();
    break;
  case 'getToutesLesCompetences':
    $json = getCompetencesApi('toutes');
    break;
  case 'getCompetencesValidation':
    $json = getCompetencesValidationApi();
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

  case 'validationCompetenceParTuteur':
    $idCompetence = $_GET["idCompetence"];
    $idUtilisateur = $_GET["idUtilisateur"];
    validationCompetenceParTuteur($idCompetence,$idUtilisateur);
    break;
  case 'invalidationCompetencesUtilisateurs':
    $idCompetence = $_GET["idCompetence"];
    $idUtilisateur = $_GET["idUtilisateur"];
    invaliderCompetence($idCompetence,$idUtilisateur);
    break;

  case 'ajouterCompetence':
    $idPere = $_GET["idCompetence"];
    $nomCompetence = $_GET["nomCompetence"];
    $json = ajouterCompetenceApi($idPere, $nomCompetence);
    break;
  case 'ajouterPlusieursCompetences':
    $idPere = $_GET["idCompetence"];
    $nomsCompetences = $_GET["nomCompetence"];
    $json = ajouterPlusieursCompetencesApi($idPere, $nomsCompetences);
    break;
  case 'modifierCompetence':
    $idCompetence = $_GET["idCompetence"];
    $nomCompetence = $_GET["nomCompetence"];
    $json = modifierCompetenceApi($idCompetence, $nomCompetence);
    break;
  case 'setCompetencesVisibles':
  	$idCompetence = $_GET["idCompetence"];
  	$json = setCompetencesVisiblesApi($idCompetence);
  	break;
  case 'setCompetencesInvisibles':
  	$idCompetence = $_GET["idCompetence"];
  	$json = setCompetencesInvisiblesApi($idCompetence);
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

function getCompetencesFeuilleApi($idPere) {
  return json_encode(getCompetencesFeuille($idPere));
}

function getUtilisateursCompetenceApi($idCompetence) {
  return json_encode(getUtilisateursCompetence($idCompetence));
}

function getCompetencesApi($visibilite){
  return json_encode(getToutesLesCompetences($visibilite));
}

function getCompetencesValidesApi(){
	return json_encode(getCompetencesValides());
}

function getCompetencesVisiblesSansFeuillesApi(){
	return json_encode(getCompetencesVisibles());
}

function getCompetencesInvisiblesApi(){
	return json_encode(getCompetencesInvisibles());
}

function getCompetencesValidationApi() {
  return json_encode(getCompetencesValidation());
}

function ajouterCompetenceApi($idPere, $nomCompetence) {
  return json_encode(ajouterCompetence($idPere, $nomCompetence));
}

function ajouterPlusieursCompetencesApi($idPere, $nomsCompetences) {
  return json_encode(ajouterPlusieursCompetences($idPere, $nomsCompetences));
}

function modifierCompetenceApi($idCompetence, $nomCompetence) {
  return json_encode(modifierCompetence($idCompetence, $nomCompetence));
}

function setCompetencesVisiblesApi($idCompetence) {
  return json_encode(setCompetencesVisibles($idCompetence));
}

function setCompetencesInvisiblesApi($idCompetence) {
  return json_encode(setCompetencesInvisibles($idCompetence));
}

function erreurApi($message) {
  return '{"erreur" : '. $message . '}';
}

echo $json;

?>
