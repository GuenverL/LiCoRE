<?php

function getCompetencesVisibles(){
    global $bdd;
    $competences = array();
    $querySelect = $bdd->prepare("Select idCompetence, idPereCompetence, nomCompetence From competence Where visible = 1 ORDER BY nomCompetence ASC");
	$querySelect->execute();

    while($row = $querySelect->fetch()){
		if(!estUneFeuille($row['idCompetence'])){
            $competence = array(
              	'idCompetence' => intval($row['idCompetence']),
                'idPereCompetence' => intval($row['idPereCompetence']),
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

/*function validationCompetenceParTuteur($idCompetence, $idUtilisateur){
	global $bdd;
	
	$queryUpdate = $bdd->prepare("Update validation Set idTuteur = :idTuteur Where idUtilisateur = :idUtilisateur and idCompetence = :idCompetence");
	$queryUpdate->bindParam(':idTuteur', $idTuteur, PDO::PARAM_INT);
	$queryUpdate->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
	$queryUpdate->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryUpdate->execute();
} */

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
                'idCompetence' => intval($row['idCompetence']),
                'idPereCompetence' => intval($row['idPereCompetence']),
                'nomCompetence' => $row['nomCompetence']
            );

            $competencesValides[] = $competence;
        }
    }

    return $competencesValides;
}

function modifierCompetence($idCompetence, $nouveauNom){
	global $bdd;

	if(empty(trim($nouveauNom))){
		return array(
						'retour' => false	
			   );
	}

	$queryUpdate = $bdd->prepare("Update competence Set nomCompetence = :nouveauNom Where idCompetence = :idCompetence");
	$queryUpdate->bindParam(':nouveauNom', $nouveauNom, PDO::PARAM_STR);
	$queryUpdate->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryUpdate->execute();

	return array(
					'retour' => true
		   );
}

function ajouterCompetence($idPere, $nomCompetence){
	global $bdd;
	$idCompetence = -1;

	if(!empty(trim($nomCompetence))){
		$queryInsert = $bdd->prepare("Insert into competence (nomCompetence, idPereCompetence) Values (:nomCompetence, :idPereCompetence)");
		$queryInsert->bindParam(':nomCompetence', $nomCompetence, PDO::PARAM_STR);
		$queryInsert->bindParam(':idPereCompetence', $idPere, PDO::PARAM_INT);
		$queryInsert->execute();
		$idCompetence = $bdd->lastInsertId();
	}

	return array(
                'idCompetence' => intval($idCompetence),
                'nomCompetence' => $nomCompetence
           );
}

function ajouterPlusieursCompetences($idPere, $nomsCompetences) {
	$tableauCompetences = preg_split("/\r\n|\n|\r/", $nomsCompetences);
	$competencesAjoutees = array();

	foreach ($tableauCompetences as $nomCompetence) {
    	$competencesAjoutees[] = ajouterCompetence($idPere, $nomCompetence);
	}

	return $competencesAjoutees;
}

function getToutesLesCompetences($mode){
	global $bdd;
    $competences = array();

    if(strcmp($mode, "visibles") == 0){
    	$querySelect = $bdd->prepare("Select idCompetence, idPereCompetence, nomCompetence From competence Where visible = 1 ORDER BY nomCompetence ASC");
    }
    else{
    	$querySelect = $bdd->prepare("Select idCompetence, idPereCompetence, nomCompetence, visible From competence ORDER BY nomCompetence ASC");
    }

    $querySelect->execute();

    while($row = $querySelect->fetch()){
    	if(strcmp($mode, "visibles") == 0){
        	$competence = array(
            	'idCompetence' => intval($row['idCompetence']),
            	'idPereCompetence' => intval($row['idPereCompetence']),
            	'nomCompetence' => $row['nomCompetence'],
            	'feuille' => estUnefeuille($row['idCompetence']),
        	);
        }else{
        	$competence = array(
            	'idCompetence' => intval($row['idCompetence']),
            	'idPereCompetence' => intval($row['idPereCompetence']),
            	'nomCompetence' => $row['nomCompetence'],
            	'feuille' => estUnefeuille($row['idCompetence'], 2),
            	'visible' => intval($row['visible'])
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

function getNomCompetence($idCompetence){
	global $bdd;

	$querySelect = $bdd->prepare("Select nomCompetence From competence Where idCompetence = :idCompetence");
	$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$querySelect->execute();

	return $querySelect->fetchColumn();
}

function setCompetencesInvisibles($idCompetence){
	global $bdd;
	$competences = array();

	$queryUpdate = $bdd->prepare("Update competence Set visible = 0 Where idCompetence = :idCompetence");
	$queryUpdate->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryUpdate->execute();

	$competences[] = array(
            				'idCompetence' => intval($idCompetence),
            				'nomCompetence' => getNomCompetence($idCompetence)
    				 );

	if(!estUneFeuille($idCompetence)){
		$querySelect = $bdd->prepare("Select idCompetence From competence Where idPereCompetence = :idCompetence and visible = 1");
		$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
		$querySelect->execute();

		while($row = $querySelect->fetch()){
			$competences = array_merge($competences, setCompetencesInvisibles($row['idCompetence']));
		}
	}

	return $competences;
}

function setCompetencesVisibles($idCompetence){
    global $bdd;
    $competences = array();

    $queryUpdate = $bdd->prepare("Update competence Set visible = 1 Where idCompetence = :idCompetence");
	$queryUpdate->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$queryUpdate->execute();
    
	$competences[] = array(
            				'idCompetence' => intval($idCompetence),
            				'nomCompetence' => getNomCompetence($idCompetence)
    				 );

	$querySelect = $bdd->prepare("Select idPereCompetence From competence Where idCompetence = :idCompetence");
	$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
	$querySelect->execute();

	if(!empty($idPere = $querySelect->fetchColumn())){
		$querySelect = $bdd->prepare("Select visible From competence Where idCompetence = :idPere");
		$querySelect->bindParam(':idPere', $idPere, PDO::PARAM_INT);
		$querySelect->execute();

		if(!$querySelect->fetchColumn()){
			$competences = array_merge($competences, setCompetencesVisibles($idPere));
		}
	}

	/*if(!estUneFeuille($idCompetence, 2)){
		$querySelect = $bdd->prepare("Select idCompetence From competence Where idPereCompetence = :idCompetence and visible = 0");
		$querySelect->bindParam(':idCompetence', $idCompetence, PDO::PARAM_INT);
		$querySelect->execute();

		while($row = $querySelect->fetch()){
			$competences = array_merge($competences, setCompetencesVisibles($row['idCompetence']));
		}
	}*/

	return $competences;
}

function getUtilisateursCompetence($idCompetence) {
	global $bdd;
	$utilisateurs = array();
	$querySelect = $bdd->prepare("Select idUtilisateur, nom, prenom From utilisateur Natural Join validation Where idTuteur is NULL");
	$querySelect->execute();

	while($row = $querySelect->fetch()){
       	$utilisateur = array(
            'idUtilisateur' => $row['idUtilisateur'],
            'prenom' => $row['prenom'],
            'nom' => $row['nom'],
        );

        $utilisateurs[] = $utilisateur;
    }

    return $utilisateurs;
}

function auMoinsUneFeuilleEstInvisible($idPere){
	global $bdd;
	$querySelect = $bdd->prepare("Select idCompetence, visible From competence Where idPereCompetence = :idPere");
	$querySelect->bindParam(':idPere', $idPere, PDO::PARAM_INT);
	$querySelect->execute();

	while($row = $querySelect->fetch()){
		if(estUnefeuille($row['idCompetence'],2)){
			if($row['visible'] == 0){
				return true;
			}
		}
		else{
			if(($row['visible'] == 0) || (auMoinsUneFeuilleEstInvisible($row['idCompetence']))){
				return true;
			}
		}
	}

	return false;
}

function getCompetencesInvisibles(){
	global $bdd;
	$competences = array();
    $querySelect = $bdd->prepare("Select idCompetence, idPereCompetence, nomCompetence, visible From competence ORDER BY nomCompetence ASC");
	$querySelect->execute();

    while($row = $querySelect->fetch()){
    	if(($row['visible'] == 0) || (!estUneFeuille($row['idCompetence']) && auMoinsUneFeuilleEstInvisible($row['idCompetence']))){
    		$competence = array(
            	'idCompetence' => intval($row['idCompetence']),
            	'idPereCompetence' => intval($row['idPereCompetence']),
            	'nomCompetence' => $row['nomCompetence'],
            	'feuille' => estUnefeuille($row['idCompetence'], 2),
            	'visible' => $row['visible']
        	);

        	$competences[] = $competence;
    	}
    }

    return $competences;
}

function estUnUtilisateur($pseudo, $mdp){
	global $bdd;
	$querySelect = $bdd->prepare("Select idUtilisateur From utilisateur Where pseudo = :pseudo and mdp = :mdp");
	$querySelect->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$querySelect->bindParam(':mdp', $mdp, PDO::PARAM_STR);
	$querySelect->execute();

	if($id = $querySelect->fetchColumn()){
		return $id;
	}

	return -1;
}

?>
