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
                $html .= ' <span data-toggle="modal" data-target="#ajouterCompetenceModal" data-id-pere="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" class="glyphicon glyphicon-plus cursor-pointer" aria-hidden="true"></span>';
                $html .= ' <span data-toggle="modal" data-target="#modifierCompetenceModal" data-id-competence="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" class="glyphicon glyphicon-pencil cursor-pointer" aria-hidden="true"></span>';
                $html .= ' <span data-toggle="modal" data-target="#supprimerCompetenceModal" data-id-competence="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" data-feuille="' . $noeud['feuille'] . '" class="glyphicon glyphicon-remove cursor-pointer" aria-hidden="true"></span>';
            }
            else {
                if(isset($noeud['valide']) && $noeud['valide']){
                	$html .= '<li class="text-validated-dark">';
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
    $query = "Select idCompetence, idPereCompetence, nomCompetence From competence ORDER BY nomCompetence ASC";

    if(count($bdd->query($query))>0){
        foreach($bdd->query($query) as $row){
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
    }

    return $competences;
}

function sontDesFeuillesLesFils($idPere){
	global $bdd;
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere;

	foreach($bdd->query($query) as $row){
		if(!estUneFeuille($row['idCompetence'])){
        	return false;
        }
	}

	return true;
}

function auMoinsUneFeuilleDansLesFils($idPere){
	global $bdd;
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere;

	foreach($bdd->query($query) as $row){
		if(estUneFeuille($row['idCompetence'])){
        		return true;
        	}
	}

	return false;
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

	if($req->fetch()){
		return false;
	}

	return true;
}

function estCompetenceValide($idCompetence){
	global $bdd;
    $idUtilisateur = 0;

	$query = "Select idCompetence From validation Where idUtilisateur = " . $idUtilisateur . " and idCompetence = " . $idCompetence;
	$req = $bdd->query($query);

	if($req->fetch()){
		return true;
	}

	return false;
}

function getSousCompetences($idPere){
	global $bdd;
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere;
	$sousCompetences = array();

	if(count($bdd->query($query))>0){
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
	$query = "Select idCompetence, nomCompetence From competence Where idPereCompetence = " . $idPere . " ORDER BY nomCompetence ASC";
	$competencesFeuille = array();

	if(count($bdd->query($query))>0){
		foreach($bdd->query($query) as $row){
			if(estUneFeuille($row['idCompetence'])){
				$competence = array(
					'id' => $row['idCompetence'],
					'nom' => $row['nomCompetence'],
					'valide' => estCompetenceValide($row['idCompetence'])
				);

				$competencesFeuille[] = $competence;
			}
		}
	}

	return $competencesFeuille;
}

function validerCompetence($idCompetence, $idUtilisateur = 0){
	global $bdd;

	$queryInsert = $bdd->prepare("Insert into validation (idUtilisateur, idCompetence) Values (:idUtilisateur, :idCompetence)");
	$queryInsert->bindParam(':idUtilisateur', $idUtilisateur);
	$queryInsert->bindParam(':idCompetence', $idCompetence);
	$queryInsert->execute();
}

function invaliderCompetence($idCompetence, $idUtilisateur = 0){
	global $bdd;

	$queryDelete = $bdd->prepare("Delete From validation Where idUtilisateur = :idUtilisateur and idCompetence = :idCompetence");
	$queryDelete->bindParam(':idUtilisateur', $idUtilisateur);
	$queryDelete->bindParam(':idCompetence', $idCompetence);
	$queryDelete->execute();
}

function auMoinsUneCompetenceEstValide($idPere){
	global $bdd;
	$query = "Select idCompetence From competence Where idPereCompetence = " . $idPere;

	foreach($bdd->query($query) as $row){
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
    $query = "Select idCompetence, idPereCompetence, nomCompetence From competence ORDER BY nomCompetence ASC";

    if(count($bdd->query($query))>0){
        foreach($bdd->query($query) as $row){
			if((estUneFeuille($row['idCompetence']) && estCompetenceValide($row['idCompetence'])) || (auMoinsUneCompetenceEstValide($row['idCompetence']))){
                $competence = array(
                	'idCompetence' => $row['idCompetence'],
                	'idPereCompetence' => $row['idPereCompetence'],
                	'nomCompetence' => $row['nomCompetence']
                );

                $competencesValides[] = $competence;
            }
        }
    }

    return $competencesValides;
}

function modifierCompetence($idCompetence, $nouveauNom){
	global $bdd;

	$queryUpdate = $bdd->prepare("Update competence Set nomCompetence = :nouveauNom Where idCompetence = :idCompetence");
	$queryUpdate->bindParam(':nouveauNom', $nouveauNom);
	$queryUpdate->bindParam(':idCompetence', $idCompetence);
	$queryUpdate->execute();
}

function ajouterCompetence($idPere, $nomCompetence){
	global $bdd;

	$queryInsert = $bdd->prepare("Insert into competence (nomCompetence, idPereCompetence) Values (:nomCompetence, :idPereCompetence)");
	$queryInsert->bindParam(':nomCompetence', $nomCompetence);
	$queryInsert->bindParam(':idPereCompetence', $idPere);
	$queryInsert->execute();
}

function getToutesLesCompetences(){
	global $bdd;
    $competences = array();
    $query = "Select idCompetence, idPereCompetence, nomCompetence From competence ORDER BY nomCompetence ASC";

    if(count($bdd->query($query))>0){
        foreach($bdd->query($query) as $row){
            $competence = array(
                'idCompetence' => $row['idCompetence'],
                'idPereCompetence' => $row['idPereCompetence'],
                'nomCompetence' => $row['nomCompetence'],
                'feuille' => estUneFeuille($row['idCompetence'])
            );

            $competences[] = $competence;
        }
    }

    return $competences;
}

function supprimerCompetence($idCompetence){
	global $bdd;

	if(!estUneFeuille($idCompetence)){
		$query = "Select idCompetence From competence Where idPereCompetence = " . $idCompetence;

		foreach($bdd->query($query) as $row){
			supprimerCompetence($row['idCompetence']);
		}
	}

	$queryDelete = $bdd->prepare("Delete From competence Where idCompetence = :idCompetence");
	$queryDelete->bindParam(':idCompetence', $idCompetence);
	$queryDelete->execute();
}

function getUtilisateurs(){
	global $bdd;
	$utilisateurs = array();
	$query = "Select idUtilisateur, nom, prenom From utilisateur";

	if(count($bdd->query($query))>0){
        foreach($bdd->query($query) as $row){
            $utilisateur = array(
                'idUtilisateur' => $row['idUtilisateur'],
                'prenom' => $row['prenom'],
                'nom' => $row['nom']
            );

            $utilisateurs[] = $utilisateur;
        }
    }

    return $utilisateurs;
}

?>
