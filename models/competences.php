<?php

function getCompetencesPreprofessionnelles(){
	global $bdd;
	$competences = array();
	$query = "Select nomCompetence Where idCategorie = 2";

	foreach($bdd->query($query) as $row){
		$competences[] = $row['nomCompetence'];
	}

	return $competences;
}

function getCompetencesDisciplinaires($id){
	global $bdd;
	$competences = array();
	$query = "Select nomCompetence Where idCategorie = 1 and idMention = '$id' ";

	foreach($bdd->query($query) as $row){
		$competences[] = $row['nomCompetence'];
	}

	return $competences;
}

function getCompetencesTransversalesEtLinguistiques(){
	global $bdd;
	$competences = array();
	$query = "Select nomCompetence Where idCategorie = 3";

	foreach($bdd->query($query) as $row){
		$competences[] = $row['nomCompetence'];
	}

	return $competences;
}


function getCompetences(){
    global $bdd;
    $competences = array();
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence is NULL";

	if(!empty($bdd->query($query))){
		foreach($bdd->query($query) as $row){
			$sousCompetences = getSousCompetences($row['idCompetence']);
			if(empty($sousCompetences)){
				$sousCompetences = NULL;
			}

			$competence = array(
				'id' => $row['idCompetence'],
				'nom' => $row['nomCompetence'],
				'sousCompetences' => $sousCompetences
			);

			$competences[] = $competence;
		}
	}

	return $competences;
}

function getSousCompetences($idPere){
	global $bdd;
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere . " and idCompetence in (Select distinct(idPereCompetence) From competence)";
	$sousCompetences = array();

	if(!empty($bdd->query($query))){
		foreach($bdd->query($query) as $row){
			$sousCompetence = getSousCompetences($row['idCompetence']);
			if(empty($sousCompetence)){
				$sousCompetences = NULL;
			}

			$competences = array(
				'id' => $row['idCompetence'],
				'nom' => $row['nomCompetence'],
				'sousCategories' => $sousCompetence
			);

			$sousCompetences[] = $competences;
		}
	}

	return $sousCompetences;
}

?>
