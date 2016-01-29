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

    default:
        $json = erreur("Il faut renseigner le type");
        break;
}

function getCompetencesFeuilleApi($idPere) {
    return json_encode(getCompetencesFeuille($idPere));
}

function erreur($message) {
    return '{"erreur" : '. $message . '}';
}

echo $json;

?>
