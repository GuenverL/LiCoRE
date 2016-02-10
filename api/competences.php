<?php

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
    default:
        $json = erreurApi("Il faut renseigner le type");
        break;
}

function getCompetencesFeuilleApi($idPere) {
    return json_encode(getCompetencesFeuille($idPere));
}

function erreurApi($message) {
    return '{"erreur" : '. $message . '}';
}

echo $json;

?>
