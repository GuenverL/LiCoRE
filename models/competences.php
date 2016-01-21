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


function getCompetencesOld(){
    global $bdd;
    $categories = array();
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence is NULL";

	if(!empty($bdd->query($query))){
		foreach($bdd->query($query) as $row){

			$categorie = array(
				'id' => $row['idCompetence'],
				'nom' => $row['nomCompetence'],
				'sousCategories' => getSousCategories($row['idCompetence'])
			);

			$categories[] = $categorie;
		}
	}

	return $categories;
}

function afficherArbreCompetences($parent, $niveau, $array) {
    $html = "";
    $niveau_precedent = 0;

    if (!$niveau && !$niveau_precedent) {
        $html .= "\n<ul>\n";
    }

    foreach ($array AS $noeud) {
        if ($parent == $noeud['idPereCompetence']) {
            if ($niveau_precedent < $niveau) {
                $html .= "\n<ul>\n";
            }
            $html .= "<li><a href=\"#\">" . $noeud['nomCompetence'] . "</a>";
            $niveau_precedent = $niveau;
            $html .= afficherArbreCompetences($noeud['idCompetence'], ($niveau + 1), $array);
        }
    }

    if (($niveau_precedent == $niveau) && ($niveau_precedent != 0)) {
        $html .= "</ul>\n</li>\n";
    }
    else if ($niveau_precedent == $niveau) {
        $html .= "</ul>\n";
    }
    else {
        $html .= "</li>\n";
    }

    return $html;
}

function getCompetences(){
    global $bdd;
    $competences = array();
    $query = "Select idCompetence, idPereCompetence, nomCompetence From competence ORDER BY nomCompetence ASC";

    if(!empty($bdd->query($query))){
        foreach($bdd->query($query) as $row){

            if(!empty(getSousCategories($row['idCompetence']))) {
                $competence = array(
                'idCompetence' => $row['idCompetence'],
                'idPereCompetence' => $row['idPereCompetence'],
                'nomCompetence' => $row['nomCompetence']
                );

                $competences[] = $competence;
            }
        }
    }

    return $competences;
}

function getSousCategories($idPere){
	global $bdd;
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere . " and idCompetence in (Select distinct(idPereCompetence) From competence)";
	$sousCategories = array();

	if(!empty($bdd->query($query))){
		foreach($bdd->query($query) as $row){
			$categorie = array(
				'id' => $row['idCompetence'],
				'nom' => $row['nomCompetence'],
				'sousCategories' => getSousCategories($row['idCompetence'])
			);

			$sousCategories[] = $categorie;
		}
	}

	return $sousCategories;
}

?>
