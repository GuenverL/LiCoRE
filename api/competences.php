<?php

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
    default:
        $json = erreurApi("Il faut renseigner le type");
        break;
}

function getCompetencesFeuilleApi($idPere) {
    return json_encode(getCompetencesFeuille($idPere));
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
