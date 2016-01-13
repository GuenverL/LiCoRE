<?php

include("connexion_sql.php");

function competencePreprofessionnelles(){
	$competences = array();
	$query = "Select nomCompetence Where idCategorie = 2";
	$result = mysql_result($query);

	while($row = mysql_fetch_array($result)){
		$ompetences[] = $row[0];
	}

	return $competences
}

function competencesDisciplinaires($id){
	$competences = array();
	$query = "Select nomCompetence Where idCategorie = 1 and idMention = '$id' ";
	$result = mysql_result($query);

	while($row = mysql_fetch_array($result)){
		$ompetences[] = $row[0];
	}

	return $competences
}

?>