<?php
/* XXX */
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.'Projet_Licore');
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
    case 'validation':
    	$idCompetence = $_GET["idCompetence"];
    	$json = validerCompetenceApi($idCompetence);
    	break;
    case 'invalidation':
    	$idCompetence = $_GET["idCompetence"];
    	$json = invaliderCompetenceApi($idCompetence);
    	break;
    case 'ajouterCompetence':
        $idPere = $_GET["idPere"];
        $nomCompetence = $_GET["nomCompetence"];
        ajouterCompetence($idPere, $nomCompetence);
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
    case 'arbreCompetences':
        $json = getCompetencesValidesApi();
        break;
    default:
        $json = erreurApi("Il faut renseigner le type");
        break;
}

function getCompetencesFeuilleApi($idPere) {
    return json_encode(getCompetencesFeuille($idPere));
}

function getCompetencesValidesApi(){
	return json_encode(getCompetencesValides());
}

function validerCompetenceApi($idCompetence){
	return json_encode(validerCompetence($idCompetence));
}

function invaliderCompetenceApi($idCompetence){
	return json_encode(invaliderCompetence($idCompetence));
}

function erreurApi($message) {
    return '{"erreur" : '. $message . '}';
}

echo $json;

?>
