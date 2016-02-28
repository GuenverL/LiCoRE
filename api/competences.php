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
        $competences = getCompetencesVisiblesApi();
        break;
    case 'getCompetencesInvisibles':
        $competences = getCompetencesInvisiblesApi();
        break;
    case 'getCompetencesValides':
        $json = getCompetencesValidesApi();
        break;
    case 'getToutesLesCompetences':
        $json = getToutesLesCompetencesApi();
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

function getToutesLesCompetencesApi(){
	return json_encode(getToutesLesCompetences());
}

function getCompetencesValidesApi(){
	return json_encode(getCompetencesValides());
}

function getCompetencesVisiblesApi(){
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
