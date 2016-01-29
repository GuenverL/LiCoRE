<?php

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

            if ($noeud['valide']) {
                $html .= '<li class="text-validated-dark"';
            }
            else {
                $html .= "<li";
            }
            if ($noeud['feuille']) {
                $html .= ' onclick="afficherCompetence(this,' . $noeud['idCompetence'] . ')">';
            }
            else {
                $html .= ">";
            }

            $html .= '<a href="#">' . $noeud['nomCompetence'] . '</a>';
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
			if(!empty(getSousCompetences($row['idCompetence']))){
                $competence = array(
                	'idCompetence' => $row['idCompetence'],
                	'idPereCompetence' => $row['idPereCompetence'],
                	'nomCompetence' => $row['nomCompetence'],
                	'feuille' => sontDesFeuillesLesFils($row['idCompetence']),
                	'valide' => sontToutesValidesLesCompetences($row['idCompetence'])
                );

                $competences[] = $competence;
            }
        }
    }

    return $competences;
}

function sontDesFeuillesLesFils($idPere){
	global $bdd;
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere;

	foreach($bdd->query($query) as $row){
		if(!empty(getSousCompetences($row['idCompetence']))){
        	return false;
        }
	}

	return true;
}

function sontToutesValidesLesCompetences($idPere){
	global $bdd;
	$query = "Select idCompetence From competence Where idPereCompetence = " . $idPere;

	foreach($bdd->query($query) as $row){
		if(estUnefeuille($row['idCompetence'])){
			if(!estCompetenceValide($row['idCompetence'])){
				return false;
			}
		}
		else{
			if(!sontToutesValidesLesCompetences($row['idCompetence'])){
				return false;
			}
		}
	}

	return true;
}

function estUneFeuille($idCompetence){
	global $bdd;
	$query = "Select * From competence Where idPereCompetence = " . $idCompetence;
	$req = $bdd->query($query);

	if(!$req->fetch()){
		return true;
	}

	return false;
}

function estCompetenceValide($idCompetence){
	global $bdd;
    if (isset($_SESSION['idUtilisateur'])) {
        $idUtilisateur = $_SESSION['idUtilisateur'];
    }
    else {
        $idUtilisateur = 0;
    }

	$query = "Select idCompetence From validation Where idUtilisateur = " . $idUtilisateur . " and idCompetence = " . $idCompetence;
	$req = $bdd->query($query);

	if($req->fetch()){
		return true;
	}
    return true;
	return false;
}

function getSousCompetences($idPere){
	global $bdd;
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere;
	$sousCompetences = array();

	if(!empty($bdd->query($query))){
		foreach($bdd->query($query) as $row){
			$categorie = array(
				'id' => $row['idCompetence'],
				'nom' => $row['nomCompetence'],
				'sousCompetences' => getSousCompetences($row['idCompetence'])
			);

			$sousCompetences[] = $categorie;
		}
	}

	return $sousCompetences;
}

function getCompetencesFeuille($idPere){
	global $bdd;
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere;
	$competencesFeuille = array();

	if(!empty($bdd->query($query))){
		foreach($bdd->query($query) as $row){
			$competence = array(
				'id' => $row['idCompetence'],
				'nom' => $row['nomCompetence'],
				'valide' => estCompetenceValide($row['idCompetence'])
			);

			$competencesFeuille[] = $competence;
		}
	}

	return $competencesFeuille;
}

?>
