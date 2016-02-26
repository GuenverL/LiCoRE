<?php

function afficherArbreCompetences($parent, $niveau, $array, $typeAffichage) {
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

            if($typeAffichage == 'gestionCompetences') {
                $html .= '<li><a href="#">' . $noeud['nomCompetence'] . '</a>';
                $html .= ' <span data-toggle="modal" data-target="#gestionCompetencesModal" data-type="ajouterCompetence" data-id-competence="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" class="glyphicon glyphicon-plus cursor-pointer couleur-verte" aria-hidden="true"></span>';
                $html .= ' <span data-toggle="modal" data-target="#gestionCompetencesModal" data-type="ajouterPlusieursCompetences" data-id-competence="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" class="glyphicon glyphicon-th-list cursor-pointer couleur-verte" aria-hidden="true"></span>';
                $html .= ' <span data-toggle="modal" data-target="#gestionCompetencesModal" data-type="modifierCompetence" data-id-competence="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" class="glyphicon glyphicon-pencil cursor-pointer couleur-jaune" aria-hidden="true"></span>';
                $html .= ' <span data-toggle="modal" data-target="#gestionCompetencesModal" data-type="supprimerCompetence" data-id-competence="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" data-feuille="' . $noeud['feuille'] . '" class="glyphicon glyphicon-remove cursor-pointer couleur-rouge" aria-hidden="true"></span>';
            }
            else {
                if(isset($noeud['valide']) && $noeud['valide']){
                	$html .= '<li class="text-validated">';
                }
                else{
                    $html .= "<li>";
                }

                if (isset($noeud['feuille']) && $noeud['feuille']){
                    if($typeAffichage == 'validerCompetencesUtilisateurs') {
                        $html .= '<a onclick="afficherUtilisateursCompetence(this,' . $noeud['idCompetence'] . ')" href="#">' . $noeud['nomCompetence'] . '</a>';
                    }
                    else {
                        $html .= '<a onclick="afficherCompetence(this,' . $noeud['idCompetence'] . ')" href="#">' . $noeud['nomCompetence'] . '</a>';
                    }
                }
                else {
                    $html .= '<a href="#">' . $noeud['nomCompetence'] . '</a>';
                }
            }

            $niveau_precedent = $niveau;
            $html .= afficherArbreCompetences($noeud['idCompetence'], ($niveau + 1), $array, $typeAffichage);
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
    $querySelect = $bdd->prepare("Select idCompetence, idPereCompetence, nomCompetence From competence Where visible = 1 ORDER BY nomCompetence ASC");
	$querySelect->execute();

    while($row = $querySelect->fetch()){
		if(!estUneFeuille($row['idCompetence'])){
            $competence = array(
              	'idCompetence' => $row['idCompetence'],
                'idPereCompetence' => $row['idPereCompetence'],
                'nomCompetence' => $row['nomCompetence'],
                'feuille' => auMoinsUneFeuilleDansLesFils($row['idCompetence']),
                'valide' => sontToutesValidesLesCompetences($row['idCompetence'])
            );

            $competences[] = $competence;
        }
    }

    return $competences;
}

function auMoinsUneFeuilleDansLesFils($idPere){
	global $bdd;
	$querySelect = $bdd->prepare("Select idCompetence From competence Where idPereCompetence = :idPere and visible = 1");
	$querySelect->bindParam(':idPere', $idPere, PDO::PARAM_INT);
	$querySelect->execute();

	while($row = $querySelect->fetch()){
		if(estUneFeuille($row['idCompetence'])){
        		return true;
        }
	}

	return false;
}

function sontToutesValidesLesCompetences($idPere){
	global $bdd;
	$querySelect = $bdd->prepare("Select idCompetence From competence Where idPereCompetence = :idPere and visible = 1");
	$querySelect->bindParam(':idPere', $idPere, PDO::PARAM_INT);
	$querySelect->execute();

	while($row = $querySelect->fetch()){
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

function estUneFeuille($idCompetence, $mode = 1){
	global $bdd;

	if($mode == 1){
		$querySelect = $bdd->prepare("Select * From competence Where idPereCompetence = :idCompetence and visible = 1");
	}
	else{
		$querySelect = $bdd->prepare("Select * From competence Where idPereCompetence = :idCompetence");
	}

	$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$querySelect->execute();

	if($querySelect->fetch()){
		return false;
	}

	return true;
}

function estCompetenceValide($idCompetence, $idUtilisateur = 0){
	global $bdd;
	$querySelect = $bdd->prepare("Select * From validation Where idUtilisateur = :idUtilisateur and idCompetence = :idCompetence");
	$querySelect->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
	$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$querySelect->execute();

	if($querySelect->fetch()){
		return true;
	}

	return false;
}

function getCompetencesFeuille($idPere){
	global $bdd;
	$querySelect = $bdd->prepare("Select idCompetence, nomCompetence From competence Where idPereCompetence = :idPere and visible = 1 ORDER BY nomCompetence ASC");
	$querySelect->bindParam(':idPere', $idPere, PDO::PARAM_INT);
	$querySelect->execute();
	$competencesFeuille = array();

	while($row = $querySelect->fetch()){
		if(estUneFeuille($row['idCompetence'])){
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

function validerCompetence($idCompetence, $idUtilisateur = 0){
	global $bdd;

	$queryInsert = $bdd->prepare("Insert into validation (idUtilisateur, idCompetence) Values (:idUtilisateur, :idCompetence)");
	$queryInsert->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
	$queryInsert->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryInsert->execute();
}

function invaliderCompetence($idCompetence, $idUtilisateur = 0){
	global $bdd;

	$queryDelete = $bdd->prepare("Delete From validation Where idUtilisateur = :idUtilisateur and idCompetence = :idCompetence");
	$queryDelete->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
	$queryDelete->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryDelete->execute();
}

function auMoinsUneCompetenceEstValide($idPere){
	global $bdd;
	$querySelect = $bdd->prepare("Select idCompetence From competence Where idPereCompetence = :idPere and visible = 1");
	$querySelect->bindParam(':idPere', $idPere, PDO::PARAM_INT);
	$querySelect->execute();

	while($row = $querySelect->fetch()){
		if(estUnefeuille($row['idCompetence'])){
			if(estCompetenceValide($row['idCompetence'])){
				return true;
			}
		}
		else{
			if(auMoinsUneCompetenceEstValide($row['idCompetence'])){
				return true;
			}
		}
	}

	return false;
}

function getCompetencesValides(){
	global $bdd;
    $competencesValides = array();
    $querySelect = $bdd->prepare("Select idCompetence, idPereCompetence, nomCompetence From competence Where visible = 1 ORDER BY nomCompetence ASC");
    $querySelect->execute();

    while($row = $querySelect->fetch()){
		if((estUneFeuille($row['idCompetence']) && estCompetenceValide($row['idCompetence'])) || (auMoinsUneCompetenceEstValide($row['idCompetence']))){
            $competence = array(
                'idCompetence' => $row['idCompetence'],
                'idPereCompetence' => $row['idPereCompetence'],
                'nomCompetence' => $row['nomCompetence']
            );

            $competencesValides[] = $competence;
        }
    }

    return $competencesValides;
}

function modifierCompetence($idCompetence, $nouveauNom){
	global $bdd;

	$queryUpdate = $bdd->prepare("Update competence Set nomCompetence = :nouveauNom Where idCompetence = :idCompetence");
	$queryUpdate->bindParam(':nouveauNom', $nouveauNom, PDO::PARAM_STR);
	$queryUpdate->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryUpdate->execute();
}

function ajouterCompetence($idPere, $nomCompetence){
	global $bdd;

  $visible = 1;
	$queryInsert = $bdd->prepare("Insert into competence (nomCompetence, idPereCompetence, visible) Values (:nomCompetence, :idPereCompetence, :visible)");
	$queryInsert->bindParam(':nomCompetence', $nomCompetence, PDO::PARAM_STR);
	$queryInsert->bindParam(':idPereCompetence', $idPere, PDO::PARAM_INT);
  $queryInsert->bindParam(':visible', $visible, PDO::PARAM_BOOL);
	$queryInsert->execute();
}

function ajouterPlusieursCompetences($idPere, $nomsCompetences) {
  $tableauCompetences = preg_split("/\r\n|\n|\r/", $nomsCompetences);
  foreach ($tableauCompetences as $nomCompetence) {
    ajouterCompetence($idPere, $nomCompetence);
  }
}

function getToutesLesCompetences($mode = 1){
	global $bdd;
    $competences = array();

    if($mode == 1){
    	$querySelect = $bdd->prepare("Select idCompetence, idPereCompetence, nomCompetence From competence Where visible = 1 ORDER BY nomCompetence ASC");
    }
    else{
    	$querySelect = $bdd->prepare("Select idCompetence, idPereCompetence, nomCompetence, visible From competence ORDER BY nomCompetence ASC");
    }

    $querySelect->execute();

    while($row = $querySelect->fetch()){
    	if($mode == 1){
        	$competence = array(
            	'idCompetence' => $row['idCompetence'],
            	'idPereCompetence' => $row['idPereCompetence'],
            	'nomCompetence' => $row['nomCompetence'],
            	'feuille' => estUnefeuille($row['idCompetence']),
        	);
        }else{
        	$competence = array(
            	'idCompetence' => $row['idCompetence'],
            	'idPereCompetence' => $row['idPereCompetence'],
            	'nomCompetence' => $row['nomCompetence'],
            	'feuille' => estUnefeuille($row['idCompetence'], 2),
            	'visible' => $row['visible']
        	);
        }

        $competences[] = $competence;
    }

    return $competences;
}

function supprimerCompetence($idCompetence){
	global $bdd;

	if(!estUneFeuille($idCompetence)){
		$querySelect = $bdd->prepare("Select idCompetence From competence Where idPereCompetence = :idCompetence");
		$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
		$querySelect->execute();

		while($row = $querySelect->fetch()){
			supprimerCompetence($row['idCompetence']);
		}
	}

	$queryDelete = $bdd->prepare("Delete From competence Where idCompetence = :idCompetence");
	$queryDelete->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryDelete->execute();
}

function setCompetencesInvisibles($idCompetence){
	global $bdd;

	if(!estUneFeuille($idCompetence)){
		$querySelect = $bdd->prepare("Select idCompetence From competence Where idPereCompetence = :idCompetence and visible = 1");
		$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
		$querySelect->execute();

		while($row = $querySelect->fetch()){
			setCompetencesInvisible($row['idCompetence']);
		}
	}

	$queryUpdate = $bdd->prepare("Update competence Set visible = 0 Where idCompetence = :idCompetence");
	$queryUpdate->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryUpdate->execute();
}

function setCompetencesVisibles($idCompetence){
	if(!estUneFeuille($idCompetence)){
		$querySelect = $bdd->prepare("Select idCompetence From competence Where idPereCompetence = :idCompetence and visible = 0");
		$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
		$querySelect->execute();

		while($row = $querySelect->fetch()){
			setCompetencesVisibles($row['idCompetence']);
		}
	}

	$queryUpdate = $bdd->prepare("Update competence Set visible = 1 Where idCompetence = :idCompetence");
	$queryUpdate->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryUpdate->execute();
}

function getUtilisateursCompetence($idCompetence) {
	global $bdd;
	$utilisateurs = array();
	$querySelect = $bdd->prepare("Select idUtilisateur, nom, prenom From utilisateur");
	$querySelect->execute();

	while($row = $querySelect->fetch()){
       	$utilisateur = array(
            'idUtilisateur' => $row['idUtilisateur'],
            'prenom' => $row['prenom'],
            'nom' => $row['nom'],
            'valide' => estCompetenceValide($idCompetence, $row['idUtilisateur'])
        );

        $utilisateurs[] = $utilisateur;
    }

    return $utilisateurs;
}


?>
