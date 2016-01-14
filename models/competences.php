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


function getCategoriesEtNomsMentions(){
    global $bdd;
    $categories = array();
	$query = "Select idCategorie, nomCategorie From categoriecompetence";


	foreach($bdd->query($query) as $row){
		$query2 = "Select nomMention From mention NATURAL JOIN competence Where idCategorie = " . $row['idCategorie'];
		$mentions = array();

		if(!empty($bdd->query($query2))){
			foreach($bdd->query($query2) as $row2){
				$mentions[] = $row2['nomMention'];
			}
		}

		$categorie = array(
				'nom' => $row['nomCategorie'],
				'mentions' => $mentions
		);

		$categories[] = $categorie;
	}

	return $categories;
}

?>
