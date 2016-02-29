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

    case 'validation':
    	$idCompetence = $_GET["idCompetence"];
    	validerCompetence($idCompetence);
    	break;
    case 'invalidation':
    	$idCompetence = $_GET["idCompetence"];
    	invaliderCompetence($idCompetence);
    	break;

    case 'validationCompetencesUtilisateurs':
        $idCompetence = $_GET["idCompetence"];
        $idUtilisateur = $_GET["idUtilisateur"];
        validerCompetence($idCompetence,$idUtilisateur);
        break;
    case 'invalidationCompetencesUtilisateurs':
        $idCompetence = $_GET["idCompetence"];
        $idUtilisateur = $_GET["idUtilisateur"];
        invaliderCompetence($idCompetence,$idUtilisateur);
        break;

    case 'ajouterCompetence':
        $idPere = $_GET["idCompetence"];
        $nomCompetence = $_GET["nomCompetence"];
        ajouterCompetence($idPere, $nomCompetence);
        break;
    case 'ajouterPlusieursCompetences':
        $idPere = $_GET["idCompetence"];
        $nomsCompetences = $_GET["nomCompetence"];
        ajouterPlusieursCompetences($idPere, $nomsCompetences);
        break;
    case 'modifierCompetence':
        $idCompetence = $_GET["idCompetence"];
        $nomCompetence = $_GET["nomCompetence"];
        modifierCompetence($idCompetence, $nomCompetence);
        break;
    case 'setCompetencesVisibles':
    	$idCompetence = $_GET["idCompetence"];
    	setCompetencesVisibles($idCompetence);
    	break;
    case 'setCompetencesInvisibles':
    	$idCompetence = $_GET["idCompetence"];
    	setCompetencesInvisibles($idCompetence);
    	break;
    case 'supprimerCompetence':
      $idCompetence = $_GET["idCompetence"];
      $nomCompetence = $_GET["nomCompetence"];
      supprimerCompetence($idCompetence, $nomCompetence);
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

function erreurApi($message) {
  return '{"erreur" : '. $message . '}';
}

echo $json;

?>
